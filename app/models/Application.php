<?php
namespace models;

use core\Model;

class Application extends Model {
    
    // Get application by ID
    public function getApplicationById($id) {
        $query = "SELECT a.*, j.title as job_title, j.created_at as job_created_at,
                  u.full_name, u.email, u.phone, u.avatar_path
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
        $query = "SELECT a.*, u.full_name, u.email, u.phone, u.avatar_path
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
        $query = "SELECT a.*, j.title as job_title, j.company_id, j.location, j.job_type,
                  u.full_name, u.email, u.phone, u.avatar_path
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
                  WHERE j.employer_id = ? AND a.admin_status = 'approved'";
                  
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
    public function updateStatus($applicationId, $status) {
        $validStatuses = ['pending', 'reviewing', 'shortlisted', 'hired', 'rejected'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        
        $query = "UPDATE job_applications SET status = ?, updated_at = NOW() WHERE application_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $status);
        $this->db->bind(2, $applicationId);
        
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
                  WHERE j.employer_id = ? AND a.admin_status = 'approved'
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

    public function updateNotes($applicationId, $notes) {
        $query = "UPDATE job_applications
                  SET employer_notes = ?, updated_at = NOW()
                  WHERE application_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $notes);
        $this->db->bind(2, $applicationId);
        
        return $this->db->execute();
    }
    
    public function scheduleInterview($applicationId, $date, $location) {
        $query = "UPDATE job_applications
                  SET interview_date = ?, interview_location = ?, status = 'shortlisted', updated_at = NOW()
                  WHERE application_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $date);
        $this->db->bind(2, $location);
        $this->db->bind(3, $applicationId);
        
        return $this->db->execute();
    }
    
    public function getApplicationStats($employerId) {
        $stats = [];
        
        $query = "SELECT a.status, COUNT(*) as count FROM job_applications a 
                  JOIN job_posts j ON a.job_id = j.job_id 
                  WHERE j.employer_id = ? 
                  GROUP BY a.status"; 
        
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $statusStats = $this->db->resultSet();
        
        foreach ($statusStats as $stat) {
            $stats['status'][$stat['status']] = $stat['count'];
        }
        
        // Applications by job
        $query = "SELECT j.title, COUNT(*) as count FROM job_applications a 
                  JOIN job_posts j ON a.job_id = j.job_id 
                  WHERE j.employer_id = ? 
                  GROUP BY j.job_id";
        
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $jobStats = $this->db->resultSet();
        
        foreach ($jobStats as $stat) {
            $stats['jobs'][$stat['title']] = $stat['count'];
        }
        
        return $stats;
    }
    
    // Get all applications with detailed information
    public function getDetailedApplicationsByEmployer($employerId, $filters = []) {
        $query = "SELECT a.*, j.title as job_title, j.location, j.job_type,
                    u.full_name, u.email, u.phone, 
                    c.company_name, c.logo_path, a.status as status
                    FROM job_applications a
                    JOIN job_posts j ON a.job_id = j.job_id
                    JOIN users u ON a.seeker_id = u.user_id
                    JOIN companies c ON j.company_id = c.company_id
                    WHERE j.employer_id = ?";
        
        // Add filters if provided
        if (!empty($filters['status'])) {
            $query .= " AND a.status = ?";
        }
        
        if (!empty($filters['job_id'])) {
            $query .= " AND j.job_id = ?";
        }
        
        // Add search term if provided
        if (!empty($filters['search'])) {
            $query .= " AND (u.full_name LIKE ? OR j.title LIKE ?)";
        }
        
        $query .= " ORDER BY a.created_at DESC";
        
        $this->db->query($query);
        $paramIndex = 1;
        $this->db->bind($paramIndex++, $employerId);
        
        if (!empty($filters['status'])) {
            $this->db->bind($paramIndex++, $filters['status']);
        }
        
        if (!empty($filters['job_id'])) {
            $this->db->bind($paramIndex++, $filters['job_id']);
        }
        
        if (!empty($filters['search'])) {
            $searchTerm = "%{$filters['search']}%";
            $this->db->bind($paramIndex++, $searchTerm);
            $this->db->bind($paramIndex++, $searchTerm);
        }
        
        return $this->db->resultSet();
    }

    // Count all applications
    public function countAllApplications() {
        $query = "SELECT COUNT(*) as count FROM job_applications";
        $this->db->query($query);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Get all applications (for admin)
    public function getAllApplications() {
        $query = "SELECT a.*, j.title as job_title, u.full_name, c.company_name
                FROM job_applications a
                JOIN job_posts j ON a.job_id = j.job_id
                JOIN users u ON a.seeker_id = u.user_id
                JOIN companies c ON j.company_id = c.company_id
                ORDER BY a.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getRecentApplications($limit = 5) {
        $query = "SELECT a.*, j.title as job_title, u.full_name 
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  ORDER BY a.created_at DESC
                  LIMIT ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $limit);
        
        return $this->db->resultSet();
    }

    public function getTotalApplicationCount() {
        $this->db->query("SELECT COUNT(*) as count FROM job_applications");
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    public function getApplicationsBySeekerId($seekerId) {
        $this->db->query("
            SELECT a.*, 
                   j.title as job_title,
                   j.location,
                   c.company_name,
                   c.logo_path
            FROM job_applications a
            JOIN job_posts j ON a.job_id = j.job_id
            JOIN companies c ON j.company_id = c.company_id
            WHERE a.seeker_id = ?
            ORDER BY a.created_at DESC
        ");
        $this->db->bind(1, $seekerId);
        
        return $this->db->resultSet();
    }

    public function getApplicationsByStatus($status) {
        $query = "SELECT a.*, j.title as job_title, j.created_at as job_created_at,
                  u.full_name, u.email, u.phone, c.company_name
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  LEFT JOIN companies c ON j.company_id = c.company_id
                  WHERE a.status = ?
                  ORDER BY a.created_at DESC";
        
        $this->db->query($query);
        $this->db->bind(1, $status);
        
        return $this->db->resultSet();
    }

    public function updateAdminStatus($applicationId, $status) {
        $query = "UPDATE job_applications SET admin_status = ?, updated_at = NOW() WHERE application_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $status);
        $this->db->bind(2, $applicationId);
        
        return $this->db->execute();
    }

    public function getApplicationsByAdminStatus($adminStatus) {
        $query = "SELECT a.*, j.title as job_title, j.created_at as job_created_at,
                  u.full_name, u.email, u.phone, c.company_name
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  JOIN users u ON a.seeker_id = u.user_id
                  LEFT JOIN companies c ON j.company_id = c.company_id
                  WHERE a.admin_status = ?
                  ORDER BY a.created_at DESC";
        
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        
        return $this->db->resultSet();
    }
}