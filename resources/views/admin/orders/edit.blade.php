@extends('admin.layouts.app')

@section('title', 'Edit Order')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 font-accent">Edit Order</h1>
        <p class="mt-2 text-slate-600">Update order information</p>
    </div>

    <div class="mx-auto max-w-3xl">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-800">Order No.</label>
                    <input type="text" class="mt-2 min-h-11 w-full rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500" value="{{ $order->order_number }}" disabled>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="payment_status" class="block text-sm font-semibold text-slate-800">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('payment_status') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror" required>
                            @foreach (['Pending', 'Paid', 'Failed', 'Refund'] as $status)
                                <option value="{{ $status }}" @selected(old('payment_status', $order->payment_status) === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order_status" class="block text-sm font-semibold text-slate-800">Order Status</label>
                        <select id="order_status" name="order_status" class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('order_status') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror" required>
                            @foreach (['Pending', 'Processing', 'Shipping', 'Delivered', 'Cancelled'] as $status)
                                <option value="{{ $status }}" @selected(old('order_status', $order->order_status) === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('order_status')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="shipping_address" class="block text-sm font-semibold text-slate-800">Shipping Address</label>
                    <textarea
                        id="shipping_address"
                        name="shipping_address"
                        class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-cyan-700 focus:ring-2 focus:ring-cyan-700/15 @error('shipping_address') border-rose-500 focus:border-rose-500 focus:ring-rose-500/15 @enderror"
                        rows="4"
                        required
                        placeholder="Enter shipping address"
                    >{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    @error('shipping_address')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        <i data-lucide="save" class="size-4"></i>
                        Update Order
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:border-slate-950 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
