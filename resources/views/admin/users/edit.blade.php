@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    @include('admin.components.breadcrumb', [
        'items' => ['Users' => route('admin.users.index'), 'Edit' => null],
    ])

    <h2 class="mb-4">Edit User</h2>

    @include('admin.users.form', [
        'action' => route('admin.users.update', $user),
        'method' => 'PUT',
        'buttonText' => 'Update User',
    ])
@endsection
