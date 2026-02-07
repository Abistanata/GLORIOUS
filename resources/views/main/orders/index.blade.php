@extends('layouts.theme')

@section('title', 'Pesanan Saya - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-8">
            <i class="fas fa-clipboard-list text-primary mr-2"></i> Pesanan Saya
        </h1>

        @if(session('info'))
            <div class="mb-4 p-4 bg-blue-500/20 border border-blue-500/50 rounded-lg text-blue-300">{{ session('info') }}</div>
        @endif

        <p class="text-gray-400 mb-6">Berikut pesanan yang sudah dikonfirmasi oleh admin.</p>

        @if($orders->isEmpty())
            <div class="bg-dark-lighter rounded-xl border border-gray-800 p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-600 mb-4"></i>
                <p class="text-xl text-gray-400">Belum ada pesanan yang dikonfirmasi.</p>
                <p class="text-gray-500 mt-2">Setelah Anda checkout via WhatsApp dan admin mengonfirmasi, pesanan akan muncul di sini.</p>
                <a href="{{ route('main.products.index') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                    Lihat Produk
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-dark-lighter rounded-xl border border-gray-800 p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4">
                            <div>
                                <p class="font-mono text-primary">{{ $order->order_number }}</p>
                                <p class="text-gray-400 text-sm mt-1">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm
                                    @if($order->status === 'confirmed') bg-blue-500/20 text-blue-300
                                    @elseif($order->status === 'processed') bg-green-500/20 text-green-300
                                    @else bg-gray-500/20 text-gray-400 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                <a href="{{ route('customer.orders.show', $order) }}" class="text-primary hover:underline text-sm mt-1 inline-block">Detail</a>
                            </div>
                        </div>
                        <ul class="mt-4 pt-4 border-t border-gray-800 text-gray-400 text-sm">
                            @foreach($order->items->take(3) as $oi)
                                <li>{{ $oi->product_name }} x{{ $oi->qty }}</li>
                            @endforeach
                            @if($order->items->count() > 3)
                                <li>+ {{ $order->items->count() - 3 }} item lainnya</li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection
