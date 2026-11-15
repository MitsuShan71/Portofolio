const body = document.body;
const root = document.documentElement;
const navToggles = document.querySelectorAll('[data-admin-nav-toggle]');
const mobileToggle = document.querySelector('[data-admin-nav-toggle][aria-controls="admin-sidebar"]');
const themeToggles = document.querySelectorAll('[data-theme-toggle]');
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function setNavigation(open) {
    body.classList.toggle('admin-nav-open', open);

    navToggles.forEach((toggle) => {
        if (toggle.hasAttribute('aria-expanded')) {
            toggle.setAttribute('aria-expanded', String(open));
        }
    });

    if (mobileToggle) {
        mobileToggle.setAttribute('aria-label', open ? 'Tutup navigasi' : 'Buka navigasi');
    }
}

navToggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
        setNavigation(!body.classList.contains('admin-nav-open'));
    });
});

document.querySelectorAll('.admin-nav__link').forEach((link) => {
    link.addEventListener('click', () => {
        if (body.classList.contains('admin-nav-open')) {
            setNavigation(false);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && body.classList.contains('admin-nav-open')) {
        setNavigation(false);
        mobileToggle?.focus();
    }
});

function applyTheme(theme) {
    root.dataset.theme = theme;

    themeToggles.forEach((toggle) => {
        const nextTheme = theme === 'light' ? 'dark' : 'light';
        const label = nextTheme === 'light' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';

        toggle.innerHTML = `<i class="ri-${nextTheme === 'light' ? 'sun' : 'moon'}-line" aria-hidden="true"></i>`;
        toggle.setAttribute('aria-label', label);
        toggle.title = label;
    });
}

let themeTransitioning = false;
let fallbackTimeout;

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
        root.classList.add('theme-transition');
        commitTheme(theme);

        window.clearTimeout(fallbackTimeout);
        fallbackTimeout = window.setTimeout(() => {
            root.classList.remove('theme-transition');
            themeTransitioning = false;
        }, 520);

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
            root.animate(
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

applyTheme(localStorage.getItem('portfolio-theme') === 'light' ? 'light' : 'dark');

themeToggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
        const nextTheme = root.dataset.theme === 'light' ? 'dark' : 'light';

        transitionTheme(nextTheme, toggle);
    });
});

document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    const input = document.getElementById(toggle.dataset.passwordToggle);

    if (!input) return;

    toggle.addEventListener('click', () => {
        const revealing = input.type === 'password';

        input.type = revealing ? 'text' : 'password';
        toggle.innerHTML = `<i class="ri-${revealing ? 'eye-off' : 'eye'}-line" aria-hidden="true"></i>`;
        toggle.setAttribute('aria-label', revealing ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });
});

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});
