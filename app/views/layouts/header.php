<?php
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$currentPage = end($parts);

if (strpos($currentPage, '?') !== false) {
    $currentPage = substr($currentPage, 0, strpos($currentPage, '?'));
}

if ($currentPage == 'huntly' || $currentPage == 'public' || $currentPage == '') {
    $currentPage = 'home';
}

if (strpos($uri, '/job') !== false) {
    $currentPage = 'jobs';
}
?>

<header>
    <div class="container">
        <a href="<?= SITE_URL ?>" class="logo">
            <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/logo.png" alt="Huntly">
        </a>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <nav class="main-nav collapse navbar-collapse" id="mainNav">
            <!-- Navigation content -->
            <ul class="nav-links">
                <li><a href="<?= SITE_URL ?>" class="<?= ($currentPage == 'home' || empty($currentPage)) ? 'active' : '' ?>">Home</a></li>
                <li class="dropdown <?= ($currentPage == 'jobs') ? 'active' : '' ?>">
                    <a href="<?= SITE_URL ?>/job" class="dropdown-toggle">
                        All jobs <i class="fa-solid fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a href="<?= SITE_URL ?>/job?category=<?= $category['category_id'] ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?= SITE_URL ?>/job">All Categories</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php if (\helpers\Session::isLoggedIn()): ?>
                    <li><a href="<?= SITE_URL ?>/notifications" class="<?= ($currentPage == 'notifications') ? 'active' : '' ?>">Notification <i class="fa-solid fa-bell"></i></a></li>
                <?php endif; ?>
                <li><a href="<?= SITE_URL ?>/home/about" class="<?= ($currentPage == 'about') ? 'active' : '' ?>">About Us</a></li>
            </ul>
        </nav>

        <div class="auth">
            <?php if (\helpers\Session::isLoggedIn()): ?>
                <?php if (\helpers\Session::getUserRole() === 'company_admin'): ?>
                    <a href="<?= SITE_URL ?>/employer" class="nav-link">Dashboard</a>
                <?php endif; ?>

                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <?= htmlspecialchars(\helpers\Session::get('full_name') ?? 'User') ?>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <?php if (\helpers\Session::getUserRole() === 'company_admin'): ?>
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