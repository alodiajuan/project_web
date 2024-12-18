<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KOMPEN - Login</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        .login-page {
            background: linear-gradient(135deg, #6366F1 0%, #8dcbff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* .login-box {
           min-width: 400px;
       }  */



        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .card-outline.card-primary {
            border-top: 3px solid #000000;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #e2e8f0;
            padding: 5px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            border-color: #6366F1;
        }

        .btn-primary {
            background: linear-gradient(to right, #6366F1, #2563EB);
            border: none;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #4F46E5, #1D4ED8);
            transform: translateY(-1px);
            box-shadow: 0 6px 8px rgba(37, 99, 235, 0.3);
        }

        .input-group-text {
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .card-header h1 {
            background: linear-gradient(45deg, #6366F1, #000000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            margin-bottom: 0;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background: transparent;
            border-left: none;
        }

        .form-control {
            border-right: none;
        }

        .card-body {
            padding: 2rem;
        }

        .icheck-primary label {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1><b>KOMPEN</b></h1>
                <p class="mb-0">Jurusan Teknologi Informasi</p>
            </div>
            <div class="card-body">

                <form action="/login" method="POST" id="form-login">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username" required class="form-control"
                            placeholder="NIP/NIM">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                        <small id="error-username" class="error-text text-danger"></small>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" required class="form-control"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small id="error-password" class="error-text text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
