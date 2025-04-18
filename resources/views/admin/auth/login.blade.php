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
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Akun</h2>

        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="post">
            @csrf
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
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow-md hover:bg-blue-600 focus:outline-none">
                Login
            </button>
        </form>        
        <p class="text-sm text-center text-gray-600 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar</a> dulu yuk!
        </p>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('alert-success')?.remove();
        }, 5000);
    </script>
</body>
</html>
