@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 font-accent">Profile</h1>
        <p class="mt-2 text-slate-600">View and manage your account information</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 text-center">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" 
                             class="mx-auto size-32 rounded-full object-cover border-4 border-slate-100 shadow-lg">
                    @else
                        <div class="mx-auto flex size-32 items-center justify-center rounded-full bg-cyan-100 border-4 border-slate-100 shadow-lg">
                            <i data-lucide="user" class="size-16 text-cyan-700"></i>
                        </div>
                    @endif
                </div>
                <h3 class="text-center text-xl font-bold text-slate-900">{{ $user->name }}</h3>
                <p class="mt-1 text-center text-sm font-semibold text-slate-600">{{ ucfirst($user->role->name ?? 'N/A') }}</p>
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-slate-800">
                        <i data-lucide="pencil" class="size-4"></i>
                        Edit Profile
                    </a>
                    <a href="{{ route('admin.profile.password') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                        <i data-lucide="key" class="size-4"></i>
                        Change Password
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-lg font-bold text-slate-900">Profile Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
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
                            <div class="mt-1 text-sm font-semibold text-slate-900">{{ ucfirst($user->role->name ?? 'N/A') }}</div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
