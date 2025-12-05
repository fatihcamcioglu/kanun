<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Kanun-i</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h1 {
            color: #f59e0b;
            font-size: 32px;
            font-weight: 700;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .form-group input:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .remember-me input {
            width: auto;
            margin-right: 8px;
        }
        .remember-me label {
            margin: 0;
            font-weight: 400;
            font-size: 14px;
            color: #6b7280;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .btn-login:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .admin-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .admin-link a {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }
        .admin-link a:hover {
            color: #f59e0b;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Kanun-i</h1>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('customer.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-posta</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="ornek@email.com"
                >
            </div>

            <div class="form-group">
                <label for="password">Şifre</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    placeholder="••••••••"
                >
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Beni hatırla</label>
            </div>

            <button type="submit" class="btn-login">
                Giriş Yap
            </button>
        </form>

        <div class="admin-link">
            <a href="{{ route('filament.admin.auth.login') }}">Admin Paneli</a>
        </div>
    </div>
</body>
</html>

