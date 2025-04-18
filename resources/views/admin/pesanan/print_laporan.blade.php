<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan Pelanggan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ffd700;
            color: #000;
        }
        @media print {
            body {
                background-color: white;
            }
            .container {
                box-shadow: none;
                border: none;
            }
            th, td {
                border: 1px solid black;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laporan Pesanan Pelanggan</h1>
        <table>
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Waktu Kirim</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedOrders = $laporan->groupBy('KODE_TRANSAKSI');
                @endphp
                @forelse($groupedOrders as $kode_transaksi => $orders)
                    @foreach($orders as $index => $order)
                        <tr>
                            @if ($index == 0)
                                <td rowspan="{{ count($orders) }}">{{ $kode_transaksi }}</td>
                                <td rowspan="{{ count($orders) }}">{{ $order->user->nama }}</td>
                            @endif
                            <td>{{ $order->produk->NAMA_PRODUK }}</td>
                            <td>{{ $order->JUMLAH }}</td>
                            @if ($index == 0)
                                <td rowspan="{{ count($orders) }}">{{ $order->STATUS }}</td>
                                <td rowspan="{{ count($orders) }}">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td rowspan="{{ count($orders) }}">{{ $order->WAKTU_KIRIM }}</td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pesanan yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
