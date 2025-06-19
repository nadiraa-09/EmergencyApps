<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YMB | System</title>

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

<style>
    body {
        background: #f4f6f9;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .login-box {
        width: 100%;
        max-width: 500px;
    }

    .card-header a {
        font-size: 2rem;
        text-decoration: none;
        color: white;
    }

    .login-box-msg {
        font-size: 1.1rem;
        margin-bottom: 25px;
        text-align: center;
    }

    .form-control {
        height: 50px;
        font-size: 1rem;
    }

    .input-group-text {
        height: 50px;
        font-size: 1rem;
    }

    .invalid-feedback {
        display: block;
        color: red;
    }

    @media (max-width: 576px) {
        .card-header a {
            font-size: 1.5rem;
        }

        .form-control,
        .input-group-text {
            height: 45px;
            font-size: 0.9rem;
        }
    }
</style>

<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="login-box">
        <div class="card border-primary shadow">
            <div class="card-header bg-success text-center">
                <a href="#" class="h1">Emergency Record<b> OUT</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Please tap your Badge Id</p>
                <form action="{{ route('recordout') }}" method="POST" id="recordForm">
                    @csrf
                    <div class="mb-3 input-group">
                        <input type="text" name="cardid" id="cardid" class="form-control" placeholder="BadgeId" require autofocus>
                        <span class="input-group-text">
                            <i class="fas fa-id-badge"></i>
                        </span>
                    </div>
                    @error('cardid')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
    <!-- SweetAlert -->
    <script src="{{ asset('/plugins/sweetalert2/sweetalert2.js') }}"></script>

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('cardid');
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('recordForm').submit();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Success Toast
        @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        @endif

        // Custom Error Toast
        @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        @endif
    });
</script>

</html>