document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.mobile-nav-toggle');
    const mobileNav = document.querySelector('.mobile-nav');

    toggle.addEventListener('click', function() {
        toggle.classList.toggle('open');
        mobileNav.classList.toggle('open');
    });
});
