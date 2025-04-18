<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #b0b0b0;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-track {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-md hidden md:block fixed top-0 h-screen">
            <div class="p-4 text-center text-2xl font-bold">BLISSBOX</div>
            <nav class="mt-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.index') }}" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <span class="w-5 h-5 bg-blue-500 text-white flex items-center justify-center rounded-full text-sm">H</span>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li class="relative group">
                        <a href="#" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <span class="w-5 h-5 bg-green-500 text-white flex items-center justify-center rounded-full text-sm">D</span>
                            <span class="ml-3">Katalog</span>
                            <svg class="ml-auto w-4 h-4 text-gray-500 group-hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul class="hidden group-hover:block pl-8 space-y-1 text-gray-600">
                            <li><a href="{{ route('kategoriproduk.index') }}" class="block py-2 px-4 hover:bg-gray-200">Kategori Produk</a></li>
                            <li><a href="{{ route('produk.index') }}" class="block py-2 px-4 hover:bg-gray-200">Produk</a></li>
                        </ul>
                    </li>
                    <li class="relative group">
                        <a href="#" class="flex items-center p-4 text-gray-700 hover:bg-gray-200">
                            <span class="w-5 h-5 bg-purple-500 text-white flex items-center justify-center rounded-full text-sm">P</span>
                            <span class="ml-3">Pesanan</span>
                            <svg class="ml-auto w-4 h-4 text-gray-500 group-hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul class="hidden group-hover:block pl-8 space-y-1 text-gray-600">
                            <li><a href="{{ route('pesanan.index') }}" class="block py-2 px-4 hover:bg-gray-200">Data Pesanan</a></li>
                            <li><a href="{{ route('admin.pesanan.laporan') }}" class="block py-2 px-4 hover:bg-gray-200">Laporan Pesanan</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 bg-gray-50 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">Dashboard</h1>
                <button id="hamburger-btn" class="md:hidden text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="relative">
                    <button id="profileBtn" class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center text-xl focus:outline-none">
                        <i class="fas fa-user"></i>
                    </button>

                    <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md hidden">
                        <div class="py-2 px-4 text-gray-700">
                            <p class="text-sm font-medium">{{Auth::user()->nama}}</p>
                        </div>
                        <div class="border-t">
                            <a href="{{ route('auth.profile') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-blue-200"><i class="fas fa-user text-gray-500 mr-2"></i>Profile</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();" class="block py-2 px-4 text-sm text-gray-600 hover:bg-blue-200"><i class="fas fa-sign-out-alt text-gray-500 mr-1"></i>
                                Logout
                            </a>                            
                        </div>
                    </div>
                </div>
            </header>
            <main class="p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('hamburger-btn').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        profileBtn.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });
    </script>
</body>
</html>
