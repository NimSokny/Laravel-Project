<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @isset($method)
            @method($method)
        @endisset

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-800">Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('name', $user->name ?? '') }}"
                    required
                    placeholder="Enter name"
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
                    value="{{ old('email', $user->email ?? '') }}"
                    required
                    placeholder="Enter email"
                >
                @error('email')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div>
                <label for="role_id" class="block text-sm font-semibold text-slate-800">Role</label>
                <select id="role_id" name="role_id" class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('role_id') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror" required>
                    <option value="">Select role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected((int) old('role_id', $user->role_id ?? 0) === $role->id)>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
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
                    value="{{ old('phone', $user->phone ?? '') }}"
                    placeholder="Enter phone number"
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
                @if (isset($user) && $user->profile_image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="size-24 rounded-full object-cover border border-slate-200">
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
                placeholder="Enter address"
            >{{ old('address', $user->address ?? '') }}</textarea>
            @error('address')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-800">Password @empty($user)<span class="text-rose-600">*</span>@endempty</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('password') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    @empty($user) required placeholder="Enter password" @endempty
                    placeholder="Leave blank to keep current"
                >
                @error('password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-800">Confirm Password @empty($user)<span class="text-rose-600">*</span>@endempty</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15"
                    @empty($user) required placeholder="Confirm password" @endempty
                    placeholder="Confirm password"
                >
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                {{ $buttonText ?? 'Save' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-slate-950 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                Cancel
            </a>
        </div>
    </form>
</div>
