@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Brands' => route('admin.brands.index'), 'Edit' => null],
    ])

    <h2 class="mb-4">Edit Brand</h2>

    @include('admin.brands.form', [
        'action' => route('admin.brands.update', $brand),
        'method' => 'PUT',
        'buttonText' => 'Update Brand',
    ])
@endsection
