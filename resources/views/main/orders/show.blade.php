@extends('layouts.theme')

@section('title', 'Detail Pesanan ' . $order->order_number . ' - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pesanan Saya
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Pesanan {{ $order->order_number }}</h1>
        <p class="text-gray-400 mb-8">{{ $order->updated_at->format('d M Y, H:i') }} • 
            <span class="
                @if($order->status === 'confirmed') text-blue-400
                @elseif($order->status === 'processed') text-green-400
                @else text-gray-400 @endif">
                {{ ucfirst($order->status) }}
            </span>
        </p>

        <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6 mb-6">
            <h2 class="text-lg font-semibold text-white mb-4">Item Pesanan</h2>
            <ul class="space-y-3">
                @foreach($order->items as $item)
                    <li class="flex justify-between py-2 border-b border-gray-800 last:border-0">
                        <span class="text-gray-300">{{ $item->product_name }} x{{ $item->qty }}</span>
                        <span class="text-white">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <hr class="border-gray-700 my-4">
            <p class="flex justify-between text-lg font-bold text-white">
                <span>Total</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </p>
        </div>

        <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
            <h2 class="text-lg font-semibold text-white mb-2">Info Pemesan</h2>
            <p class="text-gray-400">Nama: {{ $order->customer_name }}</p>
            <p class="text-gray-400">WhatsApp: {{ $order->customer_whatsapp }}</p>
            @if($order->notes)
                <p class="text-gray-400 mt-2">Catatan: {{ $order->notes }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
