import './bootstrap';
import Alpine from 'alpinejs'
 
window.Alpine = Alpine
 
Alpine.start()
// resources/js/app.js

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    // Toggle the mobile menu
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // JavaScript to handle dropdown menu visibility with delay
    document.querySelectorAll('.relative').forEach(item => {
        let timeout;
        const dropdown = item.querySelector('ul');
        item.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            dropdown.classList.remove('hidden');
        });
        item.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200); // 200ms delay before hiding
        });
        dropdown.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
        });
        dropdown.addEventListener('mouseleave', () => {
            timeout = setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        });
    });
});
