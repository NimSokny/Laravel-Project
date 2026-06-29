<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Auth::user()->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved',
            'data'    => $orders->items(),
            'current_page' => $orders->currentPage(),
            'last_page'    => $orders->lastPage(),
            'total'        => $orders->total(),
            'per_page'     => $orders->perPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string'],
            'payment_method'   => ['required', 'in:Cash,ABA,ACLEDA,Wing'],
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return $this->error('Your cart is empty', 400);
        }

        $totalPrice = 0;
        foreach ($cart->items as $item) {
            $product = $item->product;
            if ($product->stock < $item->quantity) {
                return $this->error("Insufficient stock for {$product->name}", 400);
            }
            $totalPrice += $item->price * $item->quantity;
        }

        $order = \App\Models\Order::create([
            'user_id'          => $user->id,
            'order_number'     => 'ORD-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'total_price'      => $totalPrice,
            'payment_method'   => $validated['payment_method'],
            'payment_status'   => 'Pending',
            'order_status'     => 'Pending',
            'shipping_address' => $validated['shipping_address'],
        ]);

        foreach ($cart->items as $item) {
            \App\Models\OrderItem::create([
                'order_id'    => $order->id,
                'product_id'  => $item->product_id,
                'quantity'    => $item->quantity,
                'price'       => $item->price,
                'subtotal'    => $item->price * $item->quantity,
            ]);

            $product = $item->product;
            $product->decrement('stock', $item->quantity);
        }

        $cart->items()->delete();

        return $this->success($order->load('items.product'), 'Order placed successfully', 201);
    }

    public function show(string $orderNumber): JsonResponse
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->with('items.product')
            ->firstOrFail();

        return $this->success($order, 'Order retrieved');
    }
}
