@extends('admin.layouts.app')

@section('title', 'Product Detail')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 font-accent">Product Detail</h1>
            <p class="mt-2 text-slate-600">View product information</p>
        </div>
        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
            <i data-lucide="pencil" class="size-4"></i>
            Edit Product
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="grid gap-6 lg:grid-cols-4">
                <div class="lg:col-span-1">
                    @if ($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full rounded-lg object-cover border border-slate-200">
                    @else
                        <div class="flex h-60 items-center justify-center rounded-lg bg-slate-100 border border-slate-200">
                            <i data-lucide="image" class="size-12 text-slate-400"></i>
                        </div>
                    @endif
                </div>
                <div class="lg:col-span-3">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="hash" class="size-4"></i>
                                ID
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->id }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="tag" class="size-4"></i>
                                Name
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->name }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="link" class="size-4"></i>
                                Slug
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->slug }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="layout-grid" class="size-4"></i>
                                Category
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->category->name ?? 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="tag" class="size-4"></i>
                                Brand
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->brand->name ?? 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="dollar-sign" class="size-4"></i>
                                Price
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">${{ number_format((float) $product->price, 2) }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="percent" class="size-4"></i>
                                Discount Price
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->discount_price ? '$'.number_format((float) $product->discount_price, 2) : 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="package" class="size-4"></i>
                                Stock
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->stock }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="shield-check" class="size-4"></i>
                                Warranty
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->warranty ?: 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="power" class="size-4"></i>
                                Status
                            </div>
                            <div class="mt-1">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->status ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="file-text" class="size-4"></i>
                                Description
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->description ?: 'No description' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="list" class="size-4"></i>
                                Specification
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->specification ?: 'No specification' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="calendar" class="size-4"></i>
                                Created At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->created_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="clock" class="size-4"></i>
                                Updated At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $product->updated_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
