@extends('admin.layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 font-accent">Order Detail</h1>
            <p class="mt-2 text-slate-600">View order information</p>
        </div>
        <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
            <i data-lucide="pencil" class="size-4"></i>
            Edit Order
        </a>
    </div>

    <div class="mb-6 rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-bold text-slate-900">Order Information</h2>
        </div>
        <div class="p-6">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="hash" class="size-4"></i>
                        Order No.
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->order_number }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="user" class="size-4"></i>
                        Customer
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="mail" class="size-4"></i>
                        Email
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->user->email ?? 'N/A' }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="dollar-sign" class="size-4"></i>
                        Total
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">${{ number_format((float) $order->total_price, 2) }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="credit-card" class="size-4"></i>
                        Payment Method
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->payment_method }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="check-circle" class="size-4"></i>
                        Payment Status
                    </div>
                    <div class="mt-1">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : ($order->payment_status === 'Failed' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                            {{ $order->payment_status }}
                        </span>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="package" class="size-4"></i>
                        Order Status
                    </div>
                    <div class="mt-1">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->order_status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : ($order->order_status === 'Cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $order->order_status }}
                        </span>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="calendar" class="size-4"></i>
                        Created At
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="map-pin" class="size-4"></i>
                        Shipping Address
                    </div>
                    <div class="mt-1 text-sm font-semibold text-slate-900">{{ $order->shipping_address }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-bold text-slate-900">Order Items</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($order->items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $item->product->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">${{ number_format((float) $item->price, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">${{ number_format((float) $item->subtotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500">No items found for this order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
