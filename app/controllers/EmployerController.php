<?php
namespace controllers;

use core\Controller;
use models\JobPost;
use models\Application;
use models\Company;
use models\User;

class EmployerController extends Controller {
    private $jobModel;
    private $applicationModel;
    private $companyModel;
    private $userModel; // Add this property
    
    public function __construct() {
        // Check if user is logged in as employer
        if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'company_admin') {
            $this->redirect('auth');
        }
        
        // Load models
        $this->jobModel = new JobPost();
        $this->applicationModel = new Application();
        $this->companyModel = new Company();
        $this->userModel = new User(); // Initialize the User model
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
                'pageTitle' => 'Create New Job',
                'categories' => $this->jobModel->getCategories(),
                'workModels' => $this->jobModel->getWorkModels(),
                'experienceLevels' => $this->jobModel->getExperienceLevels()
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
        $newCategory = $_POST['new_category'] ?? null;
        $status = $_POST['status'] ?? 'active';
        $deadline = !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null;
        
        // Handle new category creation
        if (!empty($newCategory) && empty($categoryId)) {
            $categoryId = $this->jobModel->createCategory($newCategory);
        }
        
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
        
        // Get categories and check if the job's category exists
        $categories = $this->jobModel->getCategories();
        $jobCategories = $this->jobModel->getJobCategories($id);
        
        // Check if job has a category that's not in the list
        $hasCustomCategory = false;
        $customCategory = null;
        
        if (!empty($jobCategories)) {
            $categoryExists = false;
            foreach ($categories as $category) {
                if ($category['category_id'] == $jobCategories[0]['category_id']) {
                    $categoryExists = true;
                    break;
                }
            }
            
            if (!$categoryExists && !empty($jobCategories[0]['name'])) {
                $hasCustomCategory = true;
                $customCategory = $jobCategories[0];
            }
        }
        
        $data = [
            'job' => $job,
            'jobCategories' => $jobCategories,
            'categories' => $categories,
            'hasCustomCategory' => $hasCustomCategory,
            'customCategory' => $customCategory,
            'pageTitle' => 'Edit Job',
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
        $categoryId = $_POST['category_id'] ?? '';
        $newCategory = $_POST['new_category'] ?? '';
        $status = $_POST['status'] ?? 'active';
        $deadline = !empty($_POST['application_deadline']) ? $_POST['application_deadline'] : null;
        
        // Handle new category creation
        if (!empty($newCategory) && empty($categoryId)) {
            $categoryId = $this->jobModel->createCategory($newCategory);
        }

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
            if (!empty($categoryId)) {
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
    public function applications($action = null, $id = null) {
        $employerId = $_SESSION['user_id'];
        
        if ($action === 'filter') {
            // Handle AJAX filter request
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $filters = [
                    'status' => $_POST['status'] ?? null,
                    'job_id' => $_POST['job_id'] ?? null,
                    'search' => $_POST['search'] ?? null
                ];
                
                $applications = $this->applicationModel->getDetailedApplicationsByEmployer($employerId, $filters);
                
                // Return JSON response
                header('Content-Type: application/json');
                echo json_encode(['applications' => $applications]);
                exit;
            }
        }
        
        if ($action === 'view' && !empty($id)) {
            return $this->viewApplication($id);
        }
        
        if ($action === 'notes' && !empty($id)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $notes = $_POST['notes'] ?? '';
                
                // Verify ownership
                $application = $this->applicationModel->getApplicationById($id);
                $job = $this->jobModel->getJobById($application['job_id']);
                
                if ($job['employer_id'] != $_SESSION['user_id']) {
                    $_SESSION['error'] = 'Unauthorized access';
                    $this->redirect('employer/applications');
                    return;
                }
                
                if ($this->applicationModel->updateNotes($id, $notes)) {
                    $_SESSION['success'] = 'Notes updated successfully';
                } else {
                    $_SESSION['error'] = 'Failed to update notes';
                }
                
                $this->redirect('employer/applications/view/' . $id);
                return;
            }
        }
        
        if ($action === 'interview' && !empty($id)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $date = $_POST['interview_date'] ?? '';
                $location = $_POST['interview_location'] ?? '';
                
                // Verify ownership
                $application = $this->applicationModel->getApplicationById($id);
                $job = $this->jobModel->getJobById($application['job_id']);
                
                if ($job['employer_id'] != $_SESSION['user_id']) {
                    $_SESSION['error'] = 'Unauthorized access';
                    $this->redirect('employer/applications');
                    return;
                }
                
                if ($this->applicationModel->scheduleInterview($id, $date, $location)) {
                    $_SESSION['success'] = 'Interview scheduled successfully';
                } else {
                    $_SESSION['error'] = 'Failed to schedule interview';
                }
                
                $this->redirect('employer/applications/view/' . $id);
                return;
            }
        }
        
        // Get all jobs for filter dropdown
        $jobs = $this->jobModel->getJobsByEmployer($employerId);
        
        // Get application statistics
        $applicationStats = $this->applicationModel->getApplicationStats($employerId);
        
        // Get all applications
        $applications = $this->applicationModel->getApplicationsByEmployer($employerId);
        
        $data = [
            'applications' => $applications,
            'jobs' => $jobs,
            'stats' => $applicationStats,
            'pageTitle' => 'Job Applications'
        ];
        
