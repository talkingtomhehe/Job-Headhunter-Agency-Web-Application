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
</head>

<body>
    <header>
        <a href="index.php" class="logo">
            <img src="assets/images/logo.png" alt="Huntly">
        </a>
        <nav>
            <ul>
                <li><a href="index.php">All categories <i class="fa-solid fa-caret-down"></i></a></li>
                <li><a href="noti.php">Notification <i class="fa-solid fa-bell"></i></a></li>
            </ul>
        </nav>
        <div class="auth">
            <button id="openLoginModal" class="login">Login</button>
            <button id="openRegisterModal" class="register">Register</button>
        </div>
    </header>
    <?php include(COMPONENT_PATH . '/login-modal.php'); ?>
    <?php include(COMPONENT_PATH . '/register-modal.php'); ?>