@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <h1>Create New User</h1>
@stop

@section('content')
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">User Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                        required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password"
                        required>
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Create User</button>
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
        console.log("Create User Page Loaded");
    </script>
@stop
