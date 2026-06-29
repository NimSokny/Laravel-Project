@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
    @include('admin.components.breadcrumb', ['items' => ['Categories' => route('admin.categories.index'), 'Create' => null]])
    <h2 class="mb-4">Create Category</h2>

    @include('admin.categories.form', [
        'action' => route('admin.categories.store'),
        'buttonText' => 'Save Category',
    ])
@endsection
