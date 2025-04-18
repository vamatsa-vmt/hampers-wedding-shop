<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Akun</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="p-3 mt-1 block w-full rounded-md bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
                @error('nama')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="p-3 mt-1 block w-full rounded-md bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="p-3 mt-1 block w-full rounded-md bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" class="p-3 mt-1 block w-full rounded-md bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" class="p-3 mt-1 block w-full rounded-md bg-blue-50 shadow focus:border-blue-500 focus:ring-blue-500">
                @error('no_telepon')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-600 focus:outline-none">
                Daftar
            </button>
        </form>
        <p class="text-sm text-center text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('alert-success')?.remove();
        }, 5000);
    </script>
</body>
</html>
