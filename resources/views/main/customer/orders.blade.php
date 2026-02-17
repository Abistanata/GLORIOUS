@extends('layouts.theme')

@section('title', 'Pesanan Saya - Glorious Computer')

@section('content')
<div class="min-h-screen bg-[#0f0f0f] pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ── SIDEBAR — tidak diubah ──────────────────── --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6 sticky top-24">
                    @include('partials.customer-account-sidebar')
                </div>
            </aside>

            {{-- ── MAIN ─────────────────────────────────────── --}}
            <main class="flex-1 min-w-0">

                {{-- Header --}}
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center border border-primary/20">
                            <i class="fas fa-shopping-bag text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white">Pesanan Saya</h1>
                            <p class="text-gray-400 text-sm mt-0.5">Riwayat dan status pesanan Anda</p>
                        </div>
                    </div>
                </div>

                {{-- Alerts — logic tidak diubah --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                        <div class="flex items-center gap-3 text-green-400">
                            <i class="fas fa-check-circle text-lg flex-shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
                        <div class="flex items-center gap-3 text-red-400">
                            <i class="fas fa-exclamation-circle text-lg flex-shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Orders — logic tidak diubah --}}
                @if($orders->isEmpty())
                    {{-- Empty State --}}
                    <div class="text-center py-20 bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10">
                        <div class="w-24 h-24 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-6 border border-gray-700">
                            <i class="fas fa-clipboard-list text-5xl text-gray-600"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-3">Belum Ada Pesanan</h2>
                        <p class="text-gray-400 mb-8 max-w-md mx-auto leading-relaxed">
                            Pesanan Anda akan muncul di sini setelah Anda melakukan pemesanan melalui WhatsApp atau sistem checkout kami.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('main.products.index') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-primary hover:bg-primary-dark text-white rounded-xl font-bold transition-all shadow-lg shadow-primary/20 hover:-translate-y-0.5">
                                <i class="fas fa-boxes"></i>
                                Belanja Produk
                            </a>
                            <a href="{{ route('main.services.index') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white rounded-xl font-semibold transition-all">
                                <i class="fas fa-cogs"></i>
                                Lihat Layanan
                            </a>
                        </div>
                    </div>

                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                        @php
                            $statusConfig = [
                                'pending'   => ['color' => 'amber',  'icon' => 'clock',        'label' => 'Menunggu Konfirmasi'],
                                'confirmed' => ['color' => 'sky',    'icon' => 'check-circle', 'label' => 'Dikonfirmasi'],
                                'processed' => ['color' => 'emerald','icon' => 'cog',          'label' => 'Diproses'],
                                'shipping'  => ['color' => 'indigo', 'icon' => 'truck',        'label' => 'Dalam Pengiriman'],
                                'completed' => ['color' => 'lime',   'icon' => 'check-double', 'label' => 'Selesai'],
                                'cancelled' => ['color' => 'rose',   'icon' => 'times-circle', 'label' => 'Dibatalkan'],
                            ];
                            $statusKey = $order->status ?? 'pending';
                            $config    = $statusConfig[$statusKey] ?? $statusConfig['pending'];
                        @endphp

                            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden
                                        hover:border-primary/20 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-primary/5">

                                {{-- Order Header --}}
                                <div class="p-6 border-b border-white/5">
                                    <div class="flex flex-wrap items-center justify-between gap-4">

                                        <div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">No. Pesanan</span>
                                                <span class="px-3 py-1 bg-white/5 text-white font-mono text-sm rounded-lg border border-white/10">
                                                    {{ $order->order_number ?? '#' . $order->id }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500 flex items-center gap-2">
                                                <i class="far fa-calendar text-gray-600"></i>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>

                                        {{-- Status Badges --}}
                                        <div class="flex flex-col items-end gap-2">
                                            <span class="status-badge status-{{ $config['color'] }} inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold border">
                                                <i class="fas fa-{{ $config['icon'] }}"></i>
                                                {{ $config['label'] }}
                                            </span>

                                            @if($order->status === 'shipping' && $order->shipping_status)
                                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold border
                                                             bg-slate-500/10 text-slate-300 border-slate-500/30">
                                                    <i class="fas fa-shipping-fast"></i>
                                                    {{ strtoupper($order->shipping_status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Order Items — loop & logic TIDAK diubah --}}
                                <div class="p-6 space-y-3">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
                                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                                @if($item->product && $item->product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->product->image))
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                         alt="{{ $item->product->name ?? 'Produk' }}"
                                                         class="w-16 h-16 object-cover rounded-xl bg-gray-800 flex-shrink-0">
                                                @else
                                                    <div class="w-16 h-16 bg-gray-800 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <i class="fas fa-laptop text-gray-600"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-semibold text-white mb-1 truncate">
                                                        {{ $item->product->name ?? 'Produk' }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $item->quantity }} × Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <p class="font-bold text-white">
                                                    Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Order Footer — route & condition TIDAK diubah --}}
                                <div class="px-6 py-5 bg-white/3 border-t border-white/5">
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <span class="text-gray-400 text-xs font-medium uppercase tracking-wider block mb-1">Total Pembayaran</span>
                                            <span class="text-2xl font-bold text-primary">
                                                Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex gap-3">
                                            @if(in_array($order->status, ['pending', 'confirmed']))
                                                <a href="https://wa.me/6282133803940?text=Halo, saya ingin menanyakan status pesanan {{ $order->order_number ?? '#' . $order->id }}"
                                                   target="_blank"
                                                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all text-sm shadow-lg shadow-green-900/20">
                                                    <i class="fab fa-whatsapp text-base"></i>
                                                    Hubungi Admin
                                                </a>
                                            @endif
                                            @if($order->status === 'completed')
                                                <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all text-sm shadow-lg shadow-primary/20">
                                                    <i class="fas fa-star"></i>
                                                    Beri Ulasan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination — tidak diubah --}}
                    @if($orders->hasPages())
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @endif

            </main>
        </div>
    </div>
