@extends('auth.master')

@section('title', 'Forgot Password')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="card-title mb-4 text-center">Forgot Password</h3>
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Enter your email address</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <p class="mt-3 text-center">
            Remember your password? <a href="{{ route('login') }}">Sign In</a>
        </p>
    </div>
</div>
@endsection
