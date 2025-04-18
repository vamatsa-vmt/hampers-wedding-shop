<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pelanggan.cart', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productId = $request->input('kode_produk');
        $quantity = $request->input('quantity');
        $product = Produk::findOrFail($productId);

        // Cek apakah stok mencukupi
        if ($product->STOK < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'kode_produk' => $product->KODE_PRODUK,
                'name' => $product->NAMA_PRODUK,
                'price' => $product->HARGA,
                'quantity' => $quantity,
                'image' => asset('storage/' . $product->IMAGE_PRODUK),
            ];
        }

        session()->put('cart', $cart);
        $product->decrement('STOK', $quantity);
        return redirect()->route('pelanggan.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $keranjang = session()->get('cart', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('cart', $keranjang);
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
        }
        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
