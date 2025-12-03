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
        <!-- Stats & Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="gradient-border rounded-2xl p-6 bg-dark-lighter">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-primary rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-heart text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Items in Wishlist</p>
                        <p class="text-3xl font-bold text-white">{{ $wishlistItems->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="gradient-border rounded-2xl p-6 bg-dark-lighter">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Recently Viewed</p>
                        <p class="text-3xl font-bold text-white">0</p>
                    </div>
                </div>
            </div>
            
            <div class="gradient-border rounded-2xl p-6 bg-dark-lighter">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-shopping-cart text-2xl text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Ready to Buy</p>
                        <p class="text-3xl font-bold text-white">{{ $wishlistItems->where('stock', '>', 0)->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Wishlist Items -->
            <div class="lg:col-span-3">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-heading font-bold text-white mb-2">Your Saved Items</h2>
                        <p class="text-gray-400">Manage your wishlist items below</p>
                    </div>
                    
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <button class="px-4 py-2 bg-dark-light hover:bg-gray-800 text-gray-300 rounded-lg transition-all flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <button class="px-4 py-2 bg-dark-light hover:bg-gray-800 text-gray-300 rounded-lg transition-all flex items-center">
                            <i class="fas fa-sort mr-2"></i> Sort
                        </button>
                    </div>
                </div>

                <!-- Wishlist Items Grid -->
                @if($wishlistItems && $wishlistItems->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($wishlistItems as $item)
                        <div class="product-card bg-dark-lighter rounded-2xl overflow-hidden border border-gray-800 hover:border-primary/30 transition-all duration-300 group">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden h-48">
                                <img src="{{ $item->image_url ?? asset('images/default-product.jpg') }}" 
                                     alt="{{ $item->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                
                                <!-- Action Buttons -->
                                <div class="absolute top-4 right-4 flex flex-col space-y-2">
                                    <button class="w-10 h-10 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center transition-all transform translate-x-12 group-hover:translate-x-0 duration-300"
                                            onclick="removeFromWishlist({{ $item->id }})">
                                        <i class="fas fa-times text-white"></i>
                                    </button>
                                    <button class="w-10 h-10 bg-primary hover:bg-primary-dark rounded-full flex items-center justify-center transition-all transform translate-x-12 group-hover:translate-x-0 duration-300 delay-100"
                                            onclick="addToCart({{ $item->id }})">
                                        <i class="fas fa-shopping-cart text-white"></i>
                                    </button>
                                </div>
                                
                                <!-- Stock Badge -->
                                <div class="absolute top-4 left-4">
                                    @if($item->stock > 0)
                                        <span class="px-3 py-1 bg-green-500/90 text-white text-xs font-semibold rounded-full">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/90 text-white text-xs font-semibold rounded-full">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-bold text-lg text-white mb-1 line-clamp-1">{{ $item->name }}</h3>
                                        <p class="text-gray-400 text-sm mb-2">{{ $item->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <span class="text-primary font-bold text-xl">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                                
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <span>4.5</span>
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-eye mr-1"></i>
                                        <span>245</span>
                                    </div>
                                    <button onclick="viewProduct({{ $item->id }})" 
                                            class="px-4 py-2 bg-gray-800 hover:bg-primary text-gray-300 hover:text-white rounded-lg transition-all text-sm font-medium">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($wishlistItems->hasPages())
                    <div class="mt-12">
                        {{ $wishlistItems->links('vendor.pagination.custom') }}
                    </div>
                    @endif
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
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Summary Card -->
                <div class="gradient-border rounded-2xl p-6 bg-dark-lighter mb-6">
                    <h3 class="text-xl font-heading font-bold text-white mb-6">Wishlist Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Total Items</span>
                            <span class="text-white font-bold">{{ $wishlistItems->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">In Stock</span>
                            <span class="text-green-500 font-bold">{{ $wishlistItems->where('stock', '>', 0)->count() ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Out of Stock</span>
                            <span class="text-red-500 font-bold">{{ $wishlistItems->where('stock', '<=', 0)->count() ?? 0 }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-800 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-white">Total Value</span>
                            <span class="text-2xl font-bold gradient-text">
                                Rp {{ number_format($wishlistItems->sum('price'), 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <button class="w-full py-3 bg-gradient-primary hover:shadow-glow-primary text-white rounded-xl font-semibold transition-all flex items-center justify-center mb-3">
                            <i class="fas fa-shopping-cart mr-2"></i> Add All to Cart
                        </button>
                        
                        <button class="w-full py-3 bg-dark-light hover:bg-gray-800 text-gray-300 rounded-xl font-semibold transition-all flex items-center justify-center">
                            <i class="fas fa-share-alt mr-2"></i> Share Wishlist
                        </button>
                    </div>
                </div>
                
                <!-- Tips Card -->
                <div class="gradient-border rounded-2xl p-6 bg-dark-lighter">
                    <h3 class="text-xl font-heading font-bold text-white mb-6">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i> Pro Tips
                    </h3>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-300 text-sm">Items stay in your wishlist until you remove them</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-300 text-sm">Get notified when prices drop or items come back in stock</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-300 text-sm">Share your wishlist with friends and family</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-300 text-sm">Use wishlist to compare similar products</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" onclick="closeModal()"></div>
        
        <!-- Modal content -->
        <div class="relative bg-dark-lighter rounded-2xl overflow-hidden transform transition-all max-w-4xl w-full">
            <div class="absolute top-4 right-4 z-10">
                <button onclick="closeModal()" class="w-10 h-10 bg-gray-800 hover:bg-red-500 rounded-full flex items-center justify-center transition-all">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6">
                <!-- Content will be loaded via AJAX -->
                <div class="flex items-center justify-center py-12">
                    <div class="loading-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Remove from wishlist
    function removeFromWishlist(productId) {
        if (confirm('Remove this item from wishlist?')) {
            // AJAX call to remove from wishlist
            fetch(`/wishlist/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    // Add to cart
    function addToCart(productId) {
        // AJAX call to add to cart
        fetch(`/cart/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Product added to cart!', 'success');
            }
        });
    }

    // View product details
    function viewProduct(productId) {
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Load product details via AJAX
        fetch(`/products/${productId}/quick-view`)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
            });
    }

    // Close modal
    function closeModal() {
        const modal = document.getElementById('productModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
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