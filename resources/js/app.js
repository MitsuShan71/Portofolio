const navMenu = document.getElementById('nav-menu');
const navToggle = document.getElementById('nav-toggle');
const navLinks = document.querySelectorAll('.nav__link');
const navToggleIcon = navToggle?.querySelector('i');

function closeNavigation() {
    if (!navMenu || !navToggle) return;
    navMenu.classList.remove('show-menu');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.setAttribute('aria-label', 'Buka navigasi');
    if (navToggleIcon) navToggleIcon.className = 'ri-menu-line';
}

if (navMenu && navToggle) {
    navToggle.addEventListener('click', () => {
        const isOpen = navMenu.classList.toggle('show-menu');
        navToggle.setAttribute('aria-expanded', String(isOpen));
        navToggle.setAttribute('aria-label', isOpen ? 'Tutup navigasi' : 'Buka navigasi');
        if (navToggleIcon) navToggleIcon.className = isOpen ? 'ri-close-line' : 'ri-menu-line';
    });

    navLinks.forEach(link => link.addEventListener('click', closeNavigation));

    document.addEventListener('click', event => {
        const path = event.composedPath();
        if (!path.includes(navMenu) && !path.includes(navToggle)) closeNavigation();
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeNavigation();
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1400) closeNavigation();
    });
}

const header = document.getElementById('header');
function scrollHeader() {
    if (window.scrollY >= 50) {
        header.classList.add('blur-header');
    } else {
        header.classList.remove('blur-header');
    }
}
window.addEventListener('scroll', scrollHeader);

const scrollUp = () => {
    const scrollUpBtn = document.getElementById('scroll-up');
    if (window.scrollY >= 350) {
        scrollUpBtn.classList.add('show-scroll');
    } else {
        scrollUpBtn.classList.remove('show-scroll');
    }
}
window.addEventListener('scroll', scrollUp);

const sections = document.querySelectorAll('section[id]');
function scrollActive() {
    const scrollY = window.scrollY;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 58;
        const sectionId = current.getAttribute('id');
        const sectionClass = document.querySelector('.nav__list a[href*=' + sectionId + ']');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            if (sectionClass) sectionClass.classList.add('active-link');
        } else {
            if (sectionClass) sectionClass.classList.remove('active-link');
        }
    });
}
window.addEventListener('scroll', scrollActive);

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta) return meta.getAttribute('content');
    const input = document.querySelector('input[name="_token"]');
    if (input) return input.value;
    return '';
}

const contactForm = document.getElementById('contact-form');
const contactMessage = document.getElementById('contact-message');

if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        const csrfToken = getCsrfToken();

        try {
            const response = await fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    const firstError = Object.values(data.errors)[0][0];
                    throw new Error(firstError || 'Validation failed.');
                }
                throw new Error(data.message || 'Something went wrong');
            }

            contactMessage.textContent = data.message || 'Message sent successfully!';
            contactMessage.style.color = '#50C878';

            setTimeout(() => {
                contactMessage.textContent = '';
            }, 5000);

            contactForm.reset();
        } catch (error) {
            contactMessage.textContent = error.message || 'Something went wrong!';
            contactMessage.style.color = '#dc3545';

            setTimeout(() => {
                contactMessage.textContent = '';
            }, 5000);
        }
    });
}
const themeToggle = document.getElementById('theme-toggle');

if (themeToggle) {
    const savedTheme = localStorage.getItem('portfolio-theme');
    const initialTheme = savedTheme === 'light' ? 'light' : 'dark';

    const applyTheme = theme => {
        document.documentElement.dataset.theme = theme;
        const nextTheme = theme === 'dark' ? 'light' : 'dark';
        themeToggle.innerHTML = `<i class="ri-${nextTheme === 'light' ? 'sun' : 'moon'}-line" aria-hidden="true"></i>`;
        themeToggle.setAttribute('aria-label', `Switch to ${nextTheme} mode`);
        themeToggle.title = `Switch to ${nextTheme} mode`;
    };

    applyTheme(initialTheme);

    themeToggle.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('portfolio-theme', nextTheme);
        applyTheme(nextTheme);
    });
}

document.querySelectorAll('[data-open-project]').forEach(button => {
    button.addEventListener('click', () => {
        const dialog = document.getElementById(button.dataset.openProject);
        if (dialog instanceof HTMLDialogElement) dialog.showModal();
    });
});

document.querySelectorAll('[data-close-project]').forEach(button => {
    button.addEventListener('click', () => button.closest('dialog')?.close());
});

document.querySelectorAll('.project-dialog').forEach(dialog => {
    dialog.addEventListener('click', event => {
        if (event.target === dialog) dialog.close();
    });
});

const revealTargets = document.querySelectorAll(
    'main > .section:not(#home) > .section__subtitle, main > .section:not(#home) > .section__title, main > .section:not(#home) > .container'
);

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });

    revealTargets.forEach(target => {
        target.classList.add('reveal-on-scroll');
        revealObserver.observe(target);
    });
} else {
    revealTargets.forEach(target => target.classList.add('is-visible'));
}
