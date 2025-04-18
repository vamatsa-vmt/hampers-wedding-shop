@extends('pelanggan.app')

@section('content')
<a href="{{ route('admin.pesanan.index') }}" class="w-10 h-10 flex items-center justify-center bg-purple-200 rounded-full hover:bg-purple-100 mb-6">
    <i class="fas fa-chevron-left text-xl"></i>
</a>

<div class="container py-4" style="max-width: 800px; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); font-family: 'Courier New', monospace; font-size: 18px; line-height: 2;">
    <div class="nota-wrapper">
        <!-- Header Nota -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h3 style="font-size: 22px;">Nota Pesanan</h3>
            <p style="font-size: 18px;">Kode Transaksi : <strong>{{ $transaksis->first()->KODE_TRANSAKSI }}</strong></p>
            <p style="font-size: 18px;">Tanggal : <strong>{{ $tanggal_nota }}</strong></p>
        </div>

        <hr style="border-top: 1px dashed #000; margin-bottom: 10px;">
        <!-- Tabel Barang -->
        <table style="width: 100%; font-size: 18px; border-spacing: 0; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 8px;">Nama Produk</th>
                    <th style="text-align: center; padding: 8px;">Jumlah</th>
                    <th style="text-align: right; padding: 8px;">Harga</th>
                    <th style="text-align: right; padding: 8px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($transaksis as $transaksi)
                    @if ($transaksi->produk)
                        @php $subtotal = $transaksi->produk->HARGA * $transaksi->JUMLAH; $total += $subtotal; @endphp
                        <tr>
                            <td style="padding: 8px;">{{ $transaksi->produk->NAMA_PRODUK }}</td>
                            <td style="text-align: center; padding: 8px;">{{ $transaksi->JUMLAH }}</td>
                            <td style="text-align: right; padding: 8px;">{{ number_format($transaksi->produk->HARGA, 0, ',', '.') }}</td>
                            <td style="text-align: right; padding: 8px;">{{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr><td colspan="4" style="text-align: center; padding: 8px;">Produk tidak tersedia</td></tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <hr style="border-top: 1px dashed #000; margin-bottom: 10px;">

        <!-- Total Harga -->
        <div style="font-size: 20px; font-weight: bold; text-align: right;">
            <p>Total: <span style="font-size: 22px;">{{ number_format($total, 0, ',', '.') }}</span></p>
        </div>

        <hr style="border-top: 1px dashed #000; margin-bottom: 10px;">

        <!-- Informasi Pengiriman -->
        <div style="font-size: 18px;">
            <p><strong>Alamat Pengiriman:</strong> {{ Auth::user()->alamat }}</p>
            <p><strong>Waktu Pengiriman:</strong> {{ $transaksis->first()->WAKTU_KIRIM }}</p>
            <p><strong>Status Pesanan:</strong> {{ $transaksis->first()->STATUS }}</p>
        </div>
        <hr style="border-top: 1px dashed #000; margin-bottom: 10px;">
        <p style="text-align: center; font-size: 18px;">Terima kasih atas pesanan Anda!</p>
    </div>
    <button onclick="printNota()" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Print Nota</button>
</div>

<script>
    function printNota() {
        const printContent = document.querySelector('.nota-wrapper');
        const newWindow = window.open('', '', 'height=600,width=800');
        newWindow.document.write('<html><head><title>Print Nota</title></head><body>');
        newWindow.document.write(printContent.innerHTML); 
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.print();
    }
</script>
@endsection
