document.addEventListener('DOMContentLoaded', function() {
    const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
    const sidebar = document.querySelector('.dashboard-sidebar');
    const menuOverlay = document.getElementById('menuOverlay');
    
    // Toggle sidebar on mobile
    if (mobileSidebarToggle && sidebar) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            
            // Important: Remove collapsed class when showing sidebar on mobile
            if (sidebar.classList.contains('show')) {
                sidebar.classList.remove('collapsed');
            }
            
            menuOverlay.classList.toggle('show');
            this.classList.toggle('active');
        });
    }
    
    // Close sidebar when clicking overlay
    if (menuOverlay) {
        menuOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            menuOverlay.classList.remove('show');
            mobileSidebarToggle.classList.remove('active');
        });
    }
    
    // Close sidebar on window resize if it goes beyond mobile breakpoint
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992 && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            menuOverlay.classList.remove('show');
            mobileSidebarToggle.classList.remove('active');
        }
    });
});