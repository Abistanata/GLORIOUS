@extends('layouts.theme')

@section('title', $pageTitle ?? 'Profile - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">
            <i class="fas fa-user-cog text-primary mr-2"></i> Profile & Pengaturan
        </h1>

        @if(session('success'))
            <x-alert type="success" class="mb-6" dismissible>{{ session('success') }}</x-alert>
        @endif
        @if($errors->any())
            <x-alert type="error" class="mb-6" dismissible>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </x-alert>
        @endif

        <div class="space-y-6">
            <div class="bg-gray-800/50 rounded-xl border border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Data Profil</h2>
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Username</label>
                            <input type="text" value="{{ $user->username }}" readonly
                                   class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-700 text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Email</label>
                            <input type="email" value="{{ $user->email ?? '-' }}" readonly
                                   class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-700 text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxx atau 62xxx"
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                            <p class="text-gray-500 text-xs mt-1">Digunakan untuk checkout dan konfirmasi pesanan</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Alamat Lengkap</label>
                            <textarea name="address" rows="3" placeholder="Alamat pengiriman / penagihan"
                                      class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">{{ old('address', $user->address) }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Ditampilkan di pesan WhatsApp saat checkout</p>
                        </div>
                        <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-gray-800/50 rounded-xl border border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Ubah Password</h2>
                <form action="{{ route('customer.profile.password') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Password Baru</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                        </div>
                        <button type="submit" class="w-full py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-xl transition-colors">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
