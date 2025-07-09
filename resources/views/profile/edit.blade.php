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

    {{-- <div class="card card-success card-outline">
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

            <!-- WhatsApp Number Form -->

            <form action="{{ route('whatsapp.send.otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="whatsapp_number">WhatsApp Number</label>
                    <div class="input-group">
                        <!-- Country Code Dropdown -->
                        <div class="input-group-prepend" style="flex: 0 0 25%; max-width: 25%;">
                            <select name="country_code" class="form-control">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->dial_code }}">
                                        {{ $country->dial_code }} ({{ $country->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Phone Number Input -->
                        <input type="text" name="local_number" id="local_number" class="form-control"
                            placeholder="Enter number without country code"
                            value="{{ auth()->user()->phone?->phone ?? '' }}" required>

                        <!-- Send OTP Button -->
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send
                                OTP</button>
                        </div>
                    </div>
                </div>
            </form>



            <hr>

            <!-- OTP Verification Form (Hidden by Default) -->
            @if (session('whatsapp_otp'))
                <form action="{{ route('whatsapp.verify.otp') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <div class="input-group">
                            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP"
                                required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Verify
                                    OTP</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div> --}}

@stop
