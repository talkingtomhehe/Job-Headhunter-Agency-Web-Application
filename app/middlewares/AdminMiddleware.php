<?php
namespace middlewares;

class AdminMiddleware {
    
    public function handle() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            // Redirect to admin login page
            header('Location: ' . SITE_URL . '/admin/login');
            exit;
        }
        
        return true;
    }
}