<?php
namespace controllers;

use core\Controller;
use models\User;
use models\Company;
use models\JobSeeker;

class AuthController extends Controller {
    private $userModel;
    private $companyModel;
    private $seekerModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->companyModel = new Company();
        $this->seekerModel = new JobSeeker();
    }
    
    // Auth page - show login form
    public function index() {
        // If user is already logged in, redirect based on role
        if(isset($_SESSION['user_id'])) {
            if($_SESSION['role'] === 'company_admin') {
                $this->redirect('employer');
            } else {
                $this->redirect('seeker');
            }
        }
        
        $data = [
            'pageTitle' => 'Login / Register - Huntly'
        ];
        
        $this->view('pages/auth', $data);
    }
    
    // Process login form
    public function login() {
        // Check if the form was submitted
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth');
            return;
        }
        
        // Get login credentials
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['user_role'] ?? 'job_seeker';
        
        // Basic validation
        if(empty($email) || empty($password)) {
            $_SESSION['auth_error'] = 'Email and password are required';
            $this->redirect('auth');
            return;
        }
        
        // Try to authenticate the user
        $user = $this->userModel->findUserByEmailAndRole($email, $role === 'employer' ? 'company_admin' : $role);
        
        if(!$user) {
            $_SESSION['auth_error'] = 'Invalid email or password';
            $this->redirect('auth');
            return;
        }
        
        // Verify password
        if(!password_verify($password, $user['password'])) {
            $_SESSION['auth_error'] = 'Invalid email or password';
            $this->redirect('auth');
            return;
        }
        
        // At this point, authentication is successful
        // Store user data in session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        // If the user is an employer (company_admin), fetch company info
        if($user['role'] === 'company_admin') {
            $company = $this->companyModel->getCompanyByEmployerId($user['user_id']);
            
            if($company) {
                $_SESSION['company_id'] = $company['company_id'];
                $_SESSION['company_name'] = $company['company_name'];
                
                if(!empty($company['logo_path'])) {
                    $_SESSION['company_logo'] = '/huntly/public/' . $company['logo_path'];
                }
            }
            
            // Redirect to employer dashboard
            $this->redirect('employer');
        } else {
            // This is a job seeker
            // Redirect to job seeker dashboard
            $this->redirect('seeker');
        }
    }
    
    // Process registration form
    public function register() {
        // Check if the form was submitted
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth');
            return;
        }
        
        // Get registration data
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $role = $_POST['user_role'] ?? 'job_seeker';
        $phone = $_POST['phone'] ?? '';
        
        // For employers, also get company name
        $companyName = $_POST['company_name'] ?? '';
        
        // Basic validation
        if(empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['auth_error'] = 'All required fields must be filled out';
            $this->redirect('auth');
            return;
        }
        
        if($password !== $confirmPassword) {
            $_SESSION['auth_error'] = 'Passwords do not match';
            $this->redirect('auth');
            return;
        }
        
        if($role === 'employer' && empty($companyName)) {
            $_SESSION['auth_error'] = 'Company name is required for employer accounts';
            $this->redirect('auth');
            return;
        }
        
        // Check if email already exists
        if($this->userModel->emailExists($email)) {
            $_SESSION['auth_error'] = 'Email already exists. Please use a different email or try to login';
            $this->redirect('auth');
            return;
        }
        
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Register the user and related records
        if($this->userModel->register($email, $hashedPassword, $fullName, $role === 'employer' ? 'company_admin' : 'job_seeker', $phone)) {
            $userId = $this->userModel->getLastInsertId();
            
            // For employers, create a company record
            if($role === 'employer' && !empty($companyName)) {
                $this->companyModel->createCompany($userId, $companyName);
            }
            
            // For job seekers, create a job_seeker record
            if($role === 'job_seeker') {
                $this->seekerModel->createJobSeeker($userId);
            }
            
            // Set success message
            $_SESSION['auth_success'] = 'Account created successfully! Please log in.';
            
            // Redirect back to auth page
            $this->redirect('auth');
        } else {
            $_SESSION['auth_error'] = 'Registration failed. Please try again.';
            $this->redirect('auth');
        }
    }
    
    // Logout user
    public function logout() {
        // Unset all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        // Redirect to home page
        $this->redirect('');
    }
    
    // Show forgot password form
    public function forgotPassword() {
        $data = [
            'pageTitle' => 'Forgot Password - Huntly'
        ];
        
        $this->view('pages/forgot-password', $data);
    }
    
    // Process password reset request
    public function resetPassword() {
        // Future implementation for password reset functionality
        $this->redirect('auth');
    }
}