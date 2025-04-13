<?php
namespace controllers;

use core\Controller;

class HomeController extends Controller {
    
    public function __construct() {
        // Load models if needed
    }
    
    // Home page
    public function index() {
        $data = [
            'pageTitle' => 'Huntly - Find Your Dream Job'
        ];
        
        $this->view('pages/home', $data);
    }
    
    // About page
    public function about() {
        $data = [
            'pageTitle' => 'About Us - Huntly'
        ];
        
        $this->view('pages/about', $data);
    }
    
    // Contact page
    public function contact() {
        $data = [
            'pageTitle' => 'Contact Us - Huntly'
        ];
        
        $this->view('pages/contact', $data);
    }
}