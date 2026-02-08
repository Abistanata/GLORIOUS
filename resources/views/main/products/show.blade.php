@extends('layouts.theme')

@section('title', $product->name . ' - Glorious Computer')

@section('head')
<meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
@endsection

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb - Minimal -->
        <nav class="mb-10">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('main.about.index') }}" class="hover:text-primary transition-colors duration-200">
                        Beranda
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li>
                    <a href="{{ route('main.products.index') }}" class="hover:text-primary transition-colors duration-200">
                        Produk
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white font-medium">{{ Str::limit($product->name, 25) }}</li>
            </ol>
        </nav>

        <!-- Main Product Section -->
        <div class="bg-gray-900/40 rounded-xl border border-gray-800 mb-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 md:p-8">
                
                <!-- Product Image -->
                <div>
                    <div class="bg-gray-800/50 rounded-xl overflow-hidden mb-4 border border-gray-700">
                        @php
                            $imagePath = $product->image;
                            $imageUrl = null;
                            
                            if ($imagePath) {
                                if (Storage::disk('public')->exists($imagePath)) {
                                    $imageUrl = asset('storage/' . $imagePath);
                                } elseif (Str::startsWith($imagePath, ['http://', 'https://'])) {
                                    $imageUrl = $imagePath;
                                }
                            }
                        @endphp

                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-96 object-cover transition-all duration-500 hover:scale-105 cursor-pointer"
                                 onclick="openImageModal('{{ $imageUrl }}')">
                        @else
                            <div class="w-full h-96 flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-laptop text-7xl mb-4 opacity-50"></i>
                                <p class="text-lg">Gambar Tidak Tersedia</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Image Action -->
                    @if($imageUrl)
                    <div class="flex justify-center">
                        <button onclick="openImageModal('{{ $imageUrl }}')" 
                                class="text-sm text-gray-400 hover:text-white flex items-center gap-2 transition-colors duration-200">
                            <i class="fas fa-expand"></i>
                            <span>Perbesar Gambar</span>
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category & SKU -->
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-medium rounded-full border border-primary/20">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-gray-400 text-sm">
                            SKU: <span class="text-gray-300 font-mono">{{ $product->sku ?? 'N/A' }}</span>
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-2xl md:text-3xl font-bold text-white leading-snug tracking-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating -->
                    <div class="flex items-center gap-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                            @endfor
                        </div>
                        <span class="text-gray-400 text-sm">(4.5 • 28 ulasan)</span>
                    </div>

                    <!-- Price Section - Menggunakan logic yang sama -->
                    @php
                        // Pricing logic dari Product model
                        $hasDiscount = $product->has_discount;
                        $discountPercentage = $product->discount_percentage;
                        $finalPrice = $product->final_price;
                        $sellingPrice = $product->selling_price;
                        $discountAmount = $product->getDiscountAmount();
                        
                        // Additional info
                        $condition = $product->getConditionLabel();
                        $warranty = $product->getWarrantyLabel();
                        $shipping = $product->getShippingInfoLabel();
                        
                        // Stock status
                        $currentStock = $product->current_stock;
                        $stockStatus = $product->stock_status;
                        $stockStatusLabel = $product->getStockStatusLabel();
                    @endphp

                    <div>
                        @if($hasDiscount && $discountPercentage > 0)
                            <div class="flex items-baseline gap-3 mb-2">
                                <span class="text-3xl md:text-4xl font-bold text-primary">
                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-400 line-through">
                                    Rp {{ number_format($sellingPrice, 0, ',', '.') }}
                                </span>
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">
                                    -{{ $discountPercentage }}%
                                </span>
                            </div>
                            <div class="text-green-400 text-sm flex items-center gap-2">
                                <i class="fas fa-tag"></i>
                                <span>Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-3xl md:text-4xl font-bold text-primary">
                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    <div class="p-4 bg-gray-800/30 rounded-lg border border-gray-700">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                @if($currentStock > 10)
                                    <span class="px-3 py-1 bg-green-600/20 text-green-400 text-sm font-medium rounded-full border border-green-600/30">
                                        <i class="fas fa-check mr-1"></i>Stok Tersedia
                                    </span>
                                @elseif($currentStock > 0)
                                    <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 text-sm font-medium rounded-full border border-yellow-600/30">
                                        <i class="fas fa-exclamation mr-1"></i>Stok Menipis
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-600/20 text-red-400 text-sm font-medium rounded-full border border-red-600/30">
                                        <i class="fas fa-times mr-1"></i>Stok Habis
                                    </span>
                                @endif
                                <span class="text-white font-medium">{{ $currentStock }} {{ $product->unit }}</span>
                            </div>
                        </div>
                        
                        @if($product->max_stock && $product->max_stock > 0)
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-primary rounded-full h-2 transition-all duration-500" 
                                 style="width: {{ min(100, ($currentStock / $product->max_stock) * 100) }}%">
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex gap-3">
                        @php
                            $isInWishlist = false; // Will be checked via JavaScript
                            $isInCart = false; // Will be checked via JavaScript
                        @endphp

                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $finalPrice }}, '{{ $product->image }}')"
                                class="flex-1 {{ $isInCart ? 'bg-green-500 hover:bg-green-600' : 'bg-primary hover:bg-primary-dark' }} text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2 border {{ $isInCart ? 'border-green-500' : 'border-primary' }}">
                            <i class="fas fa-shopping-cart"></i>
                            {{ $isInCart ? 'Di Keranjang' : 'Tambah ke Cart' }}
                        </button>

                        <button onclick="toggleWishlist({{ $product->id }})"
                                class="flex-1 {{ $isInWishlist ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-800 hover:bg-gray-700' }} text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2 border {{ $isInWishlist ? 'border-red-500' : 'border-gray-700' }}">
                            <i class="{{ $isInWishlist ? 'fas' : 'far' }} fa-heart"></i>
                            {{ $isInWishlist ? 'Di Wishlist' : 'Wishlist' }}
                        </button>

                        <button onclick="shareProduct()"
                                class="flex-1 bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2 border border-gray-700">
                            <i class="fas fa-share-alt"></i>
                            Bagikan
                        </button>
                    </div>

                    <!-- Product Features -->
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Garansi</p>
                                <p class="text-sm text-white font-medium">{{ $warranty }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-truck text-green-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Pengiriman</p>
                                <p class="text-sm text-white font-medium">{{ $shipping }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-yellow-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Kondisi</p>
                                <p class="text-sm text-white font-medium">{{ $condition }}</p>
                            </div>
                        </div>
                        
                        @if($product->supplier && $product->supplier->name)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-industry text-purple-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Supplier</p>
                                <p class="text-sm text-white font-medium">{{ $product->supplier->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Main Action Buttons -->
                    <div class="pt-6">
                        <div class="flex flex-col sm:flex-row gap-3">
                            @auth
                                @if(auth()->user()->role === 'Customer')
                                    <form action="{{ route('order.create-and-whatsapp') }}" method="POST" class="flex-1 order-wa-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-bold transition-all duration-200 flex items-center justify-center gap-3 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $currentStock == 0 ? 'disabled' : '' }}>
                                            <i class="fab fa-whatsapp text-lg"></i>
                                            {{ $currentStock == 0 ? 'Stok Habis' : 'Pesan via WhatsApp' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('main.products.index') }}" class="flex-1 bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded-lg font-medium flex items-center justify-center gap-3">
                                        <i class="fab fa-whatsapp"></i> Lihat Katalog
                                    </a>
                                @endif
                            @else
                                <button type="button"
                                        class="flex-1 js-require-login-wa bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-bold transition-all duration-200 flex items-center justify-center gap-3 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        data-message="Silakan login untuk memesan via WhatsApp."
                                        {{ $currentStock == 0 ? 'disabled' : '' }}>
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    {{ $currentStock == 0 ? 'Stok Habis' : 'Pesan via WhatsApp' }}
                                </button>
                            @endauth
                            <a href="{{ route('main.products.index') }}"
                               class="flex-1 bg-gray-800 hover:bg-gray-700 text-white py-3 px-6 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-3 border border-gray-700">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications & Description -->
            <div class="px-6 md:px-8 pb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Specifications -->
                    <div>
                        <h2 class="text-xl font-bold text-white mb-4 pb-3 border-b border-gray-800">Spesifikasi Produk</h2>
                        <div class="text-gray-300 leading-relaxed">
                            @if($product->specification && !empty(trim($product->specification)))
                                <div class="space-y-3">
                                    {!! nl2br(e($product->specification)) !!}
                                </div>
                            @else
                                <div class="text-center py-6 text-gray-500">
                                    <i class="fas fa-info-circle text-2xl mb-3"></i>
                                    <p>Spesifikasi tidak tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div>
                        <h2 class="text-xl font-bold text-white mb-4 pb-3 border-b border-gray-800">Deskripsi Produk</h2>
                        <p class="text-gray-300 leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedProducts as $related)
                    @php
                        $relatedCurrentStock = $related->current_stock;
                        $relatedHasDiscount = $related->has_discount;
                        $relatedFinalPrice = $related->final_price;
                        $relatedSellingPrice = $related->selling_price;
                        $relatedDiscountPercentage = $related->discount_percentage;
                        $relatedImagePath = $related->image;
                        $relatedImageUrl = null;
                        
                        if ($relatedImagePath) {
                            if (Storage::disk('public')->exists($relatedImagePath)) {
                                $relatedImageUrl = asset('storage/' . $relatedImagePath);
                            } elseif (Str::startsWith($relatedImagePath, ['http://', 'https://'])) {
                                $relatedImageUrl = $relatedImagePath;
                            }
                        }
                    @endphp
                    
                    <a href="{{ route('main.products.show', $related->id) }}" 
                       class="group bg-gray-900/40 rounded-xl border border-gray-800 hover:border-primary/50 transition-all duration-200 overflow-hidden hover:-translate-y-1">
                        <!-- Image -->
                        <div class="h-48 bg-gray-800 relative overflow-hidden">
                            @if($relatedImageUrl)
                                <img src="{{ $relatedImageUrl }}" 
                                     alt="{{ $related->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-laptop text-4xl text-gray-600"></i>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            @if($relatedHasDiscount && $relatedDiscountPercentage > 0)
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">
                                        -{{ $relatedDiscountPercentage }}%
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 right-3">
                                @if($relatedCurrentStock > 10)
                                    <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs font-medium rounded border border-green-500/30">
                                        Stok
                                    </span>
                                @elseif($relatedCurrentStock > 0)
                                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-medium rounded border border-yellow-500/30">
                                        Menipis
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs font-medium rounded border border-red-500/30">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-white mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                                {{ $related->name }}
                            </h3>
                            
                            <div class="mb-3">
                                @if($relatedHasDiscount && $relatedDiscountPercentage > 0)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-lg font-bold text-primary">
                                            Rp {{ number_format($relatedFinalPrice, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">
                                            Rp {{ number_format($relatedSellingPrice, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-lg font-bold text-primary">
                                        Rp {{ number_format($relatedFinalPrice, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-400">
                                <span>{{ $related->category->name ?? 'Uncategorized' }}</span>
                                <span>{{ $relatedCurrentStock }} {{ $related->unit }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            @if($product->category)
            <div class="text-center mt-8">
                <a href="{{ route('main.products.index', ['category_id' => $product->category_id]) }}" 
                   class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium transition-colors duration-200">
                    Lihat semua produk {{ $product->category->name }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
        @endif

        <!-- Support CTA -->
        <div class="bg-gradient-to-r from-primary/10 to-primary/5 rounded-xl border border-primary/20 p-6 text-center">
            <h2 class="text-xl font-bold text-white mb-3">Butuh Bantuan?</h2>
            <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                Tim support kami siap membantu Anda dengan pertanyaan teknis dan rekomendasi produk.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="https://wa.me/6282133803940" 
                   target="_blank"
                   class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp"></i>
                    Chat WhatsApp
                </a>
                <a href="tel:082133803940" 
                   class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2 border border-gray-700">
                    <i class="fas fa-phone"></i>
                    Telepon
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center">
        <div class="fixed inset-0 bg-black/90 transition-opacity" aria-hidden="true"></div>
        <div class="relative inline-block align-bottom rounded-2xl overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
            <div class="absolute top-4 right-4 z-10 flex gap-2">
                <button type="button" 
                        onclick="closeImageModal()"
                        class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-full transition-colors"
                        title="Tutup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <img id="modalImage" 
                     src="" 
                     alt="Product Image" 
                     class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
            </div>
        </div>
    </div>
</div>

<script>
    // Image Modal Functions
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Add to Cart dengan localStorage
    function addToCart(productId, productName, price, image) {
        try {
            // Check if user is logged in as customer
            const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';

            if (!isAuthenticated) {
                // For guests, use localStorage
                let cart = JSON.parse(localStorage.getItem('glorious_cart') || '[]');

                // Check if product already in cart
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: price,
                        image: image,
                        quantity: 1
                    });
                }

                localStorage.setItem('glorious_cart', JSON.stringify(cart));
                updateCartCount();

                // Show success message
                showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');

                // Update button state
                const button = event.target.closest('button');
                button.innerHTML = '<i class="fas fa-check"></i> Di Keranjang';
                button.classList.remove('bg-primary', 'hover:bg-primary-dark');
                button.classList.add('bg-green-500', 'hover:bg-green-600');

                return;
            }

            // For authenticated users, send to backend
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount();
                    showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');

                    const button = event.target.closest('button');
                    button.innerHTML = '<i class="fas fa-check"></i> Di Keranjang';
                    button.classList.remove('bg-primary', 'hover:bg-primary-dark');
                    button.classList.add('bg-green-500', 'hover:bg-green-600');
                } else {
                    showNotification('Gagal menambahkan produk ke keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
            });

        } catch (error) {
            console.error('Cart error:', error);
            showNotification('Terjadi kesalahan sistem', 'error');
        }
    }

    // Toggle Wishlist dengan AJAX
    function toggleWishlist(productId) {
        try {
            const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';

            if (!isAuthenticated) {
                // For guests, use localStorage
                let wishlist = JSON.parse(localStorage.getItem('glorious_wishlist') || '[]');

                const existingIndex = wishlist.indexOf(productId);

                if (existingIndex > -1) {
                    // Remove from wishlist
                    wishlist.splice(existingIndex, 1);
                    showNotification('Produk dihapus dari wishlist', 'info');
                } else {
                    // Add to wishlist
                    wishlist.push(productId);
                    showNotification('Produk ditambahkan ke wishlist!', 'success');
                }

                localStorage.setItem('glorious_wishlist', JSON.stringify(wishlist));
                updateWishlistButton(productId, existingIndex === -1);
                return;
            }

            // For authenticated users, use AJAX
            if (typeof PopupManager !== 'undefined' && PopupManager && !PopupManager.isCustomerLoggedIn()) {
                PopupManager.promptCustomerLogin({ reason: 'wishlist', redirectUrl: window.location.href });
                return;
            }
        } catch (e) {
            // ignore
        }

        const button = event.target.closest('button');
        const icon = button.querySelector('i');
        const text = button.querySelector('span') || button;

        // Kirim request ke backend
        fetch(`/wishlist/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.status === 401 || response.status === 419) {
                try {
                    if (typeof PopupManager !== 'undefined' && PopupManager) {
                        PopupManager.promptCustomerLogin({ reason: 'wishlist', redirectUrl: window.location.href });
                    }
                } catch (e) {}
                return Promise.reject('unauthorized');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateWishlistButton(productId, data.isInWishlist);
                showNotification(data.isInWishlist ? 'Produk ditambahkan ke wishlist!' : 'Produk dihapus dari wishlist', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat memproses wishlist', 'error');
        });
    }

    // Update wishlist button state
    function updateWishlistButton(productId, isInWishlist) {
        const buttons = document.querySelectorAll(`button[onclick*="toggleWishlist(${productId})"]`);

        buttons.forEach(button => {
            const icon = button.querySelector('i');
            const text = button.querySelector('span') || button;

            if (isInWishlist) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
                button.classList.remove('bg-gray-800', 'border-gray-700', 'hover:bg-gray-700');
                button.classList.add('bg-red-500', 'border-red-500', 'hover:bg-red-600');
                if (text.tagName === 'SPAN') {
                    text.textContent = 'Di Wishlist';
                } else {
                    button.innerHTML = '<i class="fas fa-heart text-red-500"></i> Di Wishlist';
                }
            } else {
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
                button.classList.remove('bg-red-500', 'border-red-500', 'hover:bg-red-600');
                button.classList.add('bg-gray-800', 'border-gray-700', 'hover:bg-gray-700');
                if (text.tagName === 'SPAN') {
                    text.textContent = 'Wishlist';
                } else {
                    button.innerHTML = '<i class="far fa-heart"></i> Wishlist';
                }
            }
        });
    }

    // Update cart count
    function updateCartCount() {
        try {
            const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';

            if (!isAuthenticated) {
                const cart = JSON.parse(localStorage.getItem('glorious_cart') || '[]');
                const count = cart.reduce((total, item) => total + item.quantity, 0);

                // Update cart badge in header
                const cartBadges = document.querySelectorAll('#cart-button .bg-primary, #cart-button-mobile .bg-primary');
                cartBadges.forEach(badge => {
                    badge.textContent = count > 0 ? count : '';
                    badge.style.display = count > 0 ? 'flex' : 'none';
                });
            }
        } catch (error) {
            console.error('Error updating cart count:', error);
        }
    }

    // Show notification
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-black',
            info: 'bg-blue-500 text-white'
        };

        notification.classList.add(...colors[type].split(' '));
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Share Product
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: 'Lihat produk ini di Glorious Computer',
                url: window.location.href,
            })
            .then(() => console.log('Berbagi berhasil'))
            .catch((error) => console.log('Error sharing', error));
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link produk telah disalin ke clipboard!');
            });
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('imageModal');
        if (e.target === modal) {
            closeImageModal();
        }
    });
</script>

<style>
    /* Custom styles for better typography */
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    
    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color, transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endsection