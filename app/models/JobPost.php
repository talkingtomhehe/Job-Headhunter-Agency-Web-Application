<?php
namespace models;

use core\Model;

class JobPost extends Model {
    
    // Get all jobs
    public function getJobs($limit = null) {
        $query = "SELECT j.*, c.company_name, c.logo_path 
                  FROM job_posts j 
                  JOIN companies c ON j.company_id = c.company_id 
                  WHERE j.status = 'active' 
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
                  (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.job_id) as application_count 
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
        $query = "INSERT INTO job_posts (company_id, employer_id, title, description, 
                  requirements, job_type, location, salary_min, salary_max, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $data['company_id']);
        $this->db->bind(2, $data['employer_id']);
        $this->db->bind(3, $data['title']);
        $this->db->bind(4, $data['description']);
        $this->db->bind(5, $data['requirements']);
        $this->db->bind(6, $data['job_type']);
        $this->db->bind(7, $data['location']);
        $this->db->bind(8, $data['salary_min']);
        $this->db->bind(9, $data['salary_max']);
        $this->db->bind(10, $data['status']);
        
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
        $this->db->bind(6, $data['work_model'] ?? null);
        $this->db->bind(7, $data['experience_level'] ?? null);
        $this->db->bind(8, $data['location']);
        $this->db->bind(9, $data['salary_min']);
        $this->db->bind(10, $data['salary_max']);
        $this->db->bind(11, $data['hide_salary'] ?? 0);
        $this->db->bind(12, $data['pdf_path']);
        $this->db->bind(13, $data['status']);
        $this->db->bind(14, $data['application_deadline'] ?? null);
        $this->db->bind(15, $jobId);
        
        return $this->db->execute();
    }

    public function deleteJobCategories($jobId) {
        $query = "DELETE FROM job_post_categories WHERE job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        
        return $this->db->execute();
    }
    
    // Delete job post
    public function deleteJob($jobId) {
        $query = "DELETE FROM job_posts WHERE job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        
        return $this->db->execute();
    }

    public function addJobCategory($jobId, $categoryId) {
        $query = "INSERT INTO job_post_categories (job_id, category_id) VALUES (?, ?)";
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        $this->db->bind(2, $categoryId);
        
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
                  WHERE j.status = 'active'";
                  
        $params = [];
        
        if(!empty($keyword)) {
            $query .= " AND (j.title LIKE ? OR j.description LIKE ? OR c.company_name LIKE ?)";
            $keyword = "%$keyword%";
            $params[] = $keyword;
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
        $result = [];
        
        // Get draft jobs (assuming 'pending' status is equivalent to 'draft')
        $query = "SELECT COUNT(*) as count FROM job_posts 
                  WHERE employer_id = ? AND status = 'pending'";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $draftResult = $this->db->single();
        $result['draft'] = $draftResult['count'] ?? 0;
        
        // Get expired/closed jobs
        $query = "SELECT COUNT(*) as count FROM job_posts 
                  WHERE employer_id = ? AND status = 'closed'";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $expiredResult = $this->db->single();
        $result['expired'] = $expiredResult['count'] ?? 0;
        
        // Get filled jobs (for now, we'll use the same count as expired)
        // Since there's no 'filled' status in the schema
        $result['filled'] = $expiredResult['count'] ?? 0;
        
        return $result;
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
        $query = "SELECT * FROM work_models ORDER BY name";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // Get all experience levels
    public function getExperienceLevels() {
        $query = "SELECT * FROM experience_levels ORDER BY id";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // Get all categories
    public function getCategories() {
        $query = "SELECT * FROM job_categories ORDER BY name";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getJobCategories($jobId) {
        $query = "SELECT c.* FROM job_post_categories jpc 
                  JOIN job_categories c ON jpc.category_id = c.category_id 
                  WHERE jpc.job_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        return $this->db->resultSet();
    }

    public function createCategory($categoryName) {
        $query = "INSERT INTO job_categories (name) VALUES (?)";
        $this->db->query($query);
        $this->db->bind(1, $categoryName);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
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
}