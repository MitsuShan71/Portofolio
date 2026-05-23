const navMenu = document.getElementById('nav-menu');
const navToggle = document.getElementById('nav-toggle');
const navClose = document.getElementById('nav-close');
const navLinks = document.querySelectorAll('.nav__link');

if (navToggle) {
    navToggle.addEventListener('click', () => {
        navMenu.classList.add('show-menu');
    });
}

if (navClose) {
    navClose.addEventListener('click', () => {
        navMenu.classList.remove('show-menu');
    });
}

navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('show-menu');
    });
});

const header = document.getElementById('header');
function scrollHeader() {
    if (this.scrollY >= 50) {
        header.classList.add('blur-header');
    } else {
        header.classList.remove('blur-header');
    }
}
window.addEventListener('scroll', scrollHeader);

const scrollUp = () => {
    const scrollUpBtn = document.getElementById('scroll-up');
    if (this.scrollY >= 350) {
        scrollUpBtn.classList.add('show-scroll');
    } else {
        scrollUpBtn.classList.remove('show-scroll');
    }
}
window.addEventListener('scroll', scrollUp);

const sections = document.querySelectorAll('section[id]');
function scrollActive() {
    const scrollY = window.pageYOffset;

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

const sr = window.scrollReveal || null;

const contactForm = document.getElementById('contact-form');
const contactMessage = document.getElementById('contact-message');

if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        
        try {
            const response = await fetch(contactForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });
            
            if (!response.ok) {
                const data = await response.json();
                throw new Error(data.message || 'Something went wrong');
            }
            
            const data = await response.json();
            contactMessage.textContent = data.message || 'Message sent successfully!';
            
            setTimeout(() => {
                contactMessage.textContent = '';
            }, 5000);
            
            contactForm.reset();
        } catch (error) {
            contactMessage.textContent = error.message || 'Something went wrong!';
            
            setTimeout(() => {
                contactMessage.textContent = '';
            }, 5000);
        }
    });
}
