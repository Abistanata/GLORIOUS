<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user:id,name,email', 'product:id,name,sku']);

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Search by comment or user name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sort
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $reviews = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => Review::count(),
            'average_rating' => round(Review::avg('rating') ?? 0, 1),
            'rating_5' => Review::where('rating', 5)->count(),
            'rating_4' => Review::where('rating', 4)->count(),
            'rating_3' => Review::where('rating', 3)->count(),
            'rating_2' => Review::where('rating', 2)->count(),
            'rating_1' => Review::where('rating', 1)->count(),
        ];

        $products = Product::select('id', 'name', 'sku')->orderBy('name')->get();

        return view('pages.admin.reviews.index', compact('reviews', 'stats', 'products'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        $review->load(['user', 'product']);
        return view('pages.admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil diperbarui');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil dihapus');
    }

    /**
     * Bulk actions for reviews
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,approve',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);

        $reviewIds = $request->review_ids;

        if ($request->action === 'delete') {
            Review::whereIn('id', $reviewIds)->delete();
            return redirect()->route('admin.reviews.index')
                ->with('success', count($reviewIds) . ' review berhasil dihapus');
        }

        return redirect()->route('admin.reviews.index')
            ->with('error', 'Aksi tidak valid');
    }
}
