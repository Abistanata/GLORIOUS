@extends('layouts.theme')

@section('title', 'Login - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-dark-lighter rounded-2xl border border-gray-800 p-8">
            <h1 class="text-2xl font-bold text-white mb-2">Masuk ke Akun</h1>
            <p class="text-gray-400 mb-6">Gunakan akun Anda untuk belanja, wishlist, dan checkout.</p>

            @if(session('error') || $errors->any())
                <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300 text-sm">
                    {{ session('error') ?? $errors->first() }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-300 text-sm">{{ session('success') }}</div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-400 text-sm mb-1">Username / Email / No. HP</label>
                    <input type="text" name="login" value="{{ old('login') }}" required autofocus
                        class="w-full bg-dark border border-gray-700 rounded-lg text-white px-4 py-3 focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-gray-400 text-sm mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-dark border border-gray-700 rounded-lg text-white px-4 py-3 focus:ring-2 focus:ring-primary">
                </div>
                <label class="flex items-center gap-2 text-gray-400">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="rounded border-gray-600 bg-dark text-primary">
                    <span class="text-sm">Ingat saya</span>
                </label>
                <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                    Masuk
                </button>
            </form>
            <p class="mt-6 text-center text-gray-400 text-sm">
                Belum punya akun? <a href="{{ route('main.dashboard.index') }}#register" class="text-primary hover:underline">Daftar di sini</a> (popup di beranda).
            </p>
            <p class="mt-2 text-center">
                <a href="{{ route('main.dashboard.index') }}" class="text-gray-500 hover:text-white text-sm">← Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</div>
@endsection
