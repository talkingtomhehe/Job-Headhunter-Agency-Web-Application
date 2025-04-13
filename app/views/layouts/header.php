<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? ($pageTitle . " - Huntly") : "Huntly"; ?></title>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Base CSS -->
    <link rel="stylesheet" href="/huntlyversion2/public/assets/css/layouts.css">
    <link rel="stylesheet" href="/huntlyversion2/public/assets/css/components.css">
    <!-- Additional CSS for styling -->
    <link rel="stylesheet" href="/huntlyversion2/public/assets/css/responsive.css">
    <link rel="stylesheet" href="/huntlyversion2/public/assets/css/auth-page.css">
    <!-- JS Scripts -->
    <script src="/huntlyversion2/public/assets/js/dropdown.js" defer></script>
    <script src="/huntlyversion2/public/assets/js/navbar.js" defer></script>
    
    <?php if(isset($view) && $view === 'pages/auth'): ?>
    <script src="/huntlyversion2/public/assets/js/login-page.js" defer></script>
    <script src="/huntlyversion2/public/assets/js/password-toggle.js" defer></script>
    <script src="/huntlyversion2/public/assets/js/auth-alerts.js" defer></script>
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="container">
            <a href="<?= SITE_URL ?>" class="logo">
                <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/logo.png" alt="Huntly">
            </a>
            
            <nav class="main-nav">
                <!-- Navigation content -->
                <ul class="nav-links">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">All jobs <i class="fa-solid fa-filter"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= SITE_URL ?>/jobs?category=it">IT & Software</a></li>
                            <li><a href="<?= SITE_URL ?>/jobs?category=finance">Finance</a></li>
                            <li><a href="<?= SITE_URL ?>/jobs?category=marketing">Marketing</a></li>
                            <li><a href="<?= SITE_URL ?>/jobs?category=hr">Human Resources</a></li>
                        </ul>
                    </li>
                    <?php if(\helpers\Session::isLoggedIn()): ?>
                    <li><a href="<?= SITE_URL ?>/notifications">Notification <i class="fa-solid fa-bell"></i></a></li>
                    <?php endif; ?>
                    <li><a href="<?= SITE_URL ?>/about">About Us</a></li>
                </ul>
            </nav>
            
            <div class="auth">
                <?php if(\helpers\Session::isLoggedIn()): ?>
                    <?php if(\helpers\Session::getUserRole() === 'company_admin'): ?>
                        <a href="<?= SITE_URL ?>/employer" class="nav-link">Dashboard</a>
                    <?php endif; ?>
                    
                    <div class="dropdown">
                        <button class="dropdown-toggle">
                            <?= htmlspecialchars(\helpers\Session::get('full_name') ?? 'User') ?>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <?php if(\helpers\Session::getUserRole() === 'company_admin'): ?>
                                <li><a href="<?= SITE_URL ?>/employer/profile">Company Profile</a></li>
                            <?php else: ?>
                                <li><a href="<?= SITE_URL ?>/seeker/profile">My Profile</a></li>
                            <?php endif; ?>
                            <li><a href="<?= SITE_URL ?>/auth/logout">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= SITE_URL ?>/auth" class="login-btn">Login / Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>