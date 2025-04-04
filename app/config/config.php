<?php
// Base URL của ứng dụng
define('BASE_URL', 'http://localhost/Job-Headhunter-Agency-Web-Application');

// Đường dẫn thư mục gốc
define('ROOT_PATH', dirname(dirname(__DIR__)));

// Đường dẫn thư mục app
define('APP_PATH', ROOT_PATH . '/app');

// Đường dẫn các thư mục trong app
define('MODELS_PATH', APP_PATH . '/models');
define('VIEWS_PATH', APP_PATH . '/views');
define('CONTROLLERS_PATH', APP_PATH . '/controllers');
define('COMPONENTS_PATH', VIEWS_PATH . '/components');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'huntlys');

// Define base paths
define('BASE_PATH', dirname(dirname(__DIR__)));
define('PUBLIC_PATH', BASE_PATH . '/public');

// Define app paths
define('CONFIG_PATH', APP_PATH . '/config');
define('LAYOUTS_PATH', VIEWS_PATH . '/layouts');
define('PAGES_PATH', VIEWS_PATH . '/pages');

// Define public paths
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');

// URL paths
define('PUBLIC_URL', BASE_URL . '/public');
define('ASSETS_URL', PUBLIC_URL . '/assets');
