@extends('layouts.app')

@section('title','Change Password')

@section('content')

<form action="{{ route('profile.update_password') }}" method="POST">

    @csrf
    @method('PATCH')

    <h2 class="h3 fw-light text-muted">Change Password</h2>

    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" name="current_password" id="current_password" class="form-control">
        @if (session('current_password_error'))
        <p class="text-danger small">{{ session('current_password_error') }}</p>

        @endif
    </div>

    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" name="new_password" id="new_password" class="form-control" aria-describedby="password-info">
        <div class="form-text" id="password-info">
            Your password must be least 8 characters long, and contain letters and numbers
        </div>
        @if (session('new_password_error'))
        <p class="text-danger small">{{ session('new_password_error') }}</p>

        @endif
        @error('new_password')
        <p class="text-danger small">{{ $message }}</p>

        @enderror
    </div>


    <div class="mb-3">
        <label for="new_password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
        @if (session('success_password'))
        <p class="text-success small">{{ session('success_password') }}</p>

        @endif
    </div>
    <button type="submit" class="btn btn-warning px-5">Update Password</button>
</form>

@endsection
