<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio-UKK</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">Portfolio</a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li><a href="#home" class="nav__link active-link">Home</a></li>
                    <li><a href="#about" class="nav__link">About</a></li>
                    <li><a href="#skills" class="nav__link">Skills</a></li>
                    <li><a href="#projects" class="nav__link">Projects</a></li>
                    <li><a href="#contact" class="nav__link nav__link--contact">Contact</a></li>
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class="ri-close-line"></i>
                </div>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-menu-line"></i>
            </div>
        </nav>
    </header>

    <main class="main">
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__image">
                    <div class="profile-frame">
                        <img src="{{ asset('ShanFavian.jpg') }}" alt="Shan Favian">
                    </div>
                </div>

                <div class="home__content">
                    <div class="home__data">
                        <p class="home__greeting">Hallo...</p>
                        <h1 class="home__title">I'm Shan Favian Efendy</h1>
                        <p class="home__description">Passionate web developer dedicated to building scalable and user-friendly applications.</p>

                        <div class="home__buttons">
                            <a href="#contact" class="button">Contact me <i class="ri-arrow-right-line"></i></a>
                            <a href="#projects" class="button button--outline">View Projects</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="section-divider">

        <section class="about section" id="about">
            <div class="about__container container">
                <div class="about__data">
                    <span class="section__subtitle"><span>Discover</span></span>
                    <h2 class="section__title">About Me</h2>
                    <div class="about__box">
                        <p class="about__description">
                            I'm a UI/UX Designer & Web Developer with a passion for creating clean,
                            user-friendly digital experiences. I focus on combining aesthetics with
                            functionality to build meaningful products.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <section class="skills section" id="skills">
            <div class="skills__container container grid">
                <div class="skills__data">
                    <span class="section__subtitle"><span>Expertise</span></span>
                    <h2 class="section__title">My Skills</h2>
                    <p class="skills__description">
                        I continuously learn and adapt to new technologies. Here are the skills I've acquired
                        through years of hands-on experience in web development.
                    </p>
                </div>

                <div class="skills__content">
                    <div class="skills__boxes">
                        <div class="skill-box-wrapper">
                            <div class="skill-box">
                                <img src="{{ asset('Figma.png') }}" alt="Figma" class="skill-box__icon">
                            </div>
                            <span class="skill-box__label">Figma</span>
                        </div>
                        <div class="skill-box-wrapper">
                            <div class="skill-box">
                                <img src="{{ asset('HTML.png') }}" alt="HTML" class="skill-box__icon">
                            </div>
                            <span class="skill-box__label">HTML</span>
                        </div>
                        <div class="skill-box-wrapper">
                            <div class="skill-box">
                                <img src="{{ asset('CSS.png') }}" alt="CSS" class="skill-box__icon">
                            </div>
                            <span class="skill-box__label">CSS</span>
                        </div>
                        <div class="skill-box-wrapper">
                            <div class="skill-box">
                                <img src="{{ asset('JS.png') }}" alt="JS" class="skill-box__icon">
                            </div>
                            <span class="skill-box__label">JS</span>
                        </div>
                        <div class="skill-box-wrapper">
                            <div class="skill-box">
                                <img src="{{ asset('MySQL.png') }}" alt="MySQL" class="skill-box__icon">
                            </div>
                            <span class="skill-box__label">MySQL</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="projects section" id="projects">
            <span class="section__subtitle"><span>Showcase</span></span>
            <h2 class="section__title">My Featured Projects</h2>

            <div class="projects__container container grid">
                @forelse ($projects as $project)
                    <div class="projects__card">
                        @if ($project->image)
                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="projects__img">
                        @else
                            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=350&h=250&fit=crop" alt="{{ $project->title }}" class="projects__img">
                        @endif
                        <div class="projects__modal">
                            <h3 class="projects__title">{{ $project->title }}</h3>
                            <a href="{{ $project->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="projects__button">
                                View Project <i class="ri-external-link-line"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: var(--color-text); grid-column: 1 / -1;">No projects to display yet.</p>
                @endforelse
            </div>
        </section>

        <section class="contact section" id="contact">
            <span class="section__subtitle"><span>Get in Touch</span></span>
            <h2 class="section__title">Contact Me</h2>

            <div class="contact__container container grid">
                <div class="contact__box">
                <form action="{{ route('contact.send') }}" method="POST" class="contact__form" id="contact-form">
                    @csrf
                    <div class="contact__group">
                        <input type="text" name="name" required placeholder="Enter your name" class="contact__input">
                        <input type="email" name="email" required placeholder="Enter your email" class="contact__input">
                    </div>

                    <input type="text" name="subject" required placeholder="Enter subject" class="contact__input">

                    <textarea name="message" required placeholder="Enter your message" class="contact__input"></textarea>

                    <p class="contact__message" id="contact-message"></p>

                    <button type="submit" class="button contact__button">
                        Send Message
                    </button>
                </form>
                </div>
                <div class="contact__info">
                    <div class="contact__info-box">
                        <div class="contact__info-icon">
                            <i class="ri-mail-line"></i>
                        </div>
                        <div class="contact__info-content">
                            <h3 class="contact__info-title">Email</h3>
                            <p class="contact__info-text">shanfavianeffendy@gmail.com</p>
                        </div>
                    </div>
                    <div class="contact__info-box">
                        <div class="contact__info-icon">
                            <i class="ri-whatsapp-line"></i>
                        </div>
                        <div class="contact__info-content">
                            <h3 class="contact__info-title">WhatsApp</h3>
                            <p class="contact__info-text">+6281395445334</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer__container container">

            <div class="footer__social">
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="ri-github-fill"></i>
                </a>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="ri-linkedin-box-fill"></i>
                </a>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="ri-discord-fill"></i>
                </a>
                <a href="#" target="_blank" class="footer__social-link">
                    <i class="ri-instagram-fill"></i>
                </a>
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
