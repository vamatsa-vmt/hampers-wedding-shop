@extends('admin.sidenav')

@section('title', 'Kategori Produk')

@section('content')
<div class="container mx-auto p-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold mb-2 sm:mb-0">Kategori Produk</h2>
    <a href="{{ route('kategoriproduk.create') }}" class="px-4 py-2 bg-purple-600 font-bold text-white rounded-md text-sm sm:text-base">
        Tambah Kategori
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
            <thead class="bg-red-50 text-center">
            <tr>
                <th class="py-4 px-4 text-left text-sm sm:text-base">Kode</th>
                <th class="py-4 px-4 text-left text-sm sm:text-base">Nama Kategori</th>
                <th class="py-4 px-4 text-left text-sm sm:text-base">Gambar</th>
                <th class="py-4 px-4 text-left text-sm sm:text-base">Aksi</th>
            </tr>
            </thead>
            <tbody>
                @foreach($kategoris as $kategori)
                    <tr class="border-t">
                        <td class="py-4 px-4 text-sm">{{ $kategori->KODE_KATEGORI_PRODUK }}</td>
                        <td class="py-4 px-4 text-sm">{{ $kategori->NAMA_KATEGORI_PRODUK }}</td>
                        <td class="py-4 px-4">
                            @if($kategori->IMAGE_KATEGORI_PRODUK)
                                <img src="{{ asset('storage/' . $kategori->IMAGE_KATEGORI_PRODUK) }}" alt="Gambar Kategori" class="w-16 h-16 sm:w-20 sm:h-20 object-cover">
                            @else
                                <span class="text-gray-500 text-sm">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-sm align-middle">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('kategoriproduk.edit', $kategori->id) }}" class="text-blue-500 text-sm sm:text-base">
                                    Edit
                                </a>
                                <form action="{{ route('kategoriproduk.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm sm:text-base">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
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
