<?php
namespace controllers;

use core\Controller;
use models\JobPost;
use models\Application;
use models\Company;
use helpers\FormatHelper;

class JobController extends Controller {
    private $jobModel;
    private $applicationModel;
    private $companyModel;
    
    public function __construct() {
        $this->jobModel = new JobPost();
        $this->applicationModel = new Application();
        $this->companyModel = new Company();
    }
    
    public function index() {
        // Get query parameters for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $jobsPerPage = 10;
        $offset = ($page - 1) * $jobsPerPage;
        
        // Get search parameters
        $keyword = $_GET['keyword'] ?? '';
        $location = $_GET['location'] ?? '';
        $workModel = $_GET['work_model'] ?? '';
        $category = $_GET['category'] ?? '';
        $experienceLevel = $_GET['experience'] ?? '';
        $jobType = $_GET['job_type'] ?? '';
        $sortBy = $_GET['sort'] ?? 'newest';
        
        // Get job categories for filter
        $categories = $this->jobModel->getCategories();
        
        // Get all approved active jobs with pagination and filters
        $jobs = $this->jobModel->getApprovedJobs($keyword, $location, $category, $workModel, $experienceLevel, $jobType, $sortBy, $jobsPerPage, $offset);
        $totalJobs = $this->jobModel->countApprovedJobs($keyword, $location, $category, $workModel, $experienceLevel, $jobType);
        
        // Load the jobs view
        $this->view('jobs/job-listing', [
            'pageTitle' => 'Browse Jobs',
            'jobs' => $jobs,
            'categories' => $categories,
            'totalJobs' => $totalJobs,
            'jobsPerPage' => $jobsPerPage,
            'page' => $page,
            'keyword' => $keyword,
            'location' => $location,
            'workModel' => $workModel,
            'experienceLevel' => $experienceLevel,
            'jobType' => $jobType,
            'selectedCategory' => $category,
            'sortBy' => $sortBy,
            'formatSalary' => [FormatHelper::class, 'formatSalary'], 
            'timeAgo' => [FormatHelper::class, 'timeAgo'], 
            'additionalCss' => ['joblisting.css', 'joblisting-fixes.css']
        ]);
    }
    
    public function viewJob($jobId = null) {
        if (!$jobId) {
            $this->redirect('jobs');
            return;
        }
        
        // Get job details (only show approved jobs)
        $job = $this->jobModel->getJobById($jobId);
        
        if (!$job || $job['status'] !== 'active' || $job['admin_status'] !== 'approved') {
            $_SESSION['error'] = 'Job not found or not available';
            $this->redirect('jobs');
            return;
        }
        
        // Get company details
        $company = $this->companyModel->getCompanyById($job['company_id']);
        
        // Hide contact information for guest users AND job seekers
        // Only show contact info to employers, admins, or the employer who posted the job
        $canViewContactInfo = isset($_SESSION['logged_in']) && 
                             ($_SESSION['role'] === 'admin' || 
                              $_SESSION['role'] === 'company_admin' || 
                              (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $job['employer_id']));
        
        if (!$canViewContactInfo) {
            // Remove sensitive contact information
            unset($job['contact_email']);
            unset($job['contact_phone']);
            unset($job['contact_person']);
            
            // Also mask company specific contact info
            if (isset($company['company_email'])) unset($company['company_email']);
            if (isset($company['company_phone'])) unset($company['company_phone']);
            
            // Keep only public info about company
            $limitedCompany = [
                'company_id' => $company['company_id'],
                'company_name' => $company['company_name'],
                'logo_path' => $company['logo_path'],
                'industry' => $company['industry'] ?? '',
                'company_size' => $company['company_size'] ?? '',
                'description' => $company['description'] ?? '',
                'website' => $company['website'] ?? ''
            ];
            $company = $limitedCompany;
        }
        
        // Get related jobs
        $relatedJobs = $this->jobModel->getRelatedJobs($jobId, $job['category_id'], 3);
        
        // Load the job detail view
        $this->view('jobs/job-detail', [
            'pageTitle' => $job['title'],
            'job' => $job,
            'company' => $company,
            'relatedJobs' => $relatedJobs,
            'isGuest' => !isset($_SESSION['logged_in']),
            'canViewContactInfo' => $canViewContactInfo,
            'formatSalary' => [FormatHelper::class, 'formatSalary'],
            'formatDate' => [FormatHelper::class, 'formatDate'],
            'additionalCss' => ['jobdetail.css', 'jobdetail-fixes.css']
        ]);
    }
    
