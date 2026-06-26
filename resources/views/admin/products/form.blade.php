<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @isset($method)
            @method($method)
        @endisset

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-semibold text-slate-800">Product Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('name') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('name', $product->name ?? '') }}"
                    required
                    placeholder="Enter product name"
                >
                @error('name')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-slate-800">Price</label>
                <input
                    id="price"
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('price') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('price', $product->price ?? '') }}"
                    required
                    placeholder="0.00"
                >
                @error('price')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="discount_price" class="block text-sm font-semibold text-slate-800">Discount Price</label>
                <input
                    id="discount_price"
                    type="number"
                    step="0.01"
                    min="0"
                    name="discount_price"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('discount_price') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('discount_price', $product->discount_price ?? '') }}"
                    placeholder="0.00"
                >
                @error('discount_price')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div>
                <label for="stock" class="block text-sm font-semibold text-slate-800">Stock</label>
                <input
                    id="stock"
                    type="number"
                    min="0"
                    name="stock"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('stock') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('stock', $product->stock ?? 0) }}"
                    required
                    placeholder="0"
                >
                @error('stock')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-semibold text-slate-800">Category</label>
                <select id="category_id" name="category_id" class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('category_id') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror" required>
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id ?? 0) === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="brand_id" class="block text-sm font-semibold text-slate-800">Brand</label>
                <select id="brand_id" name="brand_id" class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('brand_id') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror" required>
                    <option value="">Select brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((int) old('brand_id', $product->brand_id ?? 0) === $brand->id)>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-800">Description</label>
            <textarea
                id="description"
                name="description"
                class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('description') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                rows="4"
                placeholder="Enter product description"
            >{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="specification" class="block text-sm font-semibold text-slate-800">Specification</label>
            <textarea
                id="specification"
                name="specification"
                class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('specification') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                rows="4"
                placeholder="Enter product specification"
            >{{ old('specification', $product->specification ?? '') }}</textarea>
            @error('specification')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label for="warranty" class="block text-sm font-semibold text-slate-800">Warranty</label>
                <input
                    id="warranty"
                    type="text"
                    name="warranty"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('warranty') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    value="{{ old('warranty', $product->warranty ?? '') }}"
                    placeholder="Enter warranty information"
                >
                @error('warranty')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="thumbnail" class="block text-sm font-semibold text-slate-800">Thumbnail</label>
                <input
                    id="thumbnail"
                    type="file"
                    name="thumbnail"
                    class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('thumbnail') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                    accept="image/*"
                >
                @if (isset($product) && $product->thumbnail)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="size-24 rounded-lg object-cover border border-slate-200">
                        <p class="mt-1 text-xs text-slate-500">Current thumbnail</p>
                    </div>
                @endif
                @error('thumbnail')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
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
                    @checked(old('status', $product->status ?? true))
                >
                <div class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-[2px] after:size-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-cyan-700 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-2 peer-focus:ring-cyan-700/15"></div>
                <span class="text-sm font-semibold text-slate-700">Active</span>
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                {{ $buttonText ?? 'Save' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-slate-950 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                Cancel
            </a>
        </div>
    </form>
</div>
