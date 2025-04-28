<?php
namespace models;

use core\Model;

class JobPost extends Model {
    
    // Get all jobs
    public function getJobs($limit = null) {
        $query = "SELECT j.*, c.company_name, c.logo_path 
                    FROM job_posts j 
                    JOIN companies c ON j.company_id = c.company_id 
                    WHERE j.admin_status = 'approved' AND j.status != 'draft' AND j.status != 'closed'
                    ORDER BY j.created_at DESC";
                  
        if($limit) {
            $query .= " LIMIT ?";
        }
        
        $this->db->query($query);
        
        if($limit) {
            $this->db->bind(1, $limit);
        }
        
        return $this->db->resultSet();
    }
    
    // Get job by ID
    public function getJobById($id) {
        $query = "SELECT j.*, c.company_name, c.logo_path, c.website
                  FROM job_posts j 
                  JOIN companies c ON j.company_id = c.company_id 
                  WHERE j.job_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $id);
        
        return $this->db->single();
    }
    
    // Get jobs by employer ID
    public function getJobsByEmployer($employerId) {
        $query = "SELECT j.*, c.company_name, 
                  (SELECT COUNT(*) FROM job_applications a 
                   WHERE a.job_id = j.job_id AND a.admin_status = 'approved') as application_count 
                  FROM job_posts j 
                  JOIN companies c ON j.company_id = c.company_id 
                  WHERE j.employer_id = ? 
                  ORDER BY j.created_at DESC";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        
        return $this->db->resultSet();
    }
    
    // Count all jobs by employer
    public function countAllJobsByEmployer($employerId) {
        $query = "SELECT COUNT(*) as count FROM job_posts WHERE employer_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
    
    // Create job post
    public function createJob($data) {
        $query = "INSERT INTO job_posts (company_id, employer_id, category_id, title, description, 
                  requirements, benefits, job_type, work_model, experience_level, location, 
                  salary_min, salary_max, hide_salary, pdf_path, status, admin_status, application_deadline, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $data['company_id']);
        $this->db->bind(2, $data['employer_id']);
        $this->db->bind(3, $data['category_id'] ?? null);
        $this->db->bind(4, $data['title']);
        $this->db->bind(5, $data['description']);
        $this->db->bind(6, $data['requirements']);
        $this->db->bind(7, $data['benefits'] ?? null);
        $this->db->bind(8, $data['job_type']);
        $this->db->bind(9, $data['work_model'] ?? null);
        $this->db->bind(10, $data['experience_level'] ?? null);
        $this->db->bind(11, $data['location']);
        $this->db->bind(12, $data['salary_min']);
        $this->db->bind(13, $data['salary_max']);
        $this->db->bind(14, $data['hide_salary'] ?? 0);
        $this->db->bind(15, $data['pdf_path']);
        $this->db->bind(16, $data['status']);
        $this->db->bind(17, $data['application_deadline'] ?? null);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    // Update job post
    public function updateJob($jobId, $data) {
        $query = "UPDATE job_posts SET 
                  title = ?, 
                  description = ?, 
                  requirements = ?,
                  benefits = ?,
                  job_type = ?, 
                  category_id = ?,
                  work_model = ?,
                  experience_level = ?,
                  location = ?, 
                  salary_min = ?, 
                  salary_max = ?,
                  hide_salary = ?,
                  pdf_path = ?,
                  status = ?,
                  application_deadline = ?,
                  updated_at = NOW()
                  WHERE job_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $data['title']);
        $this->db->bind(2, $data['description']);
        $this->db->bind(3, $data['requirements']);
        $this->db->bind(4, $data['benefits'] ?? null);
        $this->db->bind(5, $data['job_type']);
        $this->db->bind(6, $data['category_id'] ?? null);
        $this->db->bind(7, $data['work_model'] ?? null);
        $this->db->bind(8, $data['experience_level'] ?? null);
        $this->db->bind(9, $data['location']);
        $this->db->bind(10, $data['salary_min']);
        $this->db->bind(11, $data['salary_max']);
        $this->db->bind(12, $data['hide_salary'] ?? 0);
        $this->db->bind(13, $data['pdf_path']);
        $this->db->bind(14, $data['status']);
        $this->db->bind(15, $data['application_deadline'] ?? null);
        $this->db->bind(16, $jobId);
        
        return $this->db->execute();
    }
    
    // Delete job post
    public function deleteJob($jobId) {
        $query = "DELETE FROM job_posts WHERE job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        
        return $this->db->execute();
    }
    
    // Update job status
    public function updateStatus($id, $status) {
        $query = "UPDATE job_posts SET status = ?, updated_at = NOW() WHERE job_id = ?";
                
        $this->db->query($query);
        $this->db->bind(1, $status);
        $this->db->bind(2, $id);
        
        return $this->db->execute();
    }
    
    // Search jobs
    public function searchJobs($keyword, $location, $category, $workModel) {
        $query = "SELECT j.*, c.company_name, c.logo_path 
                    FROM job_posts j 
                    JOIN companies c ON j.company_id = c.company_id 
                    WHERE j.status = 'active' AND j.admin_status = 'approved'";
                  
        $params = [];
        
        if(!empty($keyword)) {
            $query .= " AND (j.title LIKE ? OR c.company_name LIKE ?)";
            $keyword = "%$keyword%";
            $params[] = $keyword;
            $params[] = $keyword;
        }
        
        if(!empty($location)) {
            $query .= " AND j.location LIKE ?";
            $params[] = "%$location%";
        }
        
        if(!empty($category)) {
            $query .= " AND j.category_id = ?";
            $params[] = $category;
        }
        
        if(!empty($workModel)) {
            $query .= " AND j.work_model = ?";
            $params[] = $workModel;
        }
        
        $query .= " ORDER BY j.created_at DESC";
        
        $this->db->query($query);
        
        // Bind all parameters
        foreach($params as $i => $param) {
            $this->db->bind($i + 1, $param);
        }
        
        return $this->db->resultSet();
    }

    public function getJobStatusCountsByEmployer($employerId) {
        $statuses = ['active', 'pending', 'rejected', 'draft', 'closed'];
        $result = [];
        
        foreach ($statuses as $status) {
            $query = "SELECT COUNT(*) as count FROM job_posts 
                      WHERE employer_id = ? AND status = ?";
            $this->db->query($query);
            $this->db->bind(1, $employerId);
            $this->db->bind(2, $status);
            $statusResult = $this->db->single();
            $result[$status] = $statusResult['count'] ?? 0;
        }
        
        return $result;
    }

    public function countActiveApprovedJobsByEmployer($employerId) {
        $query = "SELECT COUNT(*) as count FROM job_posts 
                  WHERE employer_id = ? AND status = 'active' AND admin_status = 'approved'";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
    
    public function countActiveJobsByEmployer($employerId) {
        $query = "SELECT COUNT(*) as count FROM job_posts 
                  WHERE employer_id = ? AND status = 'active'";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Get all work models
    public function getWorkModels() {
        // Define work model options as an array instead of querying a database table
        return [
            ['id' => 'remote', 'name' => 'Remote'],
            ['id' => 'onsite', 'name' => 'On-site'],
            ['id' => 'hybrid', 'name' => 'Hybrid']
        ];
    }
    
    public function getExperienceLevels() {
        // Define experience level options as an array instead of querying a database table
        return [
            ['id' => 'entry', 'name' => 'Entry Level'],
            ['id' => 'mid', 'name' => 'Mid Level'], 
            ['id' => 'senior', 'name' => 'Senior Level'],
            ['id' => 'executive', 'name' => 'Executive']
        ];
    }

    // Get all categories
    public function getCategories() {
        $query = "SELECT * FROM job_categories ORDER BY name";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function createCategory($categoryName) {
        // Generate a unique slug from the category name
        $slug = $this->generateSlug($categoryName);
        
        $query = "INSERT INTO job_categories (name, slug) VALUES (?, ?)";
        $this->db->query($query);
        $this->db->bind(1, $categoryName);
        $this->db->bind(2, $slug);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    private function generateSlug($text) {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9\-\_]/', '', $slug);
        
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    // Check if a slug already exists in the database
    private function slugExists($slug) {
        $this->db->query("SELECT COUNT(*) as count FROM job_categories WHERE slug = ?");
        $this->db->bind(1, $slug);
        $result = $this->db->single();
        
        return $result['count'] > 0;
    }

    // Count all jobs
    public function countAllJobs() {
        $query = "SELECT COUNT(*) as count FROM job_posts";
        $this->db->query($query);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Count pending jobs
    public function countPendingJobs() {
        $query = "SELECT COUNT(*) as count FROM job_posts WHERE status = 'pending'";
        $this->db->query($query);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Get jobs by status
    public function getJobsByStatus($status) {
        $query = "SELECT j.*, c.company_name, 
                (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                FROM job_posts j 
                JOIN companies c ON j.company_id = c.company_id 
                WHERE j.status = ?
                ORDER BY j.created_at DESC";
        $this->db->query($query);
        $this->db->bind(1, $status);
        return $this->db->resultSet();
    }

    // Get all jobs (for admin)
    public function getAllJobs() {
        $query = "SELECT j.*, c.company_name, 
                (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                FROM job_posts j 
                JOIN companies c ON j.company_id = c.company_id 
                ORDER BY j.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // Update job (admin version with minimal fields)
    public function updateJobAdmin($jobId, $data) {
        $query = "UPDATE job_posts SET 
                title = ?, 
                description = ?, 
                requirements = ?,
                job_type = ?, 
                location = ?, 
                status = ?,
                updated_at = NOW()
                WHERE job_id = ?";
                
        $this->db->query($query);
        $this->db->bind(1, $data['title']);
        $this->db->bind(2, $data['description']);
        $this->db->bind(3, $data['requirements']);
        $this->db->bind(4, $data['job_type']);
        $this->db->bind(5, $data['location']);
        $this->db->bind(6, $data['status']);
        $this->db->bind(7, $jobId);
        
        return $this->db->execute();
    }

    // Get count of jobs by status
    public function getJobCountByStatus($status) {
        $query = "SELECT COUNT(*) as count FROM job_posts WHERE status = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $status);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Get recent jobs with company and application count
    public function getRecentJobs($limit = 5) {
        $query = "SELECT j.*, c.company_name, 
                (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                FROM job_posts j
                JOIN companies c ON j.company_id = c.company_id
                ORDER BY j.created_at DESC
                LIMIT ?";
        
        $this->db->query($query);
        $this->db->bind(1, $limit);
        
        return $this->db->resultSet();
    }

    public function getTotalJobCount() {
        $this->db->query("SELECT COUNT(*) as count FROM job_posts");
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    public function updateJobStatus($id, $status) {
        $this->db->query("UPDATE job_posts SET status = ?, updated_at = NOW() WHERE job_id = ?");
        $this->db->bind(1, $status);
        $this->db->bind(2, $id);
        
        return $this->db->execute();
    }

    public function getJobWithDetails($id) {
        $this->db->query("
            SELECT j.*, 
                   c.company_name, c.company_size, c.industry, c.logo_path,
                   (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
            FROM job_posts j
            JOIN companies c ON j.company_id = c.company_id
            WHERE j.job_id = ?
        ");
        $this->db->bind(1, $id);
        
        $result = $this->db->single();
        
        if ($this->db->rowCount() > 0) {
            return $result;
        }
        
        return false;
    }

    public function getCompanyJobCount($companyId) {
        $this->db->query("SELECT COUNT(*) as count FROM job_posts WHERE company_id = ?");
        $this->db->bind(1, $companyId);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    public function getCategoryById($categoryId) {
        $query = "SELECT * FROM job_categories WHERE category_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $categoryId);
        return $this->db->single();
    }

    // Helper method to get work model display name
    public function getWorkModelName($modelId) {
        $models = [
            'remote' => 'Remote',
            'onsite' => 'On-site',
            'hybrid' => 'Hybrid'
        ];
        
        return $models[$modelId] ?? 'Unknown';
    }

    // Helper method to get experience level display name
    public function getExperienceLevelName($levelId) {
        $levels = [
            'entry' => 'Entry Level',
            'mid' => 'Mid Level',
            'senior' => 'Senior Level',
            'executive' => 'Executive'
        ];
        
        return $levels[$levelId] ?? 'Unknown';
    }

    public function updateAdminStatus($jobId, $status) {
        $query = "UPDATE job_posts SET admin_status = ?, updated_at = NOW() WHERE job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $status);
        $this->db->bind(2, $jobId);
        
        return $this->db->execute();
    }

    public function getJobsByAdminStatus($adminStatus) {
        $query = "SELECT j.*, c.company_name, 
                (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                FROM job_posts j 
                JOIN companies c ON j.company_id = c.company_id 
                WHERE j.admin_status = ?
                ORDER BY j.created_at DESC";
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        return $this->db->resultSet();
    }

    public function updateJobCategory($jobId, $categoryId) {
        $query = "UPDATE job_posts SET category_id = ? WHERE job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $categoryId);
        $this->db->bind(2, $jobId);
        
        return $this->db->execute();
    }

    public function getCompanyJobs($companyId) {
        $query = "SELECT j.*, 
                  COALESCE((SELECT COUNT(*) FROM job_applications WHERE job_id = j.job_id), 0) as application_count
                  FROM job_posts j 
                  WHERE j.company_id = ?
                  ORDER BY j.created_at DESC";
                  
        $this->db->query($query);
        $this->db->bind(1, $companyId);
        
        return $this->db->resultSet();
    }

    public function getApprovedJobs($keyword = '', $location = '', $category = '', $workModel = '', $experienceLevel = '', $jobType = '', $sortBy = 'newest', $limit = 10, $offset = 0) {
        $query = "SELECT j.*, c.company_name, c.logo_path, cat.name as category_name
                  FROM job_posts j
                  JOIN companies c ON j.company_id = c.company_id
                  LEFT JOIN job_categories cat ON j.category_id = cat.category_id
                  WHERE j.status = 'active' AND j.admin_status = 'approved'";
        
        $params = [];
        
        if(!empty($keyword)) {
            $query .= " AND (j.title LIKE ? OR c.company_name LIKE ?)";
            $keyword = "$keyword%";
            $params[] = $keyword;
            $params[] = $keyword;
        }
        
        if(!empty($location)) {
            $query .= " AND j.location LIKE ?";
            $params[] = "%$location%";
        }
        
        if(!empty($category)) {
            $query .= " AND j.category_id = ?";
            $params[] = $category;
        }
        
        if(!empty($workModel)) {
            $query .= " AND j.work_model = ?";
            $params[] = $workModel;
        }
        
        // Add experience level filter
        if(!empty($experienceLevel)) {
            $query .= " AND j.experience_level = ?";
            $params[] = $experienceLevel;
        }
        
        // Add job type filter
        if(!empty($jobType)) {
            $query .= " AND j.job_type = ?";
            $params[] = $jobType;
        }
        
        // Apply sorting
        switch ($sortBy) {
            case 'oldest':
                $query .= " ORDER BY j.created_at ASC";
                break;
            case 'salary_high':
                $query .= " ORDER BY j.salary_max DESC, j.salary_min DESC";
                break;
            case 'salary_low':
                $query .= " ORDER BY j.salary_min ASC, j.salary_max ASC";
                break;
            case 'newest':
            default:
                $query .= " ORDER BY j.created_at DESC";
                break;
        }
        
        // Add pagination
        $query .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $this->db->query($query);
        
        // Bind all parameters
        foreach($params as $i => $param) {
            $this->db->bind($i + 1, $param);
        }
        
        return $this->db->resultSet();
    }
    
    public function countApprovedJobs($keyword = '', $location = '', $category = '', $workModel = '', $experienceLevel = '', $jobType = '') {
        $query = "SELECT COUNT(*) as count 
                  FROM job_posts j
                  JOIN companies c ON j.company_id = c.company_id
                  WHERE j.status = 'active' AND j.admin_status = 'approved'";
        
        $params = [];
        
        if(!empty($keyword)) {
            $query .= " AND (j.title LIKE ? OR c.company_name LIKE ?)";
            $keyword = "$keyword%";
            $params[] = $keyword;
            $params[] = $keyword;
            // Remove the description parameter
        }
        
        if(!empty($location)) {
            $query .= " AND j.location LIKE ?";
            $params[] = "%$location%";
        }
        
        if(!empty($category)) {
            $query .= " AND j.category_id = ?";
            $params[] = $category;
        }
        
        if(!empty($workModel)) {
            $query .= " AND j.work_model = ?";
            $params[] = $workModel;
        }
        
        // Add experience level filter
        if(!empty($experienceLevel)) {
            $query .= " AND j.experience_level = ?";
            $params[] = $experienceLevel;
        }
        
        // Add job type filter
        if(!empty($jobType)) {
            $query .= " AND j.job_type = ?";
            $params[] = $jobType;
        }
        
        $this->db->query($query);
        
        // Bind all parameters
        foreach($params as $i => $param) {
            $this->db->bind($i + 1, $param);
        }
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
    
    /**
     * Get related jobs based on category
     */
    public function getRelatedJobs($jobId, $categoryId, $limit = 3) {
        $query = "SELECT j.*, c.company_name, c.logo_path, cat.name as category_name
                  FROM job_posts j 
                  JOIN companies c ON j.company_id = c.company_id
                  LEFT JOIN job_categories cat ON j.category_id = cat.category_id
                  WHERE j.job_id != ? AND j.category_id = ? 
                  AND j.status = 'active' AND j.admin_status = 'approved'
                  ORDER BY j.created_at DESC
                  LIMIT ?";
              
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        $this->db->bind(2, $categoryId);
        $this->db->bind(3, $limit);
        
        return $this->db->resultSet();
    }

    public function getPaginatedJobsByEmployer($employerId, $limit, $offset) {
        $query = "SELECT j.*, c.company_name, 
                  (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count 
                  FROM job_posts j
                  JOIN companies c ON j.company_id = c.company_id
                  WHERE j.employer_id = ?
                  ORDER BY j.created_at DESC
                  LIMIT ? OFFSET ?";
        
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $this->db->bind(2, $limit);
        $this->db->bind(3, $offset);
        
        return $this->db->resultSet();
    }

    public function getJobsByAdminStatusPaginated($adminStatus, $limit, $offset) {
        $query = "SELECT j.*, c.company_name, c.logo_path, 
                  (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                  FROM job_posts j
                  JOIN companies c ON j.company_id = c.company_id
                  WHERE j.admin_status = ?
                  ORDER BY j.created_at DESC
                  LIMIT ? OFFSET ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        $this->db->bind(2, $limit);
        $this->db->bind(3, $offset);
        
        return $this->db->resultSet();
    }
    
    public function getAllJobsPaginated($limit, $offset) {
        $query = "SELECT j.*, c.company_name, c.logo_path, 
                  (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count
                  FROM job_posts j
                  JOIN companies c ON j.company_id = c.company_id
                  ORDER BY j.created_at DESC
                  LIMIT ? OFFSET ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $limit);
        $this->db->bind(2, $offset);
        
        return $this->db->resultSet();
    }
    
    public function countJobsByAdminStatus($adminStatus) {
        $query = "SELECT COUNT(*) as count FROM job_posts WHERE admin_status = ?";
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
}