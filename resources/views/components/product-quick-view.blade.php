<div class="quick-view-content">
    <div class="flex items-start gap-4">
        <!-- Product Image -->
        <div class="flex-shrink-0">
            @if($product->image && Storage::disk('public')->exists($product->image))
                <img class="object-cover w-20 h-20 rounded-lg border border-gray-200 dark:border-gray-600"
                     src="{{ Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : asset('images/default-product.png') }}"
                     alt="{{ $product->name }}"
                     onerror="this.src='{{ asset('images/default-product.png') }}'">
            @else
                <div class="flex items-center justify-center w-20 h-20 bg-gray-100 rounded-lg dark:bg-gray-700">
                    <i class="text-2xl text-gray-400 fas fa-box"></i>
                </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</p>
            
            <div class="mt-2 space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategori:</span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $product->category->name ?? '-' }}
                    </span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Supplier:</span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $product->supplier->name ?? '-' }}
                    </span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Stok:</span>
                    <span class="text-sm font-semibold {{ $product->current_stock <= 0 ? 'text-red-600' : ($product->current_stock <= $product->min_stock ? 'text-yellow-600' : 'text-green-600') }}">
                        {{ number_format($product->current_stock, 0) }} {{ $product->unit }}
                    </span>
                    @if($product->current_stock <= $product->min_stock && $product->current_stock > 0)
                        <i class="text-yellow-500 fas fa-exclamation-triangle text-xs" title="Stok mendekati minimum"></i>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual:</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Harga Beli:</span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Specification -->
    @if($product->specification)
    <div class="mt-4">
        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Spesifikasi:</h4>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $product->specification }}</p>
    </div>
    @endif
    
    <!-- Description -->
    @if($product->description)
    <div class="mt-3">
        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi:</h4>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
    </div>
    @endif
    
    <!-- Actions -->
    <div class="flex gap-2 mt-4">
        <a href="{{ route('admin.products.show', $product->id) }}"
           class="flex-1 px-3 py-2 text-sm text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            <i class="mr-1 fas fa-eye"></i> Detail
        </a>
        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="flex-1 px-3 py-2 text-sm text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-300">
            <i class="mr-1 fas fa-edit"></i> Edit
        </a>
    </div>
</div>