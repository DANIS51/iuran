<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer - @yield('title')</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1e1e2f;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding-top: 1.5rem;
        }

        .sidebar h4 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
        }

        .sidebar a {
            color: #cfcfcf;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            margin: 5px 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #2c2c44;
            color: #ffffff;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
        }

        .logout {
            margin-top: auto;
            color: #ff6b6b !important;
            font-weight: 500;
        }

        .logout:hover {
            background-color: #3a2e2e;
            color: #fff !important;
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <h4>Officer Panel</h4>

        <a href="{{ route('officer.dashboard') }}" class="{{ request()->routeIs('officer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('officer.pembayaran') }}" class="{{ request()->routeIs('officer.pembayaran') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i> Pembayaran
        </a>

        <a href="{{ route('officer.keuangan') }}" class="{{ request()->routeIs('officer.keuangan') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Keuangan
        </a>

        <a href="{{ route('logout') }}" class="logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
