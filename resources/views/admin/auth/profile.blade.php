@extends('admin.sidenav')
@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Profil Saya</h1>
        @if (session('status'))
            <div id="alert" class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('auth.profile.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" 
                       class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block">Password (Opsional)</label>
                <input type="password" id="password" name="password" 
                class="w-full p-2 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="alamat" class="block">ALamat</label>
                <input type="alamat" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}" 
                       class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block">No Telepon</label>
                <input type="no_telepon" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" 
                       class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.getElementById('alert');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 3000);
        }
    });
</script>
@endsection
