@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 font-accent">Edit Profile</h1>
        <p class="mt-2 text-slate-600">Update your account information</p>
    </div>

    <div class="mx-auto max-w-3xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-800">Name</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                            value="{{ old('name', $user->name) }}"
                            required
                            placeholder="Enter your name"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-800">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('email') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                            value="{{ old('email', $user->email) }}"
                            required
                            placeholder="Enter your email"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-800">Phone</label>
                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('phone') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="Enter your phone number"
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="profile_image" class="block text-sm font-semibold text-slate-800">Profile Image</label>
                        <input
                            id="profile_image"
                            type="file"
                            name="profile_image"
                            class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('profile_image') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                            accept="image/*"
                        >
                        @if ($user->profile_image)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" 
                                     class="size-24 rounded-full object-cover border-2 border-slate-200">
                                <p class="mt-1 text-xs text-slate-500">Current image</p>
                            </div>
                        @endif
                        @error('profile_image')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-slate-800">Address</label>
                    <textarea
                        id="address"
                        name="address"
                        class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('address') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                        rows="3"
                        placeholder="Enter your address"
                    >{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        <i data-lucide="save" class="size-4"></i>
                        Update Profile
                    </button>
                    <a href="{{ route('admin.profile.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-slate-950 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
