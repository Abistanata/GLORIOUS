@extends('layouts.theme')

@section('title', $pageTitle ?? 'Keranjang - Glorious Computer')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-dark to-dark-lighter pt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-heading font-bold text-white mb-8">
            <i class="fas fa-shopping-cart text-primary mr-2"></i> Keranjang Belanja
        </h1>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="text-center py-16 bg-dark-lighter rounded-2xl border-2 border-dashed border-gray-800">
                <i class="fas fa-shopping-cart text-6xl text-gray-600 mb-4"></i>
                <h2 class="text-xl font-bold text-white mb-2">Keranjang kosong</h2>
                <p class="text-gray-400 mb-6">Tambahkan produk dari halaman produk.</p>
                <a href="{{ route('main.products.index') }}" class="btn-primary text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center">
                    <i class="fas fa-boxes mr-2"></i> Lihat Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        @if($item->product)
                            @php
                                $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                                $subtotal = $price * $item->quantity;
                            @endphp
                            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-4 flex flex-col sm:flex-row gap-4">
                                <div class="flex-shrink-0 w-full sm:w-24 h-24 rounded-lg overflow-hidden bg-dark">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-white truncate">{{ $item->product->name }}</h3>
                                    <p class="text-gray-400 text-sm">Rp {{ number_format($price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                    <p class="text-primary font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-flex items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-16 px-2 py-1 rounded bg-dark border border-gray-700 text-white text-center text-sm">
                                        <button type="submit" class="p-2 text-gray-400 hover:text-primary" title="Update"><i class="fas fa-sync-alt"></i></button>
                                    </form>
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dari keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>
                        <div class="flex justify-between text-gray-400 mb-2">
                            <span>Total Item</span>
                            <span class="text-white">{{ $cartItems->sum('quantity') }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-white mt-4 pt-4 border-t border-gray-800">
                            <span>Total</span>
                            <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="mt-6 w-full btn-primary text-white py-3 rounded-xl font-semibold flex items-center justify-center">
                            <i class="fas fa-arrow-right mr-2"></i> Checkout
                        </a>
                        <a href="{{ route('main.products.index') }}" class="mt-3 w-full bg-dark-light hover:bg-gray-800 text-gray-300 py-3 rounded-xl font-medium flex items-center justify-center">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
