<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle functionality
        const sidebar = document.querySelector('.dashboard-sidebar');
        const content = document.querySelector('.dashboard-content');
        const toggleBtn = document.getElementById('sidebarToggle');
        const expandBtn = document.getElementById('expandSidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            
            // Save preference to localStorage
            const isSidebarCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-collapsed', isSidebarCollapsed ? 'true' : 'false');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        
        if (expandBtn) {
            expandBtn.addEventListener('click', toggleSidebar);
        }
        
        // Load saved preference
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
        }

        // Responsive handling
        function handleResponsive() {
            if (window.innerWidth < 992) {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }
        }
        
        // Initial check
        handleResponsive();
        
        // Re-check on window resize
        window.addEventListener('resize', handleResponsive);

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }, 5000);
        });
    });
</script>