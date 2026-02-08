@props([
    'tag' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'block' => false,
])

@php
    $tag = $href ? 'a' : $tag;
    $base = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark';
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    $variants = [
        'primary' => 'bg-primary hover:bg-primary-dark text-white focus:ring-primary shadow-lg hover:shadow-primary/30',
        'secondary' => 'bg-gray-700 hover:bg-gray-600 text-white border border-gray-600 focus:ring-gray-500',
        'outline' => 'bg-transparent border border-gray-600 hover:border-primary text-light hover:text-primary focus:ring-primary',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'ghost' => 'bg-dark-light/50 hover:bg-dark-light text-light border border-gray-700 focus:ring-gray-500',
    ];
    $classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
    if ($block) $classes .= ' w-full';
    if ($disabled) $classes .= ' opacity-60 cursor-not-allowed pointer-events-none';
@endphp

<{{ $tag }}
    @if($tag === 'a')
        href="{{ $href ?? '#' }}"
    @else
        type="{{ $type }}"
        @if($disabled) disabled @endif
    @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</{{ $tag }}>
