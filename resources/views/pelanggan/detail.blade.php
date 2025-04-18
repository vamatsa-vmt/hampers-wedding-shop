@extends('pelanggan.app')

@section('content')
<section class="py-8 px-6">
    <a href="{{ route('pelanggan.riwayat') }}" class="w-10 h-10 flex items-center justify-center bg-purple-200 rounded-full hover:bg-purple-100 mb-6">
        <i class="fas fa-chevron-left text-xl"></i>
    </a>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow-lg rounded-lg p-6 lg:col-span-1">
            <h2 class="text-lg font-bold mb-4">Detail Transaksi</h2>
            <table class="w-full text-left border border-purple-200">
                <tbody>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Kode Transaksi</th>
                        <td class="px-4 py-2">{{ $transaksi->first()->KODE_TRANSAKSI }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Alamat Pengiriman</th>
                        <td class="px-4 py-2">{{ Auth::user()->alamat }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Waktu Kirim</th>
                        <td class="px-4 py-2">{{ $transaksi->first()->WAKTU_KIRIM }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Status Transaksi</th>
                        <td class="px-4 py-2">
                            @php
                                $status = $transaksi->first()->STATUS ?? 'Tidak Diketahui';
                                $warnaStatus = match($status) {
                                    'Selesai' => 'bg-green-100 text-green-700 border border-green-500',
                                    'Diproses' => 'bg-yellow-100 text-yellow-700 border border-yellow-500',
                                    'Pesanan Ditolak' => 'bg-red-100 text-red-700 border border-red-500',
                                    default => 'bg-gray-100 text-gray-700 border border-gray-500'
                                };
                            @endphp
                    
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $warnaStatus }}">
                                {{ $status }}
                            </span>
                    
                            @if (!empty($transaksi->first()->alasan_ditolak))
                                <p class="mt-2 text-red-500 text-sm"><strong>Alasan Ditolak:</strong> {{ $transaksi->first()->alasan_ditolak }}</p>
                            @endif
                        </td>
                    </tr>                                        
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Deskripsi Bungkus</th>
                        <td class="px-4 py-2">{{ $transaksi->first()->DESKRIPSI_BUNGKUS }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="px-4 py-2 bg-purple-50">Image Bungkus</th>
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $transaksi->first()->IMAGE_BUNGKUS) }}" alt="Bungkus" width="100">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Produk yang Dipesan -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-bold mb-6">Produk yang Dipesan</h2>
            <div class="space-y-4">
                @php $total = 0; @endphp
                @foreach ($transaksi as $transaksis)
                    @if ($transaksis->produk)
                        @php 
                            $subtotal = $transaksis->produk->HARGA * $transaksis->JUMLAH;
                            $total += $subtotal;
                        @endphp
                        <div class="flex items-center space-x-4 border-b pb-4">
                            <img src="{{ asset('storage/' . $transaksis->produk->IMAGE_PRODUK) }}" alt="{{ $transaksis->produk->NAMA_PRODUK }}" class="w-16 h-16 object-cover rounded-md">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $transaksis->produk->NAMA_PRODUK }}</h3>
                                <p class="text-sm text-gray-500">Jumlah: {{ $transaksis->JUMLAH }}</p>
                                <p class="text-sm text-gray-500">Harga Satuan: Rp. {{ number_format($transaksis->produk->HARGA, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-gray-800 font-semibold">Rp. {{ number_format($subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endif
                @endforeach
                <div class="flex justify-end mt-4">
                    <p class="text-lg font-bold">Total: Rp. {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
