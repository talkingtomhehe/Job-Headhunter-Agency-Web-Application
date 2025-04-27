document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap-style navbar toggle
    const navbarToggle = document.querySelector('.navbar-toggle');
    const mainNav = document.getElementById('mainNav');
    const body = document.body;
    
    // Create overlay element for faded background
    const overlay = document.querySelector('.nav-overlay') || (() => {
        const el = document.createElement('div');
        el.className = 'nav-overlay';
        body.appendChild(el);
        return el;
    })();
    
    // Toggle mobile menu
    if (navbarToggle && mainNav) {
        navbarToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mainNav.classList.toggle('in');
            body.classList.toggle('nav-open');
            overlay.classList.toggle('active');
            
            // Set aria attributes for accessibility
            const isExpanded = mainNav.classList.contains('in');
            navbarToggle.setAttribute('aria-expanded', isExpanded);
        });
    }
    
    // Fix for dropdown menus in mobile view
    function setupDropdownBehavior() {
        // Get all dropdown toggle links
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            // Remove existing event listeners by cloning and replacing
            const parent = toggle.closest('.dropdown');
            
            // Split the toggle into text and caret for mobile
            if (window.innerWidth <= 768) {
                // Get the text part of the toggle (without the caret)
                const toggleText = toggle.childNodes[0];
                const toggleHref = toggle.getAttribute('href');
                
                // Make clicking on text part navigate directly
                toggle.addEventListener('click', function(e) {
                    // Allow the click to go through for the text part but not the caret
                    if (!e.target.classList.contains('fa-caret-down')) {
                        // Navigate to the All Jobs page
                        window.location.href = toggleHref;
                        e.stopPropagation(); // Prevent dropdown from opening
                    } else {
                        // If clicking the caret, toggle dropdown and prevent navigation
                        e.preventDefault();
                        parent.classList.toggle('active');
                    }
                });
            }
        });
    }
    
    // Set up dropdowns immediately and when window resizes
    setupDropdownBehavior();
    window.addEventListener('resize', setupDropdownBehavior);
    
    // Close mobile menu when clicking overlay
    overlay.addEventListener('click', function() {
        if (mainNav.classList.contains('in')) {
            navbarToggle.classList.remove('active');
            mainNav.classList.remove('in');
            body.classList.remove('nav-open');
            overlay.classList.remove('active');
            navbarToggle.setAttribute('aria-expanded', 'false');
        }
    });
    
    // Update mobile menu state on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && mainNav.classList.contains('in')) {
            navbarToggle.classList.remove('active');
            mainNav.classList.remove('in');
            body.classList.remove('nav-open');
            overlay.classList.remove('active');
            navbarToggle.setAttribute('aria-expanded', 'false');
            
            // Reset dropdown menus on larger screens
            document.querySelectorAll('.dropdown.active').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
});