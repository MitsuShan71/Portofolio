@php
    $avatar = $profile?->profile_image ? Storage::url($profile->profile_image) : asset('profile.jpg');
    $competency = trim(explode('(', $profile?->competency ?? '')[0] ?? '');
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $article->excerpt ?: Str::limit($article->body, 160) }}">
    <title>{{ $article->title }} — {{ $profile?->full_name ?? 'Portofolio' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <script>
        (() => {
            const theme = localStorage.getItem('portfolio-theme');
            if (theme === 'light' || theme === 'dark') document.documentElement.dataset.theme = theme;
            document.documentElement.classList.add('js');
        })();
    </script>
    @vite(['resources/css/app.css'])
</head>
<body class="article-page">
    <div class="site-backdrop" aria-hidden="true">
        <span class="site-backdrop__grid"></span>
        <span class="site-backdrop__glow site-backdrop__glow--one"></span>
        <span class="site-backdrop__glow site-backdrop__glow--two"></span>
    </div>

    <header class="article-header">
        <div class="container article-header__inner">
            <span class="brand is-static" aria-label="Portofolio — Beranda" aria-disabled="true" tabindex="-1">
                <span class="brand__text">Portofolio</span>
            </span>

            <div class="article-header__actions">
                <button type="button" class="icon-btn" id="theme-toggle" aria-label="Ganti tema" title="Ganti tema">
                    <i class="ri-sun-line" aria-hidden="true"></i>
                </button>
                <a href="{{ route('home') }}#blog" class="btn btn--ghost btn--sm" aria-label="Semua blog">
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                    <span>Semua blog</span>
                </a>
            </div>
        </div>
    </header>

    <main id="main" class="article-main">
        <div class="container article-container">
            <a href="{{ route('home') }}#blog" class="article-back">
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
                Kembali ke blog
            </a>

            <header class="article-hero" data-reveal>
                <div class="article-hero__meta">
                    <span class="pill">Catatan</span>
                    <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->format('d M Y') }}</time>
                </div>
                <h1>{{ $article->title }}</h1>
                @if ($article->excerpt)
                    <p class="article-hero__excerpt">{{ $article->excerpt }}</p>
                @endif

                @if ($profile)
                    <div class="article-author">
                        <img src="{{ $avatar }}" alt="">
                        <div>
                            <strong>{{ $profile->full_name }}</strong>
                            <span>{{ $competency ?: 'Portofolio' }}</span>
                        </div>
                    </div>
                @endif
            </header>

            <article class="article-content" data-reveal style="--reveal-delay: .08s">
                {!! nl2br(e($article->body)) !!}
            </article>

            <footer class="article-footer" data-reveal>
                <p>Terima kasih sudah membaca.</p>
                <div>
                    <a href="{{ route('home') }}#blog" class="btn btn--ghost btn--sm">
                        <i class="ri-arrow-left-line" aria-hidden="true"></i> Blog lainnya
                    </a>
                    <a href="{{ route('home') }}#contact" class="btn btn--primary btn--sm">
                        Hubungi saya <i class="ri-send-plane-line" aria-hidden="true"></i>
                    </a>
                </div>
            </footer>
        </div>
    </main>

    <footer class="footer footer--minimal">
        <div class="container">
            <div class="footer__bottom">
                <p>&copy; {{ date('Y') }} {{ $profile?->full_name ?? 'Portofolio' }}. Semua hak dilindungi.</p>
                <a href="{{ route('home') }}">Kembali ke portofolio <i class="ri-arrow-right-up-line" aria-hidden="true"></i></a>
            </div>
        </div>
    </footer>

    @vite(['resources/js/app.js'])
</body>
</html>
