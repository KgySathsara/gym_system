<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitLife Pro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, rgba(99,102,241,0.9), rgba(76,29,149,0.9)),
                        url('https://images.unsplash.com/photo-1605296867304-46d5465a13f1?auto=format&fit=crop&w=1500&q=80') no-repeat center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            color: #fff;
            animation: fadeIn 1s ease-out;
        }

        .brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            margin: 0 auto 1rem;
            box-shadow: 0 0 20px rgba(255,255,255,0.3);
        }

        .brand h3 {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: #fff;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.3);
        }

        .input-with-icon {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 0.9rem;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none;
            color: #fff;
            padding: 0.75rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99,102,241,0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .login-footer a {
            color: #c7d2fe;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 12px;
            color: #fee2e2;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Password eye toggle */
        .toggle-password {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
            cursor: pointer;
        }

        /* Glass glow animation */
        .login-card:hover {
            box-shadow: 0 0 40px rgba(99,102,241,0.4);
            transition: 0.3s;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">
                <i class="fas fa-dumbbell"></i>
            </div>
            <h3>FitLife Pro</h3>
            <p class="mb-0 opacity-75">Welcome back, please sign in</p>
        </div>

        @if($errors->any())
            <div class="alert p-3 mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i> Invalid credentials! Please try again.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" class="form-control" name="email" placeholder="Email address" required>
            </div>

            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                <span class="toggle-password"><i class="fas fa-eye"></i></span>
            </div>

            <button type="submit" class="btn-login mt-2">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
        </form>

        <div class="login-footer mt-4">
            <p>Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
            <p><a href="#">Forgot password?</a></p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>

</body>
</html>
