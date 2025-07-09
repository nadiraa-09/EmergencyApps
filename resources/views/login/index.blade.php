<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YMB | Evacuation Attendance Record</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.css') }}">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card shadow-lg border-0 rounded-4">
            <!-- Header -->
            <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                <a href="/login" class="h1 text-white text-decoration-none">
                    <b>Login</b> Form
                </a>
                <p class="mt-2 mb-0 fw-light fs-6">Evacuation Attendance Record</p>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <p class="login-box-msg text-muted mb-4">Please login first to start your session</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            placeholder="No Badge"
                            required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-badge"></span>
                            </div>
                        </div>
                        @error('username')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-4">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </div>

                    <!-- Optional Register Link -->
                    <!--
                <small class="d-block text-center mt-3">
                    Not Registered? <a href="/register">Register Now!</a>
                </small>
                -->
                </form>
            </div>
        </div>
    </div>

    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{ asset('/plugins/sweetalert2/sweetalert2.js') }}"></script>

</body>

</html>