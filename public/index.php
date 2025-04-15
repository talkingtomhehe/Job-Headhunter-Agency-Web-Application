<?php
// Define the application root path
define('ROOT_PATH', dirname(__DIR__));

// Load configuration first
require_once ROOT_PATH . '/vendor/autoload.php';
require_once ROOT_PATH . '/app/config/config.php';

// Autoload core classes
spl_autoload_register(function($className) {
    // Convert namespace to file path
    $className = str_replace('\\', '/', $className);
    $path = ROOT_PATH . '/app/' . $className . '.php';
    
    if (file_exists($path)) {
        require_once $path;
    } else {
        error_log("Could not autoload class: $className ($path)");
    }
});

// Start session
if (class_exists('\\helpers\\Session')) {
    \helpers\Session::init();
} else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Simple routing system
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

// Default controller and action
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) : 'Home';
$actionName = !empty($urlParts[1]) ? $urlParts[1] : 'index';

// Handle parameters
$params = array_slice($urlParts, 2);

// Controller file path
$controllerFile = ROOT_PATH . '/app/controllers/' . $controllerName . 'Controller.php';

try {
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        // Create controller instance
        $controllerClass = 'controllers\\' . $controllerName . 'Controller';
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            
            // Check if action exists
            if (method_exists($controller, $actionName)) {
                call_user_func_array([$controller, $actionName], $params);
            } else {
                // Action not found
                $controller = new \controllers\HomeController();
                $controller->view('pages/404', ['pageTitle' => 'Page Not Found']);
            }
        } else {
            throw new Exception("Controller $controllerClass not found");
        }
    } else {
        // Controller not found
        require_once ROOT_PATH . '/app/controllers/HomeController.php';
        $controller = new \controllers\HomeController();
        $controller->view('pages/404', ['pageTitle' => 'Page Not Found']);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}