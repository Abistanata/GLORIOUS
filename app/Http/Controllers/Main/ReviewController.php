<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Hanya customer yang bisa membuat review
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login sebagai Customer untuk memberikan review'
            ], 403);
        }

        // Cek apakah user sudah pernah review produk ini
        $existingReview = Review::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        $imagePaths = $this->uploadReviewImages($request);

        if ($existingReview) {
            // Hapus gambar lama yang dihapus, tambah yang baru
            $existingImages = $existingReview->images ?? [];
            $newImages = array_merge($existingImages, $imagePaths);
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'images' => $newImages,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review berhasil diperbarui',
                'review' => $existingReview->load('user')
            ]);
        }

        // Buat review baru
        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan',
            'review' => $review->load('user')
        ]);
    }

    /**
     * Get reviews for a product
     */
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->with('user:id,name,profile_photo_path')
            ->latest()
            ->get();

        $product = Product::findOrFail($productId);

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'average_rating' => $product->average_rating,
            'review_count' => $product->review_count,
        ]);
    }

    /**
     * Upload review images and return stored paths.
     */
    private function uploadReviewImages(Request $request): array
    {
        $paths = [];
        if (!$request->hasFile('images')) {
            return $paths;
        }

        foreach ($request->file('images') as $file) {
            if ($file->isValid()) {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('reviews', $filename, 'public');
                if ($path) {
                    $paths[] = $path;
                }
            }
        }

        return $paths;
    }
}
