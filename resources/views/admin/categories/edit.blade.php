@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    @include('admin.components.breadcrumb', ['items' => ['Categories' => route('admin.categories.index'), 'Edit' => null]])
    <h2 class="mb-4">Edit Category</h2>

    @include('admin.categories.form', [
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'buttonText' => 'Update Category',
        'category' => $category,
    ])
@endsection
