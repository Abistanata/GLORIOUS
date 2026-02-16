@extends('layouts.dashboard')

@section('title', 'Detail Customer')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Customer</h1>
            <p class="text-gray-600 dark:text-gray-400">Informasi lengkap dan riwayat pesanan customer.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.customers.edit', $customer) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus customer ini? Semua data terkait mungkin ikut terhapus.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Customer</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Nama</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $customer->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $customer->email ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Telepon</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $customer->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Alamat</dt>
                        <dd class="text-gray-900 dark:text-gray-100 whitespace-pre-line">
                            {{ $customer->address ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Tanggal Bergabung</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            {{ optional($customer->created_at)->format('d M Y H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pesanan</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Total pesanan: {{ $orders->total() }}
                    </span>
                </div>

                @if ($orders->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan untuk customer ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Nomor Pesanan
                                    </th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Status Pesanan
                                    </th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Status Pengiriman
                                    </th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Total
                                    </th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Tanggal
                                    </th>
                                    <th class="px-4 py-2 text-right font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider text-xs">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                                            {{ $order->order_number ?? '#' . $order->id }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                            {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                                            {{ $order->shipping_status ? strtoupper(str_replace('_', ' ', $order->shipping_status)) : '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100 font-semibold">
                                            Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                                            {{ optional($order->created_at)->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

