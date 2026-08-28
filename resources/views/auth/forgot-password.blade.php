<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Finesser Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .forgot-password-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .brand-title {
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .brand-title span {
            color: #0ea5e9;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 120px;
            height: auto;
        }

        .form-floating {
            margin-bottom: 25px;
            position: relative;
        }

        .form-floating .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            height: 55px;
            padding: 1.5rem 0.75rem 0.5rem;
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem;
            height: 100%;
            transform-origin: 0 0;
            transition: opacity .15s ease-in-out, transform .15s ease-in-out;
        }

        .form-floating .form-control:focus + label,
        .form-floating .form-control:not(:placeholder-shown) + label {
            transform: scale(0.85) translateY(-0.5rem);
            opacity: 0.65;
        }

        .alert {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: none;
            color: #fff;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border-left: 4px solid #ef4444;
        }

        .description {
            color: #fff;
            opacity: 0.8;
            text-align: center;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .btn-reset {
            background: #0ea5e9;
            color: #fff;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: #0284c7;
            transform: translateY(-2px);
        }

        .login-link {
            display: block;
            text-align: center;
            color: #fff;
            opacity: 0.8;
            margin-top: 20px;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .login-link:hover {
            opacity: 1;
            color: #0ea5e9;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <h1 class="brand-title">Reset <span>Password</span></h1>
        
        <p class="description">Masukkan email Anda untuk menerima link reset password</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <label for="email">Email</label>
            </div>

            <button type="submit" class="btn btn-reset">
                <i class="fas fa-paper-plane me-2"></i>Kirim Link Reset Password
            </button>

            <a href="{{ route('login') }}" class="login-link">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke halaman login
            </a>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
