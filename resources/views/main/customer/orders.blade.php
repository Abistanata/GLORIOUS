@extends('layouts.theme')

@section('title', $pageTitle ?? 'Pesanan Saya - Glorious Computer')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-dark to-dark-lighter pt-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-heading font-bold text-white mb-8">
            <i class="fas fa-shopping-bag text-primary mr-2"></i> Pesanan Saya
        </h1>
        <p class="text-gray-400 mb-8">Hanya pesanan yang sudah dikonfirmasi admin yang ditampilkan di sini.</p>

        @if($orders->isEmpty())
            <div class="text-center py-16 bg-dark-lighter rounded-2xl border-2 border-dashed border-gray-800">
                <i class="fas fa-clipboard-list text-6xl text-gray-600 mb-4"></i>
                <h2 class="text-xl font-bold text-white mb-2">Belum ada pesanan dikonfirmasi</h2>
                <p class="text-gray-400 mb-6">Setelah Anda checkout via WhatsApp dan admin mengonfirmasi, pesanan akan muncul di sini.</p>
                <a href="{{ route('main.products.index') }}" class="btn-primary text-white px-6 py-3 rounded-xl font-semibold inline-flex items-center">
                    <i class="fas fa-boxes mr-2"></i> Belanja Produk
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-dark-lighter rounded-xl border border-gray-800 overflow-hidden">
                        <div class="p-4 border-b border-gray-800 flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <span class="text-gray-400">No. Pesanan</span>
                                <span class="text-white font-mono ml-2">{{ $order->order_number ?? '#' . $order->id }}</span>
                            </div>
                            <div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($order->status === 'confirmed') bg-blue-500/20 text-blue-400
                                    @elseif($order->status === 'processed') bg-green-500/20 text-green-400
                                    @else bg-gray-500/20 text-gray-400
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="text-gray-400 text-sm">
                                Dikonfirmasi: {{ $order->confirmed_at ? $order->confirmed_at->format('d M Y H:i') : '-' }}
                            </div>
                        </div>
                        <ul class="p-4 space-y-2">
                            @foreach($order->items as $oi)
                                <li class="flex justify-between text-gray-300">
                                    <span>{{ $oi->product->name ?? 'Produk' }} x {{ $oi->quantity }}</span>
                                    <span>Rp {{ number_format($oi->subtotal, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-4 bg-dark/50 flex justify-between items-center">
                            <span class="text-gray-400">Total</span>
                            <span class="text-xl font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
