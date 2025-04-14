<header class="main-header">
    <div class="header-container">
        <div class="header-actions">
            <div class="quick-actions">
                <a href="<?= SITE_URL ?>/admin/jobs?filter=pending" class="action-btn">
                    <i class="fa-solid fa-clock"></i> Pending Jobs
                </a>
                <a href="<?= SITE_URL ?>/admin/users" class="action-btn">
                    <i class="fa-solid fa-users"></i> User Management
                </a>
                <a href="<?= SITE_URL ?>/admin/applications" class="action-btn">
                    <i class="fa-solid fa-file-lines"></i> Applications
                </a>
                <a href="<?= SITE_URL ?>/admin/addJob" class="action-btn">
                    <i class="fa-solid fa-plus"></i> Add Job
                </a>
            </div>
            <div class="header-user">
                <div class="dropdown">
                    <button class="dropdown-toggle">
                        <span><?= htmlspecialchars(\helpers\Session::get('full_name')) ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= SITE_URL ?>"><i class="fa-solid fa-home"></i> Visit Site</a></li>
                        <li><a href="<?= SITE_URL ?>/auth/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>