<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0b1220; min-height: 100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
        .card-reset { max-width: 420px; width: 100%; background: rgba(255,255,255,0.05); border: 1px solid #1f2937; border-radius: 16px; padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.35); color: #f8fafc; }
        .form-label { color: #e2e8f0; font-weight: 600; }
        .form-control { background:#0f172a; border:1px solid #1f2937; color:#f8fafc; border-radius:12px; padding:12px; }
        .form-control::placeholder { color:#a5b4c9; opacity:1; }
        .form-control:focus { border-color:#f97316; box-shadow:0 0 0 0.15rem rgba(249,115,22,0.35); }
        .title { color:#fff; font-weight:700; }
        .text-muted { color:#cbd5e1 !important; }
    </style>
</head>
<body>
    <div class="card-reset">
        <h3 class="title mb-3">Reset Password</h3>
        <p class="text-muted">Masukkan email siswa yang terdaftar. Kami akan mengirim password baru ke email tersebut.</p>
        <form method="POST" action="{{ route('password.reset.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
            <button class="btn btn-primary w-100" type="submit">Kirim Password Baru</button>
            <a class="btn btn-link text-decoration-none w-100 mt-2" href="{{ route('login') }}">Kembali ke Login</a>

            @if (session('error'))
                <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3 mb-0">{{ session('success') }}</div>
            @endif
        </form>
    </div>
</body>
</html>
