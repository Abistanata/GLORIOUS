@props([
    'product',
    'showActions' => true,
    'layout' => 'default',
])

@php
    $currentStock = $product->current_stock ?? 0;
    $hasDiscount = $product->has_discount ?? false;
    $discountPercentage = $product->discount_percentage ?? 0;
    $finalPrice = $product->final_price ?? $product->selling_price ?? 0;
    $sellingPrice = $product->selling_price ?? $finalPrice;
    $condition = method_exists($product, 'getConditionLabel') ? $product->getConditionLabel() : ($product->condition ?? 'Baru');
    $warranty = method_exists($product, 'getWarrantyLabel') ? $product->getWarrantyLabel() : ($product->warranty ?? '-');
    $shipping = method_exists($product, 'getShippingInfoLabel') ? $product->getShippingInfoLabel() : '-';
    $stockStatus = $product->stock_status ?? ($currentStock > 0 ? 'in_stock' : 'out_of_stock');
    $imagePath = $product->image ?? null;
    $imageUrl = null;
    if ($imagePath) {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($imagePath)) {
            $imageUrl = asset('storage/' . $imagePath);
        } elseif (str_starts_with($imagePath, 'http')) {
            $imageUrl = $imagePath;
        }
    }
@endphp

<div class="group bg-gray-800/50 border border-gray-700 rounded-xl overflow-hidden transition-all hover:border-primary/30 hover:shadow-lg h-full flex flex-col" data-product-id="{{ $product->id }}">
    <div class="relative h-52 bg-gray-900 overflow-hidden">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-800">
                <i class="fas fa-laptop text-4xl text-gray-600"></i>
            </div>
        @endif

        @if($hasDiscount && $discountPercentage > 0)
            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-600 text-white">-{{ $discountPercentage }}%</span>
        @endif
        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-semibold
            {{ $stockStatus === 'out_of_stock' ? 'bg-red-900/80 text-red-300' : ($stockStatus === 'low_stock' ? 'bg-yellow-900/80 text-yellow-300' : 'bg-green-900/80 text-green-300') }}">
            @if($stockStatus === 'out_of_stock') Habis
            @elseif($stockStatus === 'low_stock') Menipis
            @else Tersedia
            @endif
        </span>
        @if($condition && $condition !== 'Baru')
            <span class="absolute bottom-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/90 text-white">{{ $condition }}</span>
        @endif
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <span class="text-primary text-xs font-semibold">{{ $product->category->name ?? 'Uncategorized' }}</span>
        <h3 class="text-base font-semibold text-white mt-1 mb-2 line-clamp-2">
            <a href="{{ route('main.products.show', $product->id) }}" class="hover:text-primary transition-colors">{{ $product->name }}</a>
        </h3>

        <div class="text-gray-400 text-sm line-clamp-2 mb-3">
            @if(!empty($product->specification))
                {{ \Illuminate\Support\Str::limit(strip_tags($product->specification), 80) }}
            @else
                <span class="italic">Spesifikasi tidak tersedia</span>
            @endif
        </div>

        <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
            <span>Stok: {{ $currentStock }} {{ $product->unit ?? 'pcs' }}</span>
            @if($warranty !== 'Tidak Ada Garansi' && $warranty !== 'Belum Ditentukan')
                <span class="text-green-400"><i class="fas fa-shield-alt mr-1"></i>{{ $warranty }}</span>
            @endif
        </div>

        <div class="mb-4">
            @if($hasDiscount)
                <div class="flex items-baseline gap-2">
                    <span class="text-xl font-bold text-primary">Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
                    <span class="text-sm text-gray-400 line-through">Rp {{ number_format($sellingPrice, 0, ',', '.') }}</span>
                </div>
            @else
                <span class="text-xl font-bold text-primary">Rp {{ number_format($finalPrice, 0, ',', '.') }}</span>
            @endif
        </div>

        @if($showActions)
            <div class="mt-auto space-y-2">
                <div class="flex gap-2">
                    <a href="{{ route('main.products.show', $product->id) }}"
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-eye text-xs"></i> Detail
                    </a>
                    @auth
                        @if(auth()->user()->role === 'Customer')
                            <button type="button"
                                    onclick="window.addToCartFromCard && window.addToCartFromCard({{ $product->id }}, {{ $finalPrice }}, {{ $currentStock }})"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $currentStock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart text-xs"></i> Keranjang
                            </button>
                            @php $inWishlist = $product->is_in_wishlist ?? false; @endphp
                            <button type="button"
                                    onclick="window.toggleWishlistFromCard && window.toggleWishlistFromCard({{ $product->id }})"
                                    class="bg-gray-700 hover:bg-red-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center {{ $inWishlist ? '!bg-red-600' : '' }}"
                                    data-product-id="{{ $product->id }}" title="{{ $inWishlist ? 'Hapus dari wishlist' : 'Tambah ke wishlist' }}">
                                <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart text-xs"></i>
                            </button>
                        @else
                            <a href="{{ route('main.products.show', $product->id) }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart text-xs"></i> Detail
                            </a>
                        @endif
                    @else
                        <button type="button" class="flex-1 js-require-login-cart bg-gray-700 hover:bg-gray-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" data-message="Silakan login untuk menambah ke keranjang." {{ $currentStock == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart text-xs"></i> Keranjang
                        </button>
                        <button type="button" class="js-require-login-wishlist bg-gray-700 hover:bg-red-600 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center" data-message="Silakan login untuk menambah wishlist.">
                            <i class="fas fa-heart text-xs"></i>
                        </button>
                    @endauth
                </div>
                @auth
                    @if(auth()->user()->role === 'Customer')
                        <form action="{{ route('order.create-and-whatsapp') }}" method="POST" class="order-wa-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 {{ $currentStock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $currentStock == 0 ? 'disabled' : '' }}>
                                <i class="fab fa-whatsapp"></i> {{ $currentStock == 0 ? 'Habis' : 'Pesan via WhatsApp' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('main.products.show', $product->id) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp"></i> Lihat Detail
                        </a>
                    @endif
                @else
                    <button type="button"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-3 rounded-lg transition-colors text-sm flex items-center justify-center gap-2 js-require-login-wa"
                            data-message="Silakan login untuk memesan via WhatsApp.">
                        <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                    </button>
                @endauth
            </div>
        @endif
    </div>
</div>
