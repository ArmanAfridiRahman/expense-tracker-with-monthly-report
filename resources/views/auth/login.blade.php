@extends('auth.master')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="card-title mb-4 text-center">Login</h3>
        <form action="{{ route('login') }}" method="POST" id="login-form">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input list="email-suggestions" type="email" name="email" id="email" class="form-control" required>
                <datalist id="email-suggestions">
                    @foreach($emails as $email)
                        <option value="{{ $email }}">
                    @endforeach
                </datalist>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <button type="button" id="fill-random" class="btn btn-outline-secondary btn-sm">
                    🎲 Random User
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-3 text-center">
            <a href="{{ route('register') }}">Register</a> |
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </p>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const randomBtn = document.getElementById("fill-random");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");

        @php
            $dbUsers = \App\Models\User::pluck('email')->toArray();
            $defaultPassword = '12341234'; 
        @endphp

        const users = @json($dbUsers);
        const defaultPassword = @json($defaultPassword);

        randomBtn.addEventListener("click", () => {
            if (users.length === 0) {
                alert("No users found in database.");
                return;
            }

            const randomUser = users[Math.floor(Math.random() * users.length)];
            emailInput.value = randomUser;
            passwordInput.value = defaultPassword;
        });
    });
</script>
@endsection
