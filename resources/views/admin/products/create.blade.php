@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Products' => route('admin.products.index'), 'Create' => null],
    ])

    <h2 class="mb-4">Create Product</h2>

    @include('admin.products.form', [
        'action' => route('admin.products.store'),
        'buttonText' => 'Save Product',
    ])
@endsection
