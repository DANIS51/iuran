<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Iuran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
