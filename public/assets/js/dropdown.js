document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.main-nav') && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
        }
    });
    
    // For smaller screens, add auth buttons to mobile menu
    function updateMobileMenu() {
        if (window.innerWidth <= 768) {
            // Check if auth buttons are already in mobile menu
            if (!document.querySelector('.auth-mobile')) {
                const authButtons = document.querySelector('.auth').cloneNode(true);
                authButtons.classList.add('auth-mobile');
                navLinks.appendChild(authButtons);
                
                // Re-attach event listeners to the cloned buttons
                authButtons.querySelector('#openLoginModal').addEventListener('click', function() {
                    document.getElementById('loginModal').style.display = 'flex';
                    navLinks.classList.remove('active');
                });
                
                authButtons.querySelector('#openRegisterModal').addEventListener('click', function() {
                    document.getElementById('registerModal').style.display = 'flex';
                    navLinks.classList.remove('active');
                });
            }
        }
    }
    
    // Run on page load
    updateMobileMenu();
    
    // Run when window is resized
    window.addEventListener('resize', updateMobileMenu);
});