</div>
@endsection

{{-- ── @push('styles') — TIDAK DIUBAH SAMA SEKALI ──────── --}}
@push('styles')
<style>
/* ── Static status badge classes (pengganti dynamic Tailwind) ── */
.status-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; border-width: 1px; border-style: solid; }

.status-amber   { background-color: rgba(245, 158, 11, 0.1);  color: rgb(251, 191, 36);  border-color: rgba(245, 158, 11, 0.3); }
.status-sky     { background-color: rgba(14, 165, 233, 0.1);  color: rgb(56, 189, 248);  border-color: rgba(14, 165, 233, 0.3); }
.status-emerald { background-color: rgba(16, 185, 129, 0.1);  color: rgb(52, 211, 153);  border-color: rgba(16, 185, 129, 0.3); }
.status-indigo  { background-color: rgba(99, 102, 241, 0.1);  color: rgb(129, 140, 248); border-color: rgba(99, 102, 241, 0.3); }
.status-lime    { background-color: rgba(132, 204, 22, 0.1);  color: rgb(163, 230, 53);  border-color: rgba(132, 204, 22, 0.3); }
.status-rose    { background-color: rgba(244, 63, 94, 0.1);   color: rgb(251, 113, 133); border-color: rgba(244, 63, 94, 0.3);  }

/* ── Legacy dynamic class fallbacks (agar tetap kompatibel) ── */
.bg-amber-500\/10  { background-color: rgba(245, 158, 11, 0.1); }
.text-amber-400    { color: rgb(251, 191, 36); }
.border-amber-500\/30 { border-color: rgba(245, 158, 11, 0.3); }

.bg-sky-500\/10    { background-color: rgba(14, 165, 233, 0.1); }
.text-sky-400      { color: rgb(56, 189, 248); }
.border-sky-500\/30   { border-color: rgba(14, 165, 233, 0.3); }

.bg-emerald-500\/10{ background-color: rgba(16, 185, 129, 0.1); }
.text-emerald-400  { color: rgb(52, 211, 153); }
.border-emerald-500\/30 { border-color: rgba(16, 185, 129, 0.3); }

.bg-indigo-500\/10 { background-color: rgba(99, 102, 241, 0.1); }
.text-indigo-400   { color: rgb(129, 140, 248); }
.border-indigo-500\/30 { border-color: rgba(99, 102, 241, 0.3); }

.bg-lime-500\/10   { background-color: rgba(132, 204, 22, 0.1); }
.text-lime-400     { color: rgb(163, 230, 53); }
.border-lime-500\/30  { border-color: rgba(132, 204, 22, 0.3); }

.bg-rose-500\/10   { background-color: rgba(244, 63, 94, 0.1); }
.text-rose-400     { color: rgb(251, 113, 133); }
.border-rose-500\/30  { border-color: rgba(244, 63, 94, 0.3); }

.bg-slate-500\/10  { background-color: rgba(100, 116, 139, 0.1); }
.text-slate-300    { color: rgb(203, 213, 225); }
.border-slate-500\/30 { border-color: rgba(100, 116, 139, 0.3); }
</style>
@endpush