@props([
    'status' => 'pending',
])

@php
    $config = [
        'pending' => ['label' => 'Menunggu', 'class' => 'bg-amber-500/20 text-amber-400 border-amber-500/40'],
        'confirmed' => ['label' => 'Dikonfirmasi', 'class' => 'bg-blue-500/20 text-blue-400 border-blue-500/40'],
        'processed' => ['label' => 'Diproses', 'class' => 'bg-green-500/20 text-green-400 border-green-500/40'],
        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-500/20 text-red-400 border-red-500/40'],
    ];
    $cfg = $config[$status] ?? $config['pending'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border ' . $cfg['class']]) }}>
    {{ $slot ?? $cfg['label'] }}
</span>
