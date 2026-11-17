@php
    $name = trim($profile->full_name ?? 'Portofolio');
    $nameParts = preg_split('/\s+/', $name) ?: [$name];
    $lastName = count($nameParts) > 1 ? array_pop($nameParts) : '';
    $firstName = implode(' ', $nameParts) ?: $name;
    $role = implode(' ', array_slice(preg_split('/\s+/', trim($profile->summary ?? 'Portofolio')) ?: [], 0, 2));
    $competencyShort = trim(explode('(', $profile->competency ?? '')[0] ?? '');
    $competencyDisplay = $competencyShort === 'PPLG'
        ? 'PPLG (Pengembangan Perangkat Lunak dan Gim)'
        : trim($profile->competency ?? '');
    $avatar = $profile->profile_image ? Storage::url($profile->profile_image) : asset('profile.jpg');
    $resume = $profile->resume_file && Storage::disk('public')->exists($profile->resume_file)
        ? Storage::url($profile->resume_file)
        : asset('cv-digital-shan-favian-efendy.pdf');
    $hardSkills = $skills->get('hard', collect());
    $softSkills = $skills->get('soft', collect());
    $skillCount = $hardSkills->count() + $softSkills->count();
    $experienceCount = $experiences->flatten(1)->count();
    $projectCount = $projects->count();
    $splitProjectTechnologies = fn ($technologies) => collect(preg_split('/[,;\n]+/', $technologies ?? '') ?: [])
        ->map(fn ($technology) => trim($technology))
        ->filter()
        ->values();
    $projectFilterOptions = $projects
        ->pluck('category')
        ->filter()
        ->map(fn ($category) => trim($category))
        ->filter()
        ->unique(fn ($category) => Str::lower($category))
        ->sort()
        ->values();
    $certificateCount = $certificates->count();
    $articleCount = $articles->count();
    $testimonialCount = $feedback->count();
    $educationItems = collect(preg_split('/\r\n|\r|\n/', $profile->education ?? '') ?: [])
        ->map(fn ($line) => trim($line))
        ->filter()
        ->map(function ($line) {
            $years = null;
            if (preg_match('/\(([^()]*)\)\s*$/', $line, $matches)) {
                $years = trim($matches[1]);
                $line = trim(preg_replace('/\s*\([^()]*\)\s*$/', '', $line));
            }
            return ['label' => $line, 'years' => $years];
        });
    $interestItems = collect(preg_split('/[,;\n]+/', $profile->technology_interests ?? '') ?: [])
        ->map(fn ($item) => trim($item))
        ->filter();
    if ($interestItems->isEmpty()) {
        $interestItems = $hardSkills->pluck('name');
    }
    $githubHandle = $profile->github_url ? basename(parse_url($profile->github_url, PHP_URL_PATH) ?? '') : null;
    $instagramHandle = $profile->instagram_url ? basename(parse_url($profile->instagram_url, PHP_URL_PATH) ?? '') : null;
    $isAdmin = session('admin_logged_in');
    $heroTools = $hardSkills->take(2)
        ->reject(fn ($skill) => Str::lower(trim($skill->name)) === 'html')
        ->pluck('name');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Portofolio {{ $name }} — {{ $profile->summary }}">
    <title>{{ $name }} — Portofolio</title>
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
<body>
    <a class="skip-link" href="#main">Lewati ke konten</a>

    <div class="site-backdrop" aria-hidden="true">
        <span class="site-backdrop__grid"></span>
        <span class="site-backdrop__glow site-backdrop__glow--one"></span>
        <span class="site-backdrop__glow site-backdrop__glow--two"></span>
    </div>

    <header class="site-header" id="header">
        <div class="scroll-progress" aria-hidden="true"><span id="scroll-progress-bar"></span></div>
        <div class="nav-shell container">
            <a href="#home" class="brand" aria-label="Portofolio - Beranda">
                <span class="brand__text">Portofolio</span>
            </a>

            <nav class="nav" id="nav-menu" aria-label="Navigasi utama">
                <ul class="nav__list">
                    <li><a href="#home" class="nav__link">Beranda</a></li>
                    <li><a href="#about" class="nav__link">Tentang</a></li>
                    <li><a href="#skills" class="nav__link">Keahlian</a></li>
                    <li><a href="#projects" class="nav__link">Proyek</a></li>
                    <li><a href="#certificates" class="nav__link">Sertifikat</a></li>
                    <li><a href="#experiences" class="nav__link">Pengalaman</a></li>
                    <li><a href="#testimonials" class="nav__link">Testimoni</a></li>
                    <li><a href="#blog" class="nav__link">Blog</a></li>
                    <li><a href="#contact" class="nav__link">Kontak</a></li>
                </ul>
            </nav>

            <div class="nav__actions">
                <button type="button" class="icon-btn" id="theme-toggle" aria-label="Ganti tema" title="Ganti tema">
                    <i class="ri-sun-line" aria-hidden="true"></i>
                </button>

                @if ($isAdmin)
                    <a href="{{ route('admin.dashboard') }}" class="icon-btn" aria-label="Dashboard admin" title="Dashboard admin">
                        <i class="ri-dashboard-line" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('admin.logout') }}" class="icon-btn" aria-label="Keluar dari admin" title="Keluar"
                       onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="ri-logout-box-line" aria-hidden="true"></i>
                    </a>
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" hidden>@csrf</form>
                @else
                    <a href="{{ route('admin.login') }}" class="icon-btn" aria-label="Masuk admin" title="Masuk admin">
                        <i class="ri-user-line" aria-hidden="true"></i>
                    </a>
                @endif

                <button type="button" class="icon-btn nav__toggle" id="nav-toggle" aria-controls="nav-menu" aria-expanded="false" aria-label="Buka menu">
                    <i class="ri-menu-line" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero" id="home">
            <div class="container hero__inner">
                <div class="hero__copy">
                    <p class="hero__eyebrow hero__enter" style="--enter-delay: .05s">
                        <span class="status-dot" aria-hidden="true"></span>
                        Terbuka untuk kolaborasi
                    </p>

                    <h1 class="hero__title hero__enter" style="--enter-delay: .12s">
                        <span class="hero__hello">Halo, saya</span>
                        <span class="hero__name">{{ $firstName }}@if ($lastName) <span class="hero__name-accent">{{ $lastName }}</span>@endif</span>
                    </h1>

                    <p class="hero__lead hero__enter" style="--enter-delay: .2s">{{ $profile->summary }}</p>
                    <p class="hero__bio hero__enter" style="--enter-delay: .26s">{{ $profile->bio }}</p>

                    <div class="hero__actions hero__enter" style="--enter-delay: .32s">
                        <a href="#projects" class="btn btn--primary">
                            Jelajahi karya <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                        </a>
                        <a href="{{ $resume }}" class="btn btn--ghost" target="_blank" rel="noopener noreferrer">
                            Unduh CV <i class="ri-download-2-line" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div class="hero__meta hero__enter" style="--enter-delay: .38s">
                        <span class="meta-chip">
                            <i class="ri-graduation-cap-line" aria-hidden="true"></i>
                            Kelas {{ $profile->class_name }}
                        </span>
                        <span class="meta-chip">
                            <i class="ri-code-s-slash-line" aria-hidden="true"></i>
                            {{ $competencyShort }}
                        </span>
                        @if ($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="meta-chip meta-chip--link">
                                <i class="ri-mail-line" aria-hidden="true"></i>
                                {{ $profile->email }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="hero__visual hero__enter" style="--enter-delay: .22s">
                    <div class="hero__portrait-glow" aria-hidden="true"></div>
                    <div class="hero__rings" aria-hidden="true"></div>
                    <figure class="hero__portrait">
                        <img src="{{ $avatar }}" alt="Foto profil {{ $name }}" fetchpriority="high">
                    </figure>
                    <div class="hero-chip hero-chip--top">
                        <span class="hero-chip__icon"><i class="ri-pen-nib-line" aria-hidden="true"></i></span>
                        <div>
                            <strong>{{ $role }}</strong>
                            <span>{{ $heroTools->isNotEmpty() ? $heroTools->join(' · ') : 'Design · Code' }}</span>
                        </div>
                    </div>
                    <div class="hero-chip hero-chip--bottom">
                        <span class="hero-chip__icon"><i class="ri-sparkling-2-line" aria-hidden="true"></i></span>
                        <div>
                            <strong>{{ $skillCount }} keahlian</strong>
                            <span>{{ $experienceCount }} pengalaman</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section about" id="about">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">01</span> Tentang saya</p>
                        <h2>Rasa ingin tahu yang tumbuh menjadi <span class="text-gradient">karya</span>.</h2>
                    </div>
                    <p class="section-head__note">Saya percaya desain yang baik bukan hanya soal tampilan, tetapi tentang bagaimana orang merasa saat menggunakannya.</p>
                </header>

                <div class="bento">
                    <article class="bento-card bento-card--profile" data-reveal data-glow>
                        <p class="card-label"><i class="ri-quote-text" aria-hidden="true"></i> Profil singkat</p>
                        <p class="bento-card__quote">{{ $profile->bio }}</p>
                        <div class="person">
                            <img src="{{ $avatar }}" alt="" loading="lazy">
                            <div>
                                <strong>{{ $name }}</strong>
                                <span>{{ $role }} · {{ $competencyShort }}</span>
                            </div>
                        </div>
                    </article>

                    <article class="bento-card" data-reveal style="--reveal-delay: .06s" data-glow>
                        <p class="card-label"><i class="ri-information-line" aria-hidden="true"></i> Detail singkat</p>
                        <dl class="facts">
                            <div>
                                <dt>Nama</dt>
                                <dd>{{ $name }}</dd>
                            </div>
                            <div>
                                <dt>Kelas</dt>
                                <dd>{{ $profile->class_name ?: '—' }}</dd>
                            </div>
                            <div>
                                <dt>Jurusan</dt>
                                <dd>{{ $competencyDisplay ?: '—' }}</dd>
                            </div>
                            @if ($profile->email)
                                <div>
                                    <dt>Email</dt>
                                    <dd><a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a></dd>
                                </div>
                            @endif
                        </dl>
                    </article>

                    <article class="bento-card bento-card--wide" data-reveal data-glow>
                        <p class="card-label"><i class="ri-route-line" aria-hidden="true"></i> Riwayat pendidikan</p>
                        @if ($educationItems->isNotEmpty())
                            <ol class="education">
                                @foreach ($educationItems as $item)
                                    <li>
                                        <div class="education__body">
                                            <p>{{ $item['label'] }}</p>
                                            @if ($item['years'])
                                                <span class="education__year">{{ $item['years'] }}</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="muted">Riwayat pendidikan belum ditambahkan.</p>
                        @endif
                    </article>

                    <article class="bento-card" data-reveal style="--reveal-delay: .06s" data-glow>
                        <p class="card-label"><i class="ri-focus-3-line" aria-hidden="true"></i> Fokus &amp; minat</p>
                        @if ($interestItems->isNotEmpty())
                            <ul class="chip-list">
                                @foreach ($interestItems as $interest)
                                    <li class="chip">{{ $interest }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="muted">Minat dan fokus sedang diperbarui.</p>
                        @endif
                    </article>

                    <article class="bento-card bento-card--goal" data-reveal data-glow>
                        <div>
                            <p class="card-label"><i class="ri-flag-2-line" aria-hidden="true"></i> Tujuan karir</p>
                            <p class="bento-card__goal">{{ $profile->career_goal }}</p>
                        </div>
                        <a href="#contact" class="link-arrow">
                            Mari berkolaborasi <i class="ri-arrow-right-line" aria-hidden="true"></i>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section class="section skills" id="skills">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">02</span> Keahlian</p>
                        <h2>Alat dan kemampuan di balik setiap <span class="text-gradient">rancangan</span>.</h2>
                    </div>
                    <p class="section-head__note">Dari eksplorasi ide di Figma hingga menyusun antarmuka dengan HTML dan CSS.</p>
                </header>

                <div class="skills-layout">
                    <div class="skills-panel">
                        @if ($skillCount === 0)
                            @include('partials.empty-state', [
                                'icon' => 'ri-bar-chart-box-line',
                                'title' => 'Keahlian sedang disiapkan',
                                'text' => 'Daftar keahlian akan tampil di sini setelah ditambahkan melalui dashboard.',
                                'action' => $isAdmin ? route('admin.skills.create') : null,
                                'actionLabel' => 'Tambah keahlian',
                            ])
                        @else
                            @foreach ([['items' => $hardSkills, 'label' => 'Hard skill'], ['items' => $softSkills, 'label' => 'Soft skill']] as $group)
                                @if ($group['items']->isNotEmpty())
                                    <div class="skill-group" data-reveal>
                                        <div class="skill-group__head">
                                            <h3>{{ $group['label'] }}</h3>
                                        </div>
                                        <div class="skill-grid">
                                            @foreach ($group['items'] as $skill)
                                                <article class="skill-card" data-glow>
                                                    <div class="skill-card__top">
                                                        <div class="skill-card__title">
                                                            <h4>{{ $skill->name }}</h4>
                                                            <span>{{ $skill->percentage }}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="meter" role="progressbar" aria-label="{{ $skill->name }}" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $skill->percentage }}">
                                                        <span style="--level: {{ $skill->percentage }}%"></span>
                                                    </div>
                                                </article>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <aside class="skills-intro" data-reveal>
                        <p class="skills-intro__text">Saya menikmati proses mengubah masalah menjadi solusi visual yang sederhana, konsisten, dan nyaman digunakan.</p>
                        <a href="#contact" class="link-arrow">
                            Diskusikan kebutuhan Anda <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                        </a>
                    </aside>
                </div>
            </div>
        </section>

        <section class="section projects" id="projects">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">03</span> Proyek</p>
                        <h2>Karya yang saya <span class="text-gradient">bangun</span>.</h2>
                    </div>
                    <p class="section-head__note">Setiap proyek adalah kesempatan untuk belajar, bereksperimen, dan menyelesaikan masalah nyata.</p>
                </header>

                @if ($projectCount === 0)
                    @include('partials.empty-state', [
                        'icon' => 'ri-layout-masonry-line',
                        'title' => 'Proyek pertama sedang dalam perjalanan',
                        'text' => 'Dokumentasi karya akan tampil di sini. Sementara itu, silakan jelajahi keahlian dan pengalaman saya.',
                        'action' => $isAdmin ? route('admin.projects.create') : '#contact',
                        'actionLabel' => $isAdmin ? 'Tambah proyek' : 'Mulai diskusi',
                    ])
                @else
                    <div class="project-toolbar" data-project-toolbar>
                        <label class="project-search">
                            <i class="ri-search-line" aria-hidden="true"></i>
                            <input type="search" data-project-search aria-label="Cari proyek" placeholder="Cari berdasarkan nama, deskripsi, peran, atau teknologi..." autocomplete="off">
                        </label>

                        <div class="project-filters" role="group" aria-label="Filter proyek berdasarkan kategori">
                            <button type="button" class="project-filter is-active" data-project-filter="all" aria-pressed="true">Semua</button>
                            @foreach ($projectFilterOptions as $category)
                                <button type="button" class="project-filter" data-project-filter="{{ Str::lower($category) }}" aria-pressed="false">{{ $category }}</button>
                            @endforeach
                        </div>

                        <p class="project-toolbar__status" data-project-status role="status" aria-live="polite">
                            Menampilkan {{ $projectCount }} dari {{ $projectCount }} proyek
                        </p>
                    </div>

                    <div class="project-grid" data-project-grid>
                        @foreach ($projects as $project)
                            @php
                                $demoLink = $project->demo_link ?: $project->link;
                                $technologyTags = $splitProjectTechnologies($project->technologies);
                                $searchableProjectText = implode(' ', array_filter([
                                    $project->title,
                                    $project->category,
                                    $project->description,
                                    $project->role,
                                    $project->technologies,
                                ]));
                            @endphp

                            <article class="project-card" data-project-card data-project-search-text="{{ Str::lower($searchableProjectText) }}" data-project-category="{{ Str::lower(trim($project->category ?? '')) }}" data-reveal data-glow>
                                <div class="project-card__media">
                                    @if ($project->image)
                                        <img src="{{ Storage::url($project->image) }}" alt="Pratinjau {{ $project->title }}" loading="lazy">
                                    @else
                                        <div class="project-card__placeholder">
                                            <i class="ri-image-2-line" aria-hidden="true"></i>
                                            <span>Dokumentasi belum tersedia</span>
                                        </div>
                                    @endif
                                    <span class="project-card__index" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                </div>

                                <div class="project-card__body">
                                    <h3>{{ $project->title }}</h3>
                                    @if ($project->description)
                                        <p>{{ Str::limit($project->description, 150) }}</p>
                                    @endif
                                    @if ($technologyTags->isNotEmpty())
                                        <div class="project-card__tags" aria-label="Teknologi proyek">
                                            @foreach ($technologyTags as $technology)
                                                <span class="project-card__tag">{{ $technology }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($project->category)
                                        <span class="project-card__tag project-card__tag--category">{{ $project->category }}</span>
                                    @endif
                                    <button type="button" class="link-arrow" data-open-project="project-{{ $project->id }}">
                                        Pratinjau detail <i class="ri-arrow-right-line" aria-hidden="true"></i>
                                    </button>
                                </div>

                                <dialog class="project-dialog" id="project-{{ $project->id }}" aria-labelledby="project-{{ $project->id }}-title">
                                    <div class="project-dialog__header">
                                        <div>
                                            <p class="project-dialog__eyebrow">Detail proyek</p>
                                            <h3 id="project-{{ $project->id }}-title">{{ $project->title }}</h3>
                                        </div>
                                        <button type="button" class="icon-btn project-dialog__close" data-close-project aria-label="Tutup detail proyek">
                                            <i class="ri-close-line" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                    <div class="project-dialog__body">
                                        @if ($project->image)
                                            <img src="{{ Storage::url($project->image) }}" alt="Dokumentasi {{ $project->title }}" class="project-dialog__image">
                                        @endif

                                        @if ($project->role)
                                            <div class="project-dialog__meta">
                                                <div>
                                                    <span>Peran</span>
                                                    <p>{{ $project->role }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @foreach ([
                                            'Deskripsi' => $project->description,
                                            'Permasalahan' => $project->problem_solved,
                                            'Tujuan' => $project->objective,
                                            'Fitur utama' => $project->features,
                                            'Detail proyek' => $project->details,
                                            'Dokumentasi proses' => $project->process_documentation,
                                            'Feedback pengguna' => $project->user_feedback,
                                        ] as $label => $content)
                                            @if ($content)
                                                <section class="project-dialog__section">
                                                    <h4>{{ $label }}</h4>
                                                    <p>{{ $content }}</p>
                                                </section>
                                            @endif
                                        @endforeach

                                        @if ($demoLink || $project->github_link)
                                            <div class="project-dialog__links">
                                                @if ($demoLink)
                                                    <a class="btn btn--primary btn--sm" href="{{ $demoLink }}" target="_blank" rel="noopener noreferrer">
                                                        Lihat demo <i class="ri-external-link-line" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                @if ($project->github_link)
                                                    <a class="btn btn--ghost btn--sm" href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer">
                                                        GitHub <i class="ri-github-fill" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </dialog>
                            </article>
                        @endforeach
                    </div>
                    <div class="project-empty" data-project-empty hidden>
                        <i class="ri-search-eye-line" aria-hidden="true"></i>
                        <strong>Proyek tidak ditemukan</strong>
                        <span>Coba kata kunci atau filter teknologi lain.</span>
                    </div>
                @endif
            </div>
        </section>

        <section class="section certificates" id="certificates">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">04</span> Sertifikat</p>
                        <h2>Bukti <span class="text-gradient">sertifikat</span>.</h2>
                    </div>
                    <p class="section-head__note">Sertifikat, prestasi, dan dokumentasi perjalanan belajar yang saya jalani.</p>
                </header>

                @if ($certificateCount === 0)
                    @include('partials.empty-state', [
                        'icon' => 'ri-award-line',
                        'title' => 'Sertifikat akan segera hadir',
                        'text' => 'Dokumentasi sertifikat dan prestasi akan tampil di sini setelah ditambahkan.',
                        'action' => $isAdmin ? route('admin.certificates.create') : null,
                        'actionLabel' => 'Tambah sertifikat',
                    ])
                @else
                    <div class="certificate-grid">
                        @foreach ($certificates as $certificate)
                            @php
                                $documentation = $certificate->documentation;
                                $isImage = $documentation && ! str_ends_with(strtolower($documentation), '.pdf');
                            @endphp

                            <article class="cert-card" data-reveal data-glow>
                                @if ($isImage)
                                    <div class="cert-card__media">
                                        <img src="{{ Storage::url($documentation) }}" alt="Dokumentasi {{ $certificate->title }}" loading="lazy">
                                    </div>
                                @else
                                    <div class="cert-card__media cert-card__media--icon">
                                        <i class="ri-award-line" aria-hidden="true"></i>
                                    </div>
                                @endif

                                <div class="cert-card__body">
                                    @if ($certificate->date)
                                        <span class="cert-card__date">
                                            <i class="ri-calendar-line" aria-hidden="true"></i>
                                            {{ $certificate->date->format('d M Y') }}
                                        </span>
                                    @endif
                                    <h3>{{ $certificate->title }}</h3>
                                    @if ($certificate->description)
                                        <p>{{ $certificate->description }}</p>
                                    @endif
                                    @if ($documentation)
                                        <a href="{{ Storage::url($documentation) }}" class="link-arrow" target="_blank" rel="noopener noreferrer">
                                            Lihat dokumentasi <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="section experiences" id="experiences">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">05</span> Pengalaman</p>
                        <h2>Jejak langkah yang membentuk cara saya <span class="text-gradient">bekerja</span>.</h2>
                    </div>
                    <p class="section-head__note">Pengalaman praktik kerja, organisasi, dan kompetisi yang saya jalani selama belajar.</p>
                </header>

                @if ($experienceCount === 0)
                    @include('partials.empty-state', [
                        'icon' => 'ri-briefcase-4-line',
                        'title' => 'Belum ada pengalaman',
                        'text' => 'Pengalaman praktik kerja, organisasi, dan lomba akan tampil di sini.',
                        'action' => $isAdmin ? route('admin.experiences.create') : null,
                        'actionLabel' => 'Tambah pengalaman',
                    ])
                @else
                    @php
                        $experienceCategories = [
                            'plk' => ['label' => 'Pengalaman PLK', 'icon' => 'ri-briefcase-4-line'],
                            'organization' => ['label' => 'Organisasi & Kepanitiaan', 'icon' => 'ri-group-line'],
                            'competition' => ['label' => 'Pengalaman Lomba', 'icon' => 'ri-trophy-line'],
                        ];
                    @endphp

                    <div class="experience-groups">
                        @foreach ($experienceCategories as $key => $category)
                            @php $items = $experiences->get($key, collect()); @endphp
                            @if ($items->isNotEmpty())
                                <div class="experience-group" data-reveal>
                                    <div class="experience-group__head">
                                        <span class="experience-group__icon"><i class="{{ $category['icon'] }}" aria-hidden="true"></i></span>
                                        <h3>{{ $category['label'] }}</h3>
                                    </div>
                                    <div class="timeline">
                                        @foreach ($items as $experience)
                                            @include('partials.experience-card', ['experience' => $experience])
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="section testimonials" id="testimonials">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">06</span> Testimoni</p>
                        <h2>Apa kata mereka setelah <span class="text-gradient">berinteraksi</span>.</h2>
                    </div>
                    <p class="section-head__note">Kesan dan pesan dari pengunjung yang telah melihat karya serta perjalanan saya.</p>
                </header>

                @if ($testimonialCount === 0)
                    @include('partials.empty-state', [
                        'icon' => 'ri-chat-quote-line',
                        'title' => 'Belum ada testimoni',
                        'text' => 'Testimoni akan tampil di sini setelah pengunjung mengirim kesan dan pesan.',
                        'action' => '#feedback',
                        'actionLabel' => 'Tulis kesan',
                    ])
                @else
                    <div class="testimonial-grid">
                        @foreach ($feedback as $testimonial)
                            <article class="testimonial-card" data-reveal data-glow>
                                <span class="testimonial-card__quote" aria-hidden="true">&ldquo;</span>
                                <p class="testimonial-card__message">{{ $testimonial->message }}</p>
                                <div class="testimonial-card__person">
                                    <span class="testimonial-card__avatar" aria-hidden="true">{{ Str::upper(Str::substr($testimonial->name, 0, 1)) }}</span>
                                    <div>
                                        <strong>{{ $testimonial->name }}</strong>
                                        @if ($testimonial->rating)
                                            <span class="testimonial-card__rating" aria-label="Rating {{ $testimonial->rating }} dari 5">
                                                @for ($star = 1; $star <= 5; $star++)
                                                    <i class="{{ $star <= $testimonial->rating ? 'ri-star-fill' : 'ri-star-line' }}" aria-hidden="true"></i>
                                                @endfor
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="testimonial-submit" data-reveal>
                    <div class="testimonial-submit__copy">
                        <p class="card-label"><i class="ri-chat-quote-line" aria-hidden="true"></i> Kirim testimoni</p>
                        <h3>Beri kesan tentang portofolio ini</h3>
                        <p>Pesan yang dikirim di sini akan ditampilkan sebagai testimoni.</p>
                    </div>
                    <form action="{{ route('feedback.store') }}" method="POST" class="form testimonial-form">
                        @csrf
                        <input type="hidden" name="kind" value="testimonial">
                        <div class="field">
                            <label for="testimonial-name">Nama</label>
                            <input id="testimonial-name" type="text" name="name" maxlength="255" value="{{ old('kind') === 'testimonial' ? old('name') : '' }}" required placeholder="Nama Anda" autocomplete="name">
                            @if (old('kind') === 'testimonial')
                                @error('name')<p class="form__error">{{ $message }}</p>@enderror
                            @endif
                        </div>
                        <div class="field rating-field">
                            <label for="testimonial-rating">Rating</label>
                            <select id="testimonial-rating" name="rating" required>
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <option value="{{ $rating }}" {{ (int) old('rating', 5) === $rating ? 'selected' : '' }}>
                                        {{ $rating }} {{ $rating === 1 ? 'star' : 'stars' }}
                                    </option>
                                @endfor
                            </select>
                            @if (old('kind') === 'testimonial')
                                @error('rating')<p class="form__error">{{ $message }}</p>@enderror
                            @endif
                        </div>
                        <div class="field">
                            <label for="testimonial-message">Pesan testimoni</label>
                            <textarea id="testimonial-message" name="message" required maxlength="10000" placeholder="Tulis testimoni Anda...">{{ old('kind') === 'testimonial' ? old('message') : '' }}</textarea>
                            @if (old('kind') === 'testimonial')
                                @error('message')<p class="form__error">{{ $message }}</p>@enderror
                            @endif
                        </div>
                        @if (session('feedback_success') && old('kind') === 'testimonial')
                            <p class="form__success" role="status">
                                <i class="ri-checkbox-circle-line" aria-hidden="true"></i>
                                {{ session('feedback_success') }}
                            </p>
                        @endif
                        <button type="submit" class="btn btn--primary">
                            Kirim testimoni <i class="ri-send-plane-line" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section class="section articles" id="blog">
            <div class="container">
                <header class="section-head" data-reveal>
                    <div class="section-head__main">
                        <p class="eyebrow"><span class="eyebrow__num">07</span> Blog</p>
                        <h2>Catatan seputar desain dan <span class="text-gradient">kode</span>.</h2>
                    </div>
                    <p class="section-head__note">Tulisan singkat tentang proses belajar, eksplorasi desain, dan hal-hal yang saya temukan di jalan.</p>
                </header>

                @if ($articleCount === 0)
                    @include('partials.empty-state', [
                        'icon' => 'ri-article-line',
                        'title' => 'Belum ada tulisan',
                        'text' => 'Catatan dan tulisan baru akan tampil di sini setelah dipublikasikan.',
                        'action' => $isAdmin ? route('admin.articles.create') : null,
                        'actionLabel' => 'Tulis blog',
                    ])
                @else
                    <div class="article-grid">
                        @foreach ($articles as $article)
                            <article class="article-card" data-reveal data-glow>
                                <div class="article-card__meta">
                                    <span>{{ $article->published_at->format('d M Y') }}</span>
                                    <span>Catatan</span>
                                </div>
                                <h3>{{ $article->title }}</h3>
                                <p>{{ Str::limit($article->excerpt ?: $article->body, 150) }}</p>
                                <a href="{{ route('articles.show', $article->slug) }}" class="link-arrow">
                                    Baca selengkapnya <i class="ri-arrow-right-line" aria-hidden="true"></i>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="section contact" id="contact">
            <div class="container">
                <div class="contact-layout">
                    <div class="contact-copy" data-reveal>
                        <p class="eyebrow"><span class="eyebrow__num">08</span> Kontak</p>
                        <h2>Punya ide? Mari kita <span class="text-gradient">wujudkan</span> bersama.</h2>
                        <p class="contact-copy__text">Saya terbuka untuk diskusi proyek, kolaborasi, atau sekadar bertukar pikiran tentang desain dan pengembangan web.</p>

                        <div class="contact-links">
                            @if ($profile->email)
                                <a href="mailto:{{ $profile->email }}" class="contact-link">
                                    <span class="contact-link__icon"><i class="ri-mail-send-line" aria-hidden="true"></i></span>
                                    <span class="contact-link__text">
                                        <span>Email</span>
                                        <strong>{{ $profile->email }}</strong>
                                    </span>
                                    <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($profile->github_url)
                                <a href="{{ $profile->github_url }}" class="contact-link" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-link__icon"><i class="ri-github-fill" aria-hidden="true"></i></span>
                                    <span class="contact-link__text">
                                        <span>GitHub</span>
                                        <strong>{{ $githubHandle ? '@'.$githubHandle : $profile->github_url }}</strong>
                                    </span>
                                    <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ($profile->instagram_url)
                                <a href="{{ $profile->instagram_url }}" class="contact-link" target="_blank" rel="noopener noreferrer">
                                    <span class="contact-link__icon"><i class="ri-instagram-line" aria-hidden="true"></i></span>
                                    <span class="contact-link__text">
                                        <span>Instagram</span>
                                        <strong>{{ $instagramHandle ? '@'.$instagramHandle : $profile->instagram_url }}</strong>
                                    </span>
                                    <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>

                        <p class="contact-note"><i class="ri-time-line" aria-hidden="true"></i> Terbuka untuk proyek, kolaborasi, atau sekadar berbagi ide.</p>
                    </div>

                </div>
            </div>
        </section>

        <section class="section feedback" id="feedback">
            <div class="container">
                <div class="feedback-panel" data-reveal>
                    <div class="feedback-panel__copy">
                        <p class="eyebrow"><span class="eyebrow__num">09</span> Buku tamu</p>
                        <h2>Kesan &amp; pesan</h2>
                        <p>Terima kasih sudah mampir. Tinggalkan kesan, saran, atau pesan yang bisa membantu saya berkembang.</p>
                        <span class="feedback-panel__quote" aria-hidden="true"><i class="ri-double-quotes-r"></i></span>
                    </div>

                    <form action="{{ route('feedback.store') }}" method="POST" class="form feedback-form">
                        @csrf
                        <input type="hidden" name="kind" value="guestbook">
                        <div class="field">
                            <label for="feedback-name">Nama</label>
                            <input id="feedback-name" type="text" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Nama Anda" autocomplete="name">
                            @error('name')<p class="form__error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="feedback-message-input">Kesan dan pesan</label>
                            <textarea id="feedback-message-input" name="message" required maxlength="10000" placeholder="Tulis kesan dan pesan Anda...">{{ old('message') }}</textarea>
                            @error('message')<p class="form__error">{{ $message }}</p>@enderror
                        </div>
                        @if (session('feedback_success'))
                            <p class="form__success" role="status">
                                <i class="ri-checkbox-circle-line" aria-hidden="true"></i>
                                {{ session('feedback_success') }}
                            </p>
                        @endif
                        <button type="submit" class="btn btn--primary">
                            Kirim kesan &amp; pesan <i class="ri-send-plane-line" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="footer__brand">
                    <span class="brand is-static" aria-label="Portofolio — Beranda" aria-disabled="true" tabindex="-1">
                        <span class="brand__text">Portofolio</span>
                    </span>
                    <p>{{ $profile->summary }}</p>
                </div>

                <nav class="footer__nav" aria-label="Navigasi footer">
                    <p class="footer__nav-title">Jelajahi</p>
                    <ul>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#skills">Keahlian</a></li>
                        <li><a href="#projects">Proyek</a></li>
                        <li><a href="#experiences">Pengalaman</a></li>
                        <li><a href="#testimonials">Testimoni</a></li>
                    </ul>
                </nav>

                <div class="footer__contact">
                    <p class="footer__nav-title">Terhubung</p>
                    @if ($profile->email)
                        <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                    @endif
                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer">GitHub</a>
                    @endif
                    @if ($profile->instagram_url)
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer">Instagram</a>
                    @endif
                    <a href="#feedback">Kesan &amp; pesan</a>
                </div>
            </div>

            <div class="footer__bottom">
                <p>&copy; {{ date('Y') }} {{ $name }}. Semua hak dilindungi.</p>
                <p>Dirancang &amp; dibangun dengan <i class="ri-heart-3-line" aria-hidden="true"></i> dan ketelitian.</p>
            </div>
        </div>
    </footer>

    <button type="button" class="scroll-up" id="scroll-up" aria-label="Kembali ke atas">
        <i class="ri-arrow-up-line" aria-hidden="true"></i>
    </button>

    @vite(['resources/js/app.js'])
</body>
</html>
