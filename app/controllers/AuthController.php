<?php
namespace controllers;

use core\Controller;
use models\User;
use models\Company;
use models\JobSeeker;
use helpers\GoogleOAuth;
use helpers\EmailService;

class AuthController extends Controller {
    private $userModel;
    private $companyModel;
    private $seekerModel;
    private $googleOAuth;
    private $emailService;
    
    public function __construct() {
        $this->userModel = new User();
        $this->companyModel = new Company();
        $this->seekerModel = new JobSeeker();
        $this->googleOAuth = new GoogleOAuth();
        $this->emailService = new EmailService();
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
        
        // Check if user is verified
        if($user['active'] != 1) {
            $_SESSION['auth_error'] = 'Please verify your email before logging in. Check your inbox for the verification link.';
            $this->redirect('auth');
            return;
        }
        
        // Verify password
        if(!password_verify($password, $user['password'])) {
            $_SESSION['auth_error'] = 'Invalid email or password';
            $this->redirect('auth');
            return;
        }
        
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
        
        // Register the user with verification token
        $registrationResult = $this->userModel->registerWithVerification(
            $email, 
            $hashedPassword, 
            $fullName, 
            $role === 'employer' ? 'company_admin' : 'job_seeker', 
            $phone
        );
        
        if ($registrationResult['success']) {
            $userId = $registrationResult['user_id'];
            $verificationToken = $registrationResult['verification_token'];
            
            // For employers, create a company record
            if($role === 'employer' && !empty($companyName)) {
                $this->companyModel->createCompany($userId, $companyName);
            }
            
            // For job seekers, create a job_seeker record
            if($role === 'job_seeker') {
                $this->seekerModel->createJobSeeker($userId);
            }
            
            // Send verification email
            $emailSent = $this->emailService->sendVerificationEmail($email, $fullName, $verificationToken);
            
            if ($emailSent) {
                $_SESSION['auth_success'] = 'Registration successful! Please check your email to verify your account.';
            } else {
                $_SESSION['auth_warning'] = 'Account created, but we could not send a verification email. Please contact support.';
            }
            
            // Redirect back to auth page
            $this->redirect('auth?registered=true');
        } else {
            $_SESSION['auth_error'] = 'Registration failed. Please try again.';
            $this->redirect('auth');
        }
    }
    
    public function verify($token = '') {
        if (empty($token)) {
            $_SESSION['error'] = 'Invalid verification link';
            $this->redirect('auth');
            return;
        }
        
        $user = $this->userModel->verifyUser($token);
        
        if ($user) {
            $_SESSION['success'] = 'Email verified successfully! You can now log in.';
            $this->redirect('auth');
        } else {
            $_SESSION['error'] = 'Invalid or expired verification link';
            $this->redirect('auth');
        }
    }

    public function resendVerification() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (empty($email)) {
                $_SESSION['auth_error'] = 'Please enter your email address';
                $this->redirect('auth/resend-verification');
                return;
            }
            
            // Find the unverified user - Use userModel instead of direct db access
            $user = $this->userModel->findUnverifiedUserByEmail($email);
            
            if (!$user) {
                $_SESSION['auth_error'] = 'No unverified account found with this email';
                $this->redirect('auth/resend-verification');
                return;
            }
            
            // Generate new token
            $verificationToken = bin2hex(random_bytes(32));
            $tokenExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Update user with new token - Use userModel instead of direct db access
            $updated = $this->userModel->updateVerificationToken($user['user_id'], $verificationToken, $tokenExpiry);
            
            if ($updated) {
                // Send email
                $emailSent = $this->emailService->sendVerificationEmail($user['email'], $user['full_name'], $verificationToken);
                
                if ($emailSent) {
                    $_SESSION['auth_success'] = 'Verification email has been resent. Please check your inbox.';
                } else {
                    $_SESSION['auth_error'] = 'Failed to send verification email. Please try again.';
                }
            } else {
                $_SESSION['auth_error'] = 'Something went wrong. Please try again.';
            }
            
