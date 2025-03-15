@extends('adminlte::page')

@section('title', 'Manage Hotspot Users')

@push('css')
    <!-- Toastr & Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    <div class="card card-primary card-outline mt-3">
        {{-- Card Header --}}
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h3 class="card-title">Hotspot Users</h3>

            {{-- MikroTik Selection Form (Redirects to GET route) --}}
            <div class="col-12 col-md-3">
                <select name="mikrotik_id" id="mikrotik_id" class="form-control select2" required>
                    <option value="">-- Select MikroTik --</option>
                    @foreach ($mikrotiks as $mikrotik)
                        <option value="{{ $mikrotik->id }}"
                            {{ isset($mikrotik_id) && $mikrotik_id == $mikrotik->id ? 'selected' : '' }}>
                            {{ $mikrotik->name }} ({{ $mikrotik->ip }})
                        </option>
                    @endforeach
                </select>
            </div>


        </div>

        <div class="card-body">
            {{-- Show Table Only If MikroTik is Selected --}}
            @if (!empty($hotspotUsers))
                <div class="table-responsive">
                    <table id="hotspotUsersTable" class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Profile</th>
                                <th>MAC Address</th>
                                <th>Uptime</th>
                                <th>Bytes In</th>
                                <th>Bytes Out</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                function formatBytes($bytes, $precision = 2)
                                {
                                    $units = ['Bytes', 'KiB', 'MiB', 'GiB', 'TiB'];
                                    $index = 0;

                                    while ($bytes >= 1024 && $index < count($units) - 1) {
                                        $bytes /= 1024;
                                        $index++;
                                    }

                                    return round($bytes, $precision) . ' ' . $units[$index];
                                }
                            @endphp

                            @foreach ($hotspotUsers as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['profile'] ?? 'N/A' }}</td>
                                    <td>{{ $user['mac-address'] ?? 'N/A' }}</td>
                                    <td>{{ $user['uptime'] ?? 'N/A' }}</td>
                                    <td>{{ isset($user['bytes-in']) ? formatBytes($user['bytes-in']) : 'N/A' }}</td>
                                    <td>{{ isset($user['bytes-out']) ? formatBytes($user['bytes-out']) : 'N/A' }}</td>

                                    <td>{{ $user['comment'] ?? 'N/A' }}</td>
                                    <td>
                                        {{-- Reset Voucher Button --}}
                                        <form action="{{ route('vouchers.reset', ['mikrotik_id' => $mikrotik_id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="voucher_code" value="{{ $user['name'] }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Reset Voucher">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>

                                        {{-- Enable/Disable Voucher Button --}}
                                        <form action="{{ route('vouchers.toggle', ['mikrotik_id' => $mikrotik_id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="voucher_code" value="{{ $user['name'] }}">

                                            @php
                                                $isEnabled = isset($user['disabled']) && $user['disabled'] == 'false';
                                            @endphp

                                            <button type="submit"
                                                class="btn btn-sm {{ $isEnabled ? 'btn-success' : 'btn-secondary' }}"
                                                title="{{ $isEnabled ? 'Disable' : 'Enable' }}">
                                                <i class="fas fa-toggle-{{ $isEnabled ? 'on' : 'off' }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop

@push('js')
    <!-- jQuery, Toastr, Select2, DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 with event listener
            $('#mikrotik_id').select2({
                placeholder: "Select a MikroTik Server",
                allowClear: true,
                width: '100%'
            }).on('change', function() {
                let mikrotikId = $(this).val();
                if (mikrotikId) {
                    window.location.href = "{{ url('/hotspot-users') }}/" + mikrotikId;
                }
            });

            // Initialize DataTable only if table exists
            if ($('#hotspotUsersTable').length) {
                $('#hotspotUsersTable').DataTable({
                    responsive: true,
                    autoWidth: false
                });
            }

            // Toastr Notifications
            toastr.options = {
                closeButton: true,
                progressBar: true,
                timeOut: 3000
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
            @endif
        });
    </script>
@endpush
