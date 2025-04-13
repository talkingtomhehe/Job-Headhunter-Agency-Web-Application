<?php
namespace middlewares;

class AuthMiddleware {
    
    public function handle() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) || !$_SESSION['logged_in']) {
            // Redirect to login page
            header('Location: ' . SITE_URL . '/auth');
            exit;
        }
        
        return true;
    }
}