@extends('layouts.theme')

@section('title', $pageTitle ?? 'Pesanan Saya - Glorious Computer')

@section('content')
{{-- UI improvement: calm bg, card hierarchy, spacing --}}
<div class="min-h-screen bg-slate-950 pt-24 pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-10">
            <aside class="lg:w-56 flex-shrink-0">
                <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 p-5 sticky top-24 shadow-sm">
                    @include('partials.customer-account-sidebar')
                </div>
            </aside>
            <main class="flex-1 min-w-0">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-1 tracking-tight">
                    <i class="fas fa-shopping-bag text-indigo-400 mr-2"></i> Pesanan Saya
                </h1>
                <p class="text-slate-400 mb-8">Riwayat dan status pesanan Anda.</p>

        @if(session('success'))
            <x-alert type="success" title="Berhasil" class="mb-6" dismissible>{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert type="error" title="Error" class="mb-6" dismissible>{{ session('error') }}</x-alert>
        @endif

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-slate-800/40 rounded-2xl border border-slate-700/50 shadow-sm">
                <i class="fas fa-clipboard-list text-5xl text-slate-500 mb-5"></i>
                <h2 class="text-xl font-bold text-white mb-2">Belum ada pesanan</h2>
                <p class="text-slate-400 mb-8 max-w-sm mx-auto">Pesanan Anda akan muncul di sini setelah Anda memesan via WhatsApp.</p>
                <a href="{{ route('main.products.index') }}" class="inline-flex items-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-sm">
                    <i class="fas fa-boxes mr-2"></i> Belanja Produk
                </a>
            </div>
        @else
            <div class="space-y-5">
                @foreach($orders as $order)
                    <div class="bg-slate-800/40 rounded-2xl border border-slate-700/50 overflow-hidden shadow-sm transition hover:border-slate-600/50">
                        <div class="p-5 border-b border-slate-700/50 flex flex-wrap justify-between items-center gap-3">
                            <div>
                                <span class="text-slate-400 text-xs font-medium uppercase tracking-wider">No. Pesanan</span>
                                <span class="text-white font-mono text-sm block mt-0.5">{{ $order->order_number ?? '#' . $order->id }}</span>
                            </div>
                            <div class="flex flex-col items-end text-right text-xs space-y-1">
                                @php
                                    $statusColors = [
                                        'pending'   => 'bg-amber-500/15 text-amber-300 border-amber-400/40',
                                        'confirmed' => 'bg-sky-500/15 text-sky-300 border-sky-400/40',
                                        'processed' => 'bg-emerald-500/15 text-emerald-300 border-emerald-400/40',
                                        'shipping'  => 'bg-indigo-500/20 text-indigo-200 border-indigo-400/50',
                                        'completed' => 'bg-lime-500/20 text-lime-200 border-lime-400/50',
                                        'cancelled' => 'bg-rose-600/20 text-rose-200 border-rose-500/60',
                                    ];
                                    $statusKey = $order->status ?? 'pending';
                                    $statusClass = $statusColors[$statusKey] ?? $statusColors['pending'];
                                @endphp
                                <div class="flex flex-col items-end space-y-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border text-[10px] font-semibold tracking-[0.12em] uppercase {{ $statusClass }}">
                                        {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                    @if($order->status === 'shipping' && $order->shipping_status)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-[10px] font-semibold tracking-[0.12em] uppercase bg-slate-100/5 text-slate-200 border-slate-500/60">
                                            {{ strtoupper($order->shipping_status) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-slate-400">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                        <ul class="p-5 space-y-2">
                            @foreach($order->items as $oi)
                                <li class="flex justify-between text-slate-300 text-sm">
                                    <span>{{ $oi->product->name ?? 'Produk' }} x {{ $oi->quantity }}</span>
                                    <span class="font-medium">Rp {{ number_format($oi->subtotal, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="px-5 py-4 bg-slate-900/40 flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Total</span>
                            <span class="text-xl font-bold text-indigo-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($orders->hasPages())
                <div class="mt-8">{{ $orders->links() }}</div>
            @endif
        @endif
            </main>
        </div>
    </div>
</div>
@endsection
