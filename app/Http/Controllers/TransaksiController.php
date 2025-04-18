<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mpdf\Mpdf;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'produk'])->get();
        return view('admin.pesanan.index', compact('transaksis'));
    }

    public function create()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));        
        return view('pelanggan.transaksi', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_bungkus' => 'nullable|string',
            'image_bungkus' => 'nullable|image|mimes:jpeg,png,jpg',
            'waktu_kirim' => 'required|date',
            // 'waktu_kirim_time' => 'required|date_format:H:i',
            'image_bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // $waktuKirim = $request->waktu_kirim . ' ' . $request->waktu_kirim_time;
        $waktuKirim = $request->waktu_kirim;
        $kodeTransaksi = 'INV-' . Str::random(5) . now()->format('dmY');
        $userId = Auth::id();
        $cart = session()->get('cart', []);
        $user = Auth::user();
        $alamat = $user->alamat;

        $transaksiData = [];
        foreach ($cart as $item) {
            if (isset($item['kode_produk'])) {
                $produk = Produk::where('KODE_PRODUK', $item['kode_produk'])->first();
                if ($produk) {
                    if ($produk->STOK < $item['quantity']) {
                        return redirect()->back()->withErrors([
                            'error' => 'Stok produk ' . $produk->NAMA_PRODUK . ' tidak mencukupi!',
                        ]);
                    }
                    $produk->STOK -= $item['quantity'];
                    $produk->save();
                }

                $transaksi = [
                    'KODE_TRANSAKSI' => $kodeTransaksi,
                    'id_user' => $userId,
                    'KODE_PRODUK' => $item['kode_produk'],
                    'JUMLAH' => $item['quantity'],
                    'DESKRIPSI_BUNGKUS' => $request->deskripsi_bungkus,
                    'WAKTU_KIRIM' => $waktuKirim,
                    'STATUS' => 'menunggu konfirmasi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($request->hasFile('image_bungkus')) {
                    $transaksi['IMAGE_BUNGKUS'] = $request->file('image_bungkus')->store('bungkus', 'public');
                }
                if ($request->hasFile('image_bukti_transaksi')) {
                    $transaksi['IMAGE_BUKTI_TRANSAKSI'] = $request->file('image_bukti_transaksi')->store('bukti', 'public');
                }
                $transaksiData[] = $transaksi;
            }
        }

        Transaksi::insert($transaksiData);
        session()->forget('cart');
        return redirect()->route('pelanggan.riwayat')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function adminPesanan()
    {
        $transaksis = Transaksi::with(['user', 'produk'])->get();
        return view('admin.pesanan.index', compact('transaksis'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'STATUS' => 'required|string',
            'alasan_ditolak' => 'nullable|string',
        ]);

        Transaksi::where('KODE_TRANSAKSI', $transaksi->KODE_TRANSAKSI)
                ->update([
                    'STATUS' => $validated['STATUS'],
                    'alasan_ditolak' => $validated['STATUS'] === 'Pesanan Ditolak' ? $validated['alasan_ditolak'] : null,
                ]);

        return redirect()->route('pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function cetakNota($kodeTransaksi)
    {
        $transaksis = Transaksi::where('KODE_TRANSAKSI', $kodeTransaksi)->get();
        if ($transaksis->isEmpty()) {
            return redirect()->back()->with('error', 'Data Transaksi tidak ditemukan.');
        }

        $transaksis->transform(function ($item) {
            $item->WAKTU_KIRIM = Carbon::parse($item->WAKTU_KIRIM)->format('Y-m-d');
            return $item;
        });
        $tanggal_nota = Carbon::now()->format('Y-m-d');
        return view('admin.pesanan.cetak', compact('transaksis', 'tanggal_nota'));
    }

    public function showDetailAdmin($kode_transaksi)
    {
        $transaksi = Transaksi::where('KODE_TRANSAKSI', $kode_transaksi)->get();
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Data Transaksi tidak ditemukan.');
        }

        $transaksi->transform(function ($item) {
            $item->WAKTU_KIRIM = Carbon::parse($item->WAKTU_KIRIM)->format('Y-m-d');
            return $item;
        });
        return view('admin.pesanan.detail', compact('transaksi'));
    }

    public function laporan(Request $request)
    {
        $query = Transaksi::with(['user', 'produk']);
        if ($request->has('status') && $request->status != '') {
            $query->where('STATUS', $request->status);
        }
        if ($request->has('time_range') && $request->time_range != '') {
            if ($request->time_range == 'weekly') {
                $query->where('created_at', '>=', now()->subWeek());
            } elseif ($request->time_range == 'monthly') {
                $query->where('created_at', '>=', now()->subMonth());
            }
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        } elseif ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }
        $laporan = $query->get(); 
        $laporan->transform(function ($item) {
            $item->WAKTU_PESAN = Carbon::parse($item->created_at)->format('Y-m-d');
            $item->WAKTU_KIRIM = Carbon::parse($item->WAKTU_KIRIM)->format('Y-m-d');
            return $item;
        });
        return view('admin.pesanan.laporan', compact('laporan'));
    }

    public function printLaporan(Request $request)
    {
        $query = Transaksi::with(['user', 'produk']);
        if ($request->has('status') && $request->status != '') {
            $query->where('STATUS', $request->status);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        } elseif ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }
        $laporan = $query->get();
        $laporan->transform(function ($item) {
            $item->WAKTU_KIRIM = Carbon::parse($item->WAKTU_KIRIM)->format('Y-m-d');
            return $item;
        });

        $mpdf = new \Mpdf\Mpdf();
        $html = view('admin.pesanan.print_laporan', compact('laporan'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('laporan_pesanan.pdf', 'D');
    }

    public function showDetailPelanggan($kode_transaksi)
    {
        $transaksi = Transaksi::where('KODE_TRANSAKSI', $kode_transaksi)->get();
        if ($transaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Data Transaksi tidak ditemukan.');
        }

        $transaksi->transform(function ($item) {
            $item->WAKTU_KIRIM = Carbon::parse($item->WAKTU_KIRIM)->format('Y-m-d');
            return $item;
        });
        return view('pelanggan.detail', compact('transaksi'));
    }

    public function riwayat()
    {
        $riwayat = Transaksi::where('id_user', Auth::id())
            ->with('user') 
            ->selectRaw('MAX(transaksis.id) as id, kode_transaksi, DATE(waktu_kirim) as waktu_kirim, status, image_bukti_transaksi')
            ->groupBy('kode_transaksi', 'waktu_kirim', 'status', 'image_bukti_transaksi')
            ->get();

        return view('pelanggan.riwayat', compact('riwayat'));
    }
}
