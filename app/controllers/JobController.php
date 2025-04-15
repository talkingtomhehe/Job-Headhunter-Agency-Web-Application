<?php
namespace controllers;

use core\Controller;
use models\JobPost;
use models\Application;
use models\Company;

class JobController extends Controller {
    private $jobModel;
    private $applicationModel;
    private $companyModel;
    
    public function __construct() {
        $this->jobModel = new JobPost();
        $this->applicationModel = new Application();
        $this->companyModel = new Company();
    }
    
    /**
     * Display all active job listings
     */
    public function index() {
        // Get all active job listings
        $jobs = $this->jobModel->getAllActiveJobs();
        
        // Load the jobs view
        $this->view('jobs/index', [
            'pageTitle' => 'Browse Jobs',
            'jobs' => $jobs
        ]);
    }
    
    /**
     * Display a specific job's details
     */
    public function view($jobId = null) {
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
        
        // Load the job detail view
        $this->view('jobs/view', [
            'pageTitle' => $job['title'],
            'job' => $job,
            'company' => $company
        ]);
    }
    
    /**
     * Download job description as PDF
     */
    public function downloadPdf($jobId = null) {
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
        
        // Generate PDF file
        require_once ROOT_PATH . '/app/helpers/PdfGenerator.php';
        $pdfGenerator = new \helpers\PdfGenerator();
        $pdfPath = $pdfGenerator->generateJobPdf($job, $company);
        
        // Set appropriate headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="job_' . $jobId . '.pdf"');
        header('Cache-Control: max-age=0');
        
        // Output the PDF file
        readfile($pdfPath);
        
        // Delete the temporary file
        unlink($pdfPath);
        exit;
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
            'company' => $company
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
    
    /**
     * Search for jobs
     */
    public function search() {
        // Get search parameters
        $keyword = $_GET['keyword'] ?? '';
        $location = $_GET['location'] ?? '';
        $workModel = $_GET['work_model'] ?? '';
        $category = $_GET['category'] ?? '';
        
        // Search for jobs
        $jobs = $this->jobModel->searchJobs($keyword, $location, $workModel, $category);
        
        // Load the search results view
        $this->view('jobs/search', [
            'pageTitle' => 'Job Search Results',
            'jobs' => $jobs,
            'keyword' => $keyword,
            'location' => $location,
            'workModel' => $workModel,
            'category' => $category
        ]);
    }
}