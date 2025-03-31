/**
 * Handle navbar transparency on scroll
 */
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    
    // Function to update header background based on scroll position
    function updateHeaderBackground() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    // Initial check on page load
    updateHeaderBackground();
    
    // Add scroll event listener
    window.addEventListener('scroll', updateHeaderBackground);
});