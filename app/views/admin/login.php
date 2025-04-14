<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Huntly</title>
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/layouts.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/components.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?= SITE_URL . PUBLIC_PATH ?>/assets/css/admin-loginpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-login-page">
    <div class="admin-login-container">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <div class="logo-container">
                    <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/logo.png" alt="Huntly Logo" class="admin-logo">
                </div>
                <h1>Admin Panel</h1>
                <p>Access restricted to authorized personnel only</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= SITE_URL ?>/admin/authenticate" method="POST" class="admin-login-form">
                <div class="form-group">
                    <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-admin-login">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </button>
            </form>
            
            <div class="admin-login-footer">
                <a href="<?= SITE_URL ?>">Back to Main Site</a>
            </div>
        </div>
    </div>
</body>
</html>