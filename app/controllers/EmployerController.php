<?php
namespace controllers;

use core\Controller;
use models\JobPost;
use models\Application;
use models\Company;

class EmployerController extends Controller {
    private $jobModel;
    private $applicationModel;
    private $companyModel;
    
    public function __construct() {
        // Check if user is logged in as employer
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company_admin') {
            $this->redirect('auth');
        }
        
        // Load models
        $this->jobModel = new JobPost();
        $this->applicationModel = new Application();
        $this->companyModel = new Company();
    }
    
    // Dashboard page (default action)
    public function index() {
        $employerId = $_SESSION['user_id'];
        
        // Get stats for dashboard
        $data = [
            'activeJobs' => $this->jobModel->countActiveJobsByEmployer($employerId),
            'totalJobs' => $this->jobModel->countAllJobsByEmployer($employerId),
            'totalApplications' => $this->applicationModel->countApplicationsByEmployer($employerId),
            'todayApplications' => $this->applicationModel->countTodayApplicationsByEmployer($employerId),
            'applicationStats' => $this->applicationModel->getApplicationStatusCountsByEmployer($employerId),
            'jobStats' => $this->jobModel->getJobStatusCountsByEmployer($employerId),
            'recentApplications' => $this->applicationModel->getRecentApplicationsByEmployer($employerId, 5),
            'pageTitle' => 'Employer Dashboard'
        ];
        
        // Render view with employer layout
        $this->view('employer/dashboard', $data, 'employer');
    }
    
    // Job listings page
    public function jobs($action = null, $id = null) {
        if ($action === 'create') {
            // Show job creation form
            $data = [
                'pageTitle' => 'Create New Job'
            ];
            $this->view('employer/create-job', $data, 'employer');
            return;
        } 
        
        if ($action === 'viewJob' && !empty($id)) {
            // Call the viewJob method with the ID
            return $this->viewJob($id);
        }
        
        // Add this block to handle the edit action
        if ($action === 'editJob' && !empty($id)) {
            // Call the editJob method with the ID
            return $this->editJob($id);
        }

        if ($action === 'store') {
            // Call the storeJob method
            return $this->storeJob();
        }
        
        if ($action === 'update') {
            // Call the updateJob method
            return $this->updateJob();
        }

        if ($action === 'updateStatus') {
            // Process status update from POST data
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $jobId = $_POST['job_id'] ?? 0;
                $status = $_POST['status'] ?? '';
                
                // Verify the job belongs to this employer
                $job = $this->jobModel->getJobById($jobId);
                if (!$job || $job['employer_id'] != $_SESSION['user_id']) {
                    $_SESSION['error'] = 'Unauthorized access';
                    $this->redirect('employer/jobs');
                    return;
                }
                
                if ($this->jobModel->updateStatus($jobId, $status)) {
                    $_SESSION['success'] = 'Job status updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to update job status';
                }
                
                $this->redirect('employer/jobs/viewJob/'.$jobId);
                return;
            }
        }

        if ($action === 'deleteJob') {
            // Process deletion from POST data
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $jobId = $_POST['job_id'] ?? 0;
                $job = $this->jobModel->getJobById($jobId);
                
                // Verify the job belongs to this employer
                if (!$job || $job['employer_id'] != $_SESSION['user_id']) {
                    $_SESSION['error'] = 'Unauthorized access';
                    $this->redirect('employer/jobs');
                    return;
                }
                
                if ($this->jobModel->deleteJob($jobId)) {
                    $_SESSION['success'] = 'Job deleted successfully';
                } else {
                    $_SESSION['error'] = 'Failed to delete job';
                }
                
                $this->redirect('employer/jobs');
                return;
            }
            
            // If not POST, redirect back to jobs
            $this->redirect('employer/jobs');
            return;
        }
        
        // Regular job listing code
        $employerId = $_SESSION['user_id'];
        $jobs = $this->jobModel->getJobsByEmployer($employerId);
        
        $data = [
            'jobs' => $jobs,
            'pageTitle' => 'My Job Listings'
        ];
        
        $this->view('employer/jobs', $data, 'employer');
    }
    
    // Create job form
    public function createJob() {
        $data = [
            'pageTitle' => 'Create New Job',
            'categories' => $this->jobModel->getCategories(),
            'workModels' => $this->jobModel->getWorkModels(),
            'experienceLevels' => $this->jobModel->getExperienceLevels()
        ];
        
        $this->view('employer/create-job', $data, 'employer');
    }
    
    // Process job creation
    public function storeJob() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/jobs');
            return;
        }
        
        $employerId = $_SESSION['user_id'];
        $companyId = $_SESSION['company_id'];
        
        // Get form data
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
        $categoryId = $_POST['category_id'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $deadline = !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null;
        
        // Handle PDF upload
        $pdfPath = null;
        if(isset($_FILES['job_pdf']) && $_FILES['job_pdf']['error'] == 0) {
            $uploadDir = ROOT_PATH . '/public/uploads/job_pdfs/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . $_FILES['job_pdf']['name'];
            $filePath = $uploadDir . $fileName;
            
            if(move_uploaded_file($_FILES['job_pdf']['tmp_name'], $filePath)) {
                $pdfPath = 'uploads/job_pdfs/' . $fileName;
            }
        }
        
        // Validate required fields
        if(empty($title) || empty($description) || empty($requirements) || empty($jobType) || empty($location)) {
            $_SESSION['error'] = 'Please fill in all required fields';
            $this->redirect('employer/jobs/create');
            return;
        }
        
        // Create job post
        $jobId = $this->jobModel->createJob([
            'company_id' => $companyId,
            'employer_id' => $employerId,
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
            'pdf_path' => $pdfPath,
            'status' => $status,
            'application_deadline' => $deadline
        ]);
        
        if($jobId) {
            // Add job categories if provided
            if(!empty($categoryId)) {
                $this->jobModel->addJobCategory($jobId, $categoryId);
            }
            
            $_SESSION['success'] = 'Job posted successfully';
            $this->redirect('employer/jobs');
        } else {
            $_SESSION['error'] = 'Failed to post job';
            $this->redirect('employer/jobs/create');
        }
    }
    
    // Edit job form
    public function editJob($id) {
        $job = $this->jobModel->getJobById($id);
        
        // Verify the job belongs to this employer
        if($job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/jobs');
            return;
        }
        
        $data = [
            'job' => $job,
            'pageTitle' => 'Edit Job',
            'categories' => $this->jobModel->getCategories(),
            'workModels' => $this->jobModel->getWorkModels(),
            'experienceLevels' => $this->jobModel->getExperienceLevels()
        ];
        
        $this->view('employer/edit-job', $data, 'employer');
    }
    
    // Process job update
    public function updateJob() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/jobs');
            return;
        }
        
        $jobId = $_POST['job_id'] ?? 0;
        $job = $this->jobModel->getJobById($jobId);
        
        // Verify the job belongs to this employer
        if($job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/jobs');
            return;
        }
        
        // Get form data
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
        $categoryId = $_POST['category_id'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $deadline = !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null;
        
        // Handle PDF upload if new one provided
        $pdfPath = $job['pdf_path']; // Keep existing by default
        if(isset($_FILES['job_pdf']) && $_FILES['job_pdf']['error'] == 0) {
            $uploadDir = ROOT_PATH . '/public/uploads/job_pdfs/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . $_FILES['job_pdf']['name'];
            $filePath = $uploadDir . $fileName;
            
            if(move_uploaded_file($_FILES['job_pdf']['tmp_name'], $filePath)) {
                $pdfPath = 'uploads/job_pdfs/' . $fileName;
            }
        }
        
        // Update job post with ALL form fields
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
            'application_deadline' => $deadline,
            'pdf_path' => $pdfPath
        ]);
        
        if($updated) {
            // Update job category
            if(!empty($categoryId)) {
                // First delete existing categories
                $this->jobModel->deleteJobCategories($jobId);
                // Then add the new one
                $this->jobModel->addJobCategory($jobId, $categoryId);
            }
            
            $_SESSION['success'] = 'Job updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update job';
        }
        
        $this->redirect('employer/jobs');
    }

    // Update job status
    public function updateJobStatus() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/jobs');
            return;
        }
        
        $jobId = $_POST['job_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        // Verify the job belongs to this employer
        $job = $this->jobModel->getJobById($jobId);
        if(!$job || $job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/jobs');
            return;
        }
        
        if($this->jobModel->updateStatus($jobId, $status)) {
            $_SESSION['success'] = 'Job status updated successfully';
        } else {
            $_SESSION['error'] = 'Failed to update job status';
        }
        
        $this->redirect('employer/jobs');
    }
    
    // Process job deletion
    public function deleteJob() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/jobs');
            return;
        }
        
        $jobId = $_POST['job_id'] ?? 0;
        $job = $this->jobModel->getJobById($jobId);
        
        // Verify the job belongs to this employer
        if(!$job || $job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/jobs');
            return;
        }
        
        if($this->jobModel->deleteJob($jobId)) {
            $_SESSION['success'] = 'Job deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete job';
        }
        
        $this->redirect('employer/jobs');
    }
    
    public function viewJob($id) {
        // Fetch the job by ID
        $job = $this->jobModel->getJobById($id);
        
        // Verify the job belongs to this employer
        if(!$job || $job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/jobs');
            return;
        }
        
        // Get applications for this job
        $applications = $this->applicationModel->getApplicationsByJob($job['job_id']);
        
        $data = [
            'job' => $job,
            'applications' => $applications,
            'pageTitle' => 'View Job'
        ];
        
        $this->view('employer/view-job', $data, 'employer');
    }

    // View applications for a job
    public function applications() {
        $employerId = $_SESSION['user_id'];
        $applications = $this->applicationModel->getApplicationsByEmployer($employerId);
        
        $data = [
            'applications' => $applications,
            'pageTitle' => 'Job Applications'
        ];
        
        $this->view('employer/applications', $data, 'employer');
    }
    
    // View a single application
    public function viewApplication($id) {
        $application = $this->applicationModel->getApplicationById($id);
        
        // Verify the application belongs to this employer
        $job = $this->jobModel->getJobById($application['job_id']);
        if($job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/applications');
            return;
        }
        
        $data = [
            'application' => $application,
            'pageTitle' => 'View Application'
        ];
        
        $this->view('employer/view-application', $data, 'employer');
    }
    
    // Update application status
    public function updateApplicationStatus() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/applications');
            return;
        }
        
        $applicationId = $_POST['application_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        // Verify ownership
        $application = $this->applicationModel->getApplicationById($applicationId);
        $job = $this->jobModel->getJobById($application['job_id']);
        if($job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/applications');
            return;
        }
        
        if($this->applicationModel->updateStatus($applicationId, $status)) {
            $_SESSION['success'] = 'Application status updated';
        } else {
            $_SESSION['error'] = 'Failed to update status';
        }
        
        $this->redirect('employer/applications');
    }
    
    // Company profile page
    public function profile() {
        $employerId = $_SESSION['user_id'];
        $company = $this->companyModel->getCompanyByEmployerId($employerId);
        
        $data = [
            'company' => $company,
            'pageTitle' => 'Company Profile'
        ];
        
        $this->view('employer/profile', $data, 'employer');
    }
    
    // Update company profile
    public function updateProfile() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/profile');
            return;
        }
        
        // Future implementation for profile update
        
        $_SESSION['success'] = 'Profile updated successfully';
        $this->redirect('employer/profile');
    }
}