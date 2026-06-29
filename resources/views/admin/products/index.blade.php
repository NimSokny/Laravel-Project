@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 font-accent">Products</h1>
            <p class="mt-2 text-slate-600">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-slate-800">
            <i data-lucide="plus" class="size-4"></i>
            Add Product
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($products as $product)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $product->id }}</td>
                            <td class="px-6 py-4">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="size-12 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div class="flex size-12 items-center justify-center rounded-lg bg-slate-100 border border-slate-200">
                                        <i data-lucide="image" class="size-5 text-slate-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $product->brand->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                @if ($product->discount_price)
                                    <span class="text-slate-400 line-through">${{ number_format((float) $product->price, 2) }}</span>
                                    <span class="ml-1">${{ number_format((float) $product->discount_price, 2) }}</span>
                                @else
                                    ${{ number_format((float) $product->price, 2) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $product->stock }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->status ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                                        <i data-lucide="eye" class="size-4"></i>
                                        View
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                                        <i data-lucide="pencil" class="size-4"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-rose-300 bg-white px-3 py-1.5 text-sm font-semibold text-rose-700 shadow-sm transition-all hover:border-rose-400 hover:bg-rose-50">
                                            <i data-lucide="trash-2" class="size-4"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-sm text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            @include('admin.components.pagination', ['items' => $products])
        </div>
    </div>
@endsection
