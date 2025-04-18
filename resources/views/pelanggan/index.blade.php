@extends('pelanggan.app')
@section('tittle', 'Beranda')
@section('content')
<!-- Navbar -->
<nav id="navbar" class="fixed top-0 left-0 w-full transition-all duration-300 z-50">
    <div class="flex justify-between items-center px-12 py-4 bg-transparent">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Logo BlissBox" class="w-32">
        </div>
        <div class="flex items-center space-x-6">
            <!-- Cart -->
            <a href="{{ route('pelanggan.cart.index') }}" class="relative">
                <img src="{{ asset('images/cart.png') }}" alt="Cart Icon" class="w-8 h-8">
                <span class="absolute -top-2 -right-2 bg-[#FFF44F] text-black text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
            {{-- Profile --}}
            <div class="relative">
                @guest
                    {{-- Tombol Login untuk pengguna yang belum login --}}
                    <a href="{{ route('login') }}" class="w-20 h-10 p-2 rounded-lg bg-[#B76E79] shadow-lg text-white flex items-center justify-center hover:bg-pink-600 transition-colors duration-300 focus:outline-none">
                        <i class="fas fa-sign-in-alt text-sm mr-2"></i>Login
                    </a>
                    {{-- <a href="{{ route('login') }}" class="w-10 h-10 rounded-full bg-blue-500 shadow-lg text-white flex items-center justify-center hover:bg-blue-600 transition-colors duration-300 focus:outline-none">
                        <i class="fas fa-sign-in-alt text-2xl"></i>
                    </a> --}}
                @else
                    {{-- Dropdown Profile untuk pengguna yang sudah login --}}
                    <button id="profileToggle" class="w-12 h-12 rounded-full bg-white shadow-lg text-yellow-700 flex items-center justify-center hover:shadow-xl transition-shadow duration-300 focus:outline-none">
                        <i class="fas fa-user-circle text-3xl"></i>
                    </button>
                    <div id="profileDropdown" class="absolute right-0 mt-2 w-56 bg-white shadow-lg rounded-lg hidden transition-opacity duration-300">
                        <div class="py-3 px-4 border-b">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->nama }}</p>
                            <p class="text-xs text-gray-500">Active User</p>
                        </div>
                        <div class="py-2">
                            <a href="{{ route('profile') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user text-gray-500 mr-2"></i> Profile
                            </a>
                            <a href="{{ route('pelanggan.riwayat') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-book text-gray-500 mr-2"></i> Riwayat Transaksi
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();" 
                            class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-sign-out-alt text-gray-500 mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                @endguest
            </div>                    
        </div>        
    </div>
</nav>

<!-- Hero Section -->
<section class="relative flex flex-wrap items-center justify-between px-12 py-20 mt-16">
    <div class="absolute left-0 bottom-0 z-0">
        <img src="{{ asset('images/elemen-2.png') }}" alt="Dekorasi Kiri" class="w-72 h-auto">
    </div>
    <div class="absolute right-0 bottom-0 z-0">
        <img src="{{ asset('images/elemen-1.png') }}" alt="Dekorasi Kanan" class="w-96 h-auto">
    </div>
    <div class="w-full md:w-1/2 relative z-10 mb-12">
        <h1 class="text-5xl font-bold text-[#B76E79] leading-tight">Hadiah Pernikahan Terbaik di Indonesia</h1>
        <p class="text-lg mt-4 font-medium text-gray-700">
            Jadikan momen pernikahan Anda menjadi berharga dengan hadiah pernikahan terbaik dan berkualitas.
        </p>
        <a href="#kategori-produk" class="mt-6 px-6 py-3 bg-[#FFF44F] rounded-md text-lg font-semibold hover:bg-yellow-300 transition inline-block">
            Pesan Hampers Anda
        </a>
    </div>
    <div class="w-full md:w-1/2 relative z-10 flex justify-end mb-12">
        <img src="{{ asset('images/image-carousel-1.png') }}" alt="Hampers" class="w-96 h-auto">
    </div>
</section>

<!-- Tentang BlissBox -->
<section class="px-4 md:px-12 py-16 bg-white">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 md:p-8">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-[#B76E79] mb-4 md:mb-6">Tentang BlissBox</h2>
        <p class="text-base md:text-lg text-center font-medium text-gray-600 mb-6 md:mb-8">
            BlissBox adalah platform yang menghadirkan solusi hampers pernikahan Anda dengan layanan:
        </p>
        <div class="flex flex-wrap justify-center gap-y-6 gap-x-4">
            <!-- Card 1 -->
            <div class="w-1/4 flex flex-col items-center">
                <img src="{{ asset('images/fast.png') }}" alt="Icon Pengiriman Cepat" class="w-8 md:w-12 h-auto mb-3 md:mb-4">
                <h3 class="font-bold text-sm md:text-lg text-center">Pengiriman Cepat</h3>
            </div>
            <!-- Card 2 -->
            <div class="w-1/3 flex flex-col items-center">
                <img src="{{ asset('images/shield.png') }}" alt="Icon Aman" class="w-6 md:w-12 h-auto mb-3 md:mb-4">
                <h3 class="font-bold text-sm md:text-lg text-center">Pengiriman Aman</h3>
            </div>
            <!-- Card 3 -->
            <div class="w-1/3 flex flex-col items-center">
                <img src="{{ asset('images/hour.png') }}" alt="Icon Tepat Waktu" class="w-6 md:w-12 h-auto mb-3 md:mb-4">
                <h3 class="font-bold text-sm md:text-lg text-center">Pengiriman Tepat Waktu</h3>
            </div>
        </div>
    </div>
</section>

