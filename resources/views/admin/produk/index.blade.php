@extends('admin.sidenav')

@section('title', 'Produk')

@section('content')
<div class="container mx-auto p-4 flex justify-between items-center flex-wrap">
    <h2 class="text-2xl font-bold mb-2 sm:mb-0">Produk</h2>
    <a href="{{ route('produk.create') }}" class="px-4 py-2 bg-purple-600 font-bold text-white rounded-md text-sm sm:text-base">
        Tambah Produk
    </a>
</div>

@if(session('success'))
    <div id="alert-success" class="bg-green-500 text-white p-3 rounded-md mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead class="bg-red-50">
                <tr>
                    @foreach(['Kode', 'Kategori', 'Nama Produk', 'Gambar', 'Deskripsi', 'Harga', 'Stok', 'Status', 'Aksi'] as $heading)
                        <th class="py-2 px-4 text-left text-sm sm:text-base border-b">
                            {{ $heading }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $produk)
                    <tr class="border-t">
                        <td class="py-4 px-4 text-sm">{{ $produk->KODE_PRODUK }}</td>
                        <td class="py-4 px-4 text-sm">
                            {{ $produk->kategori->NAMA_KATEGORI_PRODUK ?? 'Tidak ada kategori' }}
                        </td>
                        <td class="py-4 px-4 text-sm">{{ $produk->NAMA_PRODUK }}</td>
                        <td class="py-4 px-4">
                            @if($produk->IMAGE_PRODUK)
                                <img src="{{ asset('storage/' . $produk->IMAGE_PRODUK) }}" 
                                     class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-md">
                            @else
                                <span class="text-gray-500 text-sm">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-sm">{{ $produk->DESKRIPSI }}</td>
                        <td class="py-4 px-4 text-sm">{{ number_format($produk->HARGA, 0, ',', '.') }}</td>
                        <td class="py-4 px-4 text-sm">{{ $produk->STOK }}</td>
                        <td class="py-4 px-4 text-sm">{{ $produk->STATUS }}</td>
                        <td class="py-4 px-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('produk.edit', $produk->id) }}" 
                                   class="text-blue-500 text-sm sm:text-base">Edit</a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm sm:text-base">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-4 px-4 text-center text-gray-500 text-sm">
                            Tidak ada produk yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    setTimeout(() => {
        document.getElementById('alert-success')?.remove();
    }, 3000);
</script>
@endsection
