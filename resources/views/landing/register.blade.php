<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - KANUN-I</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a4d68 0%, #0d6b8f 100%);
            padding: 40px 20px;
        }
        
        .auth-box {
            background: white;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        @media (max-width: 768px) {
            .auth-box {
                padding: 15px;
            }
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .auth-logo {
            font-size: 32px;
            font-weight: 700;
            color: #0a4d68;
            margin-bottom: 8px;
        }
        
        .auth-title {
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .auth-subtitle {
            font-size: 14px;
            color: #6b7280;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #0a4d68;
        }
        
        .form-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #0a4d68;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .btn-submit:hover {
            background: #0d6b8f;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }
        
        .auth-footer a {
            color: #0a4d68;
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .back-link:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div style="position: absolute; top: 20px; left: 20px;" class="mb-5">
            <a href="{{ route('landing') }}" class="back-link">← Ana Sayfaya Dön</a>
        </div>
        
        <div class="auth-box">
            <div class="auth-header">
                <div class="auth-logo mb-5"><img src="{{ asset('logo.png') }}" alt="Kanun-i Logo" class="logo-img" style="max-height: 50px; "></div>
                <h1 class="auth-title">Hesap Oluştur</h1>
                <p class="auth-subtitle">Hukuki sorularınıza hızlı yanıt almak için kayıt olun</p>
            </div>
            
            @if ($errors->any())
                <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        placeholder="Adınız ve soyadınız"
                    >
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">E-posta</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input"
                                value="{{ old('email') }}"
                                required
                                placeholder="ornek@email.com"
                            >
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Telefon</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-input"
                                value="{{ old('phone') }}"
                                placeholder="+90 555 123 45 67"
                            >
                            @error('phone')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Şifre</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input"
                        required
                        placeholder="En az 8 karakter"
                    >
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input"
                        required
                        placeholder="Şifrenizi tekrar girin"
                    >
                </div>
                
                <button type="submit" class="btn-submit">
                    Kayıt Ol
                </button>
            </form>
            
            <div class="auth-footer">
                Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