<!-- Keunikan -->
<section class="px-12 py-16 bg-[#FDF8F9]">
    <h2 class="text-3xl font-bold text-center text-[#B76E79] mb-12">Apa yang Membuat BlissBox Berbeda</h2>
    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
        <div>
            <ul class="space-y-6 mt-12">
                <li class="flex items-start">
                    <img src="{{ asset('images/icon-delivery.png') }}" alt="Pengiriman Aman" class="w-12 h-12 mr-4">
                    <div>
                        <h3 class="text-2xl font-bold">Pengiriman Tepat Waktu dan Aman</h3>
                        <p class="text-lg text-gray-600">Kami memastikan setiap hampers tiba sesuai jadwal penting acara Anda.</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <img src="{{ asset('images/icon-badge.png') }}" alt="Kualitas Terjamin" class="w-12 h-12 mr-4">
                    <div>
                        <h3 class="text-2xl font-bold">100% Kualitas Terjamin</h3>
                        <p class="text-lg text-gray-600">Kami memilih produk dengan cermat untuk memastikan kualitas terbaik.</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <img src="{{ asset('images/icon-paintbrush.png') }}" alt="Kustomisasi" class="w-12 h-12 mr-4">
                    <div>
                        <h3 class="text-2xl font-bold">Kustomisasi Sesuai Keinginan</h3>
                        <p class="text-lg text-gray-600">Hadirkan kesan personal dengan berbagai desain hampers yang sesuai tema Anda.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div>
            <img src="{{ asset('images/image-carousel-2.png') }}" alt="Kelebihan BlissBox" class="w-72 md:w-full">
        </div>
    </div>
</section>

<!-- Tips -->
<section style="padding: 3rem; background-color: white;">
    <h2 style="font-size: 2rem; font-weight: bold; text-align: center; color: #B76E79; margin-bottom: 3rem;">
        Cara Mudah Memesan di BlissBox
    </h2>
    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; max-width: 80rem; margin: 0 auto;">
        <!-- Step 1 -->
        <div style="text-align: center;">
            <div style="width: 3rem; height: 3rem; background-color: #D5F3FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: 1B2A41; margin: 0 auto;">
                1
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: medium; color: #4A5568;">
                Pilih produk berdasarkan kategori hampers.
            </p>
        </div>
        <!-- Step 2 -->
        <div style="text-align: center;">
            <div style="width: 3rem; height: 3rem; background-color: #D5F3FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: 1B2A41; margin: 0 auto;">
                2
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: medium; color: #4A5568;">
                Gratis kustomisasi bungkus sesuai keinginan.
            </p>
        </div>
        <!-- Step 3 -->
        <div style="text-align: center;">
            <div style="width: 3rem; height: 3rem; background-color: #D5F3FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: 1B2A41; margin: 0 auto;">
                3
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: medium; color: #4A5568;">
                Masukkan tanggal, dan waktu pengiriman.
            </p>
        </div>
        <!-- Step 4 -->
        <div style="text-align: center;">
            <div style="width: 3rem; height: 3rem; background-color: #D5F3FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: 1B2A41; margin: 0 auto;">
                4
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: medium; color: #4A5568;">
                Lakukan pembayaran hampers dan upload bukti pembayaran.
            </p>
        </div>
        <!-- Step 5 -->
        <div style="text-align: center;">
            <div style="width: 3rem; height: 3rem; background-color: #D5F3FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: 1B2A41; margin: 0 auto;">
                5
            </div>
            <p style="margin-top: 0.5rem; font-size: 0.875rem; font-weight: medium; color: #4A5568;">
                Pesanan dikemas dan dikirim sesuai jadwal.
            </p>
        </div>
    </div>
</section>

<!-- Produk -->
@include('pelanggan.produk');

<!-- Footer -->
<footer class="px-32 py-8 bg-gray-100">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Section 1: Brand Information -->
        <div>
            <h4 class="font-bold text-lg mb-4">BLISSBOX</h4>
            <p class="text-gray-600">
                Jl. Srikaya Babadan No. 35, Wuluh, Kec. Kesamben, Jombang, Jawa Timur 61484
            </p>
        </div>

        <!-- Section 2: Menu -->
        <div>
            <h4 class="font-bold text-lg mb-4">Menu</h4>
            <ul class="space-y-2 text-gray-600">
                <li><a href="#beranda" class="hover:text-[#B76E79]">Beranda</a></li>
                <li><a href="#tentang" class="hover:text-[#B76E79]">Tentang BlissBox</a></li>
                <li><a href="#rekomendasi" class="hover:text-[#B76E79]">Rekomendasi Produk</a></li>
                <li><a href="#pemesanan" class="hover:text-[#B76E79]">Pemesanan</a></li>
            </ul>
        </div>

        <!-- Section 3: Contact -->
        <div>
            <h4 class="font-bold text-lg mb-4">Kontak Kami</h4>
            <p class="text-gray-600">Email: info@blissbox.com</p>
            <p class="text-gray-600">Telp: 6285745408225</p>
            <div class="mt-4 flex space-x-4">
                <a href="" class="text-blue-600 text-xl hover:text-blue-800">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="text-pink-600 text-xl hover:text-pink-800">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="text-blue-400 text-xl hover:text-blue-600">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="text-black-400 text-xl hover:text-blue-600">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>            
        </div>
    </div>
    <div class="text-center text-gray-600 mt-8">
        &copy; 2024 BlissBox. Semua Hak Dilindungi.
    </div>
</footer>

<style>
    #navbar {
        background-color: transparent;
    }
    #navbar.scrolled {
        background-color: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
<script>
    window.addEventListener("scroll", function () {
        const navbar = document.getElementById("navbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
    document.getElementById('profileToggle').addEventListener('click', function () {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('profileDropdown');
        const toggle = document.getElementById('profileToggle');
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endsection