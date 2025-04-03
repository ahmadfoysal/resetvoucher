@extends('adminlte::page')

@section('title', 'Verify WhatsApp')

@section('content_header')
    <h1>Verify Your WhatsApp</h1>
@stop

@section('content')
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">WhatsApp Verification</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('whatsapp.send.otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="whatsapp_number">WhatsApp Number</label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control"
                        placeholder="Enter WhatsApp number" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send OTP</button>
            </form>

            <hr>

            <form action="{{ route('whatsapp.verify.otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP"
                        required>
                </div>

                <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Verify OTP</button>
            </form>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>
@stop

@section('css')
    {{-- Additional Styles --}}
@stop

@section('js')
    <script>
        console.log("WhatsApp Verification Page Loaded");
    </script>
@stop
