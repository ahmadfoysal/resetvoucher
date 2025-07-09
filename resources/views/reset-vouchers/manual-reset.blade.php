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
    <div class="card card-primary card-outline mt-4">
        <div class="card-header">
            <h3 class="card-title">Manual Voucher Reset</h3>
        </div>

        <div class="card-body">
            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form start --}}
            <form action="{{ route('vouchers.reset') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="mikrotik_id">Select MikroTik Server</label>
                    <select name="mikrotik_id" id="mikrotik_id" class="form-control select2" required>
                        <option value="">-- Select MikroTik --</option>
                        @foreach ($mikrotiks as $mikrotik)
                            <option value="{{ $mikrotik->id }}" {{ old('mikrotik_id') == $mikrotik->id ? 'selected' : '' }}>
                                {{ $mikrotik->name }} ({{ $mikrotik->ip }})
                            </option>
                        @endforeach
                    </select>
                    @error('mikrotik_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="voucher_code">Voucher Code</label>
                    <input type="text" name="voucher_code" id="voucher_code" class="form-control"
                        placeholder="Enter voucher code" value="{{ old('voucher_code') }}" required>
                    @error('voucher_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-undo"></i> Reset Voucher
                </button>
            </form>
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
            // // Initialize Select2 with event listener
            // $('#mikrotik_id').select2({
            //     placeholder: "Select a MikroTik Server",
            //     allowClear: true,
            //     width: '100%'
            // }).on('change', function() {
            //     let mikrotikId = $(this).val();
            //     if (mikrotikId) {
            //         window.location.href = "{{ url('/hotspot-users') }}/" + mikrotikId;
            //     }
            // });

            // Initialize DataTable only if table exists
            // if ($('#hotspotUsersTable').length) {
            //     $('#hotspotUsersTable').DataTable({
            //         responsive: true,
            //         autoWidth: false
            //     });
            // }

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
