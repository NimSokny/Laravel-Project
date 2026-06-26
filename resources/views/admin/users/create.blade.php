@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Users' => route('admin.users.index'), 'Create' => null],
    ])

    <h2 class="mb-4">Create User</h2>

    @include('admin.users.form', [
        'action' => route('admin.users.store'),
        'buttonText' => 'Save User',
    ])
@endsection
