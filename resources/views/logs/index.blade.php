@extends('adminlte::page')

@section('title', 'System Logs')

@section('content_header')
    <h1>System Logs</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Activity Logs</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="logTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>MikroTik</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->user->name ?? 'N/A' }}</td>
                                <td>{{ $log->mikrotik->name ?? 'N/A' }}</td>
                                <td><span class="badge badge-info">{{ $log->action }}</span></td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
@stop

@section('js')
    {{-- jQuery and DataTables --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#logTable').DataTable({
                responsive: true
            });
        });
    </script>
@stop
