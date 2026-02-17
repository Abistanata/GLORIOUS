{{--
    ════════════════════════════════════════════════════════════
     QUICK VIEW PRODUCT COMPONENT
     File  : resources/views/components/product-quick-view.blade.php
     Cara pakai :
       1. Include file ini di layouts/theme.blade.php sebelum </body>
          @include('components.product-quick-view')

       2. Panggil dari tombol di product card:
          onclick="openQuickView(productId, { name, category, price,
                   originalPrice, discount, stock, image, detailUrl })"
    ════════════════════════════════════════════════════════════
--}}

<div id="quickViewModal"
     class="fixed inset-0 z-[999] hidden"
     role="dialog"
     aria-modal="true">

    {{-- Backdrop --}}
    <div id="qv-backdrop"
         onclick="closeQuickView()"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

    {{-- Panel --}}
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">

            <div id="qv-panel"
                 class="relative w-full max-w-3xl bg-gray-900 rounded-2xl border border-gray-700/80
                        ring-1 ring-white/5 shadow-2xl shadow-black/50
                        transform transition-all duration-300 scale-95 opacity-0">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800/80">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-primary/10 border border-primary/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-primary text-sm"></i>
                        </div>
                        <span class="font-bold text-white text-sm">Quick View Produk</span>
                    </div>
                    <button type="button"
                            onclick="closeQuickView()"
                            aria-label="Tutup"
                            class="w-9 h-9 rounded-xl bg-gray-800 hover:bg-red-500/20 border border-gray-700
                                   hover:border-red-500/40 text-gray-400 hover:text-red-400
                                   flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-6">
                    {{-- Skeleton --}}
                    <div id="qv-skeleton" class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-pulse">
                        <div class="bg-gray-800 rounded-xl aspect-square"></div>
                        <div class="space-y-4 py-2">
                            <div class="h-3 bg-gray-800 rounded w-1/3"></div>
                            <div class="h-7 bg-gray-800 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-800 rounded w-1/2"></div>
                            <div class="h-12 bg-gray-800 rounded w-1/2 mt-2"></div>
                            <div class="space-y-2 mt-4">
                                <div class="h-3 bg-gray-800 rounded w-full"></div>
                                <div class="h-3 bg-gray-800 rounded w-5/6"></div>
                                <div class="h-3 bg-gray-800 rounded w-4/6"></div>
                            </div>
                            <div class="h-12 bg-gray-800 rounded w-full mt-6"></div>
                        </div>
                    </div>

                    {{-- Content area (filled by JS) --}}
                    <div id="qv-body" class="hidden"></div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-800/80 flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-shield-alt text-blue-400/70"></i>
                            Garansi Resmi
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-undo text-green-400/70"></i>
                            Produk Original
                        </span>
                    </div>
                    <button type="button"
                            onclick="closeQuickView()"
                            class="text-xs text-gray-500 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="fas fa-times text-xs"></i>
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
#quickViewModal.qv-open #qv-backdrop { opacity: 1; }
#quickViewModal.qv-open #qv-panel    { opacity: 1; transform: scale(1); }

