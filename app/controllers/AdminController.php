<?php
namespace controllers;

use core\Controller;
use models\User;
use models\JobPost;
use models\Application;
use models\Company;
use models\Notification;

class AdminController extends Controller {
    private $userModel;
    private $jobModel;
    private $applicationModel;
    private $companyModel;
    private $notificationModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->jobModel = new JobPost();
        $this->applicationModel = new Application();
        $this->companyModel = new Company();
        $this->notificationModel = new Notification();
    }
    
    // Show login page
    public function login() {
        if ($this->isAdminLoggedIn()) {
            $this->redirect('admin/dashboard');
            return;
        }
        
        require_once ROOT_PATH . '/app/views/admin/login.php';
        exit;
    }
    
    // Process admin login
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/login');
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Validate admin credentials
        $user = $this->userModel->getUserByEmail($email);
        
        if (!$user || $user['role'] !== 'admin' || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Invalid email or password';
            $this->redirect('admin/login');
            return;
        }
        
        // Set admin session
        $_SESSION['admin_id'] = $user['user_id'];
        $_SESSION['admin_name'] = $user['full_name'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_logged_in'] = true;
        
        $this->redirect('admin/dashboard');
    }
    
    // Admin logout
    public function logout() {
        // Clear admin session variables
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_logged_in']);
        
        $this->redirect('admin/login');
    }
    
    // Admin dashboard
    public function dashboard() {
        $this->requireAdminLogin();
        
        // Basic stats
        $totalJobs = $this->jobModel->getTotalJobCount();
        $pendingJobs = $this->jobModel->getJobCountByStatus('pending');
        $totalUsers = $this->userModel->getTotalUserCount();
        $totalApplications = $this->applicationModel->getTotalApplicationCount();
        
        // Data for job status chart
        $jobStatusCounts = [
            'active' => $this->jobModel->getJobCountByStatus('active'),
            'pending' => $pendingJobs,
            'rejected' => $this->jobModel->getJobCountByStatus('rejected'),
            'closed' => $this->jobModel->getJobCountByStatus('closed'),
        ];
        
        // Data for user role chart
        $userRoleCounts = [
            'job_seeker' => $this->userModel->getUserCountByRole('job_seeker'),
            'company_admin' => $this->userModel->getUserCountByRole('company_admin'),
            'admin' => $this->userModel->getUserCountByRole('admin'),
        ];
        
        // Get recent jobs and users
        $recentJobs = $this->jobModel->getRecentJobs(5);
        $recentUsers = $this->userModel->getRecentUsers(5);
        $recentActivities = $this->generateRecentActivity();
        $data['recentActivities'] = $recentActivities;
        
        $data = [
            'pageTitle' => 'Admin Dashboard',
            'totalJobs' => $totalJobs,
            'pendingJobs' => $pendingJobs,
            'totalUsers' => $totalUsers,
            'totalApplications' => $totalApplications,
            'jobStatusCounts' => $jobStatusCounts,
            'userRoleCounts' => $userRoleCounts,
            'recentJobs' => $recentJobs,
            'recentUsers' => $recentUsers
        ];
        
        $this->view('admin/dashboard', $data, 'admin');
    }

    private function generateRecentActivity() {
        $activities = [];
        
        // Get recent job posts
        $recentJobs = $this->jobModel->getRecentJobs(3);
        foreach ($recentJobs as $job) {
            $activities[] = [
                'type' => 'job_posted',
                'description' => "New job: \"{$job['title']}\" posted by {$job['company_name']}",
                'timestamp' => $job['created_at']
            ];
        }
        
        // Get recent users
        $recentUsers = $this->userModel->getRecentUsers(3);
        foreach ($recentUsers as $user) {
            $role = $user['role'] == 'company_admin' ? 'employer' : 'job seeker';
            $activities[] = [
                'type' => 'user_registered',
                'description' => "New {$role}: {$user['full_name']} joined the platform",
                'timestamp' => $user['created_at']
            ];
        }
        
        // Get recent applications
        $recentApplications = $this->applicationModel->getRecentApplications(3);
        foreach ($recentApplications as $app) {
            $activities[] = [
                'type' => 'application_submitted',
                'description' => "New application for \"{$app['job_title']}\" from {$app['full_name']}",
                'timestamp' => $app['created_at']
            ];
        }
        
        // Sort by timestamp (newest first)
        usort($activities, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        // Return just the most recent 10
        return array_slice($activities, 0, 10);
    }
    
    // Job management
    public function jobs($action = null, $id = null) {
        $this->requireAdminLogin();
        
        if ($action === 'view' && $id) {
            $this->viewJob($id);
            return;
        }
        
        if ($action === 'edit' && $id) {
            $this->editJob($id);
            return;
        }
        
        if ($action === 'approve' && $id) {
            $this->approveJob($id);
            return;
        }
        
        if ($action === 'reject' && $id) {
            $this->rejectJob($id);
            return;
        }
        
        if ($action === 'delete' && $id) {
            $this->deleteJob($id);
            return;
        }
        
        // Default: show job listing
        $filter = $_GET['filter'] ?? 'all';
    
        if ($filter === 'pending_admin') {
            $jobs = $this->jobModel->getJobsByAdminStatus('pending');
            $pageTitle = 'Jobs Pending Admin Review';
        } else if ($filter === 'approved') {
            $jobs = $this->jobModel->getJobsByAdminStatus('approved');
            $pageTitle = 'Admin Approved Jobs';
        } else if ($filter === 'rejected') {
            $jobs = $this->jobModel->getJobsByAdminStatus('rejected');
            $pageTitle = 'Admin Rejected Jobs';
        } else if ($filter === 'pending') {
            $jobs = $this->jobModel->getJobsByStatus('pending');
            $pageTitle = 'Pending Jobs';
        } else {
            $jobs = $this->jobModel->getAllJobs();
            $pageTitle = 'All Jobs';
        }
        
        $data = [
            'pageTitle' => $pageTitle,
            'jobs' => $jobs,
            'activeFilter' => $filter
        ];
        
        $this->view('admin/jobs', $data, 'admin');
    }
    
    // View job details
    private function viewJob($id) {
        $job = $this->jobModel->getJobWithDetails($id);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        $company = $this->companyModel->getCompanyById($job['company_id']);
        
        $data = [
            'pageTitle' => $job['title'],
            'job' => $job,
            'company' => $company
        ];
        
        $this->view('admin/view-job', $data, 'admin');
    }
    
    // Edit job
    private function editJob($id) {
        $job = $this->jobModel->getJobById($id);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        // Get categories and other data needed for the form
        $categories = $this->jobModel->getCategories();
        
        $jobCategory = null;
        if (!empty($job['category_id'])) {
            $jobCategory = $this->jobModel->getCategoryById($job['category_id']);
        }
        
        // Check if job has a category that's not in the master list
        $hasCustomCategory = false;
        $customCategory = null;
        
        if ($jobCategory) {
            $categoryExists = false;
            foreach ($categories as $category) {
                if ($category['category_id'] == $jobCategory['category_id']) {
                    $categoryExists = true;
                    break;
                }
            }
            
            if (!$categoryExists) {
                $hasCustomCategory = true;
                $customCategory = $jobCategory;
            }
        }
        
        $data = [
            'pageTitle' => 'Edit Job',
            'job' => $job,
            'jobCategory' => $jobCategory,
            'categories' => $categories,
            'hasCustomCategory' => $hasCustomCategory,
            'customCategory' => $customCategory,
            'workModels' => $this->jobModel->getWorkModels(),
            'experienceLevels' => $this->jobModel->getExperienceLevels()
        ];
        
        $this->view('admin/edit-job', $data, 'admin');
    }
    
    // Update job from admin
    public function updateJob() {
        $this->requireAdminLogin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/jobs');
            return;
        }
        
        $jobId = $_POST['job_id'] ?? 0;
        $job = $this->jobModel->getJobById($jobId);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        // Get form data (same as from employer control)
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $requirements = $_POST['requirements'] ?? '';
        $benefits = $_POST['benefits'] ?? '';
        $jobType = $_POST['employment_type'] ?? '';
        $workModel = $_POST['work_model'] ?? '';
        $experienceLevel = $_POST['experience_level'] ?? '';
        $location = $_POST['location'] ?? '';
        $salaryMin = !empty($_POST['salary_min']) ? $_POST['salary_min'] : null;
        $salaryMax = !empty($_POST['salary_max']) ? $_POST['salary_max'] : null;
        $hideSalary = isset($_POST['hide_salary']) ? 1 : 0;
        $categoryId = $_POST['category_id'] ?? '';
        $newCategory = $_POST['new_category'] ?? '';
        $status = $_POST['status'] ?? $job['status']; // Keep existing status by default
        $deadline = !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null;
        
        // Handle new category if provided
        if (!empty($newCategory)) {
            $categoryId = $this->jobModel->createCategory($newCategory);
        }
        
        // Update job
        $updated = $this->jobModel->updateJob($jobId, [
            'title' => $title,
            'description' => $description,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'job_type' => $jobType,
            'work_model' => $workModel,
            'experience_level' => $experienceLevel,
            'location' => $location,
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'hide_salary' => $hideSalary,
            'status' => $status,
            'application_deadline' => $deadline
        ]);
        
        if ($updated) {
            // Update job category if we have one - using the new category_id field
            if ($categoryId) {
                // Direct update to the category_id field
                $this->jobModel->updateJobCategory($jobId, $categoryId);
            }
            
            $_SESSION['success'] = 'Job updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update job';
        }
        
        $this->redirect('admin/jobs');
    }
    
    // Approve job
    public function approveJob($id) {
        $job = $this->jobModel->getJobById($id);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        // Set admin_status to approved AND change job status to active
        if ($this->jobModel->updateAdminStatus($id, 'approved') && 
            $this->jobModel->updateJobStatus($id, 'active')) {
            
            // Create notification for employer
            $this->notificationModel->createNotification([
                'user_id' => $job['employer_id'],
                'title' => 'Job Post Approved',
                'message' => 'Your job posting "' . $job['title'] . '" has been approved and is now visible to job seekers.',
                'type' => 'approval',
                'reference_id' => $id
            ]);
            
            $_SESSION['success'] = 'Job approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve job';
        }
        
        $this->redirect('admin/jobs');
    }
    
    // Reject job
    public function rejectJob($id) {
        $job = $this->jobModel->getJobById($id);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        // Update admin_status to rejected AND change job status to rejected
        if ($this->jobModel->updateAdminStatus($id, 'rejected') && 
            $this->jobModel->updateJobStatus($id, 'rejected')) {
            
            // Create notification for employer
            $this->notificationModel->createNotification([
                'user_id' => $job['employer_id'],
                'title' => 'Job Post Rejected',
                'message' => 'Your job posting "' . $job['title'] . '" has been rejected. Please review and update it before resubmitting.',
                'type' => 'approval',
                'reference_id' => $id
            ]);
            
            $_SESSION['success'] = 'Job rejected';
        } else {
            $_SESSION['error'] = 'Failed to reject job';
        }
        
        $this->redirect('admin/jobs');
    }
    
    // Delete job
    private function deleteJob($id) {
        $job = $this->jobModel->getJobById($id);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('admin/jobs');
            return;
        }
        
        if ($this->jobModel->deleteJob($id)) {
            $_SESSION['success'] = 'Job deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete job';
        }
        
        $this->redirect('admin/jobs');
    }

    private function viewUser($id) {
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            $this->redirect('admin/users');
            return;
        }
        
        $data = [
            'pageTitle' => $user['full_name'],
            'user' => $user
        ];
        
        // If user is employer, get their company
        if ($user['role'] === 'company_admin') {
            $company = $this->companyModel->getCompanyByEmployerId($id);
            if ($company) {
                $data['company'] = $company;
                
                // Get count of jobs posted by this company
                $data['jobCount'] = $this->jobModel->getCompanyJobCount($company['company_id']);
            }
        }
        
        // If user is job seeker, get their applications
        if ($user['role'] === 'job_seeker') {
            $applications = $this->applicationModel->getApplicationsBySeekerId($id);
            $data['applications'] = $applications;
            $data['applicationCount'] = count($applications);
        }
        
        $this->view('admin/view-user', $data, 'admin');
    }
    
    // User management
    public function users($action = null, $id = null) {
        $this->requireAdminLogin();
        
        if ($action === 'view' && $id) {
            $this->viewUser($id);
            return;
        }
        
        // Default: show user listing
        $role = $_GET['role'] ?? 'all';
        
        if ($role !== 'all') {
            $users = $this->userModel->getUsersByRole($role);
        } else {
            $users = $this->userModel->getAllUsers();
        }
        
        $data = [
            'pageTitle' => 'User Management',
            'users' => $users,
            'activeFilter' => $role
        ];
        
        $this->view('admin/users', $data, 'admin');
    }
    
    // Helper: Check if admin is logged in
    private function isAdminLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }
    
    // Helper: Require admin login
    private function requireAdminLogin() {
        $adminMiddleware = new \middlewares\AdminMiddleware();
        $adminMiddleware->handle();
    }

    public function applications($action = null, $id = null) {
        $this->requireAdminLogin();
        
        if ($action === 'view' && $id) {
            // View a specific application
            $application = $this->applicationModel->getApplicationById($id);
            $job = $this->jobModel->getJobById($application['job_id']);
            
            $data = [
                'pageTitle' => 'View Application',
                'application' => $application,
                'job' => $job
            ];
            
            $this->view('admin/view-application', $data, 'admin');
            return;
        }
        
        if ($action === 'approve' && $id) {
            $this->approveApplication($id);
            return;
        } else if ($action === 'approve' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['application_id'] ?? 0;
            $this->approveApplication($id);
            return;
        }
        
        if ($action === 'reject' && $id) {
            $this->rejectApplication($id);
            return;
        } else if ($action === 'reject' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['application_id'] ?? 0;
            $this->rejectApplication($id);
            return;
        }
        
        if ($action === 'edit' && $id) {
            // Edit application form
            $application = $this->applicationModel->getApplicationById($id);
            $job = $this->jobModel->getJobById($application['job_id']);
            
            $data = [
                'pageTitle' => 'Edit Application',
                'application' => $application,
                'job' => $job
            ];
            
            $this->view('admin/edit-application', $data, 'admin');
            return;
        }
        
        // Get filter parameter
        $filter = $_GET['filter'] ?? '';
    
        // Get applications based on admin_status filter
        if ($filter === 'pending') {
            $applications = $this->applicationModel->getApplicationsByAdminStatus('pending');
        } else if ($filter === 'approved') {
            $applications = $this->applicationModel->getApplicationsByAdminStatus('approved');
        } else if ($filter === 'rejected') {
            $applications = $this->applicationModel->getApplicationsByAdminStatus('rejected');
        } else {
            $applications = $this->applicationModel->getAllApplications();
        }
        
        $data = [
            'pageTitle' => 'Manage Applications',
            'applications' => $applications
        ];
        
        $this->view('admin/applications', $data, 'admin');
    }
    
    public function approveApplication($id) {
        $application = $this->applicationModel->getApplicationById($id);
        
        if (!$application) {
            $_SESSION['error'] = 'Application not found';
            $this->redirect('admin/applications');
            return;
        }
        
        // Update admin_status to approved
        if ($this->applicationModel->updateAdminStatus($id, 'approved')) {
            // Get job details
            $job = $this->jobModel->getJobById($application['job_id']);
            
            // Create notification for employer
            $this->notificationModel->createNotification([
                'user_id' => $job['employer_id'],
                'title' => 'New Application',
                'message' => $application['full_name'] . ' has applied for your "' . $job['title'] . '" position',
                'type' => 'application',
                'reference_id' => $id
            ]);
            
            $_SESSION['success'] = 'Application approved successfully';
        } else {
            $_SESSION['error'] = 'Failed to approve application';
        }
        
        $this->redirect('admin/applications');
    }
    
    public function rejectApplication($id) {
        $application = $this->applicationModel->getApplicationById($id);
        
        if (!$application) {
            $_SESSION['error'] = 'Application not found';
            $this->redirect('admin/applications');
            return;
        }
        
        // Update admin_status to rejected
        if ($this->applicationModel->updateAdminStatus($id, 'rejected')) {
            // Create notification for seeker
            $this->notificationModel->createNotification([
                'user_id' => $application['seeker_id'],
                'title' => 'Application Not Forwarded',
                'message' => 'Your application for the job "' . $application['job_title'] . '" was not forwarded to the employer.',
                'type' => 'application',
                'reference_id' => $id
            ]);
            
            $_SESSION['success'] = 'Application rejected';
        } else {
            $_SESSION['error'] = 'Failed to reject application';
        }
        
        $this->redirect('admin/applications');
    }
}