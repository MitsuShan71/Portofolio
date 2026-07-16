<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
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
        }
        .header {
            background: var(--color-container);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #3a3d4a;
        }
        .header h1 { color: var(--color-title); font-size: 1.25rem; }
        .header a {
            color: var(--color-text);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .header a:hover { background: #3a3d4a; color: var(--color-title); }
        @yield('styles')
    </style>
</head>
<body>
    @section('header')
        <div class="header">
            <h1>Dashboard Admin</h1>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); if(confirm('Logout?')) document.getElementById('logout-form').submit();">
                <i class="ri-logout-box-line"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
    @show

    @yield('content')

    @yield('scripts')
</body>
</html>
