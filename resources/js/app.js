document.documentElement.classList.add('js');

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const header = document.getElementById('header');
const navMenu = document.getElementById('nav-menu');
const navToggle = document.getElementById('nav-toggle');
const navToggleIcon = navToggle?.querySelector('i');
const navLinks = Array.from(document.querySelectorAll('.nav__link'));
const themeToggle = document.getElementById('theme-toggle');
const scrollUp = document.getElementById('scroll-up');
const scrollProgress = document.getElementById('scroll-progress-bar');

function closeNavigation() {
    if (!navMenu || !navToggle) return;

    navMenu.classList.remove('is-open');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.setAttribute('aria-label', 'Buka menu');
    document.body.classList.remove('nav-open');

    if (navToggleIcon) {
        navToggleIcon.className = 'ri-menu-line';
    }
}

if (navMenu && navToggle) {
    navToggle.addEventListener('click', () => {
        const willOpen = !navMenu.classList.contains('is-open');

        navMenu.classList.toggle('is-open', willOpen);
        navToggle.setAttribute('aria-expanded', String(willOpen));
        navToggle.setAttribute('aria-label', willOpen ? 'Tutup menu' : 'Buka menu');
        document.body.classList.toggle('nav-open', willOpen);

        if (navToggleIcon) {
            navToggleIcon.className = willOpen ? 'ri-close-line' : 'ri-menu-line';
        }
    });

    navLinks.forEach((link) => link.addEventListener('click', closeNavigation));

    document.addEventListener('click', (event) => {
        if (!navMenu.classList.contains('is-open')) return;
        if (navMenu.contains(event.target) || navToggle.contains(event.target)) return;

        closeNavigation();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeNavigation();
    });

    window.matchMedia('(min-width: 1024px)').addEventListener('change', (event) => {
        if (event.matches) closeNavigation();
    });
}

function applyTheme(theme) {
    document.documentElement.dataset.theme = theme;

    if (!themeToggle) return;

    const nextTheme = theme === 'dark' ? 'light' : 'dark';
    const nextLabel = nextTheme === 'light' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';

    themeToggle.innerHTML = `<i class="ri-${nextTheme === 'light' ? 'sun' : 'moon'}-line" aria-hidden="true"></i>`;
    themeToggle.setAttribute('aria-label', nextLabel);
    themeToggle.title = nextLabel;
}

const savedTheme = localStorage.getItem('portfolio-theme');
applyTheme(savedTheme === 'light' ? 'light' : 'dark');

let themeTransitioning = false;
let themeTransitionTimeout;

function commitTheme(theme) {
    localStorage.setItem('portfolio-theme', theme);
    applyTheme(theme);
}

function transitionTheme(theme, trigger) {
    if (themeTransitioning) return;

    if (prefersReducedMotion) {
        commitTheme(theme);
        return;
    }

    if (!document.startViewTransition) {
        themeTransitioning = true;
        document.documentElement.classList.add('theme-transition');
        commitTheme(theme);

        window.clearTimeout(themeTransitionTimeout);
        themeTransitionTimeout = window.setTimeout(() => {
            document.documentElement.classList.remove('theme-transition');
            themeTransitioning = false;
        }, 550);

        return;
    }

    const rect = trigger.getBoundingClientRect();
    const x = rect.left + rect.width / 2;
    const y = rect.top + rect.height / 2;
    const radius = Math.hypot(
        Math.max(x, window.innerWidth - x),
        Math.max(y, window.innerHeight - y)
    );

    themeTransitioning = true;

    const viewTransition = document.startViewTransition(() => commitTheme(theme));

    viewTransition.ready
        .then(() => {
            document.documentElement.animate(
                {
                    clipPath: [
                        `circle(0px at ${x}px ${y}px)`,
                        `circle(${radius}px at ${x}px ${y}px)`,
                    ],
                },
                {
                    duration: 620,
                    easing: 'cubic-bezier(0.22, 0.61, 0.36, 1)',
                    fill: 'forwards',
                    pseudoElement: '::view-transition-new(root)',
                }
            );
        })
        .catch(() => {});

    viewTransition.finished.finally(() => {
        themeTransitioning = false;
    });
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';

        transitionTheme(nextTheme, themeToggle);
    });
}

const navSections = Array.from(document.querySelectorAll('main section[id]')).filter((section) =>
    document.querySelector(`.nav__link[href="#${section.id}"]`)
);

