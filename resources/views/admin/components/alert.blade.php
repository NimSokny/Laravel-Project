@if (session('success'))
    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle" class="size-5"></i>
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="alert-circle" class="size-5"></i>
                {{ session('error') }}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-rose-600 hover:text-rose-800">
                <i data-lucide="x" class="size-4"></i>
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3">
        <div class="flex items-center gap-2 text-sm font-semibold text-rose-800">
            <i data-lucide="alert-triangle" class="size-5"></i>
            Please check the form.
        </div>
        <ul class="mt-2 ml-7 list-disc text-sm text-rose-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif