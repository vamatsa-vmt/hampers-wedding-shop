@extends('pelanggan.app')
@section('title', 'Halaman Transaksi')

@section('content')
<section class="bg-gray-50 py-8 px-6">
    <!-- Button Kembali -->
    <a href="{{ route('pelanggan.cart.index') }}" class="w-10 h-10 flex items-center justify-center bg-purple-200 rounded-full hover:bg-purple-100 mb-6">
        <i class="fas fa-chevron-left text-xl"></i>
    </a>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Form Input -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Data Pelanggan</h2>
            <form action="{{ route('pelanggan.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" value="{{ Auth::user()->nama }}" disabled class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Deskripsi Bungkus</label>
                    <textarea name="deskripsi_bungkus" class="w-full border rounded-lg px-4 py-2"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Contoh Desain Bungkus</label>
                    <input type="file" name="image_bungkus" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Alamat Lengkap</label>
                    <input name="alamat" value="{{ Auth::user()->alamat }}" disabled class="w-full border rounded-lg px-4 py-2">
                </div>
                <div class="form-group mb-4">
                    <label for="waktu_kirim">Tanggal Kirim:</label>
                    <input type="date" id="waktu_kirim" name="waktu_kirim" class="form-control w-full border rounded-lg px-4 py-2" required>
                </div>
                
                {{-- <div class="form-group mb-4">
                    <label for="waktu_kirim_time">Waktu Kirim:</label>
                    <input type="time" id="waktu_kirim_time" name="waktu_kirim_time" class="form-control w-full border rounded-lg px-4 py-2" required>
                </div>                 --}}
            </div>

        <!-- Produk yang Dipesan -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Produk yang Dipesan</h2>
            @if(empty($cart))
                <p class="text-gray-500">Keranjang kosong.</p>
            @else
                <table class="w-full text-left border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nama Produk</th>
                            <th class="px-4 py-2">Harga</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $item['name'] }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $item['quantity'] }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="mt-4 font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                @endif

                <!-- Detail Pembayaran -->
                <div class="mt-4">
                    <hr class="mb-4">
                    <h2 class="text-lg font-bold mb-4">Detail Pembayaran</h2>
                    <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                    <div class="flex items-center gap-4">
                        <select id="paymentMethod" class="border rounded-lg px-4 py-2 shadow-lg">
                            <option value="" selected disabled>Pilih Metode</option>
                            <option value="qris">QRIS</option>
                            <option value="e-wallet">E-Wallet</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                        <div id="extraOptions" class="flex items-center gap-4" style="display:none;">
                            <select id="eWalletOptions" class="border rounded-lg px-4 py-2 shadow-lg">
                                <option value="shopeepay">ShopeePay</option>
                                <option value="dana">DANA</option>
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                            </select>
                        </div>
                        <p class="text-gray-700 bg-pink-100 p-2 rounded-lg shadow-lg" id="accountNumber" style="display:none;"><strong></strong></p>
                        <img id="qrisImage" src="/images/qris.jpeg" alt="QRIS Code" style="display:none; width:100px; height:100px;">
                    </div>
                    
                    <div class="mb-4 mt-4">
                        <label class="block text-sm font-medium mb-2">Upload Bukti Pembayaran</label>
                        <input type="file" name="image_bukti_transaksi" class="w-full border rounded-lg px-4 py-2">
                    </div>
                    
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg" id="submitBtn">
                        Buat Pesanan
                    </button>
                    <div id="loading" class="hidden">Mengirim...</div>
                </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('paymentMethod').addEventListener('change', function() {
        let accountNumber = document.getElementById('accountNumber');
        let accountText = accountNumber.querySelector('strong');
        let qrisImage = document.getElementById('qrisImage');
        let extraOptions = document.getElementById('extraOptions');
        let eWalletOptions = document.getElementById('eWalletOptions');
        
        accountNumber.style.display = 'none';
        qrisImage.style.display = 'none';
        extraOptions.style.display = 'none';
        
        if (this.value === 'transfer') {
            accountText.textContent = '0019785647';
            accountNumber.style.display = 'block';
        } else if (this.value === 'qris') {
            qrisImage.style.display = 'block';
        } else if (this.value === 'e-wallet') {
            extraOptions.style.display = 'block';
        }
    });

    document.getElementById('eWalletOptions').addEventListener('change', function() {
        let accountNumber = document.getElementById('accountNumber');
        let accountText = accountNumber.querySelector('strong');
        
        accountText.textContent = '085745408225';
        accountNumber.style.display = 'block';
    });
    
    document.querySelector('#submitBtn').addEventListener('click', () => {
        document.querySelector('#loading').classList.remove('hidden');
    });
</script>
@endsection
