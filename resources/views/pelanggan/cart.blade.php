@extends('pelanggan.app')
@section('title', 'Keranjang Belanja')
@section('content')
<section class="px-6 py-8 bg-white">
    <div class="max-w-4xl mx-auto">
        <!-- Button Kembali -->
        <a href="{{ route('pelanggan.index') }}" class="w-10 h-10 flex items-center justify-center bg-purple-200 rounded-full hover:bg-purple-100 mb-6">
            <i class="fas fa-chevron-left text-xl"></i>
        </a>

        <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>

        <!-- Notifikasi -->
        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6 mb-6" role="alert">
                <strong class="font-bold">Produk Berhasil Ditambahkan!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>

            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.style.display = 'none';
                    }
                }, 3000);
            </script>
        @endif

        <!-- Tabel Keranjang -->
        @if(empty($cart))
            <p class="text-red-700">Keranjang kosong.</p>
        @else
            <table class="table-auto w-full border-collapse mt-6">
                <thead>
                    <tr class="bg-violet-200">
                        <th class="p-2">Produk</th>
                        <th class="p-2">Jumlah</th>
                        <th class="p-2">Harga</th>
                        <th class="p-2">Subtotal</th>
                        <th class="p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-red-50">
                    @php $total = 0; @endphp
                    @foreach (session('cart', []) as $productId => $item)
                        @php 
                            $subtotal = $item['quantity'] * $item['price']; 
                            $total += $subtotal; 
                        @endphp
                        <tr>
                            <td class="p-2 pl-12 flex items-center">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover mr-4">
                                <span>{{ $item['name'] }}</span>
                            </td>
                            <td class="p-2 text-center">{{ $item['quantity'] }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="p-2 pr-6 text-center">
                                <form action="{{ route('pelanggan.cart.destroy', $productId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded-md">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tabel Total dan Checkout -->
            <div class="mt-12">
                <table class="w-full text-right">
                    <tr>
                        <td class="text-lg font-bold">Total Keseluruhan : Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <div class="flex justify-end mt-4 space-x-4">
                    <form action="{{ route('pelanggan.cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md">Kosongkan Keranjang</button>
                    </form>
                    <a href="{{ route('pelanggan.transaksi.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Lanjut Pembayaran
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
