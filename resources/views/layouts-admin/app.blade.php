<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/icon-logo-150.png') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('img/icon-logo-300.png') }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset('img/icon-logo-300.png') }}" sizes="192x192">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/vendor-admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/vendor-admin/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/vendor-admin/sweetalert/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.toast.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style-admin.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom Script -->
    @stack('styles')

</head>

<body>
    <div id="toast-container"></div>
    <div id="progress-overlay" class="progress-overlay" style="display: none;">
        <div class="text-center spinner-border text-primary progress" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @include('layouts-admin.header')
    @include('layouts-admin.sidebar')
    @yield('content')
    @include('layouts-admin.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.toast.min.js') }}"></script>
    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/vendor-admin/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/vendor-admin/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendor/vendor-admin/sweetalert/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('vendor/vendor-admin/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <!-- Custom Script -->
    @stack('scripts')
</body>

</html>