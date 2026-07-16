<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --color-body: #2b2e3b;
            --color-container: #21232c;
            --color-title: #f1f2f3;
            --color-text: #9fa1ad;
            --color-first: #50C878;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--color-body);
            color: var(--color-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: var(--color-container);
            padding: 2.5rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: var(--color-title);
            text-align: center;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        p.subtitle {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.875rem;
        }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; color: var(--color-title); font-weight: 500; font-size: 0.875rem; }
        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            background: #fff;
            color: #333;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 0.938rem;
        }
        input:focus { box-shadow: 0 0 0 2px var(--color-first); }
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 2.5rem; }
        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--color-text);
            cursor: pointer;
            font-size: 1.25rem;
            padding: 0;
            line-height: 1;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background: var(--color-first);
            color: var(--color-title);
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .error { color: #dc3545; font-size: 0.813rem; margin-top: 0.25rem; text-align: center; }
        .logo { text-align: center; font-size: 2rem; color: var(--color-title); margin-bottom: 0.5rem; }
        .logo span { color: var(--color-title); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">Portfolio</div>
        <h1>Admin Login</h1>
        <p class="subtitle">Sign in to manage your portfolio</p>

        @if ($errors->has('login'))
            <div class="error">{{ $errors->first('login') }}</div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
                        <i class="ri-eye-line" id="password-icon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn"><i class="ri-login-circle-line"></i> Sign In</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'ri-eye-off-line';
            } else {
                input.type = 'password';
                icon.className = 'ri-eye-line';
            }
        }
    </script>
</body>
</html>
