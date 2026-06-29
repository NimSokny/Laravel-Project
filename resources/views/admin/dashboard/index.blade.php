@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 font-accent">Dashboard</h1>
        <p class="mt-2 text-slate-600">Welcome back! Here's what's happening with your store today.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Total Products</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalProducts }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-cyan-100">
                    <i data-lucide="laptop" class="size-6 text-cyan-700"></i>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Total Categories</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalCategories }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-emerald-100">
                    <i data-lucide="layout-grid" class="size-6 text-emerald-700"></i>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Total Brands</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalBrands }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-amber-100">
                    <i data-lucide="tag" class="size-6 text-amber-700"></i>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Total Orders</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-rose-100">
                    <i data-lucide="shopping-cart" class="size-6 text-rose-700"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Total Users</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-violet-100">
                    <i data-lucide="users" class="size-6 text-violet-700"></i>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Pending Orders</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingOrders }}</p>
                </div>
                <div class="flex size-12 items-center justify-center rounded-lg bg-orange-100">
                    <i data-lucide="clock" class="size-6 text-orange-700"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <h2 class="text-lg font-bold text-slate-900">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                View All
                <i data-lucide="arrow-right" class="size-4"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Order No.</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">${{ number_format((float) $order->total_price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $order->order_status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : ($order->order_status === 'Cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                                    <i data-lucide="eye" class="size-4"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">No recent orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
