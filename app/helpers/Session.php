<?php
namespace helpers;

class Session {
    
    public static function init() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }
    
    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    public static function destroy() {
        // Unset all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
    }
    
    public static function setFlash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }
    
    public static function getFlash($key) {
        $message = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    
    public static function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function getUserRole() {
        return $_SESSION['role'] ?? null;
    }
}