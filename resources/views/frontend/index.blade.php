<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>GUB - @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('frontend.styles')
    @yield('styles')
</head>

<body>

    @yield('content')
    
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    @yield('scripts')
    @include('frontend.scripts')
</body>

</html>