.qv-line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
(function () {

    /* ── OPEN ─────────────────────────────────────────────── */
    window.openQuickView = function (productId, data) {
        const modal    = document.getElementById('quickViewModal');
        const skeleton = document.getElementById('qv-skeleton');
        const body     = document.getElementById('qv-body');
        if (!modal) return;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        skeleton.classList.remove('hidden');
        body.classList.add('hidden');
        body.innerHTML = '';
        requestAnimationFrame(() => modal.classList.add('qv-open'));

        const resolve = () => {
            if (data && data.name) return data;
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            return card ? scrapeCard(card) : null;
        };

        setTimeout(() => {
            const d = resolve();
            if (d) renderQV(d);
            else {
                skeleton.classList.add('hidden');
                body.innerHTML = '<p class="text-center text-gray-500 py-10 text-sm">Data produk tidak ditemukan.</p>';
                body.classList.remove('hidden');
            }
        }, 220);
    };

    /* ── CLOSE ────────────────────────────────────────────── */
    window.closeQuickView = function () {
        const modal = document.getElementById('quickViewModal');
        if (!modal) return;
        modal.classList.remove('qv-open');
        setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = ''; }, 300);
    };

    /* ── SCRAPE from card DOM ─────────────────────────────── */
    function scrapeCard(cardEl) {
        const root = cardEl.closest('div') || cardEl;
        const name     = root.querySelector('h3,h2')?.textContent?.trim() || 'Produk';
        const category = root.querySelector('[class*="text-primary"]:first-child, .badge-category')?.textContent?.trim() || '';
        const allPriceEls = root.querySelectorAll('[class*="text-primary"]');
        let price = 0;
        allPriceEls.forEach(el => {
            const v = parseInt(el.textContent.replace(/[^0-9]/g, ''));
            if (v > price) price = v;
        });
        const imgEl    = root.querySelector('img');
        const image    = imgEl?.src || '';
        const detailEl = root.querySelector('a[href]');
        const detailUrl= detailEl?.href || '#';
        const stockMatch = root.textContent.match(/(\d+)\s*(unit|stok|pcs)/i);
        const stock    = stockMatch ? parseInt(stockMatch[1]) : 0;
        const spec     = root.querySelector('[class*="gray-400"]')?.textContent?.trim() || '';
        return { name, category, price, image, detailUrl, stock, specification: spec };
    }

    /* ── RENDER ───────────────────────────────────────────── */
    function renderQV(p) {
        const skeleton = document.getElementById('qv-skeleton');
        const body     = document.getElementById('qv-body');

        const fmt      = v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v || 0);
        const hasDisc  = p.originalPrice && p.originalPrice > p.price && p.discount > 0;
        const inStock  = (p.stock || 0) > 0;
        const waNum    = p.waNumber || '6282133803940';
        const waMsg    = encodeURIComponent(
            'Halo, saya tertarik dengan produk: ' + p.name +
            '\nHarga: ' + fmt(p.price) + '\n\nMohon info lebih lanjut.'
        );

        body.innerHTML = `
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- IMAGE COL -->
    <div class="relative">
        <div class="bg-gray-800/40 rounded-xl overflow-hidden border border-gray-700/50 aspect-square
                    flex items-center justify-center group cursor-zoom-in"
             ${p.image ? `onclick="if(typeof openImageModal==='function') openImageModal('${p.image}')"` : ''}>
            ${p.image
                ? `<img src="${p.image}" alt="${p.name}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">`
                : `<div class="flex flex-col items-center text-gray-600">
                       <i class="fas fa-laptop text-6xl mb-3 opacity-20"></i>
                       <span class="text-xs">Gambar tidak tersedia</span>
                   </div>`
            }
        </div>

        ${hasDisc ? `
        <div class="absolute top-3 left-3">
            <span class="px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow">
                -${p.discount}%
            </span>
        </div>` : ''}

        <div class="absolute top-3 right-3">
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full border
                         ${inStock
                            ? 'bg-green-500/20 text-green-400 border-green-500/30'
                            : 'bg-red-500/20 text-red-400 border-red-500/30'}">
                ${inStock ? 'Tersedia' : 'Habis'}
            </span>
        </div>

        ${p.image ? `
        <div class="absolute bottom-3 right-3">
            <button onclick="if(typeof openImageModal==='function') openImageModal('${p.image}')"
                    class="w-8 h-8 bg-black/60 hover:bg-black/80 text-white rounded-lg flex items-center justify-center
                           text-xs transition-all border border-white/10 hover:border-white/30">
                <i class="fas fa-expand-alt"></i>
            </button>
        </div>` : ''}
    </div>

    <!-- INFO COL -->
    <div class="flex flex-col gap-4">

        ${p.category ? `
        <div>
            <span class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-full border border-primary/20">
                ${p.category}
            </span>
        </div>` : ''}

        <h2 class="text-xl md:text-2xl font-bold text-white leading-snug">${p.name}</h2>

        <!-- Price -->
        <div class="py-3 px-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
            ${hasDisc ? `
            <div class="flex items-baseline gap-2 flex-wrap">
                <span class="text-2xl font-bold text-primary">${fmt(p.price)}</span>
                <span class="text-base text-gray-500 line-through">${fmt(p.originalPrice)}</span>
                <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-md">-${p.discount}%</span>
            </div>
            <p class="text-green-400 text-xs mt-1 flex items-center gap-1">
                <i class="fas fa-tag"></i>
                Hemat ${fmt(p.originalPrice - p.price)}
            </p>` : `
            <span class="text-2xl font-bold text-primary">${fmt(p.price)}</span>`}
        </div>

        <!-- Stock -->
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full flex-shrink-0 ${inStock ? 'bg-green-400' : 'bg-red-500'}"></span>
            <span class="text-sm ${inStock ? 'text-gray-300' : 'text-red-400'}">
                ${inStock
                    ? 'Stok tersedia' + (p.stock ? ' &mdash; ' + p.stock + ' unit' : '')
                    : 'Stok habis'}
            </span>
        </div>

        ${p.specification ? `
        <!-- Spec preview -->
        <div class="bg-gray-800/40 rounded-xl p-4 border border-gray-700/40 flex-1">
            <p class="text-xs text-gray-500 mb-2 uppercase tracking-wider font-semibold">Spesifikasi</p>
            <p class="text-gray-300 text-sm leading-relaxed qv-line-clamp-4 whitespace-pre-line">${p.specification}</p>
        </div>` : '<div class="flex-1"></div>'}

        <!-- Trust badges -->
        <div class="flex flex-wrap gap-3 text-xs text-gray-500">
            <span class="flex items-center gap-1"><i class="fas fa-shield-alt text-blue-400/80"></i> Garansi Resmi</span>
            <span class="flex items-center gap-1"><i class="fas fa-truck text-green-400/80"></i> Pengiriman Cepat</span>
            <span class="flex items-center gap-1"><i class="fas fa-certificate text-primary/80"></i> 100% Original</span>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col gap-3 pt-1">
            <a href="https://wa.me/${waNum}?text=${waMsg}"
               target="_blank"
               class="w-full py-3.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl
                      flex items-center justify-center gap-2.5 transition-all duration-200
                      shadow-lg shadow-green-900/30 hover:shadow-green-900/50 hover:-translate-y-0.5">
                <i class="fab fa-whatsapp text-lg"></i>
                Tanya via WhatsApp
            </a>
            ${p.detailUrl && p.detailUrl !== '#' ? `
            <a href="${p.detailUrl}"
               class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl
                      flex items-center justify-center gap-2.5 transition-all duration-200
                      shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-0.5">
                <i class="fas fa-arrow-right"></i>
                Lihat Detail Lengkap
            </a>` : ''}
        </div>

    </div>
</div>
        `;

        skeleton.classList.add('hidden');
        body.classList.remove('hidden');
    }

    /* ── EVENT LISTENERS ─────────────────────────────────── */
    document.addEventListener('keydown', e => { if (e.key === 'Escape') window.closeQuickView(); });

})();
</script>