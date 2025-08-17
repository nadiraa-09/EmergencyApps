<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Evacuation Attendance Record</title>

    <link rel="shortcut icon" href="{{ asset('yokogawa.ico') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-icons/bootstrap-icons.css') }}">
</head>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        {{-- Full width content wrapper --}}
        <div class="content-wrapper" style="margin-left:0;">
            @yield('container')
        </div>

        <footer class="main-footer">
            <strong>Yokogawa Manufacturing Batam &copy; 2025</strong>
            All rights reserved.
        </footer>

    </div>

    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/dist/js/adminlte.js') }}"></script>
    @yield('scripts')
</body>

</html>