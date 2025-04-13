<?php
namespace core;

class Controller {
    // Load model
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        $modelNamespace = 'models\\' . $model;
        return new $modelNamespace();
    }
    
    // Load view
    public function view($view, $data = [], $layout = 'default') {
        // Extract data for the view
        if(is_array($data)) {
            extract($data);
        }
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        if(file_exists('../app/views/' . $view . '.php')) {
            include_once '../app/views/' . $view . '.php';
        } else {
            // Fallback to 404 if view doesn't exist
            include_once '../app/views/pages/404.php';
        }
        
        $content = ob_get_clean();
        
        // Include the layout
        if(file_exists('../app/views/layouts/' . $layout . '.php')) {
            include_once '../app/views/layouts/' . $layout . '.php';
        } else {
            // If layout doesn't exist, just output the content
            echo $content;
        }
    }
    
    // Redirect to another page
    public function redirect($url) {
        header('Location: ' . SITE_URL . '/' . $url);
        exit;
    }
    
    // Return JSON response
    public function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}