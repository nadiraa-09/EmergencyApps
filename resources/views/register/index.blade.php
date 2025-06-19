<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>YMB System</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <h1 class="h3 mb-3 fw-normal">Registration Form</h1>
        <form action="/register" method="POST">
            @csrf
            <div class="form-floating">
                <input type="text" name="username"
                    class="form-control rounded-top @error('username') is-invalid @enderror" id="username"
                    placeholder="Username" required value="{{ old('username') }}">
                <label for="username">Username</label>
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="text" name="name"
                    class="form-control rounded-top @error('name') is-invalid @enderror" id="name"
                    placeholder="Name" required value="{{ old('name') }}">
                <label for="name">Name</label>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" name="email"
                    class="form-control rounded-top @error('email') is-invalid @enderror" id="email"
                    placeholder="Email" required value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password"
                    class="form-control rounded-top @error('password') is-invalid @enderror" id="password"
                    placeholder="Password" required>
                <label for="password">Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
            <small class="d-block text-center mt-3">Already Registered? <a href="/login"> Login Now!</a></small>
        </form>
    </main>
</body>

</html>
