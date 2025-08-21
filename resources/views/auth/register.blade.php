@extends('auth.master')

@section('title', 'Register')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="card-title mb-4 text-center">Register</h3>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>
        <p class="mt-3 text-center">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </p>
    </div>
</div>
@endsection
