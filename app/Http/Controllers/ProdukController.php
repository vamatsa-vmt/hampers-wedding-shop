<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::all();
        return view('admin.produk.index', compact('produks'));
    }
    

    public function publicIndex()
    {
        $kategoriproduks = KategoriProduk::all();
        $produks = Produk::with('kategori')->get();

        return view('pelanggan.index', compact('kategoriproduks', 'produks'));
    }
    
    public function produkDetail($id)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk mengakses produk.');
        }

        $produk = Produk::find($id);
        return view('pelanggan.detail_produk', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestProduk = Produk::latest('id')->first();
        $kodeProduk = 'KR' . ($latestProduk ? ((int) substr($latestProduk->KODE_PRODUK, 2)) + 1 : 1001);

        $kategoris = KategoriProduk::where('NAMA_KATEGORI_PRODUK', '!=', 'semua')->get();
        return view('admin.produk.create', compact('kategoris', 'kodeProduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $latestProduk = Produk::latest('id')->first();
        $data['KODE_PRODUK'] = $request->KODE_PRODUK ?: 'KR' . ($latestProduk ? ((int) substr($latestProduk->KODE_PRODUK, 2)) + 1 : 1001);
        $data['STATUS'] = $request->STOK > 0 ? 'tersedia' : 'habis';
        if ($request->hasFile('IMAGE_PRODUK')) {
            $data['IMAGE_PRODUK'] = $request->file('IMAGE_PRODUK')->store('produk', 'public');
        }
        Produk::create($data);
        return redirect('/admin/produk')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::find($id);
        $kategoris = KategoriProduk::where('NAMA_KATEGORI_PRODUK', '!=', 'semua')->get();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::find($id);
        $data = $request->all();
        $data['STATUS'] = $request->STOK > 0 ? 'tersedia' : 'habis';
        if ($request->hasFile('IMAGE_PRODUK')) {
            if ($produk->IMAGE_PRODUK) {
                $oldImagePath = storage_path('app/public/' . $produk->IMAGE_PRODUK);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $data['IMAGE_PRODUK'] = $request->file('IMAGE_PRODUK')->store('produk', 'public');
        }
        $produk->update($data);
        return redirect('/admin/produk')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->IMAGE_PRODUK) {
            $imagePath = storage_path('app/public/' . $produk->IMAGE_PRODUK);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $produk->delete();

        return redirect('/admin/produk')->with('success', 'Produk berhasil dihapus.');
    }
}
