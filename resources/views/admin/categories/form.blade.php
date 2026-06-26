<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @isset($method)
            @method($method)
        @endisset

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-800">Category Name</label>
            <input
                id="name"
                type="text"
                name="name"
                class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                value="{{ old('name', $category->name ?? '') }}"
                required
                placeholder="Enter category name"
            >
            @error('name')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-semibold text-slate-800">Category Image</label>
            <input
                id="image"
                type="file"
                name="image"
                class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('image') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                accept="image/*"
            >
            @if(isset($category) && $category->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" class="size-24 rounded-lg object-cover border border-slate-200">
                    <p class="mt-1 text-xs text-slate-500">Current image</p>
                </div>
            @endif
            @error('image')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-800">Description</label>
            <textarea
                id="description"
                name="description"
                class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('description') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                rows="4"
                placeholder="Enter category description"
            >{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="hidden" name="status" value="0">
            <label class="relative inline-flex cursor-pointer items-center gap-3">
                <input
                    id="status"
                    type="checkbox"
                    name="status"
                    value="1"
                    class="peer sr-only"
                    @checked(old('status', $category->status ?? true))
                >
                <div class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-[2px] after:size-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-cyan-700 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-2 peer-focus:ring-cyan-700/15"></div>
                <span class="text-sm font-semibold text-slate-700">Active</span>
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                {{ $buttonText ?? 'Save' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-slate-950 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                Cancel
            </a>
        </div>
    </form>
</div>
