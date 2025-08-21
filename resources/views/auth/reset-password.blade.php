@extends('auth.master')

@section('title', 'Reset Password')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="card-title mb-4 text-center">Reset Password</h3>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $email ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Reset Password</button>
        </form>
        <p class="mt-3 text-center">
            Remembered your password? <a href="{{ route('login') }}">Sign In</a>
        </p>
    </div>
</div>
@endsection