        $this->view('employer/applications', $data, 'employer');
    }
    
    // View a single application
    private function viewApplication($id) {
        // Get the application details
        $application = $this->applicationModel->getApplicationById($id);
        
        if (!$application) {
            $_SESSION['error'] = 'Application not found';
            $this->redirect('employer/applications');
            return;
        }
        
        // Get the associated job
        $job = $this->jobModel->getJobById($application['job_id']);
        
        // Verify that this application belongs to a job posted by the current employer
        if ($job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/applications');
            return;
        }
        
        $data = [
            'application' => $application,
            'job' => $job,
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
        if(!$application) {
            $_SESSION['error'] = 'Application not found';
            $this->redirect('employer/applications');
            return;
        }
        
        $job = $this->jobModel->getJobById($application['job_id']);
        if(!$job || $job['employer_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Unauthorized access';
            $this->redirect('employer/applications');
            return;
        }
        
        if($this->applicationModel->updateStatus($applicationId, $status)) {
            $_SESSION['success'] = 'Application status updated to ' . ucfirst($status);
            // Redirect back to the specific application view
            $this->redirect('employer/applications/view/' . $applicationId);
        } else {
            $_SESSION['error'] = 'Failed to update status';
            $this->redirect('employer/applications/view/' . $applicationId);
        }
    }
    
    // Company profile page
    public function profile($action = null, $param = null) {
        $employerId = $_SESSION['user_id'];
    
        // Handle action based on URL segments
        switch ($action) {
            case 'edit':
                // Get company profile for editing
                $company = $this->companyModel->getCompanyByEmployerId($employerId);
                
                if (!$company) {
                    $_SESSION['error'] = 'Company profile not found';
                    $this->redirect('employer/profile');
                    return;
                }
                
                $data = [
                    'company' => $company,
                    'pageTitle' => 'Edit Company Profile'
                ];
                
                $this->view('employer/edit-profile', $data, 'employer');
                return;
                
            case 'update':
                // Process form submission
                $this->updateProfile();
                return;
                
            default:
                // Display profile page
                $company = $this->companyModel->getCompanyByEmployerId($employerId);
                
                // If no company profile exists yet, create a default one
                if (!$company) {
                    // Create a default company profile with the user's name
                    $user = $this->userModel->getUserById($employerId);
                    $companyName = $user['full_name'] . "'s Company";
                    
                    $this->companyModel->createCompany($employerId, $companyName);
                    $company = $this->companyModel->getCompanyByEmployerId($employerId);
                }
                
                // Get recent jobs posted by this company
                $jobs = $this->jobModel->getJobsByEmployer($employerId, 5);
                
                $data = [
                    'company' => $company,
                    'jobs' => $jobs,
                    'pageTitle' => 'Company Profile'
                ];
                
                $this->view('employer/company-profile', $data, 'employer');
                return;
        }
    }
    
    public function updateProfile() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('employer/profile');
            return;
        }
        
        $employerId = $_SESSION['user_id'];
        $company = $this->companyModel->getCompanyByEmployerId($employerId);
        
        if (!$company) {
            $_SESSION['error'] = 'Company profile not found';
            $this->redirect('employer/profile');
            return;
        }
        
        // Prepare data for update
        $data = [
            'company_name' => $_POST['company_name'],
            'headquarters_address' => $_POST['headquarters_address'] ?? null,
            'website' => $_POST['website'] ?? null,
            'description' => $_POST['description'] ?? null,
            'industry' => $_POST['industry'] ?? null,
            'company_size' => $_POST['company_size'] ?? null,
            'logo_path' => $company['logo_path'] // Default to current logo
        ];
        
        // Handle logo upload if present
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/public/uploads/company_logos/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileExt = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $fileName = 'company_' . $company['company_id'] . '_' . time() . '.' . $fileExt;
            $uploadPath = 'uploads/company_logos/' . $fileName;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $fileName)) {
                $data['logo_path'] = $uploadPath;
            } else {
                $_SESSION['error'] = 'Failed to upload logo image';
                $this->redirect('employer/profile/edit');
                return;
            }
        }
        
        // Update company details
        if ($this->companyModel->updateCompany($company['company_id'], $data)) {
            $_SESSION['success'] = 'Company profile updated successfully';
            $this->redirect('employer/profile');
        } else {
            $_SESSION['error'] = 'Failed to update company profile';
            $this->redirect('employer/profile/edit');
        }
    }

    public function rejectApplication($id) {
        $application = $this->applicationModel->getApplicationById($id);
        
        // Verify this application belongs to one of the employer's job postings
        if (!$application || !$this->isEmployerJobApplication($application['job_id'])) {
            $_SESSION['error'] = 'Application not found or access denied';
            $this->redirect('employer/applications');
            return;
        }
        
        // Only allow rejecting applications that have been approved or are in intermediate stages
        if (in_array($application['status'], ['approved', 'reviewing', 'shortlisted'])) {
            if ($this->applicationModel->updateStatus($id, 'rejected')) {
                $_SESSION['success'] = 'Application rejected successfully';
            } else {
                $_SESSION['error'] = 'Failed to reject application';
            }
        } else {
            $_SESSION['error'] = 'Cannot reject application in its current state';
        }
        
        $this->redirect('employer/applications');
    }
    
    // Helper method to verify employer owns the job
    private function isEmployerJobApplication($jobId) {
        $employerId = $_SESSION['user_id'];
        $job = $this->jobModel->getJobById($jobId);
        return $job && $job['employer_id'] == $employerId;
    }
}