@extends('adminlte::page')

@section('title', 'Edit Profile')

@section('content_header')
    <h1>Edit Profile</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Update Profile Information</h3>
        </div>
        <div class="card-body">
            {{-- Show success message --}}
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Profile updated successfully.
                </div>
            @endif

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Profile Update Form --}}
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ auth()->user()->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ auth()->user()->email }}" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password <small>(Leave blank if you don't want to change)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </form>
        </div>
    </div>
@stop
