@extends('layouts.theme')

@section('title', 'Katalog Produk - Glorious Computer')

@section('content')
<div class="min-h-screen bg-darker pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── HERO HEADER ──────────────────────────────────── --}}
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-primary/10 border border-primary/20 mx-auto mb-6">
                <i class="fas fa-box-open text-3xl text-primary"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">
                Katalog <span class="text-primary">Produk</span>
            </h1>
            <div class="h-1 w-24 rounded-full bg-gradient-to-r from-transparent via-primary to-transparent mx-auto mb-5"></div>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Temukan perangkat teknologi berkualitas dengan harga kompetitif
            </p>
        </div>

        {{-- ── FILTER SECTION ───────────────────────────────── --}}
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h3 class="text-base font-semibold text-white">Filter Produk</h3>

                <div class="flex flex-wrap gap-2">
                    @php $currentCategoryId = request('category_id'); @endphp

                    <a href="{{ route('main.products.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border transition-all duration-200
                              {{ !$currentCategoryId
                                    ? 'bg-primary border-primary text-white shadow-lg shadow-primary/30'
                                    : 'bg-gray-800/60 border-gray-700 text-gray-300 hover:border-primary/50 hover:text-white' }}">
                        <i class="fas fa-th-large text-xs"></i>
                        <span>Semua</span>
                    </a>

                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories->take(5) as $category)
                            <a href="{{ route('main.products.index', ['category_id' => $category->id]) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border transition-all duration-200
                                      {{ $currentCategoryId == $category->id
                                            ? 'bg-primary border-primary text-white shadow-lg shadow-primary/30'
                                            : 'bg-gray-800/60 border-gray-700 text-gray-300 hover:border-primary/50 hover:text-white' }}">
                                <i class="fas {{ $currentCategoryId == $category->id ? 'fa-folder-open' : 'fa-folder' }} text-xs"></i>
                                <span>{{ $category->name }}</span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="bg-gray-800/50 rounded-2xl p-5 border border-gray-700/80">
                <form method="GET" class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-500"></i>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk..."
                               class="w-full pl-11 pr-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500
                                      focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm transition-all">
                    </div>

                    <div class="w-full md:w-48">
                        <select name="category_id"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white
                                       focus:outline-none focus:border-primary text-sm cursor-pointer transition-all">
                            <option value="">Semua Kategori</option>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="w-full md:w-48">
                        <select name="sort"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white
                                       focus:outline-none focus:border-primary text-sm cursor-pointer transition-all">
                            <option value="name_asc"   {{ request('sort') == 'name_asc'   ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="name_desc"  {{ request('sort') == 'name_desc'  ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl
                                       transition-all duration-200 text-sm flex items-center gap-2 shadow-lg shadow-primary/20">
                            <i class="fas fa-filter"></i>
                            <span class="hidden sm:inline">Filter</span>
                        </button>
                        <a href="{{ route('main.products.index') }}"
                           class="px-4 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-xl
                                  transition-all duration-200 text-sm flex items-center gap-2 border border-gray-600">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── PRODUCTS COUNTER ─────────────────────────────── --}}
        @if(isset($products) && $products->count() > 0)
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">
                        <span class="text-primary font-bold">{{ $products->total() }}</span> Produk Ditemukan
                    </h2>
                </div>
            </div>
        @endif

        {{-- ── PRODUCTS GRID ────────────────────────────────── --}}
        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-12">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="mb-12">
                    <div class="bg-gray-800/50 rounded-2xl p-4 border border-gray-700">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif

        @else
            <div class="text-center py-20 bg-gray-800/30 rounded-2xl border border-gray-700/50 mb-12">
                <div class="w-24 h-24 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-6 border border-primary/20">
                    <i class="fas fa-box-open text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Produk Tidak Ditemukan</h3>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    Tidak ada produk yang sesuai dengan filter pencarian Anda.
                </p>
                <a href="{{ route('main.products.index') }}"
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 shadow-lg shadow-primary/20">
                    <i class="fas fa-redo"></i>
                    Tampilkan Semua Produk
                </a>
            </div>
        @endif

        {{-- ── CTA BANNER ───────────────────────────────────── --}}
        <div class="mb-16">
            <div class="relative overflow-hidden bg-gradient-to-r from-primary/10 via-primary/5 to-primary/10 border border-primary/20 rounded-2xl p-8 text-center">
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative">
                    <h2 class="text-xl font-semibold text-white mb-3">Butuh Bantuan Memilih?</h2>
                    <p class="text-gray-300 mb-6 max-w-xl mx-auto">
                        Konsultasikan kebutuhan Anda dengan tim ahli kami
                    </p>
                    <a href="https://wa.me/6282133803940"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5">
                        <i class="fab fa-whatsapp text-lg"></i>
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── QUICK VIEW MODAL — UI diperbarui, JS TIDAK DIUBAH ── --}}
<div id="quickViewModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" aria-hidden="true"></div>
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl border border-gray-700 ring-1 ring-primary/10">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <div class="flex items-center gap-2 text-sm font-semibold text-white">
                        <i class="fas fa-eye text-primary"></i>
                        Quick View
                    </div>
                    <button type="button"
                            onclick="closeQuickView()"
                            class="w-8 h-8 rounded-lg bg-gray-800 hover:bg-red-500/20 border border-gray-700 hover:border-red-500/50
                                   text-gray-400 hover:text-red-400 flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div id="quickViewContent" class="p-6">
                    {{-- Content dimuat via JavaScript (tidak diubah) --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    * { transition: all 0.2s ease; }
</style>

<script>
    /* ── SEMUA LOGIC JS DI BAWAH INI TIDAK DIUBAH SAMA SEKALI ── */
    function openQuickView(productId) {
        const modal = document.getElementById('quickViewModal');
        const content = document.getElementById('quickViewContent');
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        if (productElement) {
            const productCard = productElement.closest('.bg-gray-800\\/50');
            if (productCard) {
                const productData = extractProductData(productCard);
                content.innerHTML = generateQuickViewHTML(productData);
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
    }

    function extractProductData(productCard) {
        const name = productCard.querySelector('h3')?.textContent?.trim() || 'Produk';
        const category = productCard.querySelector('.text-primary')?.textContent?.trim() || 'Uncategorized';
        const priceText = productCard.querySelector('.text-primary.text-xl')?.textContent?.replace('Rp ', '').replace(/\./g, '') || '0';
        const price = parseInt(priceText) || 0;
        const stockText = productCard.querySelector('.text-xs.text-gray-400 span')?.textContent?.replace('Stok: ', '').split(' ')[0] || '0';
        const stock = parseInt(stockText) || 0;
        const specification = productCard.querySelector('.text-gray-400')?.textContent?.trim() || 'Spesifikasi tidak tersedia';
        return { name, category, price, stock, specification };
    }

    function generateQuickViewHTML(product) {
        return `
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">${product.name}</h2>
                    <div class="text-primary text-sm font-medium">${product.category}</div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-3">Spesifikasi</h3>
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <p class="text-gray-300 whitespace-pre-line">${product.specification}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <div class="text-gray-400 text-sm mb-1">Harga</div>
                        <div class="text-2xl font-bold text-primary">
                            Rp ${new Intl.NumberFormat('id-ID').format(product.price)}
                        </div>
                    </div>
                    <div class="bg-gray-900/50 rounded-lg p-4">
                        <div class="text-gray-400 text-sm mb-1">Stok</div>
                        <div class="text-xl font-bold text-white">${product.stock} unit</div>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-700">
                    <a href="https://wa.me/6282133803940?text=Halo,%20saya%20tertarik%20dengan%20produk:%20${encodeURIComponent(product.name)}%0AHarga: Rp ${new Intl.NumberFormat('id-ID').format(product.price)}%0A%0AMohon info lebih lanjut."
                       target="_blank"
                       class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-3 rounded-lg flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>
        `;
    }

    function closeQuickView() {
        const modal = document.getElementById('quickViewModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.getElementById('quickViewModal').addEventListener('click', function(e) {
        if (e.target === this) closeQuickView();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeQuickView();
    });
</script>
@endsection