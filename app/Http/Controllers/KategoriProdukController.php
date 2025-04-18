<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = KategoriProduk::all();
        return view('admin.kategoriproduk.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestKategori = KategoriProduk::latest('id')->first();
        $lastNumber = $latestKategori ? ((int) substr($latestKategori->KODE_KATEGORI_PRODUK, 2)) + 1 : 1001;
        $kodeKategori = 'KP' . $lastNumber;

        return view('admin.kategoriproduk.create', compact('kodeKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $latestKategori = KategoriProduk::latest('id')->first();
        $kodeKategori = 'KP' . ($latestKategori ? ((int) substr($latestKategori->KODE_KATEGORI_PRODUK, 2)) + 1 : 1001);

        if ($request->hasFile('IMAGE_KATEGORI_PRODUK')) {
            $image = $request->file('IMAGE_KATEGORI_PRODUK');
            $imagePath = $image->storeAs('kategori_produk', time() . '-' . $image->getClientOriginalName(), 'public');
        } else {
            $imagePath = null;
        }

        KategoriProduk::create([
            'KODE_KATEGORI_PRODUK' => $kodeKategori,
            'NAMA_KATEGORI_PRODUK' => $request->NAMA_KATEGORI_PRODUK,
            'IMAGE_KATEGORI_PRODUK' => $imagePath,
        ]);
    
        return redirect('/admin/kategoriproduk')->with('success', 'Kategori berhasil ditambahkan.');
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
        $kategori = KategoriProduk::findOrFail($id);
        return view('admin.kategoriproduk.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $data = $request->except('IMAGE_KATEGORI_PRODUK');
        if ($request->hasFile('IMAGE_KATEGORI_PRODUK')) {
            if ($kategori->IMAGE_KATEGORI_PRODUK) {
                $oldImagePath = storage_path('app/public/' . $kategori->IMAGE_KATEGORI_PRODUK);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $data['IMAGE_KATEGORI_PRODUK'] = $request->file('IMAGE_KATEGORI_PRODUK')->storeAs(
                'kategori_produk', 
                time() . '-' . $request->file('IMAGE_KATEGORI_PRODUK')->getClientOriginalName(),
                'public'
            );
        }
        $kategori->update($data);
        return redirect('/admin/kategoriproduk')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        if ($kategori->IMAGE_KATEGORI_PRODUK) {
            $imagePath = storage_path('app/public/' . $kategori->IMAGE_KATEGORI_PRODUK);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $kategori->delete();
        DB::statement('ALTER TABLE kategori_produks AUTO_INCREMENT = 1');
        return redirect('/admin/kategoriproduk')->with('success', 'Kategori berhasil dihapus.');
    }
}
