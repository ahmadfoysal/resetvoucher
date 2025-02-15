@extends('adminlte::page')

@section('title', 'Add MikroTik Server')

@section('content_header')
    <h1>Add MikroTik Server</h1>
@stop

@section('content')
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">MikroTik Server Details</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mikrotiks.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Server Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter server name"
                        required>
                </div>

                <div class="form-group">
                    <label for="ip">IP Address</label>
                    <input type="text" name="ip" id="ip" class="form-control" placeholder="Enter IP address"
                        required>
                </div>

                <div class="form-group">
                    <label for="username">MikroTik Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Enter MikroTik username" required>
                </div>

                <div class="form-group">
                    <label for="password">MikroTik Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter MikroTik password" required>
                </div>

                <div class="form-group">
                    <label for="port">API Port</label>
                    <input type="number" name="port" id="port" class="form-control" placeholder="Enter API port"
                        required>
                </div>

                <div class="form-group">
                    <label for="location">Server Location</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Enter location"
                        required>
                </div>

                <div class="form-group">
                    <label for="user_id">Assign to User</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Add Server</button>
                <a href="{{ route('mikrotiks.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Back</a>
            </form>
        </div>
    </div>
@stop
