<?php
namespace controllers;

use core\Controller;
use models\JobPost;
use models\Company;
use helpers\FormatHelper;

class HomeController extends Controller {
    private $jobModel;
    private $companyModel;
    
    public function __construct() {
        // Initialize models
        $this->jobModel = new JobPost();
        $this->companyModel = new Company();
    }
    
    // Home page
    public function index() {
        // Get recent approved jobs and top companies
        $recentJobs = $this->jobModel->getApprovedJobs('', '', '', '', '', '', 'newest', 3, 0);
        $topCompanies = $this->companyModel->getTopCompanies(5);
        
        // Get categories and work models for the search form
        $categories = $this->jobModel->getCategories();
        $workModels = $this->jobModel->getWorkModels();
        
        $data = [
            'pageTitle' => 'Huntly - Find Your Dream Job',
            'recentJobs' => $recentJobs,
            'topCompanies' => $topCompanies,
            'categories' => $categories,
            'workModels' => $workModels,
            'formatSalary' => [FormatHelper::class, 'formatSalary'],
            'timeAgo' => [FormatHelper::class, 'timeAgo']
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

    public function jobs() {
        // Get query parameters for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $jobsPerPage = 10;
        $offset = ($page - 1) * $jobsPerPage;
        
        // Get search parameters
        $keyword = $_GET['keyword'] ?? '';
        $location = $_GET['location'] ?? '';
        $workModel = $_GET['work_model'] ?? '';
        $category = $_GET['category'] ?? '';
        $sortBy = $_GET['sort'] ?? 'newest';
        
        // Get job categories for filter
        $categories = $this->jobModel->getCategories();
        
        // Get all approved active jobs with pagination and filters
        $jobs = $this->jobModel->getApprovedJobs($keyword, $location, $category, $workModel, $sortBy, $jobsPerPage, $offset);
        $totalJobs = $this->jobModel->countApprovedJobs($keyword, $location, $category, $workModel);
        
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
            'selectedCategory' => $category,
            'sortBy' => $sortBy,
            'formatSalary' => [FormatHelper::class, 'formatSalary'], 
            'timeAgo' => [FormatHelper::class, 'timeAgo'], 
            'additionalCss' => ['joblisting.css']
        ]);
    }
}