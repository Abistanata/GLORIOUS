{{-- Sidebar untuk halaman Akun Customer (Profile, Pesanan Saya) --}}
<nav class="space-y-1" aria-label="Akun Saya">
    <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Akun Saya</p>
    <a href="{{ route('customer.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('customer.profile.*') ? 'bg-primary/20 text-primary border border-primary/40' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
        <i class="fas fa-user-cog w-5 text-center"></i>
        Profile
    </a>
    <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('customer.orders') ? 'bg-primary/20 text-primary border border-primary/40' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
        <i class="fas fa-shopping-bag w-5 text-center"></i>
        Pesanan Saya
    </a>
</nav>
