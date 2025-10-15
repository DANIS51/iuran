<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Bootstrap Offline --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa; /* warna lembut bersih */
        }

        body {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #1e2140; /* tetap gelap di sisi kiri */
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar h4 {
            text-align: center;
            padding: 20px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 5px 10px;
            transition: 0.3s ease;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
        }

        .sidebar hr {
            margin: 1rem 1.5rem;
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Konten utama */
        .content {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: transparent; /* ✅ hilangkan background */
        }

        /* Navbar */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
        }

        .navbar-brand {
            font-weight: bold;
            color: #1e2140 !important;
        }

        /* Area konten utama */
        main {
            flex: 1;
            padding: 25px;
            background: #f5f6fa; /* warna dasar konten */
        }

        /* Footer */
        footer {
            background: #ffffff;
            border-top: 1px solid #ddd;
            color: #555;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        /* Tombol toggle sidebar */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.7rem;
            color: #1e2140;
        }

        /* Responsive (mobile) */
        @media (max-width: 991px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <h4>Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <i class="bi bi-house-door me-2"></i> Dashboard
        </a>
        <a href="{{ route('warga.index') }}" class="{{ request()->is('admin/warga*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Data Warga
        </a>
        <a href="{{ route('officer.index') }}" class="{{ request()->is('admin/officer*') ? 'active' : '' }}">
            <i class="bi bi-person-badge me-2"></i> Users
        </a>
        <a href="{{ route('iuran.index') }}" class="{{ request()->is('admin/iuran*') ? 'active' : '' }}">
            <i class="bi bi-wallet2 me-2"></i> Iuran
        </a>
        <a href="{{ route('pembayaran.index') }}" class="{{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
            <i class="bi bi-credit-card me-2"></i> Pembayaran
        </a>
        <a href="#">
            <i class="bi bi-gear me-2"></i> Pengaturan
        </a>
        <hr>
        <form action="{{ route('logout') }}" method="POST" class="px-3 pb-3">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    {{-- Area konten --}}
    <div class="content">
        

        <main>
            @yield('content')
        </main>

        <footer>
            <p class="mb-0">© {{ date('Y') }} - Sistem Iuran Warga | Dibuat dengan ❤️ oleh Admin</p>
        </footer>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            });

            $('#menuToggle').click(function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>
