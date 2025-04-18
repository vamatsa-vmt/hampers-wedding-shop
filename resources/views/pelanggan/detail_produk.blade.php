@extends('pelanggan.app')
@section('title', 'Detail Produk')
@section('content')
<section class="px-6 py-16 bg-white">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row items-center">
            <!-- Gambar Produk -->
            <img src="{{ asset('storage/' . $produk->IMAGE_PRODUK) }}" alt="{{ $produk->NAMA_PRODUK }}" class="w-64 h-64 object-cover rounded-md">
            
            <!-- Detail Produk -->
            <div class="md:ml-6 mt-4 md:mt-0">
                <h1 class="text-2xl font-bold">{{ $produk->NAMA_PRODUK }}</h1>
                <p class="text-gray-700 text-sm mt-2">{{ $produk->DESKRIPSI }}</p>
                <p class="text-lg font-semibold mt-4">Rp {{ number_format($produk->HARGA, 0, ',', '.') }}</p>

                <!-- Form Tambah ke Keranjang -->
                <form action="{{ route('pelanggan.cart.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="kode_produk" value="{{ $produk->KODE_PRODUK }}">
                    
                    <!-- Input Jumlah -->
                    <label for="quantity" class="block text-gray-600 text-sm font-medium">Jumlah</label>
                    <input 
                        type="number" 
                        name="quantity" 
                        id="quantity" 
                        value="1" 
                        min="1" 
                        class="w-20 px-2 border rounded-md focus:ring-2 focus:ring-[#B76E79] focus:outline-none"
                        required
                    >

                    <!-- Tombol Tambah ke Keranjang -->
                    <button type="submit" class="mt-4 px-4 py-2 bg-[#B76E79] text-white rounded-md hover:bg-[#a05b67]">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
