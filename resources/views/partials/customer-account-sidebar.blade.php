{{-- Sidebar untuk halaman Akun Customer (Profile, Pesanan Saya) - UI improvement --}}
<nav class="space-y-1" aria-label="Akun Saya">
    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Akun Saya</p>
    <a href="{{ route('customer.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('customer.profile.*') ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/40' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
        <i class="fas fa-user-cog w-5 text-center"></i>
        Profile
    </a>
    <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('customer.orders') ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/40' : 'text-slate-400 hover:bg-slate-700/50 hover:text-white' }}">
        <i class="fas fa-shopping-bag w-5 text-center"></i>
        Pesanan Saya
    </a>
</nav>
