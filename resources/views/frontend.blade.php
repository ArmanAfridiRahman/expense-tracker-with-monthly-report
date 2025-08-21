<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .card {
            max-width: 500px;
            padding: 2rem;
            border-radius: 1rem;
        }
        .btn-custom {
            width: 45%;
        }
    </style>
</head>
<body>
    <div class="card shadow-sm text-center">
        <h2 class="mb-3">Expense Tracker</h2>
        <p class="mb-4">
            Track your daily expenses effortlessly. Add your expenses, categorize them, and visualize your monthly spending with charts.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('login') }}" class="btn btn-primary btn-custom">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-success btn-custom">
                <i class="bi bi-person-plus"></i> Register
            </a>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
