@extends('admin.sidenav')
@section('title', 'Tambah Produk')
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4">Tambah Produk</h2>
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="kode_produk" class="block text-sm font-semibold">Kode Produk</label>
            <input type="text" name="KODE_PRODUK" value="{{ $kodeProduk }}" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" readonly>
        </div>        
        <div class="mb-4">
            <label for="kategori_produk" class="block text-sm font-semibold">Kategori Produk</label>
            <select name="KODE_KATEGORI_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" required>
                <option value="" disabled selected>Pilih Kategori Produk</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->NAMA_KATEGORI_PRODUK }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="nama_produk" class="block text-sm font-semibold">Nama Produk</label>
            <input type="text" name="NAMA_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-semibold">Image Produk</label>
            <input type="file" name="IMAGE_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-semibold">Deskripsi</label>
            <input type="text" name="DESKRIPSI" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="harga" class="block text-sm font-semibold">Harga</label>
            <input type="number" name="HARGA" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="stok" class="block text-sm font-semibold">Stok</label>
            <input type="number" name="STOK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" required>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Simpan</button>
    </form>
    </div>
</div>
@endsection
