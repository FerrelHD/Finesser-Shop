<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Finesser Shop</title>
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
        }

        .login-container {
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

        .logo img {
            width: 120px;
            height: auto;
        }

        .form-floating {
            margin-bottom: 25px;  /* Menambah margin bottom */
            position: relative;
        }

        .form-floating .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            height: 55px;  /* Menambah height */
            padding: 1.5rem 0.75rem 0.5rem;  /* Menyesuaikan padding */
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

        /* Menambahkan style untuk alert */
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
        
        .form-floating .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #0ea5e9;
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.25);
        }

        .form-floating label {
            color: rgba(255, 255, 255, 0.7);
            padding: 1rem 0.75rem;
        }

        .btn-login {
            background: #0ea5e9;
            border: none;
            height: 50px;
            font-weight: 600;
            width: 100%;
            border-radius: 10px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #0284c7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
        }

        .forgot-password {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #0ea5e9;
        }

        .remember-me {
            color: rgba(255, 255, 255, 0.7);
        }

        .remember-me .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .remember-me .form-check-input:checked {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
        }
    </style>
</head>
<body>
    <div class="login-container">
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

        <div class="brand-title">
            <span>Finesser</span> Shop
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="email">Email address</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="remember-me">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
            </div>
            
            <button type="submit" class="btn btn-login btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Log In
            </button>
        </form>
    </div>
</body>
</html>
