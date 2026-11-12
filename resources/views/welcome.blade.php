<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portfolio-UKK</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container" aria-label="Navigasi utama">
            <a href="#home" class="nav__logo">Portfolio</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li><a href="#home" class="nav__link active-link">Beranda</a></li>
                    <li><a href="#about" class="nav__link">Tentang</a></li>
                    <li><a href="#skills" class="nav__link">Keahlian</a></li>
                    <li><a href="#projects" class="nav__link">Proyek</a></li>
                    <li><a href="#certificates" class="nav__link">Sertifikat</a></li>
                    <li><a href="#experiences" class="nav__link">Pengalaman</a></li>
                    <li><a href="#feedback" class="nav__link">Kesan &amp; Pesan</a></li>
                    <li><a href="#contact" class="nav__link nav__link--contact">Kontak</a></li>
                </ul>
            </div>

            <div class="nav__actions">
                @if (session('admin_logged_in'))
                    <div class="nav__admin">
                        <a href="{{ route('admin.dashboard') }}" class="nav__admin-link">
                            <i class="ri-dashboard-line" aria-hidden="true"></i> Admin
                        </a>
                        <a href="{{ route('admin.logout') }}" class="nav__admin-link" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="ri-logout-box-line" aria-hidden="true"></i> Log out
                        </a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" hidden>@csrf</form>
                    </div>
                @else
                    <a href="{{ route('admin.login') }}" class="nav__login-link">
                        <i class="ri-login-circle-line" aria-hidden="true"></i> Login
                    </a>
                @endif

                <button class="theme-toggle" id="theme-toggle" type="button" aria-label="Switch to light mode" title="Switch to light mode">
                    <i class="ri-sun-line" aria-hidden="true"></i>
                </button>

                <button class="nav__toggle" id="nav-toggle" type="button" aria-label="Buka navigasi" aria-controls="nav-menu" aria-expanded="false">
                    <i class="ri-menu-line" aria-hidden="true"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="main">
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__image">
                    <div class="profile-frame">
                        <img src="{{ $profile->profile_image ? Storage::url($profile->profile_image) : asset('ShanFavian.jpg') }}" alt="{{ $profile->full_name }}">
                    </div>
                </div>

                <div class="home__content">
                    <div class="home__data">
                        <p class="home__greeting">Halo, saya</p>
                        <h1 class="home__title">{{ $profile->full_name }}</h1>
                        <p class="home__education">Kelas {{ trim($profile->class_name . ' — ' . $profile->competency, ' —') }}</p>
                        <p class="home__description">{{ $profile->summary }}</p>

                        <div class="home__buttons">
                            <a href="#projects" class="button">Lihat Portfolio <i class="ri-arrow-right-line"></i></a>
                            <a href="{{ $profile->resume_file ? Storage::url($profile->resume_file) : asset('cv-shan-favian-efendy.pdf') }}" class="button button--outline" target="_blank" rel="noopener noreferrer">Lihat CV</a>
                            <a href="#contact" class="button button--outline">Hubungi Saya</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="section-divider">

        <section class="about section" id="about">
            <div class="about__container container">
                <div class="about__data">
                    <span class="section__subtitle"><span>Tentang Saya</span></span>
                    <h2 class="section__title">Profil dan Perjalanan</h2>
                    <div class="about__box">
                        <h3>Biodata Singkat</h3>
                        <p class="about__description">{{ $profile->bio }}</p>

                        <h3>Riwayat Pendidikan</h3>
                        <p class="about__description about__preline">{{ $profile->education }}</p>

                        <h3>Minat</h3>
                        <p class="about__description">{{ $profile->summary }}</p>

                        <h3>Tujuan Karir</h3>
                        <p class="about__description">{{ $profile->career_goal }}</p>
                    </div>
                </div>
            </div>
        </section>

        <hr class="section-divider">

        <section class="skills section" id="skills">
            <div class="skills__container container grid">
                <div class="skills__data">
                    <span class="section__subtitle"><span>Keahlian</span></span>
                    <h2 class="section__title">Keahlian Utama</h2>
                    <p class="skills__description">Teknologi dan alat yang saya gunakan.</p>
                </div>

                <div class="skills__content">
                    @foreach (['hard' => 'Hard Skill', 'soft' => 'Soft Skill'] as $category => $label)
                        <div class="skill-category">
                            <h3>{{ $label }}</h3>
                            @forelse ($skills->get($category, collect()) as $skill)
                                <div class="skill-meter">
                                    <div class="skill-meter__label">
                                        <span>{{ $skill->name }}</span>
                                        <span>{{ $skill->percentage }}%</span>
                                    </div>
                                    <div class="skill-meter__track" role="progressbar" aria-label="{{ $skill->name }}" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $skill->percentage }}">
                                        <span style="width: {{ $skill->percentage }}%"></span>
                                    </div>
                                </div>
                            @empty
                                <p class="skills__description">Belum ada {{ strtolower($label) }} yang ditambahkan.</p>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="projects section" id="projects">
            <span class="section__subtitle"><span>Galeri</span></span>
            <h2 class="section__title">Proyek Saya</h2>

            <div class="projects__container container grid">
                @forelse ($projects as $project)
                    <article class="projects__card">
                        @if ($project->image)
                            <img src="{{ Storage::url($project->image) }}" alt="Dokumentasi {{ $project->title }}" class="projects__img">
                        @else
                            <div class="projects__no-image">Dokumentasi belum tersedia</div>
                        @endif
                        <div class="projects__modal">
                            <h3 class="projects__title">{{ $project->title }}</h3>
                            <p class="projects__description">{{ $project->description }}</p>
                            <button type="button" class="projects__button projects__preview-button" data-open-project="project-{{ $project->id }}">
                                Pratinjau detail <i class="ri-eye-line"></i>
                            </button>
                        </div>

                        <dialog class="project-dialog" id="project-{{ $project->id }}">
                            <div class="project-dialog__header">
                                <h3>{{ $project->title }}</h3>
                                <button type="button" class="project-dialog__close" aria-label="Tutup detail proyek" data-close-project>&times;</button>
                            </div>
                            <div class="project-dialog__body">
                                @if ($project->image)
                                    <img src="{{ Storage::url($project->image) }}" alt="Dokumentasi {{ $project->title }}" class="project-dialog__image">
                                @endif
                                @foreach ([
                                    'Deskripsi' => $project->description,
                                    'Permasalahan' => $project->problem_solved,
                                    'Tujuan' => $project->objective,
                                    'Teknologi' => $project->technologies,
                                    'Peran' => $project->role,
                                    'Fitur' => $project->features,
                                    'Detail proyek' => $project->details,
                                    'Dokumentasi proses' => $project->process_documentation,
                                    'Feedback user' => $project->user_feedback,
                                ] as $label => $content)
                                    @if ($content)
                                        <section class="project-dialog__section">
                                            <h4>{{ $label }}</h4>
                                            <p>{{ $content }}</p>
                                        </section>
                                    @endif
                                @endforeach
                                <div class="project-dialog__links">
                                    @if ($project->demo_link ?? $project->link)
                                        <a class="button" href="{{ $project->demo_link ?? $project->link }}" target="_blank" rel="noopener noreferrer">Lihat Demo</a>
                                    @endif
                                    @if ($project->github_link)
                                        <a class="button button--outline" href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer">Source Code</a>
                                    @endif
                                </div>
                            </div>
                        </dialog>
                    </article>
                @empty
                    <p class="empty-state">Belum ada proyek yang ditambahkan.</p>
                @endforelse
            </div>
        </section>

        <section class="certificates section" id="certificates">
            <span class="section__subtitle"><span>Pencapaian</span></span>
            <h2 class="section__title">Sertifikat dan Prestasi</h2>
            <div class="certificates__container container grid">
                @forelse ($certificates as $certificate)
                    <article class="certificate-card">
                        @if ($certificate->documentation && !str_ends_with(strtolower($certificate->documentation), '.pdf'))
                            <img src="{{ Storage::url($certificate->documentation) }}" alt="Dokumentasi {{ $certificate->title }}">
                        @endif
                        <div class="certificate-card__body">
                            <h3>{{ $certificate->title }}</h3>
                            @if ($certificate->date)<p>{{ $certificate->date->format('d M Y') }}</p>@endif
                            @if ($certificate->description)<p>{{ $certificate->description }}</p>@endif
                            @if ($certificate->documentation)
                                <a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer">Lihat dokumentasi</a>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="empty-state">Belum ada sertifikat atau prestasi yang ditambahkan.</p>
                @endforelse
            </div>
        </section>

        <section class="experiences section" id="experiences">
            <span class="section__subtitle"><span>Perjalanan</span></span>
            <h2 class="section__title">Pengalaman</h2>
            <div class="experience__container container">
                @foreach (['plk' => 'Pengalaman PLK', 'organization' => 'Organisasi dan Kepanitiaan', 'competition' => 'Pengalaman Lomba'] as $category => $label)
                    <div class="experience-category">
                        <h3>{{ $label }}</h3>
                        <div class="experience-category__items">
                            @forelse ($experiences->get($category, collect()) as $experience)
                                <article class="experience-card">
                                    <h4>{{ $experience->title }}</h4>
                                    <p><strong>{{ $experience->role }}</strong> · {{ $experience->organization }}</p>
                                    <p>{{ $experience->start_date->format('d M Y') }}@if ($experience->end_date) — {{ $experience->end_date->format('d M Y') }}@endif</p>
                                    @if ($experience->description)<p>{{ $experience->description }}</p>@endif
                                    @if ($experience->documentation)
                                        <a href="{{ Storage::url($experience->documentation) }}" target="_blank" rel="noopener noreferrer">Lihat dokumentasi</a>
                                    @endif
                                </article>
                            @empty
                                <p class="empty-state">Belum ada pengalaman yang ditambahkan.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="contact section" id="contact">
            <span class="section__subtitle"><span>Hubungi Saya</span></span>
            <h2 class="section__title">Kontak</h2>

            <div class="contact__container container grid">
                <div class="contact__box">
                    <form action="{{ route('contact.send') }}" method="POST" class="contact__form" id="contact-form">
                        @csrf
                        <input type="text" name="name" required maxlength="255" placeholder="Nama" class="contact__input">
                        <input type="email" name="email" required maxlength="255" placeholder="Email" class="contact__input">
                        <textarea name="message" required placeholder="Pesan" class="contact__input"></textarea>
                        <p class="contact__message" id="contact-message" role="status" aria-live="polite"></p>
                        <button type="submit" class="button contact__button">Kirim Pesan</button>
                    </form>
                </div>
                <div class="contact__info">
                    @if ($profile->email)
                        <a href="mailto:{{ $profile->email }}" class="contact__info-box">
                            <div class="contact__info-icon"><i class="ri-mail-line"></i></div>
                            <div class="contact__info-content"><h3 class="contact__info-title">Email</h3><p class="contact__info-text">{{ $profile->email }}</p></div>
                        </a>
                    @endif
                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="contact__info-box">
                            <div class="contact__info-icon"><i class="ri-github-line"></i></div>
                            <div class="contact__info-content"><h3 class="contact__info-title">GitHub</h3><p class="contact__info-text">{{ $profile->github_url }}</p></div>
                        </a>
                    @endif
                    @if ($profile->instagram_url)
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="contact__info-box">
                            <div class="contact__info-icon"><i class="ri-instagram-line"></i></div>
                            <div class="contact__info-content"><h3 class="contact__info-title">Instagram</h3><p class="contact__info-text">{{ $profile->instagram_url }}</p></div>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="feedback section" id="feedback">
            <span class="section__subtitle"><span>Masukan</span></span>
            <h2 class="section__title">Kesan dan Pesan</h2>
            <form action="{{ route('feedback.store') }}" method="POST" class="feedback__form container">
                @csrf
                <label for="feedback-name">Nama</label>
                <input id="feedback-name" type="text" name="name" maxlength="255" value="{{ old('name') }}" required class="contact__input">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
                <label for="feedback-message">Kesan dan pesan</label>
                <textarea id="feedback-message" name="message" required maxlength="10000" class="contact__input">{{ old('message') }}</textarea>
                @error('message')<p class="form-error">{{ $message }}</p>@enderror
                @if (session('feedback_success'))<p class="feedback__success" role="status">{{ session('feedback_success') }}</p>@endif
                <button type="submit" class="button">Kirim Kesan dan Pesan</button>
            </form>
        </section>
    </main>

    <hr class="section-divider">

    <footer class="footer">
        <div class="footer__container container">
            <div class="footer__social">
                @if ($profile->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="footer__social-link" aria-label="GitHub">
                        <i class="ri-github-fill"></i>
                    </a>
                @endif
                @if ($profile->instagram_url)
                    <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="footer__social-link" aria-label="Instagram">
                        <i class="ri-instagram-fill"></i>
                    </a>
                @endif
            </div>

            <span class="footer__copy">
                &copy; {{ date('Y') }} SMKN 2 Banjarmasin.
            </span>
        </div>
    </footer>

    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line"></i>
    </a>

    @vite(['resources/js/app.js'])
</body>
</html>
