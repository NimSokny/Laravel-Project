@if (isset($items) && method_exists($items, 'links'))
    <div class="flex items-center justify-between">
        <div class="text-sm text-slate-600">
            Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} results
        </div>
        <div class="flex items-center gap-1">
            @if ($items->onFirstPage())
                <span class="inline-flex size-8 items-center justify-center rounded-md text-slate-400">
                    <i data-lucide="chevron-left" class="size-4"></i>
                </span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="inline-flex size-8 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition">
                    <i data-lucide="chevron-left" class="size-4"></i>
                </a>
            @endif

            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                @if ($page == $items->currentPage())
                    <span class="inline-flex size-8 items-center justify-center rounded-md bg-cyan-700 text-white text-sm font-semibold">
                        {{ $page }}
                    </span>
                @elseif ($url)
                    <a href="{{ $url }}" class="inline-flex size-8 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition text-sm font-semibold">
                        {{ $page }}
                    </a>
                @else
                    <span class="inline-flex size-8 items-center justify-center rounded-md text-slate-400">
                        {{ $page }}
                    </span>
                @endif
            @endforeach

            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="inline-flex size-8 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition">
                    <i data-lucide="chevron-right" class="size-4"></i>
                </a>
            @else
                <span class="inline-flex size-8 items-center justify-center rounded-md text-slate-400">
                    <i data-lucide="chevron-right" class="size-4"></i>
                </span>
            @endif
        </div>
    </div>
@endif