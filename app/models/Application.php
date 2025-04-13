<?php
namespace models;

use core\Model;

class Application extends Model {
    
    // Get application by ID
    public function getApplicationById($id) {
        $query = "SELECT a.*, j.title as job_title, u.full_name, u.email, u.phone
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  WHERE a.application_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $id);
        
        return $this->db->single();
    }
    
    // Get applications by job ID
    public function getApplicationsByJob($jobId) {
        $query = "SELECT a.*, u.full_name, u.email
                  FROM job_applications a
                  JOIN users u ON a.seeker_id = u.user_id
                  WHERE a.job_id = ?
                  ORDER BY a.created_at DESC";
                  
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        
        return $this->db->resultSet();
    }
    
    // Get applications by employer
    public function getApplicationsByEmployer($employerId) {
        $query = "SELECT a.*, j.title as job_title, u.full_name
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  WHERE j.employer_id = ?
                  ORDER BY a.created_at DESC";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        
        return $this->db->resultSet();
    }
    
    // Get applications by job seeker
    public function getApplicationsBySeeker($seekerId) {
        $query = "SELECT a.*, j.title as job_title, c.company_name, c.logo_path
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN companies c ON j.company_id = c.company_id
                  WHERE a.seeker_id = ?
                  ORDER BY a.created_at DESC";
                  
        $this->db->query($query);
        $this->db->bind(1, $seekerId);
        
        return $this->db->resultSet();
    }
    
    // Count applications by employer
    public function countApplicationsByEmployer($employerId) {
        $query = "SELECT COUNT(*) as count
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  WHERE j.employer_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
    
    // Apply for job
    public function applyForJob($jobId, $seekerId, $coverLetter, $resumePath) {
        $query = "INSERT INTO job_applications (job_id, seeker_id, cover_letter, resume_path, status, created_at)
                  VALUES (?, ?, ?, ?, 'pending', NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        $this->db->bind(2, $seekerId);
        $this->db->bind(3, $coverLetter);
        $this->db->bind(4, $resumePath);
        
        return $this->db->execute();
    }
    
    // Check if already applied
    public function hasApplied($jobId, $seekerId) {
        $query = "SELECT * FROM job_applications
                  WHERE job_id = ? AND seeker_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        $this->db->bind(2, $seekerId);
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
    
    // Update application status
    public function updateStatus($id, $status) {
        $query = "UPDATE job_applications
                  SET status = ?, updated_at = NOW()
                  WHERE application_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $status);
        $this->db->bind(2, $id);
        
        return $this->db->execute();
    }

    public function getApplicationStatusCountsByEmployer($employerId) {
        $statuses = ['pending', 'reviewing', 'shortlisted', 'hired', 'rejected'];
        $result = [];
        
        foreach ($statuses as $status) {
            $query = "SELECT COUNT(*) as count FROM job_applications a 
                      JOIN job_posts j ON a.job_id = j.job_id 
                      WHERE j.employer_id = ? AND a.status = ?";
            $this->db->query($query);
            $this->db->bind(1, $employerId);
            $this->db->bind(2, $status);
            $statusResult = $this->db->single();
            $result[$status] = $statusResult['count'] ?? 0;
        }
        
        return $result;
    }

    public function getRecentApplicationsByEmployer($employerId, $limit = 5) {
        $query = "SELECT a.*, j.title as job_title, u.full_name as applicant_name
                  FROM job_applications a 
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  WHERE j.employer_id = ?
                  ORDER BY a.created_at DESC
                  LIMIT ?";
        
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $this->db->bind(2, $limit);
        
        return $this->db->resultSet();
    }
    
    public function countTodayApplicationsByEmployer($employerId) {
        $query = "SELECT COUNT(*) as count FROM job_applications a 
                  JOIN job_posts j ON a.job_id = j.job_id
                  WHERE j.employer_id = ? AND DATE(a.created_at) = CURDATE()";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
}