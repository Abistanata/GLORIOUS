@extends('layouts.theme')

@section('title', $product->name . ' - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-400">
                <li>
                    <a href="{{ route('main.products.index') }}" class="hover:text-primary transition-colors">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li>
                    <a href="{{ route('main.products.index') }}" class="hover:text-primary transition-colors">
                        Produk
                    </a>
                </li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Detail Section -->
        <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="bg-gray-700 rounded-xl overflow-hidden h-80 flex items-center justify-center">
                        @if($product->image && Storage::exists($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-center text-gray-500">
                                <i class="fas fa-laptop text-8xl mb-4"></i>
                                <p class="text-lg">Gambar Tidak Tersedia</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Badge -->
                    <div class="flex justify-center">
                        @php
                            $currentStock = $product->current_stock;
                        @endphp
                        @if($currentStock > 10)
                            <span class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                                <i class="fas fa-check mr-2"></i>Stok Tersedia
                            </span>
                        @elseif($currentStock > 0)
                            <span class="bg-yellow-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                                <i class="fas fa-exclamation mr-2"></i>Stok Menipis
                            </span>
                        @else
                            <span class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg">
                                <i class="fas fa-times mr-2"></i>Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Category -->
                    <div class="inline-block">
                        <span class="bg-primary/20 text-primary px-3 py-1 rounded-full text-sm font-medium">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-white">{{ $product->name }}</h1>

                    <!-- SKU -->
                    <div class="text-gray-400">
                        <span class="font-medium text-white">SKU:</span> {{ $product->sku ?? 'N/A' }}
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-4">
                        <div class="text-4xl font-bold text-primary">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </div>
                        @if($product->purchase_price && $product->purchase_price > 0)
                            <div class="text-lg text-gray-400 line-through">
                                Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- Stock Information -->
                    <div class="bg-gray-700/50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Stok Tersedia:</span>
                            <span class="text-xl font-bold text-white">{{ $currentStock }} {{ $product->unit ?? 'pcs' }}</span>
                        </div>
                        @if($currentStock == 0)
                            <div class="mt-2 text-red-400 text-sm">
                                <i class="fas fa-clock mr-1"></i> Produk sedang tidak tersedia
                            </div>
                        @elseif($currentStock <= 5)
                            <div class="mt-2 text-yellow-400 text-sm">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Stok terbatas, segera pesan!
                            </div>
                        @endif
                    </div>

                    <!-- Specifications -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-white">Spesifikasi Produk</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            @if($product->supplier && $product->supplier->name)
                            <div>
                                <span class="text-gray-400">Supplier:</span>
                                <span class="text-white font-medium ml-2">{{ $product->supplier->name }}</span>
                            </div>
                            @endif
                            <div>
                                <span class="text-gray-400">Satuan:</span>
                                <span class="text-white font-medium ml-2">{{ $product->unit ?? 'pcs' }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-400">Dibuat:</span>
                                <span class="text-white font-medium ml-2">{{ $product->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-white">Deskripsi Produk</h3>
                        <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4">
                        <a href="https://wa.me/6282133803940?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}%20(SKU:%20{{ $product->sku }})%20dengan%20harga%20Rp%20{{ number_format($product->selling_price, 0, ',', '.') }}%0A%0AKeterangan:%20{{ urlencode($product->description) }}%0A%0ALink Produk: {{ urlencode(url()->current()) }}" 
                           target="_blank"
                           class="flex-1 bg-primary hover:bg-primary-dark text-white py-4 px-6 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-3 text-lg {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                           @if($currentStock == 0) onclick="return false;" @endif>
                            <i class="fab fa-whatsapp text-xl"></i>
                            {{ $currentStock == 0 ? 'Stok Habis' : 'Pesan via WhatsApp' }}
                        </a>
                        
                        <a href="{{ route('main.products.index') }}" 
                           class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-4 px-6 rounded-lg font-medium transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @php
            $relatedProducts = App\Models\Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('current_stock', '>', 0)
                ->limit(4)
                ->get();
        @endphp
        
        @if($relatedProducts->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-6">Produk Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 hover:border-primary transition-all duration-300 group">
                    <!-- Product Image -->
                    <div class="h-40 bg-gray-700 overflow-hidden">
                        @if($relatedProduct->image && Storage::exists($relatedProduct->image))
                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                 alt="{{ $relatedProduct->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-laptop text-4xl text-gray-500"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-semibold text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                            {{ $relatedProduct->name }}
                        </h3>
                        
                        <div class="flex justify-between items-center mb-3">
                            <div class="text-lg font-bold text-primary">
                                Rp {{ number_format($relatedProduct->selling_price, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-400">
                                Stok: <span class="text-white">{{ $relatedProduct->current_stock }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('main.products.show', $relatedProduct->id) }}" 
                               class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 rounded text-sm text-center transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-8 text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Butuh Bantuan Teknis?</h2>
            <p class="text-white/90 text-lg mb-6 max-w-2xl mx-auto">
                Tim support kami siap membantu Anda dengan pertanyaan teknis dan rekomendasi produk.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/6282133803940" 
                   target="_blank"
                   class="bg-white text-primary hover:bg-gray-100 font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp"></i> Chat Support
                </a>
                <a href="tel:082133803940" 
                   class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                    <i class="fas fa-phone"></i> Telepon Support
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endsection