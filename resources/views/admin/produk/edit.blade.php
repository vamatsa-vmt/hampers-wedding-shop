@extends('admin.sidenav')
@section('title', 'Edit Produk')
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Produk</h2>
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        <label for="NAMA_PRODUK" class="block text-sm font-semibold">Nama Produk</label>
        <input type="text" name="NAMA_PRODUK" id="NAMA_PRODUK" value="{{ old('NAMA_PRODUK', $produk->NAMA_PRODUK) }}" class="w-full p-2 border border-gray-300 rounded-md mt-2 bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500" required>
        <label for="NAMA_KATEGORI_PRODUK" class="block text-sm font-medium text-gray-700 mt-4">Kategori</label>
        <select id="KODE_KATEGORI_PRODUK" name="KODE_KATEGORI_PRODUK"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" 
                        {{ $produk->KODE_KATEGORI_PRODUK == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->NAMA_KATEGORI_PRODUK }}
                </option>
            @endforeach
        </select>
        <label for="IMAGE_PRODUK" class="block text-sm font-medium text-gray-700 mt-4">Gambar Produk</label>
        <input type="file" id="IMAGE_PRODUK" name="IMAGE_PRODUK" 
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @if($produk->IMAGE_PRODUK)
                <img src="{{ asset('storage/' . $produk->IMAGE_PRODUK) }}" alt="Gambar Produk" class="mt-2 w-20 h-20 object-cover">
            @endif
        <label for="DESKRIPSI" class="block text-sm font-semibold mt-4">Deskripsi</label>
        <input type="text" name="DESKRIPSI" id="DESKRIPSI" value="{{ old('DESKRIPSI', $produk->DESKRIPSI) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
        <label for="HARGA" class="block text-sm font-semibold mt-4">Harga</label>
        <input type="number" name="HARGA" id="HARGA" value="{{ old('HARGA', $produk->HARGA) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
        <label for="STOK" class="block text-sm font-semibold mt-4">Stok</label>
        <input type="number" name="STOK" id="STOK" value="{{ old('STOK', $produk->STOK) }}" class="w-full p-2 border border-gray-300 rounded-md" required>
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Update Produk</button>
    </form>
    </div>
</div>
@endsection
