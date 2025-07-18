<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JobRich</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('assets/logo/logo-job-rich.png')}}" type="image/x-icon">
    <style>
        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOutLeft {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-100%);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(100%);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.5s forwards;
        }

        .slide-out-left {
            animation: slideOutLeft 0.5s forwards;
        }

        .slide-in-right {
            animation: slideInRight 0.5s forwards;
        }

        .slide-out-right {
            animation: slideOutRight 0.5s forwards;
        }

        .bg-overlay {
            background: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body class="d-flex flex-column flex-lg-row h-100 bg-light overflow-hidden">

    <div id="backgroundContainer"
        class="col-lg-6 d-flex align-items-center justify-content-center text-white slide-in-left position-relative">
        <img src="{{asset('assets/logo/logo-job-rich.png')}}" alt="Background"
            class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
    </div>

    <div id="formContainer"
        class="col-lg-6 d-flex align-items-center justify-content-center vh-100 bg-white slide-in-right position-relative">
        <div class="w-100" style="max-width: 400px;">
            <div class="position-absolute top-0 end-0 mt-3 me-3">
                <a href="" class="btn btn-primary rounded-pill">Home</a>
            </div>

            <div>
                <h2 class="text-center fs-3 fw-semibold text-secondary">Login</h2>
                <p class="text-center text-muted">Selamat Datang di JobRich</p>
                <form form method="POST" action="{{ route('login') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="email@example.com" value="{{ old('email') }}" autofocus>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="********">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-muted" for="rememberMe">Remember Me</label>
                        </div>
                        <a href="#" class="text-danger text-decoration-none">Forgot Password?</a>
                    </div>
                    <button class="btn btn-primary w-100 fw-semibold">Login</button>
                </form>
                <p class="text-center mt-4 text-muted">Belum memiliki akun ?
                    <a href="{{route('register')}}"
                        class="btn btn-link text-primary text-decoration-none">Register</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>