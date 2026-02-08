@extends('layouts.theme')

@section('title', $pageTitle ?? 'Keranjang - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-6">
            <i class="fas fa-shopping-cart text-primary mr-2"></i> Keranjang Belanja
        </h1>

        @if(session('error'))
            <x-alert type="error" class="mb-6" dismissible>{{ session('error') }}</x-alert>
        @endif
        @if(session('success'))
            <x-alert type="success" class="mb-6" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if($cartItems->isEmpty())
            <div class="text-center py-16 bg-gray-800/50 rounded-2xl border border-gray-700">
                <i class="fas fa-shopping-cart text-5xl text-gray-600 mb-4"></i>
                <h2 class="text-xl font-bold text-white mb-2">Keranjang kosong</h2>
                <p class="text-gray-400 mb-6">Tambahkan produk dari halaman produk.</p>
                <a href="{{ route('main.products.index') }}" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    <i class="fas fa-boxes mr-2"></i> Lihat Produk
                </a>
            </div>
        @else
            <form action="{{ route('order.create-and-whatsapp') }}" method="POST" id="cart-checkout-form">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-center gap-2 text-gray-400 text-sm mb-4">
                            <input type="checkbox" id="select-all" class="rounded border-gray-600 bg-dark text-primary focus:ring-primary">
                            <label for="select-all">Pilih semua untuk checkout</label>
                        </div>
                        @foreach($cartItems as $item)
                            @if($item->product)
                                @php
                                    $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                                    $subtotal = $price * $item->quantity;
                                    $imgUrl = $item->product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->product->image)
                                        ? asset('storage/' . $item->product->image) : null;
                                @endphp
                                <div class="bg-gray-800/50 rounded-xl border border-gray-700 p-4 flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <input type="checkbox" name="cart_ids[]" value="{{ $item->id }}" class="cart-checkbox rounded border-gray-600 bg-dark text-primary focus:ring-primary flex-shrink-0" data-unit-price="{{ $price }}">
                                        @if($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <div class="w-20 h-20 rounded-lg bg-gray-700 flex items-center justify-center flex-shrink-0"><i class="fas fa-laptop text-gray-500"></i></div>
                                        @endif
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-white truncate">{{ $item->product->name }}</h3>
                                            <p class="text-primary font-medium">Rp {{ number_format($price, 0, ',', '.') }}</p>
                                            <p class="text-gray-400 text-sm mt-1 subtotal-display">Subtotal: Rp <span class="subtotal-value">{{ number_format($subtotal, 0, ',', '.') }}</span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <div class="inline-flex items-center gap-1 qty-form" data-cart-id="{{ $item->id }}" data-update-url="{{ route('cart.update', $item) }}" data-csrf="{{ csrf_token() }}">
                                            <button type="button" class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-bold flex items-center justify-center qty-minus">−</button>
                                            <input type="number" value="{{ $item->quantity }}" min="1" max="99" class="w-14 px-2 py-1.5 rounded-lg bg-dark border border-gray-700 text-white text-center text-sm qty-input" data-unit-price="{{ $price }}">
                                            <button type="button" class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-bold flex items-center justify-center qty-plus">+</button>
                                            <button type="button" class="p-2 text-gray-400 hover:text-primary qty-sync" title="Update"><i class="fas fa-sync-alt text-sm"></i></button>
                                        </div>
                                        <button type="submit" form="cart-delete-{{ $item->id }}" class="p-2 text-gray-400 hover:text-red-500" title="Hapus" onclick="return confirm('Hapus dari keranjang?');"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800/50 rounded-xl border border-gray-700 p-6 sticky top-24">
                            <h3 class="text-lg font-bold text-white mb-4">Ringkasan</h3>
                            <p class="text-gray-400 text-sm mb-2">Total hanya dari item yang dicentang.</p>
                            <div class="flex justify-between text-gray-400 mb-2">
                                <span>Item dipilih</span>
                                <span class="text-white" id="selected-count">0</span>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-white mt-4 pt-4 border-t border-gray-700">
                                <span>Total</span>
                                <span class="text-primary" id="cart-total-sum">Rp 0</span>
                            </div>
                            <button type="submit" id="btn-checkout-wa" class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                            </button>
                            <a href="{{ route('main.products.index') }}" class="mt-3 w-full bg-gray-700 hover:bg-gray-600 text-gray-200 py-3 rounded-xl font-medium flex items-center justify-center">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            @foreach($cartItems as $item)
                <form id="cart-delete-{{ $item->id }}" action="{{ route('cart.destroy', $item) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')
<script>
(function() {
    const form = document.getElementById('cart-checkout-form');
    if (!form) return;
    const checkboxes = form.querySelectorAll('.cart-checkbox');
    const totalEl = document.getElementById('cart-total-sum');
    const countEl = document.getElementById('selected-count');
    const btnCheckout = document.getElementById('btn-checkout-wa');
    const selectAll = document.getElementById('select-all');

    function formatRp(n) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    }

    function updateTotal() {
        let total = 0;
        let count = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const row = cb.closest('.bg-gray-800\\/50');
                const qtyInput = row ? row.querySelector('.qty-input') : null;
                const qty = qtyInput ? Math.max(1, parseInt(qtyInput.value, 10) || 1) : 1;
                const unitPrice = parseInt(cb.dataset.unitPrice, 10) || 0;
                total += unitPrice * qty;
                count++;
            }
        });
        if (totalEl) totalEl.textContent = formatRp(total);
        if (countEl) countEl.textContent = count;
        if (btnCheckout) btnCheckout.disabled = count === 0;
        if (selectAll) selectAll.checked = count === checkboxes.length && checkboxes.length > 0;
    }

    form.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const row = this.closest('.bg-gray-800\\/50');
            const unitPrice = parseInt(this.dataset.unitPrice, 10) || 0;
            const qty = Math.max(1, Math.min(99, parseInt(this.value, 10) || 1));
            const sub = row ? row.querySelector('.subtotal-value') : null;
            if (sub) sub.textContent = new Intl.NumberFormat('id-ID').format(unitPrice * qty);
            updateTotal();
        });
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => { cb.checked = selectAll.checked; });
            updateTotal();
        });
    }

    form.addEventListener('submit', function(e) {
        const checked = form.querySelectorAll('.cart-checkbox:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu item untuk checkout.');
            return false;
        }
    });

    form.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.qty-form').querySelector('.qty-input');
            const v = Math.max(1, parseInt(input.value, 10) - 1);
            input.value = v;
        });
    });
    form.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.closest('.qty-form').querySelector('.qty-input');
            const v = Math.min(99, parseInt(input.value, 10) + 1);
            input.value = v;
        });
    });

    document.querySelectorAll('.qty-sync').forEach(btn => {
        btn.addEventListener('click', function() {
            const wrap = this.closest('.qty-form');
            const url = wrap.dataset.updateUrl;
            const input = wrap.querySelector('.qty-input');
            const qty = Math.max(1, Math.min(99, parseInt(input.value, 10) || 1));
            const token = wrap.dataset.csrf;
            const body = new URLSearchParams({ _token: token, _method: 'PUT', quantity: qty });
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: body.toString()
            }).then(function(r) {
                if (r.ok || r.redirected) window.location.reload();
            });
        });
    });
})();
</script>
@endpush
@endsection
