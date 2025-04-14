<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? ($pageTitle . " - Huntly Admin") : "Huntly Admin"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/layouts.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/components.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/employer-dashboard.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/employer.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/employer-viewjob.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/employer-jobform.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/admin.css">
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/dropdown.js" defer></script>
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/employer-dashboard.js" defer></script>
    <?php if(isset($pageScripts)): ?>
        <?php foreach($pageScripts as $script): ?>
        <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/<?= $script ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body class="admin-dashboard">
    <div class="dashboard-container">
        <!-- Include admin sidebar -->
        <?php include ROOT_PATH . '/app/views/components/admin-sidebar.php'; ?>
        
        <!-- Main content -->
        <div class="dashboard-content">
            <!-- Include header -->
            <?php include ROOT_PATH . '/app/views/components/admin-header.php'; ?>

            <!-- Main dashboard content -->
            <div class="dashboard-main">
                <!-- Page title -->
                <div class="page-title-container">
                    <h1 class="page-title"><?= $pageTitle ?></h1>
                    <?php if(isset($pageSubtitle)): ?>
                        <p class="page-subtitle"><?= $pageSubtitle ?></p>
                    <?php endif; ?>
                </div>
                
                <!-- Flash messages -->
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']) ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']) ?>
                    </div>
                <?php endif; ?>
                
                <!-- Main content area -->
                <?= $content ?>
            </div>
        </div>
    </div>
    
    <!-- Include footer with JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle functionality
        const sidebar = document.querySelector('.dashboard-sidebar');
        const content = document.querySelector('.dashboard-content');
        const header = document.querySelector('.main-header');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const expandBtn = document.getElementById('expandSidebar');
        
        // Toggle sidebar and header functionality
        function toggleSidebar() {
            // Toggle classes for sidebar, content, and header
            if (sidebar) sidebar.classList.toggle('collapsed');
            if (content) content.classList.toggle('expanded');
            if (header) header.classList.toggle('expanded');
            
            // Save preference to localStorage
            if (sidebar) {
                const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebar-collapsed', isSidebarCollapsed ? 'true' : 'false');
            }
        }
        
        // Add click event listeners to toggle buttons
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        
        if (expandBtn) {
            expandBtn.addEventListener('click', toggleSidebar);
        }
        
        // Load saved preference
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
            if (header) header.classList.add('expanded');
        }
        
        // Responsive handling
        function handleResponsive() {
            if (window.innerWidth < 992) {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
                if (header) header.classList.add('expanded');
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
</body>

</html>