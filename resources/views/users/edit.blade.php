@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Update User Information</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">New Password (Leave blank to keep current password)</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter new password">
                </div>

                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Additional Styles --}}
@stop

@section('js')
    <script>
        console.log("Edit User Page Loaded");
    </script>
@stop
