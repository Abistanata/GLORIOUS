@props([
    'status' => 'pending',
])

@php
    $config = [
        'pending' => ['label' => 'Menunggu', 'class' => 'bg-amber-500/15 text-amber-400/90 border border-amber-500/30'],
        'confirmed' => ['label' => 'Dikonfirmasi', 'class' => 'bg-indigo-500/15 text-indigo-300 border border-indigo-500/30'],
        'processed' => ['label' => 'Diproses', 'class' => 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30'],
        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-500/15 text-red-400/90 border border-red-500/30'],
    ];
    $cfg = $config[$status] ?? $config['pending'];
@endphp

{{-- UI improvement: modern badge, rounded-full, soft colors --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border ' . $cfg['class']]) }}>
    {{ $slot ?? $cfg['label'] }}
</span>
