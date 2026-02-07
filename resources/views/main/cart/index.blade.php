@extends('layouts.theme')

@section('title', 'Keranjang - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-8">
            <i class="fas fa-shopping-cart text-primary mr-2"></i> Keranjang Belanja
        </h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-300">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300">{{ session('error') }}</div>
        @endif

        @if($items->isEmpty())
            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-12 text-center">
                <i class="fas fa-shopping-cart text-6xl text-gray-600 mb-4"></i>
                <p class="text-xl text-gray-400 mb-6">Keranjang Anda kosong.</p>
                <a href="{{ route('main.products.index') }}" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Belanja Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        <div class="bg-dark-lighter rounded-xl border border-gray-800 p-4 flex flex-wrap gap-4 items-center">
                            @php
                                $img = $item->product->image;
                                $imgUrl = $img && \Storage::disk('public')->exists($img) ? asset('storage/'.$img) : null;
                            @endphp
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-700 rounded-lg flex items-center justify-center"><i class="fas fa-box text-gray-500"></i></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('main.products.show', $item->product_id) }}" class="font-medium text-white hover:text-primary truncate block">{{ $item->product->name }}</a>
                                <p class="text-gray-400 text-sm">Rp {{ number_format($item->product->discount_price > 0 ? $item->product->discount_price : $item->product->selling_price, 0, ',', '.') }} / pcs</p>
                            </div>
                            <form action="{{ route('main.cart.update', $item->product_id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->current_stock ?? 999 }}" class="w-16 bg-dark border border-gray-700 rounded-lg text-white text-center py-1">
                                <button type="submit" class="px-3 py-1 bg-primary/20 text-primary rounded-lg hover:bg-primary/30 text-sm">Update</button>
                            </form>
                            <p class="text-white font-medium">Rp {{ number_format(($item->product->discount_price > 0 ? $item->product->discount_price : $item->product->selling_price) * $item->qty, 0, ',', '.') }}</p>
                            <form action="{{ route('main.cart.remove', $item->product_id) }}" method="POST" onsubmit="return confirm('Hapus dari keranjang?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6 sticky top-24">
                        <h2 class="text-lg font-semibold text-white mb-4">Ringkasan</h2>
                        <p class="flex justify-between text-gray-400 mb-2"><span>Subtotal</span><span class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        <hr class="border-gray-700 my-4">
                        <p class="flex justify-between text-lg font-bold text-white mb-6"><span>Total</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></p>
                        <a href="{{ route('main.checkout.index') }}" class="block w-full py-3 bg-primary hover:bg-primary-dark text-white text-center font-medium rounded-xl transition-colors">
                            Checkout
                        </a>
                        <a href="{{ route('main.products.index') }}" class="block w-full py-2 text-center text-gray-400 hover:text-white mt-3">Lanjut Belanja</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
