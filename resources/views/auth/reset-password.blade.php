<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password · PT JeWePe Steel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #fafaf9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-card {
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .04);
        }
        .form-control {
            padding: .75rem 1rem;
            border-color: #cbd5e1;
            border-radius: 12px;
        }
        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .15);
        }
        .btn-submit {
            width: 100%;
            padding: .8rem;
            color: #fff;
            background: #0f172a;
            border: 0;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-submit:hover {
            color: #fff;
            background: #1e293b;
        }
    </style>
</head>
<body>
    <main class="container d-flex justify-content-center">
        <section class="reset-card">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold text-dark">Atur Ulang Password</h1>
                <p class="text-muted mb-0">Buat password baru minimal 8 karakter.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label text-secondary fw-semibold small" for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        class="form-control"
                        autocomplete="email"
                        required
                        autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary fw-semibold small" for="password">Password baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        autocomplete="new-password"
                        minlength="8"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-semibold small" for="password_confirmation">Konfirmasi password baru</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        autocomplete="new-password"
                        minlength="8"
                        required>
                </div>

                <button type="submit" class="btn-submit">Simpan Password Baru</button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-semibold">Kembali ke login</a>
            </div>
        </section>
    </main>
</body>
</html>
