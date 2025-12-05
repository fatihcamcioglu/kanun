<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Müşteri Paneli') - Kanun-i</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9fafb;
            color: #1f2937;
        }
        .header {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0;
        }
        .header-top {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }
        .logo {
            color: #f59e0b;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .logo img {
            max-height: 50px;
            height: auto;
            width: auto;
            display: block;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-name {
            color: #6b7280;
            font-size: 14px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-logout {
            background: #ef4444;
            color: white;
        }
        .btn-logout:hover {
            background: #dc2626;
        }
        .btn-primary {
            background: #f59e0b;
            color: white;
        }
        .btn-primary:hover {
            background: #d97706;
        }
        .nav-menu {
            background: white;
            padding: 0 40px;
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #e5e7eb;
        }
        .nav-item {
            padding: 16px 0;
            text-decoration: none;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        .nav-item:hover,
        .nav-item.active {
            color: #f59e0b;
            border-bottom-color: #f59e0b;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .page-header h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="header">
        <div class="header-top">
            <a href="{{ route('customer.dashboard') }}" class="logo">
                <img src="{{ asset('logo.png') }}" alt="Kanun-i Logo" style="max-height: 50px; height: auto;">
            </a>
            <div class="user-menu">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('customer.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout">Çıkış Yap</button>
                </form>
            </div>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('customer.dashboard') }}" class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('customer.packages.index') }}" class="nav-item {{ request()->routeIs('customer.packages.*') ? 'active' : '' }}">
                Paketler
            </a>
            <a href="{{ route('customer.questions.index') }}" class="nav-item {{ request()->routeIs('customer.questions.*') ? 'active' : '' }}">
                Sorularım
            </a>
            <a href="{{ route('customer.questions.create') }}" class="nav-item {{ request()->routeIs('customer.questions.create') ? 'active' : '' }}">
                Soru Sor
            </a>
            <a href="{{ route('customer.faqs.index') }}" class="nav-item {{ request()->routeIs('customer.faqs.*') ? 'active' : '' }}">
                SSS
            </a>
            <a href="{{ route('customer.videos.index') }}" class="nav-item {{ request()->routeIs('customer.videos.*') ? 'active' : '' }}">
                Videolar
            </a>
        </nav>
    </div>

    <div class="container">
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>

