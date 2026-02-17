@extends('layouts.theme')

@section('title', $pageTitle ?? 'Profile - Glorious Computer')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- ── SIDEBAR — tidak diubah ──────────────────── --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6 sticky top-24">
                    @include('partials.customer-account-sidebar')
                </div>
            </aside>

            {{-- ── MAIN ─────────────────────────────────────── --}}
            <main class="flex-1 min-w-0">

                {{-- Profile Header --}}
                <div class="flex items-center gap-5 mb-10 p-6 bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10">
                    {{-- Avatar — logic tidak diubah --}}
                    @if($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path))
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                             alt=""
                             class="w-16 h-16 rounded-full object-cover border-2 border-primary/30 flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-800 border-2 border-gray-700 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-2xl text-gray-500"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-white">Profile & Pengaturan</h1>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $user->username }}</p>
                    </div>
                </div>

                {{-- Alerts — logic tidak diubah --}}
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

                <div class="space-y-8">

                    {{-- ── CARD 1: DATA PROFIL ─────────────── --}}
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-lg">
                        {{-- Card header --}}
                        <div class="flex items-center gap-3 px-8 py-5 border-b border-white/5">
                            <div class="w-9 h-9 bg-primary/10 border border-primary/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-edit text-primary text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Data Profil</h2>
                        </div>

                        {{-- Form — action, method, enctype, name, value TIDAK diubah --}}
                        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                  focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-600">
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Username</label>
                                    <input type="text" value="{{ $user->username }}" readonly
                                           class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-gray-500 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Email</label>
                                    <input type="email" value="{{ $user->email ?? '-' }}" readonly
                                           class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-gray-500 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Nomor WhatsApp</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fab fa-whatsapp text-green-400 text-sm"></i>
                                        </div>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                               placeholder="08xxx atau 62xxx" required
                                               class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                      focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-600">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-2 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-xs"></i>
                                        Digunakan untuk checkout dan konfirmasi pesanan
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Alamat Lengkap</label>
                                    <textarea name="address" rows="4"
                                              placeholder="Alamat pengiriman / penagihan" required
                                              class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                     focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-600 resize-none">{{ old('address', $user->address) }}</textarea>
                                    <p class="text-gray-500 text-xs mt-2 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-xs"></i>
                                        Wajib diisi untuk checkout. Ditampilkan di pesan WhatsApp.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Foto Profil</label>
                                    {{-- Preview — logic tidak diubah --}}
                                    @if($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path))
                                        <div class="mb-4 flex items-center gap-4">
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                                 alt="Foto profil"
                                                 class="w-20 h-20 rounded-full object-cover border-2 border-white/10">
                                            <p class="text-gray-500 text-xs">Foto saat ini</p>
                                        </div>
                                    @endif
                                   <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg,image/gif"
       class="w-full rounded-xl bg-white/5 border border-white/10 text-gray-400
              file:mr-4 file:py-3 file:px-5 file:rounded-l-xl file:border-0
              file:bg-gradient-to-r file:from-orange-500 file:to-red-500
              file:text-white file:font-semibold file:cursor-pointer
              hover:file:from-orange-400 hover:file:to-red-400
              file:transition-all transition-all">
                                </div>

                                <button type="submit"
        class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-400 hover:to-red-400 text-white font-bold rounded-xl
               transition-all shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 active:translate-y-0">
    <i class="fas fa-save mr-2"></i>
    Simpan Profil
</button>
                            </div>
                        </form>
                    </div>

                    {{-- ── CARD 2: UBAH PASSWORD ───────────── --}}
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-lg">
                        {{-- Card header --}}
                        <div class="flex items-center gap-3 px-8 py-5 border-b border-white/5">
                            <div class="w-9 h-9 bg-yellow-500/10 border border-yellow-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lock text-yellow-400 text-sm"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-white">Ubah Password</h2>
                        </div>

                        {{-- Form — action, method, name TIDAK diubah --}}
                        <form action="{{ route('customer.profile.password') }}" method="POST" class="p-8">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Password Saat Ini</label>
                                    <div class="relative">
                                        <input type="password" name="current_password" required
                                               id="current_password"
                                               class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                      focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all pr-12">
                                        <button type="button"
                                                onclick="togglePw('current_password')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" name="password" required
                                               id="new_password"
                                               class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                      focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all pr-12">
                                        <button type="button"
                                                onclick="togglePw('new_password')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-sm mb-2 font-medium">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" required
                                               id="confirm_password"
                                               class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white
                                                      focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all pr-12">
                                        <button type="button"
                                                onclick="togglePw('confirm_password')"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit"
        class="w-full py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400
               text-white font-bold rounded-xl transition-all shadow-lg shadow-yellow-500/30 hover:shadow-yellow-500/50 hover:-translate-y-0.5 active:translate-y-0">
    <i class="fas fa-key mr-2"></i>
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

{{-- Toggle password visibility — UI helper saja, tidak menyentuh form logic --}}
<script>
function togglePw(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.type = el.type === 'password' ? 'text' : 'password';
    const btn = el.nextElementSibling?.querySelector('i');
    if (btn) btn.classList.toggle('fa-eye'); btn && btn.classList.toggle('fa-eye-slash');
}
</script>
@endsection