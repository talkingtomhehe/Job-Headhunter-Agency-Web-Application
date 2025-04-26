<?php

namespace config;

// Load environment-specific configuration if it exists
if (file_exists(dirname(__FILE__) . '/env.php')) {
    require_once dirname(__FILE__) . '/env.php';
} else {
    die('Environment configuration file not found. Please create app/config/env.php based on env.sample.php');
}

// Define site URL
define('SITE_URL', 'http://localhost/huntly');

// App Root
define('APP_ROOT', dirname(dirname(__FILE__)));

// Path constants
define('LAYOUT_PATH', APP_ROOT . '/views/layouts');
define('COMPONENT_PATH', APP_ROOT . '/views/components');
define('VIEW_PATH', APP_ROOT . '/views');
define('PAGE_PATH', APP_ROOT . '/views/pages');
define('PUBLIC_PATH', '/public');
define('ASSETS_PATH', PUBLIC_PATH . '/assets');

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'huntly');
