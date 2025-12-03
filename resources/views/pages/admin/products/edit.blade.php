@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 transition-colors hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('admin.products.index') }}" class="ml-1 text-sm font-medium text-gray-700 transition-colors hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Produk</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Produk</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Produk: {{ $product->name }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui informasi produk sesuai kebutuhan</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Status Badge -->
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($product->current_stock <= 0) bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300
                    @elseif($product->current_stock <= $product->min_stock) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                    @else bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 @endif">
                    Stok: {{ $product->current_stock }} {{ $product->unit }}
                </span>
                <!-- Quick Actions -->
                <button type="button" class="inline-flex items-center px-3 py-2 text-xs font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700" onclick="window.print()">
                    <i class="mr-1 fas fa-print"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800">
            <div class="flex items-center mb-2">
                <i class="mr-2 fas fa-exclamation-triangle"></i>
                <span class="font-medium">Terdapat kesalahan dalam form:</span>
            </div>
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="flex items-center text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="mr-2 text-blue-600 fas fa-edit dark:text-blue-400"></i>
                        Form Edit Produk
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui field yang diperlukan</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/20 dark:text-blue-400">
                        <i class="mr-1 fas fa-info-circle"></i>
                        Terakhir diupdate: {{ $product->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6" id="productForm" novalidate>
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <!-- Left Column - Basic Information -->
                <div class="space-y-6 lg:col-span-8">
                    <!-- Section: Product Information -->
                    <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50 dark:bg-gray-800/50 dark:border-gray-700">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <i class="mr-2 text-blue-600 fas fa-box dark:text-blue-400"></i>
                            Informasi Produk
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Product Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                                       class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('name') border-red-500 dark:border-red-500 @enderror"
                                       placeholder="Contoh: Laptop ASUS ROG Strix G15" autofocus>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Kode SKU <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required
                                       class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('sku') border-red-500 dark:border-red-500 @enderror"
                                       placeholder="SKU produk">
                                @error('sku')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <select id="unit" name="unit" required
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('unit') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Satuan</option>
                                    <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>Pcs (Pieces)</option>
                                    <option value="unit" {{ old('unit', $product->unit) == 'unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram</option>
                                    <option value="gram" {{ old('unit', $product->unit) == 'gram' ? 'selected' : '' }}>Gram</option>
                                    <option value="liter" {{ old('unit', $product->unit) == 'liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="pack" {{ old('unit', $product->unit) == 'pack' ? 'selected' : '' }}>Pack</option>
                                    <option value="dus" {{ old('unit', $product->unit) == 'dus' ? 'selected' : '' }}>Dus</option>
                                </select>
                                @error('unit')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id" required
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('category_id') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Supplier
                                </label>
                                <select id="supplier_id" name="supplier_id"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('supplier_id') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Supplier (Opsional)</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Price & Stock -->
                    <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50 dark:bg-gray-800/50 dark:border-gray-700">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <i class="mr-2 text-green-600 fas fa-dollar-sign dark:text-green-400"></i>
                            Harga & Stok
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            <!-- Purchase Price -->
                            <div>
                                <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Harga Beli <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">Rp</span>
                                    </div>
                                    <input type="hidden" id="purchase_price_raw" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}">
                                    <input type="text" id="purchase_price_display" value="{{ number_format(old('purchase_price', $product->purchase_price), 0, ',', '.') }}" required
                                           class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('purchase_price') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                @error('purchase_price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selling Price -->
                            <div>
                                <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Harga Jual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">Rp</span>
                                    </div>
                                    <input type="hidden" id="selling_price_raw" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}">
                                    <input type="text" id="selling_price_display" value="{{ number_format(old('selling_price', $product->selling_price), 0, ',', '.') }}" required
                                           class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('selling_price') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                <!-- Profit Margin Display -->
                                <div id="profitMargin" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Margin: </span>
                                    <span id="marginAmount" class="text-green-600 dark:text-green-400">
                                        {{ $product->getFormattedMarginAmount() }}
                                    </span>
                                    <span class="text-gray-500">(<span id="marginPercent">
                                        {{ $product->profit_margin }}%
                                    </span>)</span>
                                </div>
                                @error('selling_price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Discount Price -->
                            <div>
                                <label for="discount_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Harga Diskon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">Rp</span>
                                    </div>
                                    <input type="hidden" id="discount_price_raw" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                                    <input type="text" id="discount_price_display" value="{{ $product->discount_price > 0 ? number_format(old('discount_price', $product->discount_price), 0, ',', '.') : '' }}"
                                           class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('discount_price') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                <!-- Discount Info Display -->
                                <div id="discountInfo" class="mt-2 text-sm text-gray-600 dark:text-gray-400 {{ $product->has_discount ? '' : 'hidden' }}">
                                    <span class="font-medium">Diskon: </span>
                                    <span id="discountAmount" class="text-red-600 dark:text-red-400">
                                        {{ $product->getFormattedDiscountAmount() ?? 'Rp 0' }}
                                    </span>
                                    <span class="text-gray-500">(<span id="discountPercent">
                                        {{ $product->discount_percentage }}%
                                    </span>)</span>
                                </div>
                                @error('discount_price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Current Stock -->
                            <div>
                                <label for="current_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Stok Terkini <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="text-gray-500 fas fa-box dark:text-gray-400"></i>
                                    </div>
                                    <input type="number" id="current_stock" name="current_stock" value="{{ old('current_stock', $product->current_stock) }}" min="0" required
                                           class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('current_stock') border-red-500 dark:border-red-500 @enderror"
                                           placeholder="0">
                                </div>
                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Stok saat ini produk</span>
                                </div>
                                @error('current_stock')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Minimum Stock & Maximum Stock -->
                            <div class="md:col-span-4">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label for="min_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Stok Minimum <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <i class="text-yellow-500 fas fa-exclamation-triangle dark:text-yellow-400"></i>
                                            </div>
                                            <input type="number" id="min_stock" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" min="0" required
                                                   class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('min_stock') border-red-500 dark:border-red-500 @enderror"
                                                   placeholder="0">
                                        </div>
                                        <div id="stockWarning" class="hidden mt-2 text-sm text-yellow-600 dark:text-yellow-400">
                                            <i class="mr-1 fas fa-exclamation-circle"></i>
                                            <span>Stok terkini di bawah stok minimum!</span>
                                        </div>
                                        @error('min_stock')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="max_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Stok Maksimum (Opsional)
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <i class="text-blue-500 fas fa-chart-bar dark:text-blue-400"></i>
                                            </div>
                                            <input type="number" id="max_stock" name="max_stock" value="{{ old('max_stock', $product->max_stock) }}" min="0"
                                                   class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('max_stock') border-red-500 dark:border-red-500 @enderror"
                                                   placeholder="Tidak terbatas">
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            <span>Batasan stok maksimal</span>
                                        </div>
                                        @error('max_stock')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg dark:bg-gray-700">
                                        <div class="flex items-center">
                                            <i class="mr-2 text-blue-500 fas fa-chart-pie"></i>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Status Stok:</span>
                                        </div>
                                        <div id="stockStatus" class="flex items-center">
                                            <span id="stockStatusText" class="text-sm font-medium">{{ $product->getStockStatusLabel() }}</span>
                                            <div id="stockStatusBadge" class="ml-2 px-2 py-1 text-xs font-medium rounded-full 
                                                @if($product->stock_status == 'out_of_stock') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                @elseif($product->stock_status == 'low_stock') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                @elseif($product->stock_status == 'max_stock') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif">
                                                {{ $product->stock_status == 'out_of_stock' ? 'Habis' : ($product->stock_status == 'low_stock' ? 'Menipis' : ($product->stock_status == 'max_stock' ? 'Maksimum' : 'Aman')) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Spesifikasi Produk -->
                    <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50 dark:bg-gray-800/50 dark:border-gray-700">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <i class="mr-2 text-purple-600 fas fa-list-alt dark:text-purple-400"></i>
                            Spesifikasi Produk
                        </h3>
                        <div>
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Detail Spesifikasi
                            </label>
                            <textarea id="description" name="description" rows="5"
                                      class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('description') border-red-500 dark:border-red-500 @enderror"
                                      placeholder="Tuliskan spesifikasi lengkap produk, seperti bahan, ukuran, warna, kapasitas, atau spesifikasi teknis lainnya...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Gunakan format bullet atau poin-poin penting untuk memudahkan pembacaan</p>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50 dark:bg-gray-800/50 dark:border-gray-700">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <i class="mr-2 text-orange-600 fas fa-info-circle dark:text-orange-400"></i>
                            Informasi Tambahan
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <!-- Pengiriman -->
                            <div>
                                <label for="shipping_info" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Pengiriman
                                </label>
                                <select id="shipping_info" name="shipping_info"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('shipping_info') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Metode Pengiriman</option>
                                    <option value="free" {{ old('shipping_info', $product->shipping_info) == 'free' ? 'selected' : '' }}>Gratis Ongkir</option>
                                    <option value="calculated" {{ old('shipping_info', $product->shipping_info) == 'calculated' ? 'selected' : '' }}>Dihitung Otomatis</option>
                                    <option value="flat_rate" {{ old('shipping_info', $product->shipping_info) == 'flat_rate' ? 'selected' : '' }}>Tarif Flat</option>
                                    <option value="pickup" {{ old('shipping_info', $product->shipping_info) == 'pickup' ? 'selected' : '' }}>Ambil di Tempat</option>
                                </select>
                                @error('shipping_info')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label for="condition" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Kondisi <span class="text-red-500">*</span>
                                </label>
                                <select id="condition" name="condition" required
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('condition') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Baru</option>
                                    <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Bekas</option>
                                    <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Rekondisi</option>
                                </select>
                                @error('condition')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Garansi -->
                            <div>
                                <label for="warranty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Garansi
                                </label>
                                <select id="warranty" name="warranty"
                                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all @error('warranty') border-red-500 dark:border-red-500 @enderror">
                                    <option value="">Pilih Masa Garansi</option>
                                    <option value="no_warranty" {{ old('warranty', $product->warranty) == 'no_warranty' ? 'selected' : '' }}>Tidak Ada Garansi</option>
                                    <option value="1_month" {{ old('warranty', $product->warranty) == '1_month' ? 'selected' : '' }}>1 Bulan</option>
                                    <option value="3_months" {{ old('warranty', $product->warranty) == '3_months' ? 'selected' : '' }}>3 Bulan</option>
                                    <option value="6_months" {{ old('warranty', $product->warranty) == '6_months' ? 'selected' : '' }}>6 Bulan</option>
                                    <option value="1_year" {{ old('warranty', $product->warranty) == '1_year' ? 'selected' : '' }}>1 Tahun</option>
                                    <option value="2_years" {{ old('warranty', $product->warranty) == '2_years' ? 'selected' : '' }}>2 Tahun</option>
                                    <option value="lifetime" {{ old('warranty', $product->warranty) == 'lifetime' ? 'selected' : '' }}>Seumur Hidup</option>
                                </select>
                                @error('warranty')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Image Upload -->
                <div class="lg:col-span-4">
                    <div class="sticky top-6">
                        <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/50 dark:bg-gray-800/50 dark:border-gray-700">
                            <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                                <i class="mr-2 text-indigo-600 fas fa-image dark:text-indigo-400"></i>
                                Gambar Produk
                            </h3>

                            <!-- Image Preview -->
                            <div class="mb-4">
                                <div class="relative group">
                                    <img id="imagePreview" class="object-cover w-full h-48 transition-all border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-600 group-hover:border-blue-400"
                                         src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                         alt="Preview gambar">
                                    <button type="button" id="removeImageBtn" class="absolute p-2 text-white transition-colors bg-red-500 rounded-full shadow-lg -top-2 -right-2 hover:bg-red-600"
                                            style="{{ !$product->image ? 'display: none;' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Upload Button -->
                            <div>
                                <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                                <label for="image" class="cursor-pointer">
                                    <div class="flex flex-col items-center justify-center w-full px-4 py-6 text-sm font-medium text-gray-700 transition-all bg-white border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 hover:border-blue-400 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:border-blue-500">
                                        <i class="mb-2 text-2xl text-blue-500 fas fa-cloud-upload-alt"></i>
                                        <span class="font-medium">Klik untuk pilih gambar</span>
                                        <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">atau drag & drop file di sini</span>
                                    </div>
                                </label>
                                <div class="mt-3 space-y-1 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <i class="mr-1 text-green-500 fas fa-check-circle"></i>
                                        Format: JPG, PNG, GIF
                                    </div>
                                    <div class="flex items-center">
                                        <i class="mr-1 text-green-500 fas fa-check-circle"></i>
                                        Maksimal: 2MB
                                    </div>
                                    <div class="flex items-center">
                                        <i class="mr-1 text-blue-500 fas fa-info-circle"></i>
                                        Rekomendasi: 800x600px
                                    </div>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Stock Summary -->
                        <div class="p-4 mt-6 border border-blue-200 rounded-lg bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800">
                            <h4 class="flex items-center mb-2 text-sm font-medium text-blue-900 dark:text-blue-300">
                                <i class="mr-1 fas fa-boxes"></i>
                                Ringkasan Stok
                            </h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-blue-800 dark:text-blue-400">Stok Terkini:</span>
                                    <span class="font-medium text-blue-900 dark:text-blue-300" id="summaryCurrentStock">{{ $product->current_stock }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-yellow-600 dark:text-yellow-400">Stok Minimum:</span>
                                    <span class="font-medium text-yellow-700 dark:text-yellow-300" id="summaryMinStock">{{ $product->min_stock }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-green-600 dark:text-green-400">Stok Maksimum:</span>
                                    <span class="font-medium text-green-700 dark:text-green-300" id="summaryMaxStock">
                                        {{ $product->max_stock ?? 'Tidak Terbatas' }}
                                    </span>
                                </div>
                                <div class="pt-2 mt-2 border-t border-blue-200 dark:border-blue-700">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-blue-900 dark:text-blue-300">Status:</span>
                                        <span class="font-medium text-blue-900 dark:text-blue-300" id="summaryStockStatus">{{ $product->getStockStatusLabel() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="p-4 mt-6 border border-green-200 rounded-lg bg-green-50 dark:bg-green-900/20 dark:border-green-800">
                            <h4 class="flex items-center mb-2 text-sm font-medium text-green-900 dark:text-green-300">
                                <i class="mr-1 fas fa-chart-line"></i>
                                Ringkasan Harga
                            </h4>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-green-800 dark:text-green-400">Harga Beli:</span>
                                    <span class="font-medium text-green-900 dark:text-green-300" id="summaryPurchasePrice">
                                        {{ $product->formatted_purchase_price }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-green-800 dark:text-green-400">Harga Jual:</span>
                                    <span class="font-medium text-green-900 dark:text-green-300" id="summarySellingPrice">
                                        {{ $product->formatted_selling_price }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-red-600 dark:text-red-400">Harga Diskon:</span>
                                    <span class="font-medium text-red-700 dark:text-red-300" id="summaryDiscountPrice">
                                        {{ $product->formatted_discount_price ?? 'Rp 0' }}
                                    </span>
                                </div>
                                <div class="pt-2 mt-2 border-t border-green-200 dark:border-green-700">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-green-900 dark:text-green-300">Keuntungan:</span>
                                        <span class="font-medium text-green-900 dark:text-green-300" id="summaryProfit">
                                            {{ $product->getFormattedMarginAmount() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Stats -->
                        <div class="p-4 mt-6 border border-purple-200 rounded-lg bg-purple-50 dark:bg-purple-900/20 dark:border-purple-800">
                            <h4 class="flex items-center mb-2 text-sm font-medium text-purple-900 dark:text-purple-300">
                                <i class="mr-1 fas fa-chart-bar"></i>
                                Informasi Produk
                            </h4>
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-purple-800 dark:text-purple-400">Kondisi:</span>
                                    <span class="font-medium text-purple-900 dark:text-purple-300">{{ $product->getConditionLabel() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-800 dark:text-purple-400">Pengiriman:</span>
                                    <span class="font-medium text-purple-900 dark:text-purple-300">{{ $product->getShippingInfoLabel() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-purple-800 dark:text-purple-400">Garansi:</span>
                                    <span class="font-medium text-purple-900 dark:text-purple-300">{{ $product->getWarrantyLabel() }}</span>
                                </div>
                                @if($product->has_discount)
                                <div class="flex justify-between">
                                    <span class="text-purple-800 dark:text-purple-400">Diskon:</span>
                                    <span class="font-medium text-red-700 dark:text-red-300">{{ $product->discount_percentage }}%</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-6">
                            <a href="{{ route('admin.products.show', $product->id) }}"
                               class="flex items-center justify-center w-full px-4 py-3 mb-3 text-sm font-medium text-gray-900 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                                <i class="mr-2 fas fa-eye"></i>
                                Lihat Detail Produk
                            </a>
                            <button type="button" id="deleteProductBtn"
                                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700">
                                <i class="mr-2 fas fa-trash-alt"></i>
                                Hapus Produk
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle"></i>
                    <span>Semua field bertanda (*) wajib diisi</span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                        <i class="mr-2 fas fa-times"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                        <i class="mr-2 fas fa-save"></i>
                        Update Produk
                    </button>
                </div>
            </div>
        </form>

        <form id="deleteProductForm" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format currency inputs
    const formatCurrencyInputs = () => {
        const purchasePriceInput = document.getElementById('purchase_price_display');
        const sellingPriceInput = document.getElementById('selling_price_display');
        const discountPriceInput = document.getElementById('discount_price_display');
        const purchasePriceRaw = document.getElementById('purchase_price_raw');
        const sellingPriceRaw = document.getElementById('selling_price_raw');
        const discountPriceRaw = document.getElementById('discount_price_raw');

        function formatCurrency(input, rawInput) {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                value = value === '' ? '0' : value;
                rawInput.value = value;
                this.value = new Intl.NumberFormat('id-ID').format(value);
                updateCalculations();
            });
        }

        function setInitialValue(input, rawInput) {
            if (rawInput.value && rawInput.value !== '0') {
                input.value = new Intl.NumberFormat('id-ID').format(rawInput.value);
            }
        }

        if (purchasePriceInput && purchasePriceRaw) {
            formatCurrency(purchasePriceInput, purchasePriceRaw);
            setInitialValue(purchasePriceInput, purchasePriceRaw);
        }

        if (sellingPriceInput && sellingPriceRaw) {
            formatCurrency(sellingPriceInput, sellingPriceRaw);
            setInitialValue(sellingPriceInput, sellingPriceRaw);
        }

        if (discountPriceInput && discountPriceRaw) {
            discountPriceInput.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                value = value === '' ? '0' : value;
                discountPriceRaw.value = value;
                this.value = new Intl.NumberFormat('id-ID').format(value);
                updateCalculations();
            });

            if (discountPriceRaw.value && discountPriceRaw.value !== '0') {
                discountPriceInput.value = new Intl.NumberFormat('id-ID').format(discountPriceRaw.value);
            }
        }
    };

    // Stock validation
    const currentStockInput = document.getElementById('current_stock');
    const minStockInput = document.getElementById('min_stock');
    const maxStockInput = document.getElementById('max_stock');
    const stockWarning = document.getElementById('stockWarning');

    function validateStock() {
        const currentStock = parseInt(currentStockInput.value) || 0;
        const minStock = parseInt(minStockInput.value) || 0;
        const maxStock = parseInt(maxStockInput.value) || 0;

        // Update summary
        document.getElementById('summaryCurrentStock').textContent = currentStock;
        document.getElementById('summaryMinStock').textContent = minStock;
        document.getElementById('summaryMaxStock').textContent = maxStock > 0 ? maxStock : 'Tidak Terbatas';

        // Check stock warning
        if (currentStock > 0 && currentStock <= minStock) {
            stockWarning.classList.remove('hidden');
        } else {
            stockWarning.classList.add('hidden');
        }

        // Update stock status
        updateStockStatus();
    }

    function updateStockStatus() {
        const currentStock = parseInt(currentStockInput.value) || 0;
        const minStock = parseInt(minStockInput.value) || 0;
        const maxStock = parseInt(maxStockInput.value) || 0;

        let status = '';
        let badgeClass = '';
        let badgeText = '';

        if (currentStock === 0) {
            status = 'Stok Habis';
            badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
            badgeText = 'Habis';
        } else if (currentStock <= minStock) {
            status = 'Stok Menipis';
            badgeClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            badgeText = 'Menipis';
        } else if (maxStock > 0 && currentStock >= maxStock) {
            status = 'Stok Maksimum';
            badgeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
            badgeText = 'Maksimum';
        } else {
            status = 'Stok Aman';
            badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
            badgeText = 'Aman';
        }

        const stockStatusText = document.getElementById('stockStatusText');
        const stockStatusBadge = document.getElementById('stockStatusBadge');

        if (stockStatusText) stockStatusText.textContent = status;
        if (stockStatusBadge) {
            stockStatusBadge.className = `ml-2 px-2 py-1 text-xs font-medium rounded-full ${badgeClass}`;
            stockStatusBadge.textContent = badgeText;
        }

        // Update summary status
        const summaryStatus = document.getElementById('summaryStockStatus');
        if (summaryStatus) summaryStatus.textContent = status;
    }

    // Update calculations (margin, discount, etc.)
    function updateCalculations() {
        const purchase = parseInt(document.getElementById('purchase_price_raw').value) || 0;
        const selling = parseInt(document.getElementById('selling_price_raw').value) || 0;
        const discount = parseInt(document.getElementById('discount_price_raw').value) || 0;

        // Update price summary
        document.getElementById('summaryPurchasePrice').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(purchase);
        document.getElementById('summarySellingPrice').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(selling);
        document.getElementById('summaryDiscountPrice').textContent = discount > 0 ? 'Rp' + new Intl.NumberFormat('id-ID').format(discount) : 'Rp 0';

        // Calculate profit margin
        if (purchase > 0 && selling > 0) {
            const finalPrice = discount > 0 && discount < selling ? discount : selling;
            const margin = finalPrice - purchase;
            const marginPercent = purchase > 0 ? ((margin / purchase) * 100).toFixed(2) : '0';

            document.getElementById('marginAmount').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(margin);
            document.getElementById('marginPercent').textContent = marginPercent;
            document.getElementById('summaryProfit').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(margin);
        }

        // Calculate discount info
        if (discount > 0 && selling > 0) {
            const discountAmount = selling - discount;
            const discountPercent = ((discountAmount / selling) * 100).toFixed(2);

            document.getElementById('discountAmount').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(discountAmount);
            document.getElementById('discountPercent').textContent = discountPercent;
            document.getElementById('discountInfo').classList.remove('hidden');
        } else {
            document.getElementById('discountInfo').classList.add('hidden');
        }
    }

    // Handle image upload and removal
    const handleImageUpload = () => {
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const removeImageBtn = document.getElementById('removeImageBtn');
        const removeImageInput = document.getElementById('removeImageInput');
        const placeholderImage = 'https://via.placeholder.com/300x200?text=No+Image';

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        if (removeImageBtn) removeImageBtn.style.display = 'flex';
                        if (removeImageInput) removeImageInput.value = '0';
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        if (removeImageBtn && removeImageInput) {
            removeImageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (imageInput) imageInput.value = '';
                if (imagePreview) imagePreview.src = placeholderImage;
                this.style.display = 'none';
                if (removeImageInput) removeImageInput.value = '1';
            });
        }
    };

    // Delete product confirmation
    const deleteProductBtn = document.getElementById('deleteProductBtn');
    if (deleteProductBtn) {
        deleteProductBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                document.getElementById('deleteProductForm').submit();
            }
        });
    }

    // Initialize event listeners
    if (currentStockInput) {
        currentStockInput.addEventListener('input', validateStock);
    }
    if (minStockInput) {
        minStockInput.addEventListener('input', validateStock);
    }
    if (maxStockInput) {
        maxStockInput.addEventListener('input', validateStock);
    }

    // Initialize all functions
    formatCurrencyInputs();
    handleImageUpload();
    validateStock();
    updateCalculations();
});
</script>
@endpush