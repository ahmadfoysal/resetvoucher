@extends('adminlte::page')

@section('title', 'Reset Voucher')

@section('content_header')
    <h1>Reset Voucher</h1>
@stop

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
                    <select name="mikrotik_id" id="mikrotik_id" class="form-control" required>
                        <option value="">-- Select MikroTik --</option>
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
    <script>
        $(document).ready(function() {
            $('#mikrotik_id').on('change', function() {
                $('#mikrotik_id_toggle').val($(this).val());
            });

            $('#voucher_code').on('input', function() {
                $('#voucher_code_toggle').val($(this).val());
            });
        });
    </script>
@stop
