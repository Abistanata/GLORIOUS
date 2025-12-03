@extends('layouts.dashboard')

@section('title', 'Detail Produk')

@section('content')
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex items-center mb-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('admin.products.index') }}" class="hover:text-blue-600">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-gray-500 dark:text-gray-300">Detail</span>
        </nav>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Produk: {{ $product->name }}</h1>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm font-medium rounded-full
                    @if($product->stock_status == 'out_of_stock') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300
                    @elseif($product->stock_status == 'low_stock') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                    @elseif($product->stock_status == 'max_stock') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300
                    @else bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 @endif">
                    {{ $product->getStockStatusLabel() }}
                </span>
                @if($product->has_discount)
                <span class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-full dark:bg-red-700">
                    -{{ $product->discount_percentage }}%
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Informasi Produk -->
        <div class="col-span-2 space-y-6">
            <!-- Card Informasi Utama -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Produk</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Kolom 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Produk</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">SKU</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->sku }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $product->category ? $product->category->name : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Supplier</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $product->supplier ? $product->supplier->name : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Satuan</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $product->unit }}</p>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kondisi</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                        @if($product->condition == 'new') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                        @elseif($product->condition == 'used') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300 @endif">
                                        <i class="mr-1 fas 
                                            @if($product->condition == 'new') fa-tag
                                            @elseif($product->condition == 'used') fa-history
                                            @else fa-recycle @endif"></i>
                                        {{ $product->getConditionLabel() }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Pengiriman</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($product->shipping_info)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 rounded-full text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <i class="mr-1 fas 
                                            @if($product->shipping_info == 'free') fa-shipping-fast
                                            @elseif($product->shipping_info == 'calculated') fa-calculator
                                            @elseif($product->shipping_info == 'flat_rate') fa-tags
                                            @else fa-store @endif"></i>
                                        {{ $product->getShippingInfoLabel() }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">Belum diatur</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Garansi</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($product->warranty)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-indigo-100 rounded-full text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-300">
                                        <i class="mr-1 fas fa-shield-alt"></i>
                                        {{ $product->getWarrantyLabel() }}
                                    </span>
                                    @else
                                    <span class="text-gray-400">Tidak ada garansi</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Spesifikasi Produk</label>
                        <div class="mt-1 p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">
                                {{ $product->description ?: 'Tidak ada spesifikasi' }}
                            </p>
                        </div>
                    </div>

                    <!-- Info Tambahan -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Pada</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $product->created_at->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Diupdate Pada</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $product->updated_at->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Harga & Stok -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Harga & Stok</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Harga -->
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Harga Beli</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $product->formatted_purchase_price }}
                                </p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Harga Jual</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $product->formatted_selling_price }}
                                </p>
                            </div>

                            @if($product->has_discount)
                            <div class="p-4 bg-red-50 rounded-lg dark:bg-red-900/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-red-600 dark:text-red-300">Harga Diskon</label>
                                        <p class="mt-1 text-lg font-semibold text-red-700 dark:text-red-200">
                                            {{ $product->formatted_discount_price }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full dark:bg-red-700">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-red-600 dark:text-red-300">
                                    Hemat: {{ $product->getFormattedDiscountAmount() }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Stok -->
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 rounded-lg dark:bg-blue-900/20">
                                <label class="block text-sm font-medium text-blue-600 dark:text-blue-300">Stok Terkini</label>
                                <p class="mt-1 text-2xl font-bold text-blue-700 dark:text-blue-200">
                                    {{ $product->current_stock }} {{ $product->unit }}
                                </p>
                            </div>

                            <div class="p-4 bg-yellow-50 rounded-lg dark:bg-yellow-900/20">
                                <label class="block text-sm font-medium text-yellow-600 dark:text-yellow-300">Stok Minimum</label>
                                <p class="mt-1 text-lg font-semibold text-yellow-700 dark:text-yellow-200">
                                    {{ $product->min_stock }} {{ $product->unit }}
                                </p>
                                @if($product->current_stock <= $product->min_stock)
                                <div class="mt-2 flex items-center text-sm text-yellow-600 dark:text-yellow-300">
                                    <i class="mr-1 fas fa-exclamation-triangle"></i>
                                    <span>Stok mencapai batas minimum</span>
                                </div>
                                @endif
                            </div>

                            @if($product->max_stock)
                            <div class="p-4 bg-green-50 rounded-lg dark:bg-green-900/20">
                                <label class="block text-sm font-medium text-green-600 dark:text-green-300">Stok Maksimum</label>
                                <p class="mt-1 text-lg font-semibold text-green-700 dark:text-green-200">
                                    {{ $product->max_stock }} {{ $product->unit }}
                                </p>
                                @if($product->stock_percentage > 0)
                                <div class="mt-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-green-600 dark:text-green-300">Kapasitas: {{ $product->stock_percentage }}%</span>
                                    </div>
                                    <div class="mt-1 w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ min($product->stock_percentage, 100) }}%"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ringkasan Keuntungan -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Harga Akhir</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $product->getFormattedFinalPrice() }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Keuntungan</label>
                                <p class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">
                                    {{ $product->getFormattedMarginAmount() }}
                                    <span class="text-sm font-normal text-gray-500">({{ $product->profit_margin }}%)</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Riwayat Stok -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Riwayat Stok</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Total: {{ $product->stockTransactions->count() }} transaksi
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($product->stockTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Jenis
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            Catatan
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                                            User
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach($product->stockTransactions as $transaction)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                                {{ $transaction->date->translatedFormat('d M Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                                @if($transaction->type === 'Masuk')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        <i class="mr-1 fas fa-arrow-down"></i> Masuk
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        <i class="mr-1 fas fa-arrow-up"></i> Keluar
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                                {{ $transaction->quantity }} {{ $product->unit }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                                {{ $transaction->notes ?: '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                                {{ $transaction->user->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-6 text-center">
                            <i class="mx-auto text-3xl text-gray-400 fas fa-box-open"></i>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat stok untuk produk ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="space-y-6">
            <!-- Card Gambar Produk -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Gambar Produk</h2>
                </div>
                <div class="p-6">
                    @if($product->image)
                        <div class="overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="object-cover w-full h-48 mx-auto">
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center p-6 text-center bg-gray-100 rounded dark:bg-gray-700">
                            <i class="text-3xl text-gray-400 fas fa-image"></i>
                            <span class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Statistik Stok -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Statistik Stok</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 text-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-300">Total Masuk</p>
                            <p class="mt-1 text-xl font-bold text-blue-700 dark:text-blue-200">
                                {{ $product->stockTransactions->where('type', 'Masuk')->sum('quantity') }}
                            </p>
                        </div>
                        <div class="p-4 text-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-300">Total Keluar</p>
                            <p class="mt-1 text-xl font-bold text-purple-700 dark:text-purple-200">
                                {{ $product->stockTransactions->where('type', 'Keluar')->sum('quantity') }}
                            </p>
                        </div>
                    </div>
                    <div class="p-4 mt-4 text-center rounded-lg bg-green-50 dark:bg-green-900/30">
                        <p class="text-sm font-medium text-green-600 dark:text-green-300">Stok Saat Ini</p>
                        <p class="mt-1 text-2xl font-bold text-green-700 dark:text-green-200">
                            {{ $product->current_stock }} {{ $product->unit }}
                        </p>
                    </div>
                    
                    <!-- Status Stok Detail -->
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Status Stok:</span>
                            <span class="font-medium {{ $product->stock_status == 'out_of_stock' ? 'text-red-600 dark:text-red-400' : ($product->stock_status == 'low_stock' ? 'text-yellow-600 dark:text-yellow-400' : ($product->stock_status == 'max_stock' ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400')) }}">
                                {{ $product->getStockStatusLabel() }}
                            </span>
                        </div>
                        @if($product->max_stock)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Kapasitas:</span>
                            <span class="font-medium text-blue-600 dark:text-blue-400">
                                {{ $product->stock_percentage }}%
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Ringkasan Harga -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Ringkasan Harga</h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Harga Beli:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->formatted_purchase_price }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Harga Jual:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->formatted_selling_price }}</span>
                    </div>
                    @if($product->has_discount)
                    <div class="flex justify-between">
                        <span class="text-sm text-red-500 dark:text-red-400">Harga Diskon:</span>
                        <span class="text-sm font-medium text-red-600 dark:text-red-300">{{ $product->formatted_discount_price }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-red-500 dark:text-red-400">Diskon:</span>
                        <span class="text-sm font-medium text-red-600 dark:text-red-300">-{{ $product->discount_percentage }}%</span>
                    </div>
                    @endif
                    <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Keuntungan:</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                {{ $product->getFormattedMarginAmount() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Aksi -->
            <div class="overflow-hidden bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Aksi</h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="mr-2 fas fa-edit"></i> Edit Produk
                        </a>

                        <a href="{{ route('admin.products.confirm-delete', $product->id) }}"
                           class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="mr-2 fas fa-trash"></i> Hapus Produk
                        </a>

                        <a href="{{ route('admin.products.index') }}"
                           class="flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                            <i class="mr-2 fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection