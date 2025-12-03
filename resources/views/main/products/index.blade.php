@extends('layouts.theme')

@section('title', 'Katalog Produk - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Header - Simple & Professional -->
        <div class="text-center mb-16">
            <div class="inline-block mb-6">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto border border-primary/20">
                    <i class="fas fa-box-open text-2xl text-primary"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                Katalog <span class="text-primary">Produk</span>
            </h1>
            <div class="h-px w-24 bg-gradient-to-r from-transparent via-primary to-transparent mx-auto mb-6"></div>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                Temukan perangkat teknologi berkualitas dengan harga kompetitif
            </p>
        </div>

        <!-- Simple Filter Section -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-base font-semibold text-white mb-1">Filter Produk</h3>
                </div>
                
                <!-- Quick Category Filter -->
                <div class="flex flex-wrap gap-2">
                    @php
                        $currentCategoryId = request('category_id');
                    @endphp

                    <!-- All Products Button -->
                    <a href="{{ route('main.products.index') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                              {{ !$currentCategoryId ? 
                                'bg-primary text-white' : 
                                'bg-gray-800 hover:bg-primary/10 text-gray-300 hover:text-white border border-gray-700' }}">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-th-large"></i>
                            <span>Semua</span>
                        </div>
                    </a>

                    <!-- Category Buttons -->
                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories->take(5) as $category)
                            <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                               class="px-4 py-2 text-sm font-medium rounded-lg transition-all
                                      {{ $currentCategoryId == $category->id ? 
                                        'bg-primary text-white' : 
                                        'bg-gray-800 hover:bg-primary/10 text-gray-300 hover:text-white border border-gray-700' }}">
                                <div class="flex items-center gap-2">
                                    <i class="fas {{ $currentCategoryId == $category->id ? 'fa-folder-open' : 'fa-folder' }} text-xs"></i>
                                    <span>{{ $category->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Search & Sort Row -->
            <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-500"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari produk..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary text-sm">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="w-full md:w-48">
                        <select name="category_id" 
                                class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-primary text-sm cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div class="w-full md:w-48">
                        <select name="sort" 
                                class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg text-white focus:outline-none focus:border-primary text-sm cursor-pointer">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors text-sm flex items-center gap-2">
                            <i class="fas fa-filter"></i>
                            <span class="hidden sm:inline">Filter</span>
                        </button>
                        <a href="{{ route('main.products.index') }}" 
                           class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors text-sm flex items-center gap-2">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Counter -->
        @if(isset($products) && $products->count() > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-white">
                            <span class="text-primary">{{ $products->total() }}</span> Produk Ditemukan
                        </h2>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-12">
                @foreach($products as $product)
                    @php
                        $currentStock = $product->current_stock;
                        
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
                        $stockStatus = $product->stock_status;
                        $stockStatusLabel = $product->getStockStatusLabel();
                        $stockStatusColor = $product->getStockStatusColor();
                        
                        // Image handling
                        $imagePath = $product->image;
                        $imageExists = false;
                        $imageUrl = null;
                        
                        if ($imagePath) {
                            if (Storage::disk('public')->exists($imagePath)) {
                                $imageExists = true;
                                $imageUrl = asset('storage/' . $imagePath);
                            } elseif (Str::startsWith($imagePath, ['http://', 'https://'])) {
                                $imageExists = true;
                                $imageUrl = $imagePath;
                            }
                        }
                    @endphp
                    
                    <!-- Product Card - Simple & Elegant -->
                    <div class="group bg-gray-800/50 border border-gray-700 rounded-xl overflow-hidden transition-all hover:border-primary/30 hover:shadow-lg">
                        <!-- Image Container -->
                        <div class="relative h-52 bg-gray-900 overflow-hidden">
                            @if($imageExists && $imageUrl)
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                                    <div class="text-center p-4">
                                        <i class="fas fa-laptop text-3xl text-gray-600 mb-2"></i>
                                        <p class="text-gray-500 text-xs">No Image</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold shadow
                                    {{ $stockStatus === 'out_of_stock' ? 'bg-red-900/80 text-red-300' : 
                                       ($stockStatus === 'low_stock' ? 'bg-yellow-900/80 text-yellow-300' : 
                                       'bg-green-900/80 text-green-300') }}">
                                    {{ $stockStatusLabel }}
                                </span>
                            </div>
                            
                            <!-- Condition Badge -->
                            @if($condition && $condition !== 'Baru')
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/90 text-white">
                                        {{ $condition }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Discount Badge -->
                            @if($hasDiscount && $discountPercentage > 0)
                                <div class="absolute bottom-3 left-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-600 text-white">
                                        -{{ $discountPercentage }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Content -->
                        <div class="p-4">
                            <!-- Category -->
                            <div class="mb-2">
                                <span class="text-primary text-xs font-semibold">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                            
                            <!-- Product Name -->
                            <h3 class="text-base font-semibold text-white mb-3 line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Specifications (Short) -->
                            <div class="mb-4">
                                <div class="text-gray-400 text-sm line-clamp-2 leading-relaxed">
                                    @if($product->specification && !empty(trim($product->specification)))
                                        {{ Str::limit(strip_tags($product->specification), 80) }}
                                    @else
                                        <span class="text-gray-500 italic text-xs">
                                            Spesifikasi tidak tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Stock Info -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                                    <span>Stok: {{ $currentStock }} {{ $product->unit }}</span>
                                    @if($warranty !== 'Tidak Ada Garansi')
                                        <span class="text-green-400">
                                            <i class="fas fa-shield-alt mr-1"></i>{{ $warranty }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Pricing -->
                            <div class="mb-5">
                                <div class="flex items-end justify-between">
                                    <div>
                                        @if($hasDiscount)
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-xl font-bold text-primary">
                                                    Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                                </span>
                                                <span class="text-sm text-gray-400 line-through">
                                                    Rp {{ number_format($sellingPrice, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xl font-bold text-primary">
                                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('main.products.show', $product->id) }}" 
                                   class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-eye text-xs"></i>
                                    <span>Detail</span>
                                </a>
                                <a href="https://wa.me/6282133803940?text=Halo Glorious Computer,%20saya%20tertarik%20dengan%20produk:%0A%0A*{{ urlencode($product->name) }}*%0A%0AHarga: Rp {{ number_format($finalPrice, 0, ',', '.') }}%0AStok: {{ $currentStock }}%0AKondisi: {{ urlencode($condition) }}%0AGaransi: {{ urlencode($warranty) }}%0A%0ASpesifikasi:%20{{ urlencode(Str::limit($product->specification, 150)) }}%0A%0AMohon info lebih lanjut dan ketersediaan produknya." 
                                   target="_blank"
                                   class="flex-1 bg-primary hover:bg-primary-dark text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                   @if($currentStock == 0) onclick="return false;" @endif>
                                    <i class="fab fa-whatsapp"></i>
                                    <span>{{ $currentStock == 0 ? 'Habis' : 'Beli' }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mb-12">
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                        {{ $products->onEachSide(1)->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            @endif

        @else
            <!-- No Products State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-box-open text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Produk Tidak Ditemukan</h3>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    Tidak ada produk yang sesuai dengan filter pencarian Anda.
                </p>
                <a href="{{ route('main.products.index') }}" 
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                    <i class="fas fa-redo"></i>
                    Tampilkan Semua Produk
                </a>
            </div>
        @endif

        <!-- Simple CTA -->
        <div class="mb-16">
            <div class="bg-primary/10 border border-primary/20 rounded-xl p-6 text-center">
                <h2 class="text-xl font-semibold text-white mb-3">Butuh Bantuan Memilih?</h2>
                <p class="text-gray-300 mb-6 max-w-xl mx-auto">
                    Konsultasikan kebutuhan Anda dengan tim ahli kami
                </p>
                <a href="https://wa.me/6282133803940" 
                   target="_blank"
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fab fa-whatsapp"></i>
                    Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal (Simplified) -->
<div id="quickViewModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/70" aria-hidden="true"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl border border-gray-700">
                <button type="button" 
                        onclick="closeQuickView()"
                        class="absolute top-4 right-4 text-gray-400 hover:text-white p-2">
                    <i class="fas fa-times"></i>
                </button>
                <div id="quickViewContent" class="p-6">
                    <!-- Content akan dimuat via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Simple styles */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Smooth transitions */
    * {
        transition: all 0.2s ease;
    }
</style>

<script>
    // Simple Quick View
    function openQuickView(productId) {
        const modal = document.getElementById('quickViewModal');
        const content = document.getElementById('quickViewContent');
        
        // Get product data from current page
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        if (productElement) {
            const productCard = productElement.closest('.bg-gray-800\\/50');
            if (productCard) {
                const productData = extractProductData(productCard);
                content.innerHTML = generateQuickViewHTML(productData);
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
    }

    function extractProductData(productCard) {
        const name = productCard.querySelector('h3')?.textContent?.trim() || 'Produk';
        const category = productCard.querySelector('.text-primary')?.textContent?.trim() || 'Uncategorized';
        const priceText = productCard.querySelector('.text-primary.text-xl')?.textContent?.replace('Rp ', '').replace(/\./g, '') || '0';
        const price = parseInt(priceText) || 0;
        const stockText = productCard.querySelector('.text-xs.text-gray-400 span')?.textContent?.replace('Stok: ', '').split(' ')[0] || '0';
        const stock = parseInt(stockText) || 0;
        const specification = productCard.querySelector('.text-gray-400')?.textContent?.trim() || 'Spesifikasi tidak tersedia';
        
        return {
            name: name,
            category: category,
            price: price,
            stock: stock,
            specification: specification
        };
    }

    function generateQuickViewHTML(product) {
        return `
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">${product.name}</h2>
                    <div class="text-primary text-sm font-medium">${product.category}</div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Spesifikasi</h3>
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <p class="text-gray-300 whitespace-pre-line">${product.specification}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <div class="text-gray-400 text-sm mb-1">Harga</div>
                        <div class="text-2xl font-bold text-primary">
                            Rp ${new Intl.NumberFormat('id-ID').format(product.price)}
                        </div>
                    </div>
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <div class="text-gray-400 text-sm mb-1">Stok</div>
                        <div class="text-xl font-bold text-white">${product.stock} unit</div>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-gray-700">
                    <a href="https://wa.me/6282133803940?text=Halo,%20saya%20tertarik%20dengan%20produk:%20${encodeURIComponent(product.name)}%0AHarga: Rp ${new Intl.NumberFormat('id-ID').format(product.price)}%0A%0AMohon info lebih lanjut." 
                       target="_blank"
                       class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-3 rounded-lg flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>
        `;
    }

    function closeQuickView() {
        const modal = document.getElementById('quickViewModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('quickViewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuickView();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuickView();
        }
    });
</script>
@endsection