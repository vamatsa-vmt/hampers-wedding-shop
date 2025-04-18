@extends('admin.sidenav')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold mb-6">Laporan Pesanan Pelanggan</h1>

    <form class="mb-6">
        <div class="flex space-x-4 mb-4">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-md">
                    <option value="">Semua Status</option>
                    <option value="menunggu konfirmasi" {{ request('status') == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dikemas" {{ request('status') == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Date Filters -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-3">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-3">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full p-2 border border-gray-300 rounded-md">
            </div>
        </div>

        <button type="submit" class="bg-orange-500 hover:bg-orange-800 text-white py-2 px-4 rounded-md">Tampilkan Laporan</button>
        <a href="{{ route('admin.pesanan.laporan.cetak', request()->all()) }}" class="bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded-md mt-4 inline-block">
            Cetak Laporan
        </a>
    </form>

    <!-- Report Table -->
    <div class="overflow-x-auto bg-white rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-yellow-200">
                <tr class="text-center">
                    <th class="px-4 py-2">Kode Transaksi</th>
                    <th class="px-4 py-2">Pelanggan</th>
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Tanggal Pemesanan</th>
                    <th class="px-4 py-2">Tanggal Pengiriman</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedOrders = $laporan->groupBy('KODE_TRANSAKSI');
                @endphp

                @forelse($groupedOrders as $kodeTransaksi => $orders)
                    @php $firstOrder = $orders->first(); @endphp
                    @foreach ($orders as $index => $order)
                        <tr>
                            @if ($index == 0)
                                <td class="border px-4 py-2" rowspan="{{ $orders->count() }}">{{ $kodeTransaksi }}</td>
                                <td class="border px-4 py-2" rowspan="{{ $orders->count() }}">{{ $firstOrder->user->nama }}</td>
                            @endif
                                <td class="border px-4 py-2">{{ $order->produk->NAMA_PRODUK }}</td>
                                <td class="border px-4 py-2 text-center">{{ $order->JUMLAH }}</td>
                            @if ($index == 0)
                                <td class="border px-4 py-2 text-center" rowspan="{{ $orders->count() }}">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                        @if($firstOrder->STATUS == 'Selesai') bg-green-100 text-green-700 border border-green-500 
                                        @elseif($firstOrder->STATUS == 'Dikirim') bg-blue-100 text-blue-700 border border-blue-500 
                                        @elseif($firstOrder->STATUS == 'Dikemas') bg-yellow-100 text-yellow-700 border border-yellow-500 
                                        @elseif($firstOrder->STATUS == 'Ditolak') bg-red-100 text-red-700 border border-red-500 
                                        @else bg-yellow-100 text-black border border-orange-500 
                                        @endif">
                                        {{ $firstOrder->STATUS }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 text-center" rowspan="{{ $orders->count() }}">{{ $firstOrder->WAKTU_PESAN }}</td>
                                <td class="border px-4 py-2 text-center" rowspan="{{ $orders->count() }}">{{ $firstOrder->WAKTU_KIRIM }}</td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
