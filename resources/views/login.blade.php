<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .auth-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-shell {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 20px;
            width: min(1100px, 100%);
            background: rgba(11, 18, 32, 0.8);
            border: 1px solid #1f2937;
            border-radius: 20px;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            backdrop-filter: blur(8px);
        }

        .auth-card {
            background: transparent;
            padding: 32px 32px 36px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(249, 115, 22, 0.14);
            color: #ffd7ba;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.02em;
        }

        .form-label { color: #e2e8f0; font-weight: 600; }
        .form-control {
            background: #0b1220;
            border: 1px solid #1f2937;
            color: #e2e8f0;
            border-radius: 12px;
            padding: 12px;
        }

        .form-control:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 0.15rem rgba(249, 115, 22, 0.35);
            background: #0b1220;
            color: #e2e8f0;
        }

        .auth-footer { color: #94a3b8; font-size: 13px; }

        .auth-illustration {
            position: relative;
            min-height: 100%;
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.16), rgba(34, 211, 238, 0.12)),
                        url('https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
        }

        .auth-illustration::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(11, 18, 32, 0.45), rgba(11, 18, 32, 0.75));
        }

        .illustration-copy {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 28px;
            color: #f8fafc;
            z-index: 1;
            gap: 6px;
        }

        .illustration-copy h5 { font-weight: 800; }
        .illustration-copy p { color: #e2e8f0; margin: 0; }
    </style>
</head>

<body>
    <div class="auth-wrap">
        <div class="auth-shell">
            <form method="POST" class="auth-card text-center" novalidate>
                @csrf
                <div class="mb-3 d-flex justify-content-center">
                    <img src="{{ asset('images/logo_sekolah2.png') }}" class="rounded-circle" width="120" height="120" alt="Logo">
                </div>
                <div class="auth-badge mb-3">SMA Ovaldo • Learning Portal</div>
                <h2 class="fw-bold mb-2" style="color:#fff;">Welcome Back</h2>
                <p class="text-muted mb-4" style="color:#cbd5e1!important;">Sign in to manage classes, grades, and materials.</p>

                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="your@email.com" required>
                </div>

                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Sign In</button>
                <a href="{{ route('password.reset') }}" class="btn btn-outline-light w-100 mt-2">Reset Password</a>

                @if (session('error'))
                    <div class="alert alert-danger mt-3 mb-0">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-3 mb-0">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="auth-footer mt-4 mb-0">Need access? Contact the admin to create your account.</p>
            </form>

            <div class="auth-illustration d-none d-md-block">
                <div class="illustration-copy">
                    <h5>Belajar lebih fokus</h5>
                    <p>Materi, tugas, dan jadwal di satu tempat. Masuk untuk melanjutkan.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
