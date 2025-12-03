@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex flex-wrap items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 bg-gray-800 text-gray-600 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2"></i> Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 bg-dark-light hover:bg-primary text-gray-300 hover:text-white rounded-lg transition-all flex items-center">
                    <i class="fas fa-chevron-left mr-2"></i> Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 bg-dark-light text-gray-400 rounded-lg">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 bg-gradient-primary text-white font-bold rounded-lg shadow-glow">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" 
                               class="px-4 py-2 bg-dark-light hover:bg-primary text-gray-300 hover:text-white rounded-lg transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 bg-dark-light hover:bg-primary text-gray-300 hover:text-white rounded-lg transition-all flex items-center">
                    Next <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="px-4 py-2 bg-gray-800 text-gray-600 rounded-lg cursor-not-allowed">
                    Next <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    </nav>
@endif