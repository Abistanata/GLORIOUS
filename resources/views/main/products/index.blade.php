@extends('layouts.theme')

@section('title', 'Produk - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Katalog <span class="text-primary">Produk</span>
            </h1>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Temukan berbagai produk komputer dan aksesori berkualitas dengan harga terbaik dari Glorious Computer
            </p>
        </div>

      <!-- Category Filter Buttons -->
<div class="mb-12">
    <div class="flex flex-wrap justify-center gap-4 mb-8">
        @php
            $currentCategoryId = request('category_id');
        @endphp

        <!-- All Products Button -->
        <a href="{{ route('main.products.index') }}" 
           class="px-6 py-3 font-medium rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg border-2 {{ !$currentCategoryId ? 'bg-primary hover:bg-primary-dark text-white border-primary' : 'bg-gray-800 hover:bg-primary text-white border-gray-700 hover:border-primary' }}">
            <i class="fas fa-th-large mr-2 {{ !$currentCategoryId ? 'text-white' : 'text-gray-400' }}"></i>Semua Produk
        </a>

        <!-- Category Buttons -->
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $category)
                <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}" 
                   class="px-6 py-3 font-medium rounded-full transition-all duration-300 transform hover:scale-105 border-2 group {{ $currentCategoryId == $category->id ? 'bg-primary hover:bg-primary-dark text-white border-primary' : 'bg-gray-800 hover:bg-primary text-white border-gray-700 hover:border-primary' }}">
                    <i class="fas {{ $currentCategoryId == $category->id ? 'fa-folder-open' : 'fa-folder' }} mr-2 group-hover:rotate-12 transition-transform"></i>
                    {{ $category->name ?? 'Unknown Category' }}
                </a>
            @endforeach
        @else
            <div class="text-gray-400 py-3">Tidak ada kategori</div>
        @endif
    </div>
            <!-- Quick Stats -->
            {{-- <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-gray-800 rounded-lg p-4 text-center border border-gray-700">
                    <div class="text-2xl font-bold text-primary mb-1">{{ $totalProducts ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Total Produk</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 text-center border border-gray-700">
                    <div class="text-2xl font-bold text-primary mb-1">{{ $totalCategories ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Kategori</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 text-center border border-gray-700">
                    <div class="text-2xl font-bold text-primary mb-1">{{ $availableStock ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Stok Tersedia</div>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 text-center border border-gray-700">
                    <div class="text-2xl font-bold text-primary mb-1">10+</div>
                    <div class="text-sm text-gray-400">Tahun Pengalaman</div>
                </div>
            </div>
        </div> --}}

        <!-- Search and Filter Section -->
        <div class="bg-gray-800 rounded-2xl p-6 mb-8 border border-gray-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Cari Produk</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama produk, SKU, atau deskripsi..."
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Kategori</label>
                    <select name="category_id" 
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
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
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Urutkan</label>
                    <select name="sort" 
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-colors">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Terendah</option>
                        <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Tertinggi</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-4 flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('main.products.index') }}" 
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
@if(isset($products) && $products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
        @foreach($products as $product)
           @php
    // Gunakan current_stock langsung dari model
    $currentStock = $product->current_stock;
    $stockStatus = $product->stock_status; // Ini akan otomatis tersedia dari accessor
@endphp
            
            <div class="bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 hover:border-primary transition-all duration-300 transform hover:-translate-y-2 group relative">
                <!-- Product Badge -->
                <div class="absolute top-4 right-4 z-10">
                    @if($currentStock > 10)
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                            <i class="fas fa-check mr-1"></i>Tersedia
                        </span>
                    @elseif($currentStock > 0)
                        <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                            <i class="fas fa-exclamation mr-1"></i>Menipis
                        </span>
                    @else
                        <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                            <i class="fas fa-times mr-1"></i>Habis
                        </span>
                    @endif
                </div>

                <!-- Product Image -->
                <div class="h-48 bg-gray-700 overflow-hidden relative">
                    @if($product->image && Storage::exists($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-laptop text-5xl text-gray-500"></i>
                        </div>
                    @endif
                    
                    <!-- Category Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                        <span class="text-primary text-sm font-medium">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                        {{ $product->name ?? 'Nama Produk' }}
                    </h3>
                    
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                        {{ $product->description ?: 'Produk berkualitas dari Glorious Computer.' }}
                    </p>

                    <!-- Specifications -->
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">SKU:</span>
                            <span class="text-white font-medium">{{ $product->sku ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Satuan:</span>
                            <span class="text-white font-medium">{{ $product->unit ?? 'pcs' }}</span>
                        </div>
                        @if($product->supplier && $product->supplier->name)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Supplier:</span>
                            <span class="text-white font-medium">{{ $product->supplier->name }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Price and Stock -->
                    <div class="flex justify-between items-center mb-4 pt-4 border-t border-gray-700">
                       <div class="text-2xl font-bold text-primary">
    Rp {{ number_format($product->selling_price ?? 0, 0, ',', '.') }}
</div>
                        <div class="text-sm text-gray-400">
                            Stok: <span class="font-medium text-white">{{ $currentStock }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="https://wa.me/6282133803940?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}%20(SKU:%20{{ $product->sku }})%20dengan%20harga%20Rp%20{{ number_format($product->selling_price, 0, ',', '.') }}%0A%0AKeterangan:%20{{ urlencode($product->description) }}" 
                           target="_blank"
                           class="flex-1 bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center gap-2 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                           @if($currentStock == 0) onclick="return false;" @endif>
                            <i class="fab fa-whatsapp"></i>
                            {{ $currentStock == 0 ? 'Habis' : 'Pesan' }}
                        </a>
                        <a href="{{ route('main.products.show', $product->id) }}" 
                           class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="flex justify-center mb-12">
                    <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- No Products State -->
            <div class="text-center py-16 bg-gray-800 rounded-2xl border border-gray-700">
                <i class="fas fa-box-open text-6xl text-primary mb-4"></i>
                <h3 class="text-2xl font-bold text-white mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">
                    Maaf, tidak ada produk yang sesuai dengan filter pencarian Anda. Coba gunakan kata kunci lain atau lihat semua produk.
                </p>
                <a href="{{ route('main.products.index') }}" 
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-refresh"></i> Tampilkan Semua Produk
                </a>
            </div>
        @endif

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-8 text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Butuh Bantuan Memilih Produk?</h2>
            <p class="text-white/90 text-lg mb-6 max-w-2xl mx-auto">
                Tim ahli kami siap membantu Anda memilih produk yang tepat sesuai kebutuhan dengan konsultasi gratis.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/6282133803940" 
                   target="_blank"
                   class="bg-white text-primary hover:bg-gray-100 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp"></i> Konsultasi via WhatsApp
                </a>
                <a href="tel:082133803940" 
                   class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <i class="fas fa-phone"></i> Telepon Sekarang
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom pagination styles */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination .page-link {
        padding: 0.5rem 1rem;
        background: #374151;
        color: #D1D5DB;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid #4B5563;
    }
    
    .pagination .page-link:hover,
    .pagination .page-link.active {
        background: #FF6B00;
        color: white;
        border-color: #FF6B00;
    }
</style>

<script>
    // Auto submit form on select change
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.querySelector('select[name="category_id"]');
        const sortSelect = document.querySelector('select[name="sort"]');
        
        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
        
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
@endsection