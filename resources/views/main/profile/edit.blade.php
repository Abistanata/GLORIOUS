@extends('layouts.theme')

@section('title', $pageTitle ?? 'Profile - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Akun Saya --}}
            <aside class="lg:w-56 flex-shrink-0">
                <div class="bg-gray-800/50 rounded-2xl border border-gray-700 p-4 sticky top-24">
                    @include('partials.customer-account-sidebar')
                </div>
            </aside>

            <main class="flex-1 min-w-0">
                <div class="flex items-center gap-4 mb-6">
                    @if($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path))
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="" class="w-16 h-16 rounded-full object-cover border-2 border-gray-700">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-700 flex items-center justify-center border-2 border-gray-600">
                            <i class="fas fa-user text-2xl text-gray-500"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-white">Profile & Pengaturan</h1>
                        <p class="text-gray-400 text-sm">{{ $user->username }}</p>
                    </div>
                </div>

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
                    <div class="bg-gray-800/50 rounded-2xl border border-gray-700 p-6 shadow-lg">
                <h2 class="text-lg font-semibold text-white mb-4">Data Profil</h2>
                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxx atau 62xxx" required
                                   class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">
                            <p class="text-gray-500 text-xs mt-1">Digunakan untuk checkout dan konfirmasi pesanan</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Alamat Lengkap</label>
                            <textarea name="address" rows="3" placeholder="Alamat pengiriman / penagihan" required
                                      class="w-full px-4 py-2.5 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary">{{ old('address', $user->address) }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Wajib diisi untuk checkout. Ditampilkan di pesan WhatsApp.</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-1">Foto Profil</label>
                            @if($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto profil" class="w-20 h-20 rounded-full object-cover border-2 border-gray-700">
                                </div>
                            @endif
                            <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="w-full px-4 py-2 rounded-lg bg-dark border border-gray-700 text-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-primary file:text-white">
                        </div>
                        <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-gray-800/50 rounded-2xl border border-gray-700 p-6 shadow-lg">
                <h2 class="text-lg font-semibold text-white mb-4">Ubah Password</h2>
                <form action="{{ route('customer.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
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
            </main>
        </div>
    </div>
</div>
@endsection
