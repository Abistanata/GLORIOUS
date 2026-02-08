@extends('layouts.theme')

@section('title', 'Wishlist - Glorious Computer')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-dark to-dark-lighter pt-24">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-primary py-16">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-white mb-4 animate-fade-in">
                <i class="fas fa-heart mr-3 text-red-400"></i>My Wishlist
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">
                Save your favorite products for later purchase. Your wishlist is automatically saved and synced across devices.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @php
            $wishlistCount = $wishlistItems->count();
            $inStockCount = $wishlistItems->filter(fn($p) => ($p->current_stock ?? 0) > 0)->count();
            $wishlistTotalValue = $wishlistItems->sum(fn($p) => $p->final_price ?? $p->selling_price ?? 0);
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="rounded-xl p-6 bg-dark-lighter border border-gray-800">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-heart text-xl text-primary"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Item di Wishlist</p>
                        <p class="text-2xl font-bold text-white">{{ $wishlistCount }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl p-6 bg-dark-lighter border border-gray-800">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check text-xl text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Tersedia stok</p>
                        <p class="text-2xl font-bold text-white">{{ $inStockCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Wishlist Items -->
            <div class="lg:col-span-3">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-white mb-1">Item Tersimpan</h2>
                    <p class="text-gray-400 text-sm">Kelola wishlist Anda</p>
                </div>

                <!-- Wishlist Items Grid -->
                @if($wishlistItems && $wishlistItems->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                            @php
                                $product = $item;
                                $price = $product->final_price ?? $product->selling_price ?? 0;
                                $currentStock = $product->current_stock ?? 0;
                                $imageUrl = $product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)
                                    ? asset('storage/' . $product->image) : null;
                            @endphp
                        <div class="bg-dark-lighter rounded-xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-300 group">
                            <div class="relative overflow-hidden h-48 bg-gray-900">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600"><i class="fas fa-laptop text-4xl"></i></div>
                                @endif
                                <div class="absolute top-3 right-3 flex flex-col gap-2">
                                    <button type="button" class="w-9 h-9 bg-red-500/90 hover:bg-red-600 rounded-full flex items-center justify-center transition-all"
                                            onclick="removeFromWishlist({{ $product->id }})" title="Hapus dari wishlist">
                                        <i class="fas fa-times text-white text-sm"></i>
                                    </button>
                                    <a href="{{ route('wishlist.move-to-cart', $product->id) }}" class="w-9 h-9 bg-primary hover:bg-primary-dark rounded-full flex items-center justify-center transition-all" title="Pindah ke keranjang"
                                       onclick="return confirm('Pindah ke keranjang?');">
                                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                                    </a>
                                </div>
                                <div class="absolute top-3 left-3">
                                    @if($currentStock > 0)
                                        <span class="px-2.5 py-1 bg-green-500/90 text-white text-xs font-semibold rounded-full">Tersedia</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-500/90 text-white text-xs font-semibold rounded-full">Habis</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold text-white line-clamp-1">{{ $product->name }}</h3>
                                        <p class="text-gray-400 text-xs">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <span class="text-primary font-bold">Rp {{ number_format($price, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($product->description ?? $product->specification ?? '', 80) }}</p>
                                <a href="{{ route('main.products.show', $product->id) }}" class="block w-full py-2 text-center bg-gray-800 hover:bg-primary text-gray-300 hover:text-white rounded-lg text-sm font-medium transition-all">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty Wishlist State -->
                    <div class="text-center py-16 bg-dark-lighter rounded-2xl border-2 border-dashed border-gray-800">
                        <div class="w-24 h-24 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-heart text-4xl text-gray-600"></i>
                        </div>
                        <h3 class="text-2xl font-heading font-bold text-white mb-3">Your wishlist is empty</h3>
                        <p class="text-gray-400 max-w-md mx-auto mb-8">
                            Start adding products you love to your wishlist. They'll appear here for easy access when you're ready to purchase.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('main.products.index') }}" 
                               class="px-6 py-3 bg-gradient-primary hover:shadow-glow-primary text-white rounded-xl font-semibold transition-all flex items-center justify-center">
                                <i class="fas fa-shopping-bag mr-2"></i> Browse Products
                            </a>
                            <a href="{{ route('main.services.index') }}" 
                               class="px-6 py-3 bg-dark-light hover:bg-gray-800 text-gray-300 rounded-xl font-semibold transition-all flex items-center justify-center">
                                <i class="fas fa-cogs mr-2"></i> Explore Services
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="lg:col-span-1">
                <div class="rounded-xl p-6 bg-dark-lighter border border-gray-800 sticky top-24">
                    <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Total item</span>
                            <span class="text-white font-medium">{{ $wishlistCount }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Tersedia</span>
                            <span class="text-green-400 font-medium">{{ $inStockCount }}</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 pt-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Total nilai</span>
                            <span class="text-primary font-bold text-lg">Rp {{ number_format($wishlistTotalValue, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('main.products.index') }}" class="block w-full py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold text-center transition-all">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

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

    // Toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-xl font-semibold text-white animate-fade-in ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 
            'bg-primary'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Share wishlist
    function shareWishlist() {
        if (navigator.share) {
            navigator.share({
                title: 'My Wishlist - Glorious Computer',
                text: 'Check out my wishlist on Glorious Computer',
                url: window.location.href
            });
        } else {
            // Fallback copy to clipboard
            navigator.clipboard.writeText(window.location.href);
            showToast('Link copied to clipboard!', 'success');
        }
    }
</script>
@endpush

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
    
    /* Custom pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }
    
    .page-item {
        margin: 0 2px;
    }
    
    .page-link {
        display: block;
        padding: 8px 16px;
        background: #2D2D2D;
        color: #F8FAFC;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .page-link:hover {
        background: #FF6B00;
        color: white;
        transform: translateY(-2px);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #FF6B00, #FF8C42);
        color: white;
        font-weight: bold;
    }
</style>
@endsection