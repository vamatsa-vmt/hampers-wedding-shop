@extends('pelanggan.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<section class="py-8 px-6">
    <a href="{{ route('pelanggan.index') }}" class="w-10 h-10 flex items-center justify-center bg-purple-200 rounded-full hover:bg-purple-100 mb-6">
        <i class="fas fa-chevron-left text-xl"></i>
    </a>

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-5 text-center">Riwayat Transaksi</h1>
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-6">
            <table class="table table-striped w-full text-center">
                <thead class="bg-purple-100">
                    <tr>
                        <th class="px-4 py-2">Kode Transaksi</th>
                        <th class="px-4 py-2">Alamat</th>
                        <th class="px-4 py-2">Waktu Kirim</th>
                        <th class="px-4 py-2">Bukti Transaksi</th>
                        <th class="px-4 py-2">Status Pesanan</th>
                        {{-- <th class="px-4 py-2">Alasan Ditolak</th> --}}
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->kode_transaksi }}</td>
                            <td class="px-4 py-2">{{ Auth::user()->alamat }}</td>
                            <td class="px-4 py-2">{{ $item->waktu_kirim }}</td>
                            <td class="px-4 py-2">
                                @if ($item->image_bukti_transaksi)
                                    <img src="{{ asset('storage/' . $item->image_bukti_transaksi) }}" alt="Bukti" class="w-28 object-cover text-center">
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $item->status }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('pelanggan.detail', $item->kode_transaksi) }}"
                                    class="block w-full sm:w-auto text-center bg-blue-500 text-white px-2 py-2 rounded-md tezt-center hover:bg-blue-600 text-sm md:text-base lg:text-lg transition-all duration-300"
                                >
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
