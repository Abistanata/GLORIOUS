@extends('layouts.theme')

@section('title', $pageTitle ?? 'Pesanan Saya - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
            <i class="fas fa-shopping-bag text-primary mr-2"></i> Pesanan Saya
        </h1>
        <p class="text-gray-400 mb-8">Riwayat dan status pesanan Anda.</p>

        @if(session('success'))
            <x-alert type="success" title="Berhasil" class="mb-6" dismissible>{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error" title="Error" class="mb-6" dismissible>{{ session('error') }}</x-alert>
        @endif

        @if($orders->isEmpty())
            <div class="text-center py-16 bg-dark-lighter rounded-2xl border border-gray-800">
                <i class="fas fa-clipboard-list text-5xl text-gray-600 mb-4"></i>
                <h2 class="text-xl font-bold text-white mb-2">Belum ada pesanan</h2>
                <p class="text-gray-400 mb-6">Pesanan Anda akan muncul di sini setelah Anda memesan via WhatsApp.</p>
                <a href="{{ route('main.products.index') }}" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    <i class="fas fa-boxes mr-2"></i> Belanja Produk
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-gray-800/50 rounded-xl border border-gray-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-700 flex flex-wrap justify-between items-center gap-2">
                            <div>
                                <span class="text-gray-400 text-sm">No. Pesanan</span>
                                <span class="text-white font-mono ml-2">{{ $order->order_number ?? '#' . $order->id }}</span>
                            </div>
                            <x-status-badge :status="$order->status" />
                            <div class="text-gray-400 text-sm">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                        <ul class="p-4 space-y-2">
                            @foreach($order->items as $oi)
                                <li class="flex justify-between text-gray-300 text-sm">
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
            @if($orders->hasPages())
                <div class="mt-6">{{ $orders->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