    public function downloadPdf($jobId = null) {
        if (!$jobId) {
            $this->redirect('jobs');
            return;
        }
        
        // Get job details (only approved jobs)
        $job = $this->jobModel->getJobById($jobId);
        
        if (!$job || $job['status'] !== 'active' || $job['admin_status'] !== 'approved') {
            $_SESSION['error'] = 'Job not found or not available';
            $this->redirect('jobs');
            return;
        }
        
        // Check if job has an uploaded PDF
        if (!empty($job['pdf_path'])) {
            $pdfPath = ROOT_PATH . '/public/' . $job['pdf_path'];
            
            // Check if the file exists
            if (file_exists($pdfPath)) {
                // Set appropriate headers for PDF download
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="job_' . $jobId . '.pdf"');
                header('Cache-Control: max-age=0');
                
                // Output the PDF file
                readfile($pdfPath);
                exit;
            }
        }
        
        // If no PDF exists, show error
        $_SESSION['error'] = 'PDF description not available for this job';
        $this->redirect('jobs/view/' . $jobId);
    }
    
    /**
     * Show job application form
     */
    public function apply($jobId = null) {
        if (!$jobId) {
            $this->redirect('jobs');
            return;
        }
        
        // Get job details
        $job = $this->jobModel->getJobById($jobId);
        
        if (!$job) {
            $_SESSION['error'] = 'Job not found';
            $this->redirect('jobs');
            return;
        }
        
        // Get company details
        $company = $this->companyModel->getCompanyById($job['company_id']);
        
        // Load the application form view
        $this->view('jobs/apply', [
            'pageTitle' => 'Apply for ' . $job['title'],
            'job' => $job,
            'company' => $company,
            'formatSalary' => [FormatHelper::class, 'formatSalary'],
            'formatDate' => [FormatHelper::class, 'formatDate'],
            'additionalCss' => ['application-form.css']
        ]);
    }
    
    /**
     * Process job application submission
     */
    public function submitApplication() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('jobs');
            return;
        }
        
        $jobId = $_POST['job_id'] ?? null;
        
        if (!$jobId) {
            $_SESSION['error'] = 'Invalid job ID';
            $this->redirect('jobs');
            return;
        }
        
        // Validate required fields
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        
        if (empty($fullName) || empty($email) || empty($phone)) {
            $_SESSION['error'] = 'Please fill in all required fields';
            $this->redirect('jobs/apply/' . $jobId);
            return;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Please enter a valid email address';
            $this->redirect('jobs/apply/' . $jobId);
            return;
        }
        
        // Handle resume upload
        $resumePath = '';
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            // Validate file type (PDF only)
            $fileType = $_FILES['resume']['type'];
            if ($fileType !== 'application/pdf') {
                $_SESSION['error'] = 'Resume must be in PDF format';
                $this->redirect('jobs/apply/' . $jobId);
                return;
            }
            
            // Generate unique filename
            $fileName = uniqid('resume_') . '.pdf';
            $uploadDir = ROOT_PATH . '/public/uploads/resumes/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $uploadPath = $uploadDir . $fileName;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
                $resumePath = 'uploads/resumes/' . $fileName;
            } else {
                $_SESSION['error'] = 'Failed to upload resume';
                $this->redirect('jobs/apply/' . $jobId);
                return;
            }
        } else {
            $_SESSION['error'] = 'Please upload your resume in PDF format';
            $this->redirect('jobs/apply/' . $jobId);
            return;
        }
        
        // Prepare application data
        $applicationData = [
            'job_id' => $jobId,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'resume_path' => $resumePath,
            'cover_letter' => $_POST['cover_letter'] ?? '',
            'status' => 'pending',
            'guest_application' => 1
        ];
        
        // Submit application
        if ($this->applicationModel->createApplication($applicationData)) {
            $_SESSION['success'] = 'Your application has been submitted successfully!';
            $this->redirect('jobs/view/' . $jobId);
        } else {
            $_SESSION['error'] = 'Failed to submit application. Please try again.';
            $this->redirect('jobs/apply/' . $jobId);
        }
    }
    
    public function search() {
        // Get search parameters
        $keyword = $_GET['keyword'] ?? '';
        $location = $_GET['location'] ?? '';
        $workModel = $_GET['work_model'] ?? '';
        $category = $_GET['category'] ?? '';
        $experienceLevel = $_GET['experience'] ?? '';
        $jobType = $_GET['job_type'] ?? '';
        $sortBy = $_GET['sort'] ?? 'newest';
        
        // Get page parameters for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $jobsPerPage = 10;
        $offset = ($page - 1) * $jobsPerPage;
        
        // Search for jobs with pagination
        $jobs = $this->jobModel->getApprovedJobs($keyword, $location, $category, $workModel, $experienceLevel, $jobType, $sortBy, $jobsPerPage, $offset);
        $totalJobs = $this->jobModel->countApprovedJobs($keyword, $location, $category, $workModel, $experienceLevel, $jobType);
        
        // Format jobs for JSON response
        $formattedJobs = [];
        foreach ($jobs as $job) {
            // Format the job data
            $formattedJobs[] = $job;
        }
        
        // Calculate pagination data
        $totalPages = ceil($totalJobs / $jobsPerPage);
        $pagination = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'jobsPerPage' => $jobsPerPage,
            'totalJobs' => $totalJobs
        ];
        
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'jobs' => $formattedJobs,
            'totalJobs' => $totalJobs,
            'pagination' => $pagination
        ]);
        exit;
    }
}