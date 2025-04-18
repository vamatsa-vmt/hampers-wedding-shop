@extends('admin.sidenav')
@section('title', 'Pesanan')

@section('content')
<div class="container mx-auto mt-4">
    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Pesanan</h1>
        
        @if($transaksis->isEmpty())
            <p class="text-gray-500">Belum ada pesanan yang masuk.</p>
        @else
            <table class="min-w-full border border-[#B76E79] text-left">
                <thead class="bg-[#B76E79] border-[#B76E79] text-sm text-white text-center">
                    <tr>
                        <th class="py-3 px-6 border-r">Kode Transaksi</th>
                        <th class="py-3 px-6 border-r">Detail Pelanggan</th>
                        <th class="py-3 px-6 border-r">Produk</th>
                        <th class="py-3 px-6 border-r">Jumlah</th>
                        <th class="py-3 px-6 border-r">Bukti Transaksi</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($transaksis->groupBy('KODE_TRANSAKSI') as $kodeTransaksi => $groupTransaksi)
                        @php
                            $warnaBaris = ['bg-blue-50', 'bg-yellow-50', 'bg-green-50', 'bg-red-50'];
                            $warnaTerpilih = $warnaBaris[$loop->index % count($warnaBaris)];
                            $totalHarga = 0; 
                        @endphp
                        <tr class="border-b border-[#B76E79] hover:bg-purple-100 {{ $warnaTerpilih }}">
                            <td class="py-8 px-6 border-r border-[#B76E79]" rowspan="{{ $groupTransaksi->count() }}">
                                INV-{{ $kodeTransaksi }}
                            </td>
                            <td class="py-3 px-6 border-r border-[#B76E79]" rowspan="{{ $groupTransaksi->count() }}">
                                <div class="flex flex-col">
                                    <p><strong>Nama :</strong> {{ $groupTransaksi->first()->user->nama ?? 'Tidak Diketahui' }}</p>
                                    <p><strong>Alamat : </strong>{{ $groupTransaksi->first()->user->alamat ?? '-' }}</p>
                                    <p>
                                        <strong>Status:</strong>
                                        <span class="status-span px-3 py-1 text-md font-semibold rounded-full inline-block">
                                            {{ $groupTransaksi->first()->STATUS }}
                                        </span>
                                    </p>
                                    @if (!empty($groupTransaksi->first()->alasan_ditolak))
                                        <p>
                                            <strong>Alasan Ditolak:</strong> {{ $groupTransaksi->first()->alasan_ditolak }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            @foreach ($groupTransaksi as $index => $transaksi)
                                @php
                                    $subtotal = $transaksi->produk->HARGA * $transaksi->JUMLAH;
                                    $totalHarga += $subtotal;
                                @endphp
                                @if($index > 0) <tr class="border-b border-[#B76E79] hover:bg-purple-100 {{ $warnaTerpilih }}"> @endif
                                    <td class="py-3 px-6 text-center border-r border-[#B76E79]">{{ $transaksi->produk->NAMA_PRODUK ?? '-' }}</td>
                                    <td class="py-3 px-6 text-center border-r border-[#B76E79]">{{ $transaksi->JUMLAH }}</td>
                                @if($index == 0)
                                    <td class="py-3 px-6 text-center border-r border-[#B76E79]" rowspan="{{ $groupTransaksi->count() }}">
                                        <img src="{{ asset('storage/' . $groupTransaksi->first()->IMAGE_BUKTI_TRANSAKSI) }}" alt="Bukti Transaksi" width="100">
                                    </td>
                                    <td class="py-2 px-4" rowspan="{{ $groupTransaksi->count() }}">
                                        <div class="space-y-2">
                                            <form method="POST" action="{{ route('admin.pesanan.update', $transaksi->id) }}">
                                                @csrf
                                                <select name="STATUS" class="bg-blue-100 border-blue-300 rounded-md p-3 mb-3 status-select">
                                                    <option value="" disabled selected>-- Status Pesanan --</option>
                                                    <option value="Menunggu Konfirmasi" @if($transaksi->STATUS == 'Menunggu Konfirmasi') selected @endif>Menunggu Konfirmasi</option>
                                                    <option value="Pesanan Ditolak" @if($transaksi->STATUS == 'Pesanan Ditolak') selected @endif>Pesanan Ditolak</option>
                                                    <option value="Dikemas" @if($transaksi->STATUS == 'Dikemas') selected @endif>Dikemas</option>
                                                    <option value="Dikirim" @if($transaksi->STATUS == 'Dikirim') selected @endif>Dikirim</option>
                                                    <option value="Selesai" @if($transaksi->STATUS == 'Selesai') selected @endif>Selesai</option>
                                                </select>
                                                <textarea name="alasan_ditolak" class="hidden bg-red-100 border-red-300 rounded-md p-3 mb-4 w-full" placeholder="Masukkan alasan penolakan...">{{ $transaksi->alasan_ditolak }}</textarea>
                                            
                                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                                    <i class="fa fa-edit"></i> Ubah
                                                </button>
                                            </form>
                                            <form method="GET" action="{{ route('pesanan.cetak', $kodeTransaksi) }}">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                                    <i class="fa fa-print"></i> Cetak Nota
                                                </button>
                                            </form>
                                            <a href="{{ route('pesanan.detail', $transaksi->KODE_TRANSAKSI) }}" class="inline-block">
                                                <button type="button" class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600">
                                                    <i class="fa fa-info-circle"></i> Detail Pesanan
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                                @if($index > 0) </tr> @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let statusSelects = document.querySelectorAll('.status-select');

        statusSelects.forEach(select => {
            select.addEventListener('change', function () {
                let textarea = this.parentElement.querySelector('textarea');
                if (this.value === 'Pesanan Ditolak') {
                    textarea.classList.remove('hidden');
                    textarea.required = true;
                } else {
                    textarea.classList.add('hidden');
                    textarea.required = false;
                }
            });
        });
    });
</script>