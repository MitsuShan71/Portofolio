<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin Portofolio</title>
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
    @yield('styles')
</head>
<body class="admin-body">
    <a class="admin-skip" href="#admin-content">Lewati ke konten</a>

    <div class="admin-shell">
        <aside class="admin-sidebar" id="admin-sidebar" aria-label="Navigasi admin">
            <div class="admin-brand">
                <span class="admin-brand__mark" aria-hidden="true">SF</span>
                <div class="admin-brand__text">
                    <strong>Shan Favian.</strong>
                    <span>Panel admin</span>
                </div>
                <button type="button" class="admin-iconbtn admin-sidebar__close" data-admin-nav-toggle aria-label="Tutup navigasi">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
            </div>

            <nav class="admin-nav">
                <p class="admin-nav__label">Menu</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                    <span>Dashboard</span>
                </a>

                <p class="admin-nav__label">Konten</p>
                <a href="{{ route('admin.projects.index') }}" class="admin-nav__link {{ request()->routeIs('admin.projects.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.projects.*')) aria-current="page" @endif>
                    <span>Proyek</span>
                </a>
                <a href="{{ route('admin.articles.index') }}" class="admin-nav__link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.articles.*')) aria-current="page" @endif>
                    <span>Blog</span>
                </a>
                <a href="{{ route('admin.experiences.index') }}" class="admin-nav__link {{ request()->routeIs('admin.experiences.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.experiences.*')) aria-current="page" @endif>
                    <span>Pengalaman</span>
                </a>
                <a href="{{ route('admin.skills.index') }}" class="admin-nav__link {{ request()->routeIs('admin.skills.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.skills.*')) aria-current="page" @endif>
                    <span>Keahlian</span>
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="admin-nav__link {{ request()->routeIs('admin.certificates.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.certificates.*')) aria-current="page" @endif>
                    <span>Sertifikat</span>
                </a>

                <p class="admin-nav__label">Lainnya</p>
                <a href="{{ route('admin.testimonials.index') }}" class="admin-nav__link {{ request()->routeIs('admin.testimonials.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.testimonials.*')) aria-current="page" @endif>
                    <span>Testimoni</span>
                </a>
                <a href="{{ route('admin.feedback.index') }}" class="admin-nav__link {{ request()->routeIs('admin.feedback.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.feedback.*')) aria-current="page" @endif>
                    <span>Kesan & pesan</span>
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="admin-nav__link {{ request()->routeIs('admin.profile.*') ? 'is-active' : '' }}" @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif>
                    <span>Profil</span>
                </a>
            </nav>

            <div class="admin-sidebar__footer">
                <form action="{{ route('admin.logout') }}" method="POST" data-confirm="Keluar dari panel admin?">
                    @csrf
                    <button type="submit" class="admin-sidebar__logout">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-frame">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button type="button" class="admin-iconbtn admin-mobile-toggle" data-admin-nav-toggle aria-controls="admin-sidebar" aria-expanded="false" aria-label="Buka navigasi">
                        <i class="ri-menu-line" aria-hidden="true"></i>
                    </button>
                    <div class="admin-topbar__context">
                        <strong>@yield('title', 'Dashboard')</strong>
                    </div>
                </div>
                <div class="admin-topbar__actions">
                    <button type="button" class="admin-iconbtn" data-theme-toggle aria-label="Aktifkan mode terang">
                        <i class="ri-sun-line" aria-hidden="true"></i>
                    </button>
                    <a href="{{ route('home') }}" class="admin-btn admin-btn--ghost admin-topbar__home" aria-label="Lihat situs portofolio" title="Lihat situs portofolio">
                        <i class="ri-eye-line" aria-hidden="true"></i>
                        <span>Lihat situs</span>
                    </a>
                </div>
            </header>

            <main class="admin-main" id="admin-content">
                @yield('content')
            </main>

            <footer class="admin-footer">
                <span>&copy; {{ date('Y') }} Shan Favian.</span>
            </footer>
        </div>
    </div>

    <button type="button" class="admin-scrim" data-admin-nav-toggle aria-label="Tutup navigasi" tabindex="-1"></button>

    @yield('scripts')
</body>
</html>
