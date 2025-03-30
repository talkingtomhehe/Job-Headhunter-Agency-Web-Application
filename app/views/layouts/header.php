<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? ($pageTitle . " - Huntly") : "Huntly"; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/huntly/public/assets/css/layouts.css">
    <link rel="stylesheet" href="/huntly/public/assets/css/components.css">
    <script src="/huntly/public/assets/js/modal.js" defer></script>
    <script src="/huntly/public/assets/js/dropdown.js" defer></script>
    <script src="/huntly/public/assets/js/password-toggle.js" defer></script>
</head>

<body>
    <header>
        <div class="container">
            <a href="/huntly/public/index.php" class="logo">
                <img src="/huntly/public/assets/images/logo.png" alt="Huntly">
            </a>
            
            <nav class="main-nav">
                <button class="mobile-menu-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <ul class="nav-links">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">All categories <i class="fa-solid fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="/huntly/public/index.php?category=it">IT & Software</a></li>
                            <li><a href="/huntly/public/index.php?category=finance">Finance</a></li>
                            <li><a href="/huntly/public/index.php?category=marketing">Marketing</a></li>
                            <li><a href="/huntly/public/index.php?category=hr">Human Resources</a></li>
                        </ul>
                    </li>
                    <li><a href="/huntly/public/notifications.php">Notification <i class="fa-solid fa-bell"></i></a></li>
                    <li><a href="/huntly/public/about.php">About Us</a></li>
                </ul>
            </nav>
            
            <div class="auth">
                <button id="openLoginModal" class="login-btn">Login</button>
                <button id="openRegisterModal" class="register-btn" onclick="document.getElementById('registerModal').style.display='flex';">Register</button>
            </div>
        </div>
        <?php include(COMPONENT_PATH . '/login-modal.php'); ?>
        <?php include(COMPONENT_PATH . '/register-modal.php'); ?>
    </header>