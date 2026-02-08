@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.orders.index') }}" class="hover:text-blue-600">Pesanan</a>
            <span>/</span>
            <span>Detail</span>
        </div>
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Pesanan</h1>
                <p class="text-gray-600 dark:text-gray-400">No. {{ $order->order_number ?? '#' . $order->id }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-shopping-bag mr-2"></i>Item Pesanan
                </h2>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $item->product->name ?? 'Produk #' . $item->product_id }}</span>
                                <span class="text-gray-500 dark:text-gray-400 text-sm"> x {{ $item->quantity }}</span>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                    <span>Total</span>
                    <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-user mr-2"></i>Data Pemesan
                </h2>
                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Nama</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $order->customer_name ?? $order->user->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Telepon / WhatsApp</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $order->customer_phone ?? $order->user->phone ?? '-' }}</dd>
                    </div>
                    @if($order->user)
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Username</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $order->user->username }}</dd>
                        </div>
                        @if($order->user->address)
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Alamat</dt>
                                <dd class="text-gray-900 dark:text-white">{{ $order->user->address }}</dd>
                            </div>
                        @endif
                    @endif
                    @if($order->notes)
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Catatan</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $order->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-flag mr-2"></i>Status
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap items-center gap-3">
                        <select name="status" class="flex-1 min-w-[140px] px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="processed" {{ $order->status === 'processed' ? 'selected' : '' }}>Diproses</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </div>
                </form>
                @if($order->confirmed_at)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Dikonfirmasi: {{ $order->confirmed_at->format('d M Y H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
