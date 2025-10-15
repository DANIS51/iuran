<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    {{-- Bootstrap Offline --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #1e2140;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #0d6efd;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
        }

        footer {
            background-color: #1e2140;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-center mb-4">Admin Panel</h4>
        <a href="{{ route('admin.dashboard')  }}" class="{{ request()->is('admin/dashboard*')  ? 'active' : ''}}">Dashboard</a>
        <a href="{{ route('warga.index') }}" class="{{ request()->is('admin/warga*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data Warga
        </a>
        <a href="{{ route('iuran.index') }}" class="{{ request()->is ('admin/iuran*') ? 'active' : ''}}">Iuran</a>
        <a href="{{ route('pembayaran.index') }}" class="{{ request()->is ('admin/pembayaran*') ? 'active' : ''}}">Pembayaran</a>
       
        <a href="#">
            <i class="bi bi-gear"></i> Pengaturan
        </a>
        <hr class="text-light">
        <a href="#">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    {{-- Konten --}}
    <div class="content">
        <nav class="navbar navbar-light mb-4 px-3">
            <span class="navbar-brand mb-0 h5 fw-bold">📋 @yield('title')</span>
        </nav>

        @yield('content')
    </div>

    <footer>
        <p class="mb-0">© {{ date('Y') }} - Sistem Iuran Warga</p>
    </footer>

    {{-- Bootstrap JS Offline --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
