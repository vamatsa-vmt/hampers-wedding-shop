@extends('admin.sidenav')

@section('title', 'Edit Kategori Produk')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Kategori Produk</h2>
    <form action="{{ route('kategoriproduk.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="kode_pembimbing" class="block">Kode Kategori</label>
            <input type="text" name="KODE_KATEGORI_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" value="{{ $kategori->KODE_KATEGORI_PRODUK }}" required>
        </div>
        <div class="mb-4">
            <label for="nama_pembimbing" class="block">Nama Kategori</label>
            <input type="text" name="NAMA_KATEGORI_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" value="{{ $kategori->NAMA_KATEGORI_PRODUK }}" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block">Image Kategori</label>
            <input type="file" name="IMAGE_KATEGORI_PRODUK" class="border rounded-md w-full p-2 mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
            <img src="{{ asset('storage/' . $kategori->IMAGE_KATEGORI_PRODUK) }}" alt="Tidak ada gambar" class="mt-2 h-32">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
    </form>
    </div>
</div>
@endsection
