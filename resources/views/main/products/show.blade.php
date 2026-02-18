@extends('layouts.theme')

@section('title', $product->name . ' - Glorious Computer')

@section('head')
<meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
@endsection

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── BREADCRUMB ───────────────────────────────────────── --}}
        <nav class="mb-10">
            <ol class="flex items-center flex-wrap gap-2 text-sm text-gray-500">
                <li>
                    <a href="{{ route('main.about.index') }}"
                       class="hover:text-primary transition-colors duration-200 flex items-center gap-1">
                        <i class="fas fa-home text-xs"></i>
                        Beranda
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs text-gray-600"></i></li>
                <li>
                    <a href="{{ route('main.products.index') }}"
                       class="hover:text-primary transition-colors duration-200">
                        Produk
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs text-gray-600"></i></li>
                <li class="text-white font-medium truncate max-w-[200px]">{{ Str::limit($product->name, 25) }}</li>
            </ol>
        </nav>

        {{-- ── MAIN PRODUCT SECTION ─────────────────────────────── --}}
        <div class="bg-gray-900/60 rounded-2xl border border-gray-700/80 mb-10 overflow-hidden
                    ring-1 ring-white/5 shadow-xl shadow-black/30">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                {{-- ── LEFT: Product Image ──────────────────────── --}}
                <div class="p-6 md:p-8 lg:border-r border-gray-800">
                    <div class="bg-gray-800/40 rounded-xl overflow-hidden mb-4 border border-gray-700/60 group">
                        @php
                            $imagePath = $product->image;
                            $imageUrl  = null;
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
                            <div class="w-full h-96 flex flex-col items-center justify-center text-gray-600">
                                <i class="fas fa-laptop text-7xl mb-4 opacity-30"></i>
                                <p class="text-base font-medium">Gambar Tidak Tersedia</p>
                            </div>
                        @endif
                    </div>

                    @if($imageUrl)
                    <div class="flex justify-center">
                        <button onclick="openImageModal('{{ $imageUrl }}')"
                                class="text-sm text-gray-500 hover:text-white flex items-center gap-2 transition-colors duration-200
                                       px-4 py-2 rounded-lg hover:bg-gray-800/60 border border-transparent hover:border-gray-700">
                            <i class="fas fa-expand-alt"></i>
                            <span>Perbesar Gambar</span>
                        </button>
                    </div>
                    @endif
                </div>

                {{-- ── RIGHT: Product Info ──────────────────────── --}}
                <div class="p-6 md:p-8 space-y-6">

                    {{-- Category & SKU --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-full border border-primary/20">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-gray-500 text-sm">
                            SKU: <span class="text-gray-300 font-mono">{{ $product->sku ?? 'N/A' }}</span>
                        </span>
                    </div>

                    {{-- Product Name --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-white leading-snug tracking-tight">
                        {{ $product->name }}
                    </h1>

                    {{-- Rating --}}
                    <div class="flex items-center gap-3">
                        <div class="flex gap-0.5">
                            @php
                                $avgRating = $product->average_rating ?? 0;
                                $fullStars = floor($avgRating);
                                $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star text-sm text-yellow-400"></i>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <i class="fas fa-star-half-alt text-sm text-yellow-400"></i>
                                @else
                                    <i class="far fa-star text-sm text-gray-600"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-400 text-sm">
                            ({{ number_format($avgRating, 1) }} • {{ $product->review_count ?? 0 }} ulasan)
                        </span>
                    </div>

                    {{-- Price — LOGIC TIDAK DIUBAH --}}
                    @php
                        $hasDiscount        = $product->has_discount;
                        $discountPercentage = $product->discount_percentage;
                        $finalPrice         = $product->final_price;
                        $sellingPrice       = $product->selling_price;
                        $discountAmount     = $product->getDiscountAmount();
                        $condition          = $product->getConditionLabel();
                        $warranty           = $product->getWarrantyLabel();
                        $shipping           = $product->getShippingInfoLabel();
                        $currentStock       = $product->current_stock;
                        $stockStatus        = $product->stock_status;
                        $stockStatusLabel   = $product->getStockStatusLabel();
                    @endphp

                    <div class="py-4 px-5 bg-gray-800/50 rounded-xl border border-gray-700/60">
                        @if($hasDiscount && $discountPercentage > 0)
                            <div class="flex items-baseline gap-3 mb-1 flex-wrap">
                                <span class="text-3xl md:text-4xl font-bold text-primary">
                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-400 line-through">
                                    Rp {{ number_format($sellingPrice, 0, ',', '.') }}
                                </span>
                                <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-md">
                                    -{{ $discountPercentage }}%
                                </span>
                            </div>
                            <div class="text-green-400 text-sm flex items-center gap-2 mt-1">
                                <i class="fas fa-tag"></i>
                                <span>Hemat Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-3xl md:text-4xl font-bold text-primary">
                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    {{-- Stock Status — LOGIC TIDAK DIUBAH --}}
                    <div class="p-4 bg-gray-800/30 rounded-xl border border-gray-700/60">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                @if($currentStock > 10)
                                    <span class="px-3 py-1 bg-green-600/20 text-green-400 text-sm font-semibold rounded-full border border-green-600/30">
                                        <i class="fas fa-check mr-1"></i>Stok Tersedia
                                    </span>
                                @elseif($currentStock > 0)
                                    <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 text-sm font-semibold rounded-full border border-yellow-600/30">
                                        <i class="fas fa-exclamation mr-1"></i>Stok Menipis
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-600/20 text-red-400 text-sm font-semibold rounded-full border border-red-600/30">
                                        <i class="fas fa-times mr-1"></i>Stok Habis
                                    </span>
                                @endif
                                <span class="text-white font-medium">{{ $currentStock }} {{ $product->unit }}</span>
                            </div>
                        </div>

                        @if($product->max_stock && $product->max_stock > 0)
                        <div class="w-full bg-gray-700 rounded-full h-1.5">
                            <div class="bg-primary rounded-full h-1.5 transition-all duration-500"
                                 style="width: {{ min(100, ($currentStock / $product->max_stock) * 100) }}%">
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Quick Actions — ID, onclick, data-* TIDAK DIUBAH --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <button type="button" id="btn-cart-{{ $product->id }}"
                                data-product-name="{{ e($product->name) }}"
                                data-product-price="{{ $finalPrice }}"
                                data-product-image="{{ e($product->image ?? '') }}"
                                onclick="addToCart(this)"
                                class="product-action-btn flex-1 {{ $isInCart ? 'bg-green-600 hover:bg-green-700 border-green-500' : 'bg-primary hover:bg-primary-dark border-primary' }} text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 border shadow-lg">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="btn-cart-text">{{ $isInCart ? 'Di Keranjang' : 'Tambah ke Cart' }}</span>
                        </button>

                        <button type="button" id="btn-wishlist-{{ $product->id }}"
                                onclick="toggleWishlist({{ $product->id }}, {{ $isInWishlist ? 'true' : 'false' }})"
                                class="product-action-btn flex-1 {{ $isInWishlist ? 'bg-red-600 hover:bg-red-700 border-red-500' : 'bg-gray-800 hover:bg-gray-700 border-gray-700' }} text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 border">
                            <i class="{{ $isInWishlist ? 'fas' : 'far' }} fa-heart btn-wishlist-icon"></i>
                            <span class="btn-wishlist-text">{{ $isInWishlist ? 'Di Wishlist' : 'Wishlist' }}</span>
                        </button>

                        <button type="button" onclick="shareProduct()"
                                class="flex-1 bg-gray-800 hover:bg-gray-700 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 border border-gray-700">
                            <i class="fas fa-share-alt"></i>
                            Bagikan
                        </button>
                    </div>

                    {{-- Product Features — LOGIC TIDAK DIUBAH --}}
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div class="flex items-center gap-3 p-3 bg-gray-800/30 rounded-xl border border-gray-700/40">
                            <div class="w-9 h-9 bg-blue-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shield-alt text-blue-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Garansi</p>
                                <p class="text-sm text-white font-semibold">{{ $warranty }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-800/30 rounded-xl border border-gray-700/40">
                            <div class="w-9 h-9 bg-green-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-truck text-green-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Pengiriman</p>
                                <p class="text-sm text-white font-semibold">{{ $shipping }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-800/30 rounded-xl border border-gray-700/40">
                            <div class="w-9 h-9 bg-yellow-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-box text-yellow-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Kondisi</p>
                                <p class="text-sm text-white font-semibold">{{ $condition }}</p>
                            </div>
                        </div>

                        @if($product->supplier && $product->supplier->name)
                        <div class="flex items-center gap-3 p-3 bg-gray-800/30 rounded-xl border border-gray-700/40">
                            <div class="w-9 h-9 bg-purple-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-industry text-purple-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Supplier</p>
                                <p class="text-sm text-white font-semibold">{{ $product->supplier->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Main Action Buttons — AUTH LOGIC TIDAK DIUBAH --}}
                    <div class="pt-2">
                        <div class="flex flex-col sm:flex-row gap-3">
                            @auth
                                @if(auth()->user()->role === 'Customer')
                                    <form action="{{ route('order.create-and-whatsapp') }}" method="POST" class="flex-1 order-wa-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3.5 px-6 rounded-xl font-bold transition-all duration-200 flex items-center justify-center gap-3 shadow-lg shadow-green-900/30 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $currentStock == 0 ? 'disabled' : '' }}>
                                            <i class="fab fa-whatsapp text-lg"></i>
                                            {{ $currentStock == 0 ? 'Stok Habis' : 'Pesan via WhatsApp' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('main.products.index') }}" class="flex-1 bg-primary hover:bg-primary-dark text-white py-3.5 px-6 rounded-xl font-semibold flex items-center justify-center gap-3">
                                        <i class="fab fa-whatsapp"></i> Lihat Katalog
                                    </a>
                                @endif
                            @else
                                <button type="button"
                                        class="flex-1 js-require-login-wa bg-green-600 hover:bg-green-700 text-white py-3.5 px-6 rounded-xl font-bold transition-all duration-200 flex items-center justify-center gap-3 shadow-lg shadow-green-900/30 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        data-message="Silakan login untuk memesan via WhatsApp."
                                        {{ $currentStock == 0 ? 'disabled' : '' }}>
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    {{ $currentStock == 0 ? 'Stok Habis' : 'Pesan via WhatsApp' }}
                                </button>
                            @endauth

                            <a href="{{ route('main.products.index') }}"
                               class="flex-1 bg-gray-800 hover:bg-gray-700 text-white py-3.5 px-6 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-3 border border-gray-700">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SPECS & DESCRIPTION — LOGIC TIDAK DIUBAH ─────── --}}
            <div class="px-6 md:px-8 pb-8 pt-2 border-t border-gray-800">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8">
                    <div>
                        <h2 class="text-lg font-bold text-white mb-4 pb-3 border-b border-gray-800 flex items-center gap-2">
                            <i class="fas fa-list-ul text-primary text-sm"></i>
                            Spesifikasi Produk
                        </h2>
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

                    @if($product->description)
                    <div>
                        <h2 class="text-lg font-bold text-white mb-4 pb-3 border-b border-gray-800 flex items-center gap-2">
                            <i class="fas fa-align-left text-primary text-sm"></i>
                            Deskripsi Produk
                        </h2>
                        <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── REVIEWS SECTION ──────────────────────────────────────── --}}
        <div class="bg-gray-900/60 rounded-2xl border border-gray-700/80 mb-10 overflow-hidden ring-1 ring-white/5 shadow-xl shadow-black/30">
            <div class="px-6 md:px-8 py-8">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-primary"></i>
                    Ulasan & Rating
                </h2>

                {{-- Review Form (untuk customer yang sudah login) --}}
                @auth
                    @php
                        $userRole = \Illuminate\Support\Str::lower(auth()->user()->role ?? '');
                    @endphp
                    @if($userRole === 'customer')
                        <div class="mb-8 p-6 bg-gray-800/50 rounded-xl border border-gray-700/60">
                            <h3 class="text-lg font-semibold text-white mb-4">Tulis Ulasan Anda</h3>
                            <form id="reviewForm" class="space-y-4" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                {{-- Star Rating Input --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                                    <div class="flex items-center gap-2" id="starRating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    class="star-btn text-2xl text-gray-600 hover:text-yellow-400 transition-colors"
                                                    data-rating="{{ $i }}">
                                                <i class="far fa-star"></i>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" value="0" required>
                                    <p class="text-xs text-gray-500 mt-1" id="ratingText">Pilih rating</p>
                                </div>

                                {{-- Comment Input --}}
                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-300 mb-2">Komentar</label>
                                    <textarea name="comment" 
                                            id="comment" 
                                            rows="4" 
                                            class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                            placeholder="Bagikan pengalaman Anda dengan produk ini..."></textarea>
                                </div>

                                {{-- Image Upload --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Gambar (opsional)</label>
                                    <input type="file" 
                                           name="images[]" 
                                           id="reviewImages" 
                                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                           multiple
                                           class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/20 file:text-primary file:font-semibold focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Maks. 5 gambar, per file maks. 2MB (JPG, PNG, GIF, WebP)</p>
                                    <div id="reviewImagePreview" class="flex flex-wrap gap-2 mt-2"></div>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-6 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

                {{-- Reviews List --}}
                <div id="reviewsContainer" class="space-y-6">
                    @if($product->reviews && $product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                            <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700/60">
                                <div class="flex items-start gap-4">
                                    {{-- User Avatar --}}
                                    <div class="flex-shrink-0">
                                        @if($review->user && $review->user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}" 
                                                 alt="{{ $review->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-700">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center border-2 border-gray-700">
                                                <i class="fas fa-user text-primary text-lg"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Review Content --}}
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h4 class="text-white font-semibold">
                                                    {{ $review->user ? $review->user->name : 'Anonim' }}
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    {{ $review->created_at->format('d M Y, H:i') }}
                                                </p>
                                            </div>
                                            <div class="flex gap-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        @if($review->comment)
                                            <p class="text-gray-300 leading-relaxed mt-2">{{ $review->comment }}</p>
                                        @endif
                                        @if($review->images && count($review->images) > 0)
                                            <div class="flex flex-wrap gap-2 mt-3">
                                                @foreach($review->images as $imgPath)
                                                    @php
                                                        $imgUrl = asset('storage/' . $imgPath);
                                                    @endphp
                                                    <img src="{{ $imgUrl }}" 
                                                         alt="Ulasan" 
                                                         class="w-20 h-20 object-cover rounded-lg border border-gray-600 cursor-pointer hover:opacity-90 transition-opacity"
                                                         onclick="openImageModal('{{ $imgUrl }}')">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-star text-4xl mb-4 opacity-30"></i>
                            <p class="text-lg font-medium">Belum ada ulasan</p>
                            <p class="text-sm mt-2">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── RELATED PRODUCTS — SEMUA LOGIC/VAR TIDAK DIUBAH ── --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($relatedProducts as $related)
                    @php
                        $relatedCurrentStock      = $related->current_stock;
                        $relatedHasDiscount       = $related->has_discount;
                        $relatedFinalPrice        = $related->final_price;
                        $relatedSellingPrice      = $related->selling_price;
                        $relatedDiscountPercentage= $related->discount_percentage;
                        $relatedImagePath         = $related->image;
                        $relatedImageUrl          = null;
                        if ($relatedImagePath) {
                            if (Storage::disk('public')->exists($relatedImagePath)) {
                                $relatedImageUrl = asset('storage/' . $relatedImagePath);
                            } elseif (Str::startsWith($relatedImagePath, ['http://', 'https://'])) {
                                $relatedImageUrl = $relatedImagePath;
                            }
                        }
                    @endphp

                    <a href="{{ route('main.products.show', $related->id) }}"
                       class="group bg-gray-900/50 rounded-xl border border-gray-800 hover:border-primary/40 transition-all duration-200 overflow-hidden hover:-translate-y-1 shadow-md hover:shadow-lg hover:shadow-primary/10">
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

                            @if($relatedHasDiscount && $relatedDiscountPercentage > 0)
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-md">
                                        -{{ $relatedDiscountPercentage }}%
                                    </span>
                                </div>
                            @endif

                            <div class="absolute top-3 right-3">
                                @if($relatedCurrentStock > 10)
                                    <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs font-semibold rounded-md border border-green-500/30">Stok</span>
                                @elseif($relatedCurrentStock > 0)
                                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-semibold rounded-md border border-yellow-500/30">Menipis</span>
                                @else
                                    <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs font-semibold rounded-md border border-red-500/30">Habis</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-white mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                                {{ $related->name }}
                            </h3>
                            <div class="mb-3">
                                @if($relatedHasDiscount && $relatedDiscountPercentage > 0)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-lg font-bold text-primary">Rp {{ number_format($relatedFinalPrice, 0, ',', '.') }}</span>
                                        <span class="text-sm text-gray-400 line-through">Rp {{ number_format($relatedSellingPrice, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <span class="text-lg font-bold text-primary">Rp {{ number_format($relatedFinalPrice, 0, ',', '.') }}</span>
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
                   class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-semibold transition-colors duration-200">
                    Lihat semua produk {{ $product->category->name }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
        @endif

        {{-- ── SUPPORT CTA ──────────────────────────────────────── --}}
        <div class="relative overflow-hidden bg-gradient-to-r from-primary/10 via-primary/5 to-primary/10 rounded-2xl border border-primary/20 p-8 text-center">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white mb-3">Butuh Bantuan?</h2>
                <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                    Tim support kami siap membantu Anda dengan pertanyaan teknis dan rekomendasi produk.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="https://wa.me/6282133803940"
                       target="_blank"
                       class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5">
                        <i class="fab fa-whatsapp text-lg"></i>
                        Chat WhatsApp
                    </a>
                    <a href="tel:082133803940"
                       class="px-8 py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 border border-gray-700">
                        <i class="fas fa-phone"></i>
                        Telepon
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── IMAGE MODAL — LOGIC TIDAK DIUBAH ────────────────────── --}}
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

{{-- ── SEMUA SCRIPT DI BAWAH INI TIDAK DIUBAH ─────────────── --}}
<script>
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

    function addToCart(btnOrId) {
        const btn = typeof btnOrId === 'object' && btnOrId && btnOrId.id
            ? btnOrId
            : document.getElementById('btn-cart-{{ $product->id }}');
        const productId = {{ $product->id }};
        const productName = btn?.dataset?.productName || '{{ e($product->name) }}';
        const price = btn?.dataset?.productPrice ? parseFloat(btn.dataset.productPrice) : {{ $finalPrice }};
        const image = btn?.dataset?.productImage || '';

        const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';

        if (!isAuthenticated) {
            let cart = JSON.parse(localStorage.getItem('glorious_cart') || '[]');
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) existingItem.quantity += 1;
            else cart.push({ id: productId, name: productName, price: price, image: image || '', quantity: 1 });
            localStorage.setItem('glorious_cart', JSON.stringify(cart));
            updateCartCount();
            showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
            setCartButtonState(true);
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('product_id', productId);
        formData.append('quantity', 1);

        fetch('{{ route("cart.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'Produk berhasil ditambahkan ke keranjang!', 'success');
                setCartButtonState(true);
                updateCartBadge(data.cart_count);
            } else {
                showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showNotification('Terjadi kesalahan saat menambahkan ke keranjang', 'error');
        });
    }

    function setCartButtonState(inCart) {
        const btn = document.getElementById('btn-cart-{{ $product->id }}');
        if (!btn) return;
        const text = btn.querySelector('.btn-cart-text');
        if (inCart) {
            btn.classList.remove('bg-primary', 'hover:bg-primary-dark', 'border-primary');
            btn.classList.add('bg-green-600', 'hover:bg-green-700', 'border-green-500');
            if (text) text.textContent = 'Di Keranjang';
        } else {
            btn.classList.remove('bg-green-600', 'hover:bg-green-700', 'border-green-500');
            btn.classList.add('bg-primary', 'hover:bg-primary-dark', 'border-primary');
            if (text) text.textContent = 'Tambah ke Cart';
        }
    }

    function updateCartBadge(count) {
        const badges = document.querySelectorAll('.cart-count-badge');
        badges.forEach(b => {
            b.textContent = count > 0 ? count : '';
            b.style.display = count > 0 ? 'flex' : 'none';
        });
    }

    function toggleWishlist(productId, _currentInWishlistIgnored) {
        const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';

        if (!isAuthenticated) {
            let wishlist = JSON.parse(localStorage.getItem('glorious_wishlist') || '[]');
            const idx = wishlist.indexOf(productId);
            if (idx > -1) { wishlist.splice(idx, 1); showNotification('Produk dihapus dari wishlist', 'info'); }
            else { wishlist.push(productId); showNotification('Produk ditambahkan ke wishlist!', 'success'); }
            localStorage.setItem('glorious_wishlist', JSON.stringify(wishlist));
            setWishlistButtonState(productId, idx === -1);
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`{{ url('wishlist/toggle') }}/${productId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token || '', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            credentials: 'same-origin'
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const inWishlist = !!data.is_in_wishlist;
                setWishlistButtonState(productId, inWishlist);
                showNotification(inWishlist ? 'Produk ditambahkan ke wishlist!' : 'Produk dihapus dari wishlist', 'success');
                if (typeof data.wishlist_count !== 'undefined') {
                    const badges = document.querySelectorAll('.wishlist-count-badge');
                    badges.forEach(function(b) {
                        b.textContent = data.wishlist_count > 0 ? data.wishlist_count : '';
                        b.classList.toggle('hidden', data.wishlist_count < 1);
                        b.style.display = data.wishlist_count > 0 ? 'flex' : 'none';
                    });
                }
                if (typeof PopupManager !== 'undefined' && PopupManager.initializeCart) PopupManager.initializeCart();
            } else {
                showNotification('Gagal memperbarui wishlist', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showNotification('Terjadi kesalahan saat memproses wishlist', 'error');
        });
    }

    function setWishlistButtonState(productId, inWishlist) {
        const btn = document.getElementById('btn-wishlist-' + productId);
        if (!btn) return;
        const icon = btn.querySelector('.btn-wishlist-icon');
        const text = btn.querySelector('.btn-wishlist-text');
        if (inWishlist) {
            if (icon) { icon.classList.remove('far'); icon.classList.add('fas'); }
            btn.classList.remove('bg-gray-800', 'border-gray-700', 'hover:bg-gray-700');
            btn.classList.add('bg-red-600', 'hover:bg-red-700', 'border-red-500');
            if (text) text.textContent = 'Di Wishlist';
            btn.setAttribute('onclick', 'toggleWishlist(' + productId + ', true)');
        } else {
            if (icon) { icon.classList.remove('fas'); icon.classList.add('far'); }
            btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'border-red-500');
            btn.classList.add('bg-gray-800', 'hover:bg-gray-700', 'border-gray-700');
            if (text) text.textContent = 'Wishlist';
            btn.setAttribute('onclick', 'toggleWishlist(' + productId + ', false)');
        }
    }

    function updateCartCount() {
        try {
            const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';
            if (!isAuthenticated) {
                const cart = JSON.parse(localStorage.getItem('glorious_cart') || '[]');
                const count = cart.reduce((total, item) => total + item.quantity, 0);
                updateCartBadge(count);
            }
        } catch (e) {}
    }

    function showNotification(message, type = 'info') {
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
        setTimeout(() => { notification.classList.remove('translate-x-full'); }, 100);
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => { document.body.removeChild(notification); }, 300);
        }, 3000);
    }

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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImageModal();
    });

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('imageModal');
        if (e.target === modal) closeImageModal();
    });

    // Star Rating Handler
    document.addEventListener('DOMContentLoaded', function() {
        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.getElementById('ratingText');
        let selectedRating = 0;

        starBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                selectedRating = index + 1;
                ratingInput.value = selectedRating;
                
                // Update star display
                starBtns.forEach((star, i) => {
                    const icon = star.querySelector('i');
                    if (i < selectedRating) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        star.classList.remove('text-gray-600');
                        star.classList.add('text-yellow-400');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-600');
                    }
                });

                // Update rating text
                const ratingLabels = ['Pilih rating', 'Sangat Buruk', 'Buruk', 'Biasa', 'Bagus', 'Sangat Bagus'];
                ratingText.textContent = ratingLabels[selectedRating];
            });

            btn.addEventListener('mouseenter', function() {
                const hoverRating = index + 1;
                starBtns.forEach((star, i) => {
                    const icon = star.querySelector('i');
                    if (i < hoverRating && !selectedRating) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        star.classList.add('text-yellow-400');
                    }
                });
            });
        });

        document.getElementById('starRating').addEventListener('mouseleave', function() {
            if (!selectedRating) {
                starBtns.forEach((star) => {
                    const icon = star.querySelector('i');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-600');
                });
            }
        });

        // Review Image Preview
        const reviewImagesInput = document.getElementById('reviewImages');
        const reviewImagePreview = document.getElementById('reviewImagePreview');
        if (reviewImagesInput && reviewImagePreview) {
            reviewImagesInput.addEventListener('change', function() {
                const files = this.files;
                if (files.length > 5) {
                    showNotification('Maksimal 5 gambar yang dapat diunggah', 'warning');
                    this.value = '';
                    reviewImagePreview.innerHTML = '';
                    return;
                }
                reviewImagePreview.innerHTML = '';
                const maxPreview = 5;
                for (let i = 0; i < Math.min(files.length, maxPreview); i++) {
                    const file = files[i];
                    if (!file.type.startsWith('image/')) continue;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-16 h-16 object-cover rounded-lg border border-gray-600';
                        reviewImagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Review Form Submission
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!ratingInput.value || ratingInput.value === '0') {
                    showNotification('Silakan pilih rating terlebih dahulu', 'error');
                    return;
                }

                const formData = new FormData(reviewForm);
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                fetch('{{ route("main.reviews.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': token || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        reviewForm.reset();
                        document.getElementById('reviewImages').value = '';
                        document.getElementById('reviewImagePreview').innerHTML = '';
                        selectedRating = 0;
                        ratingInput.value = '0';
                        ratingText.textContent = 'Pilih rating';
                        
                        // Reset stars
                        starBtns.forEach((star) => {
                            const icon = star.querySelector('i');
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-600');
                        });

                        // Reload reviews
                        loadReviews();
                    } else {
                        showNotification(data.message || 'Gagal mengirim review', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan saat mengirim review', 'error');
                });
            });
        }

        // Function to load reviews
        function loadReviews() {
            fetch('{{ route("main.reviews.index", $product->id) }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('reviewsContainer');
                    if (data.reviews.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-12 text-gray-500">
                                <i class="fas fa-star text-4xl mb-4 opacity-30"></i>
                                <p class="text-lg font-medium">Belum ada ulasan</p>
                                <p class="text-sm mt-2">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                            </div>
                        `;
                    } else {
                        container.innerHTML = data.reviews.map(review => {
                            const date = new Date(review.created_at);
                            const formattedDate = date.toLocaleDateString('id-ID', { 
                                day: 'numeric', 
                                month: 'short', 
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            
                            const stars = Array.from({length: 5}, (_, i) => 
                                i < review.rating 
                                    ? '<i class="fas fa-star text-sm text-yellow-400"></i>'
                                    : '<i class="fas fa-star text-sm text-gray-600"></i>'
                            ).join('');

                            const avatar = review.user && review.user.profile_photo_path
                                ? `<img src="{{ asset('storage/') }}/${review.user.profile_photo_path}" alt="${review.user.name}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-700">`
                                : `<div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center border-2 border-gray-700"><i class="fas fa-user text-primary text-lg"></i></div>`;

                            const imagesHtml = review.images && review.images.length > 0
                                ? `<div class="flex flex-wrap gap-2 mt-3">
                                    ${review.images.map(img => {
                                        const url = '{{ asset("storage") }}/' + img;
                                        return `<img src="${url}" alt="Ulasan" class="w-20 h-20 object-cover rounded-lg border border-gray-600 cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageModal('${url}')">`;
                                    }).join('')}
                                   </div>`
                                : '';

                            return `
                                <div class="p-6 bg-gray-800/50 rounded-xl border border-gray-700/60">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">${avatar}</div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <h4 class="text-white font-semibold">${review.user ? review.user.name : 'Anonim'}</h4>
                                                    <p class="text-xs text-gray-500">${formattedDate}</p>
                                                </div>
                                                <div class="flex gap-0.5">${stars}</div>
                                            </div>
                                            ${review.comment ? `<p class="text-gray-300 leading-relaxed mt-2">${review.comment}</p>` : ''}
                                            ${imagesHtml}
                                        </div>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }
                    
                    // Update rating display
                    updateRatingDisplay(data.average_rating, data.review_count);
                }
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
            });
        }

        function updateRatingDisplay(avgRating, reviewCount) {
            const ratingContainer = document.querySelector('.flex.items-center.gap-3');
            if (ratingContainer) {
                const fullStars = Math.floor(avgRating);
                const hasHalfStar = (avgRating - fullStars) >= 0.5;
                
                let starsHTML = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= fullStars) {
                        starsHTML += '<i class="fas fa-star text-sm text-yellow-400"></i>';
                    } else if (i === fullStars + 1 && hasHalfStar) {
                        starsHTML += '<i class="fas fa-star-half-alt text-sm text-yellow-400"></i>';
                    } else {
                        starsHTML += '<i class="far fa-star text-sm text-gray-600"></i>';
                    }
                }
                
                ratingContainer.innerHTML = `
                    <div class="flex gap-0.5">${starsHTML}</div>
                    <span class="text-gray-400 text-sm">(${parseFloat(avgRating).toFixed(1)} • ${reviewCount} ulasan)</span>
                `;
            }
        }
    });
</script>

<style>
    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    * {
        transition-property: color, background-color, border-color, transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
</style>
@endsection