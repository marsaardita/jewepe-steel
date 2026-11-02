<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PT JeWePe Steel · Login Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fafaf9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            transition: all 0.3s ease;
        }
        .logo-box {
            width: 56px;
            height: 56px;
            background-color: #fef3c7;
            color: #d97706;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
        }
        .input-group-text {
            background-color: transparent;
            border-color: #cbd5e1;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            color: #64748b;
        }
        .form-control-with-icon {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .btn-masuk {
            background-color: #0f172a;
            color: #fff;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .btn-masuk:hover {
            background-color: #1e293b;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        }
        .btn-masuk:active {
            transform: translateY(0);
        }
        .copyright {
            font-size: 0.825rem;
            color: #94a3b8;
            margin-top: 2rem;
            text-align: center;
        }
        .form-check-input:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        .toggle-password {
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.15s ease;
        }
        .toggle-password:hover {
            color: #475569;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="login-card">
            
            <div class="text-center mb-4">
                <div class="logo-box shadow-sm">
                    <i class="ti ti-building-factory-2"></i>
                </div>
                <h1 class="h3 fw-bold text-dark m-0">PT JeWePe Steel</h1>
                <p class="text-muted small mt-1">Management Information System</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 mb-4" role="alert" style="font-size: 0.9rem;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-alert-circle fs-5"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success border-0 rounded-3 mb-4" role="alert" style="font-size: 0.9rem;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- Username/Email Field -->
                <div class="mb-3">
                    <label class="form-label text-secondary fw-semibold small" for="username">Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control form-control-with-icon"
                            placeholder="Masukkan email"
                            autocomplete="username"
                            required />
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label class="form-label text-secondary fw-semibold small" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-lock"></i></span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control form-control-with-icon"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required />
                        <span class="input-group-text bg-white border-start-0" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
                            <i class="ti ti-eye toggle-password" id="toggle-pwd"></i>
                        </span>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" />
                        <label class="form-check-label text-secondary small" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-warning text-decoration-none small fw-semibold">Lupa Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-masuk">
                    <span>Masuk</span>
                    <i class="ti ti-arrow-right"></i>
                </button>
            </form>

            <div class="copyright">
                <p class="m-0">© 2026 PT JeWePe Steel · Admin</p>
            </div>

        </div>
    </div>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password visibility toggle script -->
    <script>
        const toggleBtn = document.getElementById('toggle-pwd');
        const pwdInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';
            
            toggleBtn.classList.toggle('ti-eye', !isHidden);
            toggleBtn.classList.toggle('ti-eye-off', isHidden);
        });
    </script>

</body>
</html>