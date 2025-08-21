<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title', 'Dashboard')</title>
     <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
     <link rel="stylesheet" href="{{ asset('assets/css/toaster.css') }}">
     @stack('custom-css')
</head>
<body>
     @include('user.partials.topbar')

     <div class="container mt-4">
          @include('partials.toaster')
          @yield('content')
     </div>

     <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
     <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('assets/js/toaster.js') }}"></script>

     @stack('custom-js')
</body>
</html>
