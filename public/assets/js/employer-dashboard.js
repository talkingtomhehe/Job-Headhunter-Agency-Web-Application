document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const body = document.body;
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            body.classList.toggle('sidebar-visible');
        });
    }
    
    // User dropdown menu
    const userAvatar = document.querySelector('.user-avatar-container');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (userAvatar && dropdownMenu) {
        userAvatar.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userAvatar.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (body.classList.contains('sidebar-visible') && 
            !event.target.closest('.employer-sidebar') && 
            !event.target.closest('#sidebarToggle')) {
            body.classList.remove('sidebar-visible');
        }
    });
    
    // File input preview for forms
    const fileInputs = document.querySelectorAll('.custom-file-input');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = this.nextElementSibling;
            
            if (fileName) {
                label.textContent = fileName;
            } else {
                label.textContent = 'Choose file';
            }
        });
    });
    
    // Initialize any charts if they exist
    const chartElements = document.querySelectorAll('[data-chart]');
    if (chartElements.length > 0 && typeof Chart !== 'undefined') {
        chartElements.forEach(element => {
            // Chart initialization would go here
            console.log('Chart element found:', element.id);
        });
    }
    
    // Handle form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
                        document.addEventListener('DOMContentLoaded', function() {
                // Sidebar toggle functionality
                const sidebar = document.querySelector('.dashboard-sidebar');
                const content = document.querySelector('.dashboard-content');
                const header = document.querySelector('.main-header');
                const toggleBtn = document.getElementById('sidebarToggle');
                const expandBtn = document.getElementById('expandSidebar');
            
                function toggleSidebar() {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    header.classList.toggle('expanded');
                    
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
                    header.classList.add('expanded');
                }
            
                // Responsive handling
                function handleResponsive() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.add('collapsed');
                        content.classList.add('expanded');
                        header.classList.add('expanded');
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
            });            document.addEventListener('DOMContentLoaded', function() {
                // Sidebar toggle functionality
                const sidebar = document.querySelector('.dashboard-sidebar');
                const content = document.querySelector('.dashboard-content');
                const header = document.querySelector('.main-header');
                const toggleBtn = document.getElementById('sidebarToggle');
                const expandBtn = document.getElementById('expandSidebar');
            
                function toggleSidebar() {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    header.classList.toggle('expanded');
                    
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
                    header.classList.add('expanded');
                }
            
                // Responsive handling
                function handleResponsive() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.add('collapsed');
                        content.classList.add('expanded');
                        header.classList.add('expanded');
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
            form.classList.add('was-validated');
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});