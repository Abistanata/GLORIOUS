<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the wishlist page.
     */
    public function index(Request $request)
    {
        // Get wishlist items for authenticated user or from session
        $wishlistItems = $this->getWishlistItems();
        
        // Get wishlist count for the badge
        $wishlistCount = $this->getWishlistCount();
        
        // Get categories for sidebar if needed
        $categories = \App\Models\Category::withCount('products')
            ->orderBy('name')
            ->get();
        
        return view('main.wishlist.index', [
            'wishlistItems' => $wishlistItems,
            'wishlistCount' => $wishlistCount,
            'categories' => $categories,
            'pageTitle' => 'My Wishlist - Glorious Computer'
        ]);
    }

    /**
     * Add product to wishlist.
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        if (Auth::check()) {
            // For authenticated users - save to database
            $wishlist = Wishlist::firstOrCreate([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ], [
                'added_at' => now()
            ]);
            
            $message = 'Product added to wishlist!';
        } else {
            // For guests - save to session
            $wishlist = session('wishlist', []);
            
            if (!in_array($productId, $wishlist)) {
                $wishlist[] = $productId;
                session(['wishlist' => $wishlist]);
            }
            
            $message = 'Product added to wishlist! (Please login to save permanently)';
        }
        
        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }
        
        // Return redirect for regular requests
        return redirect()->back()
            ->with('success', $message)
            ->with('wishlist_count', $this->getWishlistCount());
    }

    /**
     * Remove product from wishlist.
     */
    public function remove(Request $request, $productId)
    {
        $this->removeItemFromWishlist($productId);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }

        return redirect()->route('wishlist.index')
            ->with('success', 'Product removed from wishlist')
            ->with('wishlist_count', $this->getWishlistCount());
    }

    /**
     * Remove item from wishlist (DB or session) without returning a response.
     * Used by remove() and moveToCart() so AJAX moveToCart doesn't double-return.
     */
    private function removeItemFromWishlist($productId): void
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $wishlist = session('wishlist', []);
            $wishlist = array_diff($wishlist, [$productId]);
            session(['wishlist' => array_values($wishlist)]);
        }
    }

    /**
     * Toggle product in wishlist (add if not exists, remove if exists).
     */
    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $isInWishlist = false;
        
        if (Auth::check()) {
            $wishlistItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();
            
            if ($wishlistItem) {
                $wishlistItem->delete();
                $action = 'removed';
            } else {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'added_at' => now()
                ]);
                $action = 'added';
                $isInWishlist = true;
            }
        } else {
            $wishlist = session('wishlist', []);
            
            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                $action = 'removed';
            } else {
                $wishlist[] = $productId;
                $action = 'added';
                $isInWishlist = true;
            }
            
            session(['wishlist' => array_values($wishlist)]);
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'action' => $action,
                'is_in_wishlist' => $isInWishlist,
                'message' => "Product {$action} from wishlist",
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }
        
        return redirect()->back()
            ->with('success', "Product {$action} from wishlist")
            ->with('wishlist_count', $this->getWishlistCount());
    }

    /**
     * Get wishlist count.
     */
    public function count(Request $request)
    {
        $count = $this->getWishlistCount();
        
        if ($request->ajax()) {
            return response()->json([
                'count' => $count
            ]);
        }
        
        return $count;
    }

    /**
     * Clear entire wishlist.
     */
    public function clear(Request $request)
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('wishlist');
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared',
                'wishlist_count' => 0
            ]);
        }
        
        return redirect()->route('wishlist.index')
            ->with('success', 'Wishlist cleared')
            ->with('wishlist_count', 0);
    }

    /**
     * Move product from wishlist to cart.
     */
    public function moveToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $this->removeItemFromWishlist($productId);

        \App\Models\Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['qty' => 0]
        )->increment('qty', 1);

        $message = "{$product->name} dipindah ke keranjang.";
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'wishlist_count' => $this->getWishlistCount()
            ]);
        }
        return redirect()->route('main.cart.index')->with('success', $message);
    }

    /**
     * Get wishlist items for the current user.
     */
    private function getWishlistItems()
    {
        if (Auth::check()) {
            // For authenticated users - get from database with product details
            $wishlistItems = Wishlist::where('user_id', Auth::id())
                ->with(['product' => function($query) {
                    $query->with('category');
                    // Hapus kondisi where('is_active', true) jika kolom tidak ada
                }])
                ->whereHas('product')
                ->orderBy('added_at', 'desc')
                ->get()
                ->pluck('product')
                ->filter(); // Remove null products
        } else {
            // For guests - get from session
            $wishlistIds = session('wishlist', []);
            
            if (empty($wishlistIds)) {
                return collect();
            }
            
            $wishlistItems = Product::with('category')
                ->whereIn('id', $wishlistIds)
                // Hapus kondisi where('is_active', true) jika kolom tidak ada
                ->orderByRaw("FIELD(id, " . implode(',', $wishlistIds) . ")")
                ->get();
        }
        
        return $wishlistItems;
    }

    /**
     * Get wishlist count for the current user.
     */
    private function getWishlistCount()
    {
        if (Auth::check()) {
            $count = Wishlist::where('user_id', Auth::id())
                ->whereHas('product')
                ->count();
        } else {
            $count = count(session('wishlist', []));
        }
        
        return $count;
    }

    /**
     * Check if a product is in wishlist.
     */
    public function check($productId)
    {
        $isInWishlist = false;
        
        if (Auth::check()) {
            $isInWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } else {
            $wishlist = session('wishlist', []);
            $isInWishlist = in_array($productId, $wishlist);
        }
        
        return response()->json([
            'is_in_wishlist' => $isInWishlist
        ]);
    }
}