<?php

namespace App\Http\Controllers\Api;

use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(): JsonResponse
    {
        $wishlist = Auth::user()->wishlist()
            ->with('product.category', 'product.brand', 'product.images')
            ->get();

        return $this->success($wishlist, 'Wishlist retrieved');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $user = Auth::user();

        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($exists) {
            return $this->error('Product already in wishlist', 409);
        }

        $wishlist = Wishlist::create([
            'user_id'    => $user->id,
            'product_id' => $validated['product_id'],
        ]);

        return $this->success($wishlist->load('product'), 'Added to wishlist', 201);
    }

    public function destroy($productId): JsonResponse
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->firstOrFail();

        $wishlist->delete();

        return $this->success(null, 'Removed from wishlist');
    }
}
