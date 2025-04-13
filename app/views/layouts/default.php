<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? ($pageTitle . " - Huntly") : "Huntly"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/layouts.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/components.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/responsive.css">
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/dropdown.js" defer></script>
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/navbar.js" defer></script>
    
    <?php if($view === 'pages/auth'): ?>
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/login-page.js" defer></script>
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/password-toggle.js" defer></script>
    <script src="<?= SITE_URL . PUBLIC_PATH ?>/assets/js/auth-alerts.js" defer></script>
    <?php endif; ?>
</head>

<body>
    <?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>
    
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
    
    <!-- Main content -->
    <?= $content ?>
    
    <?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
    
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>

</html>