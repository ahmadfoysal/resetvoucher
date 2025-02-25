@extends('adminlte::page')

@section('title', 'Reset Voucher')

@section('content_header')
    <h1>Reset Voucher</h1>
@stop

@push('css')
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title">Reset or Enable/Disable Hotspot Voucher</h3>
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

            {{-- Reset Voucher Form --}}
            <form action="{{ route('vouchers.reset') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="mikrotik_id">Select MikroTik Server</label>
                    <select name="mikrotik_id" id="mikrotik_id" class="form-control select2 select2-hidden-accessible"
                        style="width: 100%;" required>
                        <option value="" selected>-- Select MikroTik --</option>
                        @foreach ($mikrotiks as $mikrotik)
                            <option value="{{ $mikrotik->id }}">{{ $mikrotik->name }} ({{ $mikrotik->ip }})</option>
                        @endforeach
                    </select>
                </div>



                <div class="form-group">
                    <label for="voucher_code">Voucher Code</label>
                    <input type="text" name="voucher_code" id="voucher_code" class="form-control"
                        placeholder="Enter voucher code" required>
                </div>

                <div class="d-flex">
                    {{-- Reset Voucher Button --}}
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-undo"></i> Reset Voucher
                    </button>
                </div>
            </form>

            {{-- Separate the Forms --}}
            <hr>

            {{-- Enable/Disable Voucher Form --}}
            <form action="{{ route('vouchers.toggle') }}" method="POST">
                @csrf
                <input type="hidden" name="mikrotik_id" id="mikrotik_id_toggle">
                <input type="hidden" name="voucher_code" id="voucher_code_toggle">

                <div class="d-flex">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-toggle-on"></i> Enable/Disable Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <!-- jQuery, Toastr & Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for MikroTik server select box
            $('#mikrotik_id').select2({
                placeholder: "Type to search...",
                allowClear: true,
                width: '100%'
            });

            // Toastr options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "40000",
            }

            // Show multiple success messages
            @if (session()->has('success_messages'))
                @foreach (session('success_messages') as $message)
                    toastr.success("{{ $message }}");
                @endforeach
            @endif

            // Show multiple error messages
            @if (session()->has('error_messages'))
                @foreach (session('error_messages') as $message)
                    toastr.error("{{ $message }}");
                @endforeach
            @endif

            // Toastr notifications
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

            // Synchronize values between select and hidden inputs
            $('#mikrotik_id').on('change', function() {
                $('#mikrotik_id_toggle').val($(this).val());
            });

            $('#voucher_code').on('input', function() {
                $('#voucher_code_toggle').val($(this).val());
            });
        });
    </script>
@stop
