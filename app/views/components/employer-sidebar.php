<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <a href="<?= SITE_URL ?>/employer" class="logo">
            <img src="<?= SITE_URL . PUBLIC_PATH ?>/assets/images/logo.png" alt="Huntly">
        </a>
        <button id="sidebarToggle" class="sidebar-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li class="<?= $pageTitle === 'Employer Dashboard' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/employer">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= $pageTitle === 'My Job Listings' || $pageTitle === 'Create New Job' || $pageTitle === 'Edit Job' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/employer/jobs">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Job Listings</span>
                </a>
            </li>
            <li class="<?= $pageTitle === 'Job Applications' || $pageTitle === 'View Application' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/employer/applications">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Applications</span>
                </a>
            </li>
            <li class="<?= $pageTitle === 'Company Profile' ? 'active' : '' ?>">
                <a href="<?= SITE_URL ?>/employer/profile">
                    <i class="fa-solid fa-building"></i>
                    <span>Company Profile</span>
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