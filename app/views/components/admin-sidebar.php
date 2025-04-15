<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <a href="<?= SITE_URL ?>/admin" class="logo">
            <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/logo.png" alt="Huntly Admin">
        </a>
        <button id="sidebarToggle" class="sidebar-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="<?= $pageTitle === 'Admin Dashboard' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/admin/dashboard">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= strpos($pageTitle, 'Job') !== false || $pageTitle === 'Manage Jobs' || $pageTitle === 'Add New Job' || $pageTitle === 'Edit Job' || $pageTitle === 'View Job' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/admin/jobs">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Jobs</span>
                </a>
            </li>
            <li class="<?= strpos($pageTitle, 'Application') !== false || $pageTitle === 'Manage Applications' || $pageTitle === 'View Application' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/admin/applications">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Applications</span>
                </a>
            </li>
            <li class="<?= strpos($pageTitle, 'User') !== false || $pageTitle === 'Manage Users' || $pageTitle === 'Edit User' || $pageTitle === 'View User' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/admin/users">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="<?= SITE_URL ?>/auth/logout" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>

    <button class="sidebar-collapsed-toggle" id="expandSidebar">
        <i class="fa-solid fa-bars"></i>
    </button>
</aside>