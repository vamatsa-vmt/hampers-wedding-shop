@extends('admin.sidenav')
@section('title', 'Dashboard Admin')

@section('content')
<main class="flex-1 p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Statistik</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-4 bg-blue-500 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Jumlah Admin</h3>
                <p class="text-xl font-bold">{{ $jumlah_data_admin }}</p>
            </div>
            <div class="p-4 bg-red-500 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Jumlah Pelanggan</h3>
                <p class="text-xl font-bold">{{ $jumlah_data_pelanggan }}</p>
            </div>
            <div class="p-4 bg-yellow-400 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Jumlah Kategori Produk</h3>
                <p class="text-xl font-bold">{{ $jumlah_data_kategori }}</p>
            </div>
            <div class="p-4 bg-purple-500 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Jumlah Produk</h3>
                <p class="text-xl font-bold">{{ $jumlah_data_produk }}</p>
            </div>
            <div class="p-4 bg-green-500 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Jumlah Pesanan</h3>
                <p class="text-xl font-bold">{{ $jumlah_data_transaki }}</p>
            </div>
            <div class="p-4 bg-cyan-500 text-white rounded-lg shadow">
                <h3 class="text-sm font-semibold">Total Omset</h3>
                <p class="text-xl font-bold">Rp{{ number_format($total_omset, 0, ',', '.') }}</p>
            </div>            
        </div>
    </div>
</main>
@endsection
