@extends('adminlte::page')

@section('title', 'MikroTik Servers')

@section('content_header')
    <h1>MikroTik Server Management</h1>
@stop

@section('content')
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">List of MikroTik Servers</h3>
            <div class="float-right">
                <a href="{{ route('mikrotiks.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add Server
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="mikrotikTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Server Name</th>
                            <th>IP Address</th>
                            <th>Location</th>
                            <th>Assigned User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mikrotiks as $mikrotik)
                            <tr>
                                <td>{{ $mikrotik->name }}</td>
                                <td>{{ $mikrotik->ip }}</td>
                                <td>{{ $mikrotik->location }}</td>
                                <td>{{ $mikrotik->user->name ?? 'Unassigned' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('mikrotiks.edit', $mikrotik->id) }}"
                                        class="btn btn-sm btn-primary mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('mikrotiks.destroy', $mikrotik->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
