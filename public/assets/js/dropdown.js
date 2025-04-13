document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown menus
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            event.stopPropagation();
            
            // Get the dropdown menu
            const menu = this.nextElementSibling;
            if (!menu.classList.contains('dropdown-menu')) return;
            
            // Toggle the menu
            menu.classList.toggle('show');
            
            // Close all other open dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                if (openMenu !== menu) {
                    openMenu.classList.remove('show');
                }
            });
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            menu.classList.remove('show');
        });
    });
});