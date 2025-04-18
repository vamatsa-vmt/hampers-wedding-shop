<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login', ['title' => 'Login']);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.login', ['title' => 'Login']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Verifikasi Email
            if (!$user->email_verified_at) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Harap verifikasi email Anda terlebih dahulu.');
            }

            $request->session()->regenerate();
            if (Auth::user()->role === 'Admin') {
                return redirect()->route('admin.index');
            } elseif (Auth::user()->role === 'Pelanggan') {
                return redirect()->route('pelanggan.index');
            }
            return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.auth.register', ['title' => 'Register']);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email_verified_at' => null,
        ]);

        $verificationUrl = route('verify.email', ['id' => $user->id]);
        Mail::send('admin.auth.verifikasi', ['url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verifikasi Email Anda');
        });

        return back()->with('success', 'Silakan periksa email Anda untuk memverifikasi akun.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda berhasil logout.');
    }

    public function verifyEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email sudah diverifikasi.');
        }
        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi. Silakan login.');
    }

    public function profile()
    {
        $user = Auth::user(); 

        if ($user->role === 'Admin') {
            return view('admin.auth.profile', ['user' => $user]);
        } elseif ($user->role === 'Pelanggan') {
            return view('pelanggan.profile', ['user' => $user]);
        }

        return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric',
            'password' => 'nullable|min:6',
        ]);
        $user = Auth::user();
        
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        
        if ($user->role === 'Admin') {
            return redirect()->route('auth.profile')->with('status', 'Profil Anda berhasil diperbarui.');
        } elseif ($user->role === 'Pelanggan') {
            return redirect()->route('pelanggan.profile')->with('status', 'Profil Anda berhasil diperbarui.');
        }

        return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
    }
}
