@extends('adminlte::page')

@section('title', 'Edit MikroTik Server')

@section('content_header')
    <h1>Edit MikroTik Server</h1>
@stop

@section('content')
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Update Server Information</h3>
        </div>
        <div class="card-body">

            {{-- Show error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('mikrotiks.update', $mikrotik->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Server Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $mikrotik->name }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="ip">IP Address</label>
                    <input type="text" name="ip" id="ip" class="form-control" value="{{ $mikrotik->ip }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="username">MikroTik Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        value="{{ $mikrotik->username }}" required>
                </div>

                <div class="form-group">
                    <label for="password">MikroTik Password (Leave blank to keep current password)</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter new password">
                </div>

                <div class="form-group">
                    <label for="port">API Port</label>
                    <input type="number" name="port" id="port" class="form-control" value="{{ $mikrotik->port }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="location">Server Location</label>
                    <input type="text" name="location" id="location" class="form-control"
                        value="{{ $mikrotik->location }}">
                </div>

                <div class="form-group">
                    <label for="user_id">Assign to User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $mikrotik->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Server</button>
                <a href="{{ route('mikrotiks.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Back</a>
            </form>
        </div>
    </div>
@stop
