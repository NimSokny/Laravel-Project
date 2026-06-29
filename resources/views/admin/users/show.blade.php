@extends('admin.layouts.app')

@section('title', 'User Detail')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 font-accent">User Detail</h1>
            <p class="mt-2 text-slate-600">View user information</p>
        </div>
        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
            <i data-lucide="pencil" class="size-4"></i>
            Edit User
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="p-6">
            <div class="grid gap-6 lg:grid-cols-4">
                <div class="lg:col-span-1">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full rounded-full object-cover border-4 border-slate-100">
                    @else
                        <div class="flex h-48 items-center justify-center rounded-full bg-cyan-100 border-4 border-slate-100">
                            <i data-lucide="user" class="size-16 text-cyan-700"></i>
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
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->id }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="user" class="size-4"></i>
                                Name
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="mail" class="size-4"></i>
                                Email
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->email }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="shield-check" class="size-4"></i>
                                Role
                            </div>
                            <div class="mt-1">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->role->name === 'admin' ? 'bg-violet-100 text-violet-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($user->role->name ?? 'N/A') }}
                                </span>
                            </div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="phone" class="size-4"></i>
                                Phone
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="map-pin" class="size-4"></i>
                                Address
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->address ?: 'N/A' }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="calendar" class="size-4"></i>
                                Created At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->created_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i data-lucide="clock" class="size-4"></i>
                                Updated At
                            </div>
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ $user->updated_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
