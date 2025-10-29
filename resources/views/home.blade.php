<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Sistem Iuran Warga</title>

    {{-- Bootstrap Offline --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .welcome-card h1 {
            color: #1e2140;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .welcome-card p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }

        .features {
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: #555;
        }

        .feature-item i {
            margin-right: 10px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="welcome-card">
        <h1>Halaman Utama</h1>
        <h2>Sistem Iuran Warga</h2>
        <p>Selamat datang di Sistem Manajemen Iuran Warga. Platform ini membantu Anda mengelola pembayaran iuran, data warga, dan laporan keuangan dengan mudah dan efisien.</p>

        <div class="features">
            <div class="feature-item">
                <i class="bi bi-people"></i>
                <span>Kelola Data Warga</span>
            </div>
            <div class="feature-item">
                <i class="bi bi-credit-card"></i>
                <span>Pembayaran Iuran</span>
            </div>
            <div class="feature-item">
                <i class="bi bi-bar-chart"></i>
                <span>Laporan Keuangan</span>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
        </a>
    </div>

    {{-- JS --}}
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
