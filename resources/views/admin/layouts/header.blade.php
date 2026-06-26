<nav class="border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="Computer Shop" class="h-10 w-auto">
                <span class="text-xl font-bold text-slate-900 font-accent">Admin Dashboard</span>
            </a>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="size-10 rounded-full object-cover border-2 border-slate-200">
                    @else
                        <div class="flex size-10 items-center justify-center rounded-full bg-cyan-100 border-2 border-slate-200">
                            <i data-lucide="user" class="size-5 text-cyan-700"></i>
                        </div>
                    @endif
                    <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>

                <form action="{{ route('admin.auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:border-slate-400 hover:bg-slate-50">
                        <i data-lucide="log-out" class="size-4"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
