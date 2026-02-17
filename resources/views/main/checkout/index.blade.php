@extends('layouts.theme')

@section('title', 'Checkout - Glorious Computer')

@section('content')
<div class="min-h-screen bg-dark-800 pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primary-500/10 rounded-full mb-4 border border-primary-500/20">
                <i class="fas fa-check-circle text-3xl text-primary-400"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-3">
                Checkout Pesanan
            </h1>
            <p class="text-gray-400">Lengkapi data untuk menyelesaikan pesanan Anda</p>
        </div>

        <form action="{{ route('order.create-and-whatsapp') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Customer Data Card -->
            <div class="bg-dark-700 rounded-2xl border border-dark-500 p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-dark-500">
                    <div class="w-10 h-10 bg-primary-500/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-primary-400"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Data Pemesan</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2 font-medium">
                            Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               name="customer_name" 
                               value="{{ old('customer_name', $user->name) }}" 
                               class="w-full px-4 py-3.5 rounded-xl bg-dark-800 border border-dark-500 text-white placeholder-gray-600 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" 
                               placeholder="John Doe"
                               required>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2 font-medium">
                            No. WhatsApp <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fab fa-whatsapp text-green-400"></i>
                            </div>
                            <input type="text" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone', $user->phone ?? $user->whatsapp ?? '') }}" 
                                   class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-dark-800 border border-dark-500 text-white placeholder-gray-600 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all" 
                                   placeholder="08xx xxxx xxxx atau 62xxx"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Nomor yang terdaftar di WhatsApp
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="bg-dark-700 rounded-2xl border border-dark-500 p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-dark-500">
                    <div class="w-10 h-10 bg-primary-500/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-primary-400"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Ringkasan Pesanan</h2>
                </div>
                
                <div class="space-y-4 mb-6">
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $item)
                        @if($item->product)
                            @php
                                $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                                $subtotal = $price * $item->quantity;
                                $grandTotal += $subtotal;
                            @endphp
                            <div class="flex items-center justify-between py-3 border-b border-dark-600 last:border-0">
                                <div class="flex items-center gap-4 flex-1">
                                    <!-- Product Image Thumbnail -->
                                    @if($item->product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->product->image))
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-16 h-16 object-cover rounded-lg bg-dark-900">
                                    @else
                                        <div class="w-16 h-16 bg-dark-900 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-laptop text-gray-700"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-white truncate">{{ $item->product->name }}</h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-sm text-gray-500">
                                                Qty: <span class="text-white font-medium">{{ $item->quantity }}</span>
                                            </span>
                                            <span class="text-sm text-gray-500">×</span>
                                            <span class="text-sm text-gray-400">
                                                Rp {{ number_format($price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-bold text-white">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Total Section -->
                <div class="pt-6 border-t-2 border-dark-500">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white font-semibold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-400 flex items-center gap-2">
                            Biaya Pengiriman
                            <span class="text-xs text-gray-600">(akan dikonfirmasi)</span>
                        </span>
                        <span class="text-gray-500 italic">-</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-dark-600">
                        <span class="text-xl font-bold text-white">Total Pembayaran</span>
                        <span class="text-3xl font-bold gradient-text">
                            Rp {{ number_format($total ?? $grandTotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info & Actions Card -->
            <div class="bg-gradient-to-br from-primary-500/10 to-primary-600/5 rounded-2xl border border-primary-500/20 p-8">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-primary-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-primary-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white mb-2">Cara Pemesanan</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Setelah klik tombol di bawah, pesanan Anda akan otomatis dikirim ke WhatsApp admin kami. 
                            Admin akan segera memproses dan mengonfirmasi pesanan, termasuk informasi pembayaran dan pengiriman.
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white overflow-hidden rounded-xl transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                        <span class="absolute inset-0 bg-gradient-to-r from-green-600 via-green-500 to-green-600 bg-[length:200%_100%] transition-all duration-300 group-hover:bg-[length:100%_100%]"></span>
                        <span class="relative flex items-center gap-3">
                            <i class="fab fa-whatsapp text-2xl"></i>
                            <span class="text-lg">Kirim Pesanan ke WhatsApp</span>
                        </span>
                    </button>
                    
                    <a href="{{ route('cart.index') }}" 
                       class="px-6 py-4 bg-dark-700 hover:bg-dark-600 border border-dark-500 hover:border-primary-500/50 text-white rounded-xl font-semibold inline-flex items-center justify-center transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
input:focus {
    outline: none;
}

button[type="submit"]:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endpush