<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .dashboard {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .card {
            background: var(--color-container);
            padding: 1.5rem;
            border-radius: 0.75rem;
            text-decoration: none;
            color: var(--color-text);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, border-color 0.2s;
            border: 1px solid transparent;
        }
        .card:hover { transform: translateY(-4px); border-color: var(--color-first); }
        .card-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 0.75rem;
            background: rgba(80, 200, 120, 0.15);
            color: var(--color-first);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .card h3 { color: var(--color-title); margin-bottom: 0.25rem; font-size: 1rem; }
        .card p { font-size: 0.813rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Portfolio Admin</h1>
        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); if(confirm('Logout?')) document.getElementById('logout-form').submit();">
            <i class="ri-logout-box-line"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>

    <div class="dashboard">
        <div class="cards">
            <a href="{{ route('admin.projects.index') }}" class="card">
                <div class="card-icon"><i class="ri-folder-line"></i></div>
                <div>
                    <h3>Manage Projects</h3>
                    <p>Create, edit, and delete portfolio projects</p>
                </div>
            </a>
            <a href="/" class="card">
                <div class="card-icon"><i class="ri-eye-line"></i></div>
                <div>
                    <h3>View Portfolio</h3>
                    <p>See your public portfolio site</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