function updateActiveSection() {
    if (!navSections.length) return;

    const threshold = window.scrollY + (header?.offsetHeight ?? 0) + 140;
    let activeSection = null;

    navSections.forEach((section) => {
        if (threshold >= section.offsetTop) activeSection = section;
    });

    navLinks.forEach((link) => {
        const isActive = activeSection !== null && link.getAttribute('href') === `#${activeSection.id}`;

        link.classList.toggle('active-link', isActive);

        if (isActive) {
            link.setAttribute('aria-current', 'true');
        } else {
            link.removeAttribute('aria-current');
        }
    });
}

let scrollFrame = 0;

function updateScrollState() {
    const scrollY = window.scrollY;

    header?.classList.toggle('is-scrolled', scrollY > 24);
    scrollUp?.classList.toggle('show-scroll', scrollY > 420);

    if (scrollProgress) {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const progress = scrollable > 0 ? Math.min(scrollY / scrollable, 1) : 0;

        scrollProgress.style.transform = `scaleX(${progress})`;
    }

    updateActiveSection();
    scrollFrame = 0;
}

function scheduleScrollState() {
    if (scrollFrame) return;

    scrollFrame = window.requestAnimationFrame(updateScrollState);
}

window.addEventListener('scroll', scheduleScrollState, { passive: true });
window.addEventListener('resize', scheduleScrollState, { passive: true });
updateScrollState();

scrollUp?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
});

const revealTargets = document.querySelectorAll('[data-reveal]');

if (prefersReducedMotion || !('IntersectionObserver' in window)) {
    revealTargets.forEach((target) => target.classList.add('is-visible'));
} else {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

    revealTargets.forEach((target) => revealObserver.observe(target));
}

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.getAttribute('content');

    const input = document.querySelector('input[name="_token"]');
    return input ? input.value : '';
}

const contactForm = document.getElementById('contact-form');
const contactMessage = document.getElementById('contact-message');

if (contactForm && contactMessage) {
    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const submitButton = contactForm.querySelector('[type="submit"]');
        const originalMarkup = submitButton?.innerHTML;

        contactMessage.textContent = '';
        contactMessage.className = 'form__status';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Mengirim...';
        }

        try {
            const response = await fetch(contactForm.action, {
                method: contactForm.method || 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: new FormData(contactForm),
            });

            let data = {};

            try {
                data = await response.json();
            } catch {
                data = {};
            }

            if (response.status === 503) {
                contactMessage.textContent = data.message || 'Pesan tersimpan, tetapi email belum terkirim.';
                contactMessage.classList.add('is-warning');
                contactForm.reset();
                return;
            }

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    const firstError = Object.values(data.errors).flat()[0];
                    throw new Error(firstError || 'Periksa kembali isian Anda.');
                }

                throw new Error(data.message || 'Pesan gagal dikirim. Silakan coba lagi.');
            }

            contactMessage.textContent = data.message || 'Pesan berhasil dikirim. Terima kasih!';
            contactMessage.classList.add('is-success');
            contactForm.reset();
        } catch (error) {
            contactMessage.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
            contactMessage.classList.add('is-error');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalMarkup;
            }
        }
    });
}

document.querySelectorAll('[data-open-project]').forEach((button) => {
    button.addEventListener('click', () => {
        const dialog = document.getElementById(button.dataset.openProject);

        if (dialog instanceof HTMLDialogElement) {
            dialog.showModal();
            document.body.classList.add('dialog-open');
        }
    });
});

document.querySelectorAll('[data-close-project]').forEach((button) => {
    button.addEventListener('click', () => {
        button.closest('dialog')?.close();
    });
});

document.querySelectorAll('.project-dialog').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) dialog.close();
    });

    dialog.addEventListener('close', () => {
        if (!document.querySelector('.project-dialog[open]')) {
            document.body.classList.remove('dialog-open');
        }
    });
});

if (!prefersReducedMotion && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('[data-glow]').forEach((element) => {
        element.addEventListener('pointermove', (event) => {
            const bounds = element.getBoundingClientRect();

            element.style.setProperty('--pointer-x', `${event.clientX - bounds.left}px`);
            element.style.setProperty('--pointer-y', `${event.clientY - bounds.top}px`);
        });
    });
}
