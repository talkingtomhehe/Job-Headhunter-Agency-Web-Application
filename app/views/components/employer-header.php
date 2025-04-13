<header class="main-header">
    <div class="header-container">
        <div class="header-actions">
            <div class="quick-actions">
                <a href="<?= SITE_URL ?>/employer/jobs/create" class="action-btn">
                    <i class="fa-solid fa-plus"></i> Post New Job
                </a>
                <a href="<?= SITE_URL ?>/employer/jobs" class="action-btn">
                    <i class="fa-solid fa-briefcase"></i> Job Listings
                </a>
                <a href="<?= SITE_URL ?>/employer/applications" class="action-btn">
                    <i class="fa-solid fa-file-lines"></i> Applications
                </a>
                <a href="<?= SITE_URL ?>/employer/profile" class="action-btn">
                    <i class="fa-solid fa-building"></i> Company Profile
                </a>
            </div>
            <div class="header-user">
                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <span><?= htmlspecialchars(\helpers\Session::get('full_name')) ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= SITE_URL ?>/employer/profile">Company Profile</a></li>
                        <li><a href="<?= SITE_URL ?>/auth/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>