const navMenu = document.getElementById('nav-menu');
const navToggle = document.getElementById('nav-toggle');
const navLinks = document.querySelectorAll('.nav__link');

if (navToggle) {
    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show-menu');
    });
}

navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('show-menu');
    });
});

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
