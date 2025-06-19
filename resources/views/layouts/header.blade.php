<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emergency Apps | @yield('titlepage')</title>

    {{-- <link rel=”icon” href=yokogawa.ico”> --}}
    <link rel="shortcut icon" href="{{ asset('yokogawa.ico') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/toast.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Emergency Apps</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        {{-- <small class="d-block text-center"><a href="#"> {{ Auth::user()->username }}</a></small> --}}
                        <small class="d-block"><a href="#"> {{ Auth::user()->username }} -
                                {{ Auth::user()->role->name }}</a></small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    @if (Auth::user()->inactive !== '1')
                    @dd('error')
                    @else
                    @include('layouts.menu')
                    @endif
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('titlepage')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">{{ $menu }}</a></li>
                                <li class="breadcrumb-item active">@yield('titlepage')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @yield('container')

            <!-- jQuery -->
            <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
            <!-- Jquery Validation  -->
            <script src="{{ asset('/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
            <!-- jQuery UI 1.11.4 -->
            <script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
            <script>
                $.widget.bridge('uibutton', $.ui.button)
            </script>
            <!-- Bootstrap 4 -->
            <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- DataTables  & Plugins -->
            <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('/plugins/jszip/jszip.min.js') }}"></script>
            <script src="{{ asset('/plugins/pdfmake/pdfmake.min.js') }}"></script>
            <script src="{{ asset('/plugins/pdfmake/vfs_fonts.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
            <!-- overlayScrollbars -->
            <script src="{{ asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('/dist/js/adminlte.js') }}"></script>
            <!-- SweetAlert  -->
            <script src="{{ asset('/plugins/sweetalert2/sweetalert2.js') }}"></script>
            <!-- Custom JS  -->
            <script src="{{ asset('/dist/js/general.js') }}"></script>
            <script src="{{ asset('/dist/js/toast.js') }}"></script>


            @yield('scripts')
        </div>
        <footer class="main-footer">
            <strong>Yokogawa Manufacturing Batam &copy; 2023</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    </script>
</body>

</html>