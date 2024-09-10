<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Dashboard - LMS</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/css/public-sans.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/boxicons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"/>
{{--    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap4.min.css') }}"/>--}}

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}"/>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>--}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset("plugins/toastr/toastr.min.css") }}">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset("plugins/toastr/toastr.min.js")  }}"></script>
    @yield('header-resources')
</head>

<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">

    <div class="layout-container">
        @include('layouts.navigation.sidebar')

        <div class="layout-page">
            @include('layouts.navigation.navbar')
            <div class="content-wrapper">
                <div>
                     @yield('body')
                </div>
                <div class="content-backdrop fade"></div>

            </div>
            @include('layouts.footer')

        </div>
    </div>


    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

</div>
<!-- / Layout wrapper -->


<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>


@yield('footer-script')
</body>
</html>
