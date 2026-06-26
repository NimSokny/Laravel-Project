@extends('admin.layouts.app')

@section('title', 'Brand Detail')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 font-accent">Brand Detail</h1>
            <p class="mt-2 text-slate-600">View brand information</p>
        </div>
        <a href="{{ route('admin.brands.edit', $brand) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
            <i data-lucide="pencil" class="size-4"></i>
            Edit Brand
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="grid gap-6 lg:grid-cols-4">
                <div class="lg:col-span-1">
                    <div class="flex h-64 items-center justify-center rounded-lg bg-slate-50 border border-slate-200">
                        @if ($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-h-56 rounded-lg object-contain">
                        @else
                            <div class="text-center">
                                <i data-lucide="image" class="size-12 text-slate-400"></i>
                                <p class="mt-2 text-sm text-slate-500">No logo uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <div class="mb-4">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <i data-lucide="tag" class="size-4"></i>
                            Brand Name
                        </div>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">{{ $brand->name }}</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="hash" class="size-4"></i>
                                ID
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $brand->id }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="link" class="size-4"></i>
                                Slug
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $brand->slug }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="power" class="size-4"></i>
                                Status
                            </div>
                            <div class="mt-1">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $brand->status ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $brand->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="calendar" class="size-4"></i>
                                Created At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $brand->created_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="file-text" class="size-4"></i>
                                Description
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $brand->description ?: 'No description provided' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="clock" class="size-4"></i>
                                Updated At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $brand->updated_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
