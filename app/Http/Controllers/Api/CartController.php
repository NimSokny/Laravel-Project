<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $cart = $user->cart()->with(['items.product.category', 'items.product.brand', 'items.product.images'])->first();

        if (! $cart) {
            return $this->success([
                'id'         => null,
                'user_id'    => $user->id,
                'items'      => [],
                'total'      => 0,
                'items_count' => 0,
            ], 'Cart retrieved');
        }

        $items = $cart->items->map(function ($item) {
            return [
                'id'        => $item->id,
                'product_id'=> $item->product_id,
                'quantity'  => $item->quantity,
                'price'     => (float) $item->price,
                'subtotal'  => (float) ($item->price * $item->quantity),
                'product'   => $item->product,
            ];
        });

        $total = $items->sum(fn ($i) => $i['subtotal']);

        return $this->success([
            'id'          => $cart->id,
            'user_id'     => $cart->user_id,
            'items'       => $items,
            'total'       => $total,
            'items_count' => $items->count(),
        ], 'Cart retrieved');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate([]);
        $quantity = $validated['quantity'] ?? 1;

        $existing = $cart->items()->where('product_id', $validated['product_id'])->first();

        if ($existing) {
            $existing->update([
                'quantity' => $existing->quantity + $quantity,
            ]);
        } else {
            $product = Product::findOrFail($validated['product_id']);
            $cart->items()->create([
                'product_id' => $validated['product_id'],
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
        }

        return $this->index();
    }

    public function update(Request $request, $itemId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrFail();
        $item = $cart->items()->where('id', $itemId)->firstOrFail();

        $item->update([
            'quantity' => $validated['quantity'],
        ]);

        return $this->index();
    }

    public function destroy($itemId): JsonResponse
    {
        $user = Auth::user();
        $cart = $user->cart()->firstOrFail();
        $item = $cart->items()->where('id', $itemId)->firstOrFail();
        $item->delete();

        return $this->index();
    }
}
