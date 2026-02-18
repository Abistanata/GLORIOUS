@extends('layouts.dashboard')

@section('title', 'Edit Review')

@section('content')
    <!-- Header Section -->
    <div class="relative mb-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/10 to-orange-600/10 rounded-2xl backdrop-blur-sm"></div>
        <div class="relative p-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center mb-4 space-x-2 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-3 py-1 text-gray-600 transition-all duration-200 rounded-lg hover:text-yellow-600 hover:bg-white/50 dark:text-gray-400 dark:hover:bg-gray-800/50">
                    <i class="mr-2 fas fa-home"></i>Dashboard
                </a>
                <i class="text-gray-400 fas fa-chevron-right"></i>
                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center px-3 py-1 text-gray-600 transition-all duration-200 rounded-lg hover:text-yellow-600 hover:bg-white/50 dark:text-gray-400 dark:hover:bg-gray-800/50">
                    <i class="mr-2 fas fa-star"></i>Review
                </a>
                <i class="text-gray-400 fas fa-chevron-right"></i>
                <span class="px-3 py-1 text-yellow-600 bg-yellow-100 rounded-lg dark:text-yellow-400 dark:bg-yellow-900/50">
                    Edit
                </span>
            </nav>

            <!-- Title Section -->
            <div class="space-y-2">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    <i class="mr-3 text-yellow-600 fas fa-edit dark:text-yellow-400"></i>
                    Edit Review
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Edit atau moderasi review dari customer
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg dark:bg-green-900/50 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Review Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Review</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                <p class="text-gray-900 dark:text-white">{{ $review->user ? $review->user->name : 'Anonim' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Produk</label>
                <p class="text-gray-900 dark:text-white">{{ $review->product ? $review->product->name : 'Produk Dihapus' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Review</label>
                <p class="text-gray-900 dark:text-white">{{ $review->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Terakhir Diupdate</label>
                <p class="text-gray-900 dark:text-white">{{ $review->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        @if($review->images && count($review->images) > 0)
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar Ulasan</label>
            <div class="flex flex-wrap gap-2">
                @foreach($review->images as $imgPath)
                    <a href="{{ asset('storage/' . $imgPath) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $imgPath) }}" 
                             alt="Ulasan" 
                             class="w-24 h-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600 hover:opacity-90 transition-opacity">
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2 mb-2" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors"
                                    data-rating="{{ $i }}">
                                <i class="far fa-star"></i>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ $review->rating }}" required>
                    <p class="text-xs text-gray-500" id="ratingText">Rating saat ini: {{ $review->rating }}/5</p>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Komentar
                    </label>
                    <textarea name="comment" 
                            id="comment" 
                            rows="6" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="Komentar review...">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.reviews.index') }}"
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starBtns = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('ratingInput');
            const ratingText = document.getElementById('ratingText');
            let selectedRating = {{ $review->rating }};

            // Initialize stars based on current rating
            function updateStars() {
                starBtns.forEach((btn, index) => {
                    const icon = btn.querySelector('i');
                    if (index < selectedRating) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-yellow-400');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        btn.classList.remove('text-yellow-400');
                        btn.classList.add('text-gray-300');
                    }
                });
                ratingText.textContent = `Rating saat ini: ${selectedRating}/5`;
            }

            updateStars();

            starBtns.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    selectedRating = index + 1;
                    ratingInput.value = selectedRating;
                    updateStars();
                });
            });
        });
    </script>
@endsection
