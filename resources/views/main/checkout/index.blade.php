@extends('layouts.theme')

@section('title', $pageTitle ?? 'Checkout - Glorious Computer')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-dark to-dark-lighter pt-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-heading font-bold text-white mb-8">
            <i class="fas fa-check-circle text-primary mr-2"></i> Checkout
        </h1>

        <form action="{{ route('checkout.send-whatsapp') }}" method="POST" class="space-y-6">
            @csrf
            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
                <h2 class="text-lg font-bold text-white mb-4">Data Pemesan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Nama</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" class="w-full px-4 py-3 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary" required>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">No. WhatsApp</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? $user->whatsapp ?? '') }}" class="w-full px-4 py-3 rounded-lg bg-dark border border-gray-700 text-white focus:border-primary focus:ring-1 focus:ring-primary" placeholder="08xxx atau 62xxx" required>
                    </div>
                </div>
            </div>

            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
                <h2 class="text-lg font-bold text-white mb-4">Daftar Pesanan</h2>
                <ul class="space-y-3">
                    @foreach($cartItems as $item)
                        @if($item->product)
                            @php
                                $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                                $subtotal = $price * $item->quantity;
                            @endphp
                            <li class="flex justify-between items-center text-gray-300">
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="mt-4 pt-4 border-t border-gray-800 flex justify-between text-xl font-bold text-white">
                    <span>Total</span>
                    <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <p class="text-gray-400 text-sm">
                Klik tombol di bawah untuk mengirim pesanan ke WhatsApp Admin. Admin akan memproses dan mengonfirmasi pesanan Anda.
            </p>
            <button type="submit" class="w-full md:w-auto btn-primary text-white py-3 px-8 rounded-xl font-semibold inline-flex items-center justify-center">
                <i class="fab fa-whatsapp text-xl mr-2"></i> Kirim Pesanan ke WhatsApp
            </button>
            <a href="{{ route('cart.index') }}" class="ml-4 text-gray-400 hover:text-white">Kembali ke Keranjang</a>
        </form>
    </div>
</div>
@endsection
