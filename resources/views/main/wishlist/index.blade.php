@extends('layouts.theme')

@section('title', 'Wishlist - Glorious Computer')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] pt-24 pb-16">

    {{-- ── HERO BANNER ─────────────────────────────────────── --}}
    <div class="relative overflow-hidden bg-gradient-primary py-20">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        {{-- Dekoratif glow --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-red-500/20 border border-red-400/30 mx-auto mb-5">
                <i class="fas fa-heart text-3xl text-red-400"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in">
                My Wishlist
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
                Save your favorite products for later purchase. Your wishlist is automatically saved and synced across devices.
            </p>
        </div>
    </div>

    {{-- ── MAIN CONTENT ─────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        {{-- STATS — @php logic tidak diubah --}}
        @php
            $wishlistCount      = $wishlistItems->count();
            $inStockCount       = $wishlistItems->filter(fn($p) => ($p->current_stock ?? 0) > 0)->count();
            $wishlistTotalValue = $wishlistItems->sum(fn($p) => $p->final_price ?? $p->selling_price ?? 0);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6 hover:border-primary/30 transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-primary/10 border border-primary/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-heart text-2xl text-primary"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Item di Wishlist</p>
                        <p class="text-3xl font-bold text-white mt-0.5">{{ $wishlistCount }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6 hover:border-green-500/30 transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-green-500/10 border border-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-2xl text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Tersedia stok</p>
                        <p class="text-3xl font-bold text-white mt-0.5">{{ $inStockCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── WISHLIST CONTENT ─────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- Items --}}
            <div class="lg:col-span-3">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-1">Item Tersimpan</h2>
                    <p class="text-gray-400 text-sm">Kelola wishlist Anda</p>
                </div>

                @if($wishlistItems && $wishlistItems->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                            @php
                                $product      = $item;
                                $price        = $product->final_price ?? $product->selling_price ?? 0;
                                $currentStock = $product->current_stock ?? 0;
                                $imageUrl     = $product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)
                                                    ? asset('storage/' . $product->image) : null;
                            @endphp

                            <div class="group bg-white/5 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10
                                        hover:border-primary/30 hover:-translate-y-1
                                        transition-all duration-300 shadow-md hover:shadow-xl hover:shadow-primary/10">

                                {{-- Image --}}
                                <div class="relative overflow-hidden h-52 bg-gray-900">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                                            <i class="fas fa-laptop text-5xl opacity-30"></i>
                                        </div>
                                    @endif

                                    {{-- Action buttons — onclick/route TIDAK diubah --}}
                                    <div class="absolute top-3 right-3 flex flex-col gap-2">
                                        <button type="button"
                                                class="w-9 h-9 bg-red-500/90 hover:bg-red-600 rounded-full flex items-center justify-center transition-all shadow-lg"
                                                onclick="removeFromWishlist({{ $product->id }})"
                                                title="Hapus dari wishlist">
                                            <i class="fas fa-times text-white text-sm"></i>
                                        </button>
                                        <a href="{{ route('wishlist.move-to-cart', $product->id) }}"
                                           class="w-9 h-9 bg-primary hover:bg-primary-dark rounded-full flex items-center justify-center transition-all shadow-lg"
                                           title="Pindah ke keranjang"
                                           onclick="return confirm('Pindah ke keranjang?');">
                                            <i class="fas fa-shopping-cart text-white text-sm"></i>
                                        </a>
                                    </div>

                                    {{-- Stock badge — logic TIDAK diubah --}}
                                    <div class="absolute top-3 left-3">
                                        @if($currentStock > 0)
                                            <span class="px-2.5 py-1 bg-green-500/90 text-white text-xs font-semibold rounded-full shadow">Tersedia</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-red-500/90 text-white text-xs font-semibold rounded-full shadow">Habis</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="p-5">
                                    <div class="flex justify-between items-start gap-2 mb-2">
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-white line-clamp-1 group-hover:text-primary transition-colors">
                                                {{ $product->name }}
                                            </h3>
                                            <p class="text-gray-500 text-xs mt-0.5">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                        <span class="text-primary font-bold text-sm whitespace-nowrap flex-shrink-0">
                                            Rp {{ number_format($price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                        {{ Str::limit($product->description ?? $product->specification ?? '', 80) }}
                                    </p>
                                    <a href="{{ route('main.products.show', $product->id) }}"
                                       class="block w-full py-2.5 text-center bg-gray-800 hover:bg-primary
                                              text-gray-300 hover:text-white rounded-xl text-sm font-semibold
                                              transition-all duration-200">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @else
                    {{-- Empty state — route/href TIDAK diubah --}}
                    <div class="text-center py-20 bg-white/5 backdrop-blur-xl rounded-2xl border-2 border-dashed border-white/10">
                        <div class="w-24 h-24 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-6 border border-gray-700">
                            <i class="fas fa-heart text-4xl text-gray-600"></i>
                        </div>
                        <h3 class="text-2xl font-heading font-bold text-white mb-3">Your wishlist is empty</h3>
                        <p class="text-gray-400 max-w-md mx-auto mb-8 leading-relaxed">
                            Start adding products you love to your wishlist. They'll appear here for easy access when you're ready to purchase.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('main.products.index') }}"
                               class="px-8 py-3 bg-gradient-primary hover:shadow-glow-primary text-white rounded-xl font-semibold transition-all
                                      flex items-center justify-center hover:-translate-y-0.5">
                                <i class="fas fa-shopping-bag mr-2"></i> Browse Products
                            </a>
                            <a href="{{ url('/') }}#services"
                               class="px-8 py-3 bg-dark-light hover:bg-gray-800 text-gray-300 rounded-xl font-semibold transition-all
                                      flex items-center justify-center border border-white/10">
                                <i class="fas fa-cogs mr-2"></i> Explore Services
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── SIDEBAR RINGKASAN — semua nilai dari @php di atas, tidak diubah ── --}}
            <div class="lg:col-span-1">
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6 sticky top-24">
                    <h3 class="text-base font-bold text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-primary text-sm"></i>
                        Ringkasan
                    </h3>

                    <div class="space-y-1 mb-4">
                        <div class="flex justify-between items-center text-sm py-3 border-b border-white/5">
                            <span class="text-gray-400">Total item</span>
                            <span class="text-white font-semibold">{{ $wishlistCount }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm py-3">
                            <span class="text-gray-400">Tersedia</span>
                            <span class="text-green-400 font-semibold">{{ $inStockCount }}</span>
                        </div>
                    </div>

                    <div class="py-4 px-4 bg-white/5 rounded-xl border border-white/10 mb-5">
                        <p class="text-gray-500 text-xs mb-1">Total nilai</p>
                        <p class="text-primary font-bold text-xl">
                            Rp {{ number_format($wishlistTotalValue, 0, ',', '.') }}
                        </p>
                    </div>

                    <a href="{{ route('main.products.index') }}"
                       class="block w-full py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold
                              text-center transition-all shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Produk
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── SCRIPTS — tidak diubah sama sekali ─────────────────── --}}
@push('scripts')
<script>
    function ensureCustomerLogin(reason = 'login_required') {
        try {
            if (typeof PopupManager !== 'undefined' && PopupManager && !PopupManager.isCustomerLoggedIn()) {
                PopupManager.promptCustomerLogin({ reason, redirectUrl: window.location.href });
                return false;
            }
        } catch (e) {
            // ignore
        }
        return true;
    }

    function removeFromWishlist(productId) {
        if (!ensureCustomerLogin('wishlist')) return;
        if (!confirm('Hapus item ini dari wishlist?')) return;
        fetch(`/wishlist/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) location.reload();
        })
        .catch(() => location.reload());
    }

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-xl font-semibold text-white animate-fade-in ${
            type === 'success' ? 'bg-green-500' :
            type === 'error'   ? 'bg-red-500'   :
            'bg-primary'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function shareWishlist() {
        if (navigator.share) {
            navigator.share({
                title: 'My Wishlist - Glorious Computer',
                text: 'Check out my wishlist on Glorious Computer',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            showToast('Link copied to clipboard!', 'success');
        }
    }
</script>
@endpush

{{-- ── STYLES — tidak diubah sama sekali ──────────────────── --}}
<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .pagination { display: flex; justify-content: center; list-style: none; padding: 0; }
    .page-item  { margin: 0 2px; }
    .page-link  {
        display: block; padding: 8px 16px;
        background: #2D2D2D; color: #F8FAFC;
        border-radius: 8px; transition: all 0.3s ease;
    }
    .page-link:hover { background: #FF6B00; color: white; transform: translateY(-2px); }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #FF6B00, #FF8C42);
        color: white; font-weight: bold;
    }
</style>
@endsection
@endsection
@endsection
@endsection