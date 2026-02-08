@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $styles = [
        'success' => 'bg-green-500/10 border-green-500/30 text-green-300',
        'error' => 'bg-red-500/10 border-red-500/30 text-red-300',
        'warning' => 'bg-yellow-500/10 border-yellow-500/30 text-yellow-300',
        'info' => 'bg-blue-500/10 border-blue-500/30 text-blue-300',
    ];
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];
    $class = 'rounded-xl border p-4 ' . ($styles[$type] ?? $styles['info']);
@endphp

<div {{ $attributes->merge(['class' => $class]) }} role="alert">
    <div class="flex items-start gap-3">
        <i class="fas {{ $icons[$type] ?? $icons['info'] }} mt-0.5 flex-shrink-0"></i>
        <div class="flex-1 min-w-0">
            @if($title)
                <p class="font-semibold mb-1">{{ $title }}</p>
            @endif
            <div class="text-sm opacity-95">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <button type="button" class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity" onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>