            $this->redirect('auth');
        } else {
            // Show resend verification form
            $data = [
                'pageTitle' => 'Resend Verification Email - Huntly'
            ];
            
            $this->view('pages/resendverification', $data);
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

    public function googlelogin() {
        // Log that we're entering the method
        error_log("Entering AuthController::googlelogin()");
        
        $role = $_GET['role'] ?? 'job_seeker';
        
        // Validate role - allow 'employer' here which will be translated to 'company_admin' later
        if (!in_array($role, ['job_seeker', 'employer'])) {
            $role = 'job_seeker';
        }
        
        // Log the role
        error_log("Role for Google login: " . $role);
        
        try {
            // Get the Google auth URL
            $authUrl = $this->googleOAuth->getAuthUrl($role);
            
            if (!$authUrl) {
                throw new \Exception("Failed to generate Google auth URL");
            }
            
            // Log that we're about to redirect
            error_log("Redirecting to Google auth URL: " . $authUrl);
            
            // Clear any previous output that might prevent redirect
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            // Redirect to Google
            header('Location: ' . $authUrl);
            exit;
        } catch (\Exception $e) {
            // Log error
            error_log('Google Login Error: ' . $e->getMessage());
            
            // Show error to user
            $_SESSION['error'] = 'Error connecting to Google. Please try again.';
            $this->redirect('auth');
        }
    }
    
    public function googlecallback() {
        // Check if there was an error
        if (isset($_GET['error'])) {
            $_SESSION['error'] = 'Google authentication error: ' . $_GET['error'];
            $this->redirect('auth');
            return;
        }
        
        // Check if code is provided
        if (!isset($_GET['code'])) {
            $_SESSION['error'] = 'Authorization code not provided';
            $this->redirect('auth');
            return;
        }
        
        // Verify state to prevent CSRF
        list($validState, $role) = $this->googleOAuth->validateState($_GET['state'] ?? '');
        
        if (!$validState) {
            $_SESSION['error'] = 'Invalid authentication state';
            $this->redirect('auth');
            return;
        }
        
        // Clean up session state
        unset($_SESSION['google_oauth_state']);
        
        // Get user info from Google
        $userInfo = $this->googleOAuth->getUserInfo($_GET['code']);
        
        if (!$userInfo || !isset($userInfo['email'])) {
            $_SESSION['error'] = 'Failed to get user information from Google';
            $this->redirect('auth');
            return;
        }
        
        // Log the user info and role for debugging
        error_log("Google user info received: " . print_r($userInfo, true));
        error_log("Role for registration/login: " . $role);
        
        // Check if user exists by email and role (role is already properly converted)
        $user = $this->userModel->findUserByEmailAndRole($userInfo['email'], $role);
        
        if ($user) {
            // User exists, log them in
            $this->loginExistingUser($user);
        } else {
            // User doesn't exist, register a new account
            $this->registerGoogleUser($userInfo, $role);
        }
    }
    
    private function loginExistingUser($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        
        // Retrieve company data if user is an employer
        if ($user['role'] === 'company_admin') {
            $company = $this->companyModel->getCompanyByEmployerId($user['user_id']);
            if ($company) {
                $_SESSION['company_id'] = $company['company_id'];
            }
            $this->redirect('employer');
        } else {
            $this->redirect('dashboard');
        }
    }
    
    private function registerGoogleUser($userInfo, $role) {
        // Save basic user data
        $email = $userInfo['email'];
        $fullName = $userInfo['name'] ?? ($userInfo['given_name'] . ' ' . $userInfo['family_name']);
        
        // Generate a random password
        $password = bin2hex(random_bytes(8));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Save avatar from Google if available
        $avatarPath = 'assets/images/defaultavatar.jpg';
        if (!empty($userInfo['picture'])) {
            $avatarPath = $this->saveGoogleAvatar($userInfo['picture'], $email);
        }
        
        // Register the user (the role parameter is now correctly converted)
        if ($this->userModel->register($email, $hashedPassword, $fullName, $role, null)) {
            $userId = $this->userModel->getLastInsertId();
            
            // Update the user's avatar
            if ($avatarPath != 'assets/images/defaultavatar.jpg') {
                $this->userModel->updateAvatar($userId, $avatarPath);
            }
            
            // If role is company_admin, create a company record
            if ($role === 'company_admin') {
                // Company name default to user name + Company
                $companyName = $fullName . "'s Company";
                $this->companyModel->createCompany($userId, $companyName);
                
                // Get the company ID
                $company = $this->companyModel->getCompanyByEmployerId($userId);
                if ($company) {
                    $_SESSION['company_id'] = $company['company_id'];
                }
            }
            
            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $fullName;
            $_SESSION['role'] = $role;
            $_SESSION['logged_in'] = true;
            
            if ($role === 'company_admin') {
                $this->redirect('employer');
            } else {
                $this->redirect('dashboard');
            }
        } else {
            $_SESSION['error'] = 'Failed to register with Google. Please try again.';
            $this->redirect('auth');
        }
    }
    
    private function saveGoogleAvatar($imageUrl, $email) {
        $uploadDir = ROOT_PATH . '/public/uploads/avatars/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $filename = 'google_' . md5($email) . '_' . time() . '.jpg';
        $filePath = $uploadDir . $filename;
        
        // Download and save image
        $imageData = file_get_contents($imageUrl);
        if ($imageData && file_put_contents($filePath, $imageData)) {
            return 'uploads/avatars/' . $filename;
        }
        
        return 'assets/images/defaultavatar.jpg';
    }
}