<?php
// Include configuration file
require_once __DIR__ . '/../app/config/config.php';

// Get the requested page from URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Validate page name
$valid_pages = ['home', 'jobs', 'companies', 'company-detail', 'job-detail'];
if (!in_array($page, $valid_pages)) {
    $page = 'home';
}

// Include the requested page
$page_path = PAGES_PATH . '/' . $page . '.php';
if (file_exists($page_path)) {
    include $page_path;
} else {
    // Handle 404 error
    include PAGES_PATH . '/404.php';
}
