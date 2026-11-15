<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin — Portofolio</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <script>
        (() => {
            const theme = localStorage.getItem('portfolio-theme');
            if (theme === 'light' || theme === 'dark') document.documentElement.dataset.theme = theme;
            document.documentElement.classList.add('js');
        })();
    </script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="admin-body admin-login-body">
    <main class="admin-login">
        <section class="admin-login__card" aria-labelledby="admin-login-title">
            <a href="{{ route('home') }}" class="admin-login__back">Kembali ke portofolio</a>
            <h1 id="admin-login-title">Masuk admin</h1>
            <p class="admin-login__intro">Masuk untuk mengelola portofolio.</p>

            @if ($errors->any())
                <div class="admin-alert admin-alert--danger" role="alert" style="margin-top: 1.1rem;">
                    <i class="ri-error-warning-line" aria-hidden="true"></i>
                    <div>
                        @if ($errors->has('login'))
                            {{ $errors->first('login') }}
                        @else
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="admin-login__form">
                @csrf
                <div class="admin-field">
                    <label for="username" class="admin-label">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" class="admin-input" required autofocus autocomplete="username">
                    @error('username')
                        <span class="admin-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-field">
                    <label for="password" class="admin-label">Kata sandi</label>
                    <div class="admin-password">
                        <input type="password" name="password" id="password" class="admin-input" required autocomplete="current-password">
                        <button type="button" class="admin-password__toggle" data-password-toggle="password" aria-label="Tampilkan kata sandi">
                            <i class="ri-eye-line" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="admin-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="admin-btn admin-btn--primary admin-login__submit">
                    Masuk
                </button>
            </form>
        </section>
    </main>
</body>
</html>
