@extends('admin.layouts.app')

@section('title', 'Create Brand')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Brands' => route('admin.brands.index'), 'Create' => null],
    ])

    <h2 class="mb-4">Create Brand</h2>

    @include('admin.brands.form', [
        'action' => route('admin.brands.store'),
        'buttonText' => 'Save Brand',
    ])
@endsection
