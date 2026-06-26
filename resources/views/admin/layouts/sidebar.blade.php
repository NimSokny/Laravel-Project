<aside class="w-64 border-r border-slate-200 bg-white">
    <div class="p-4 border-b border-slate-200">
        <h2 class="text-sm font-bold uppercase tracking-wider text-cyan-700">Menu</h2>
    </div>

    <nav class="p-2">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="layout-dashboard" class="size-5"></i>
            Dashboard
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="layout-grid" class="size-5"></i>
            Categories
        </a>
        <a href="{{ route('admin.brands.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="tag" class="size-5"></i>
            Brands
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="laptop" class="size-5"></i>
            Products
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="shopping-cart" class="size-5"></i>
            Orders
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="users" class="size-5"></i>
            Users
        </a>
        <a href="{{ route('admin.profile.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-cyan-50 text-cyan-700' : 'text-slate-700 hover:bg-slate-50' }}">
            <i data-lucide="user-circle" class="size-5"></i>
            Profile
        </a>
    </nav>
</aside>
