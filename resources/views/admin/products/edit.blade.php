@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Products' => route('admin.products.index'), 'Edit' => null],
    ])

    <h2 class="mb-4">Edit Product</h2>

    @include('admin.products.form', [
        'action' => route('admin.products.update', $product),
        'method' => 'PUT',
        'buttonText' => 'Update Product',
    ])
@endsection
