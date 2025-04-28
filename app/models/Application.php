<?php
namespace models;

use core\Model;

class Application extends Model {
    public function getApplicationById($id) {
        $query = "SELECT a.*, 
                j.title as job_title, j.created_at as job_created_at,
                u.full_name as user_full_name, u.email as user_email, 
                u.phone as user_phone, u.avatar_path as user_avatar_path,
                a.applicant_email, a.applicant_phone, a.applicant_full_name
                FROM job_applications a
                JOIN job_posts j ON a.job_id = j.job_id
                LEFT JOIN users u ON a.seeker_id = u.user_id
                WHERE a.application_id = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $id);
        
        $application = $this->db->single();
        
        // If this is a guest application (no seeker_id), use the application table data
        if ($application && empty($application['seeker_id'])) {
            $application['full_name'] = $application['applicant_full_name'];
            $application['email'] = $application['applicant_email'];
            $application['phone'] = $application['applicant_phone'];
            $application['avatar_path'] = 'assets/images/defaultavatar.jpg';
        } else if ($application) {
            // For logged-in users, use the user table data
            $application['full_name'] = $application['user_full_name'];
            $application['email'] = $application['user_email'];
            $application['phone'] = $application['user_phone'];
            $application['avatar_path'] = $application['user_avatar_path'];
        }
        
        return $application;
    }

    public function getApplicationsByJob($jobId) {
        $query = "SELECT a.*, 
                u.full_name as user_full_name, u.email as user_email, 
                u.phone as user_phone, u.avatar_path as user_avatar_path,
                a.applicant_email, a.applicant_phone, a.applicant_full_name
                FROM job_applications a
                LEFT JOIN users u ON a.seeker_id = u.user_id
                WHERE a.job_id = ? AND a.admin_status = 'approved'
                ORDER BY a.created_at DESC";
        
        $this->db->query($query);
        $this->db->bind(1, $jobId);
        
        $applications = $this->db->resultSet();
        
        // Process each application to use correct data source
        foreach ($applications as &$application) {
            if (empty($application['seeker_id'])) {
                $application['full_name'] = $application['applicant_full_name'];
                $application['email'] = $application['applicant_email'];
                $application['phone'] = $application['applicant_phone'];
                $application['avatar_path'] = 'assets/images/defaultavatar.jpg';
            } else {
                $application['full_name'] = $application['user_full_name'];
                $application['email'] = $application['user_email'];
                $application['phone'] = $application['user_phone'];
                $application['avatar_path'] = $application['user_avatar_path'];
            }
        }
        
        return $applications;
    }

    public function getApplicationsByEmployer($employerId) {
        $query = "SELECT a.*, j.title as job_title, j.company_id, j.location, j.job_type,
                u.full_name as user_full_name, u.email as user_email, 
                u.phone as user_phone, u.avatar_path as user_avatar_path,
                a.applicant_email, a.applicant_phone, a.applicant_full_name
                FROM job_applications a
                JOIN job_posts j ON a.job_id = j.job_id
                LEFT JOIN users u ON a.seeker_id = u.user_id
                WHERE j.employer_id = ? AND a.admin_status = 'approved'
                ORDER BY a.created_at DESC";
        
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        
        $applications = $this->db->resultSet();
        
        // Process each application to use correct data source
        foreach ($applications as &$application) {
            if (empty($application['seeker_id'])) {
                $application['full_name'] = $application['applicant_full_name'];
                $application['email'] = $application['applicant_email'];
                $application['phone'] = $application['applicant_phone'];
                $application['avatar_path'] = 'assets/images/defaultavatar.jpg';
            } else {
                $application['full_name'] = $application['user_full_name'];
                $application['email'] = $application['user_email'];
                $application['phone'] = $application['user_phone'];
                $application['avatar_path'] = $application['user_avatar_path'];
            }
        }
        
        return $applications;
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
                  LEFT JOIN users u ON a.seeker_id = u.user_id
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
                    COALESCE(u.full_name, 'Guest Applicant') as full_name, 
                    COALESCE(u.email, a.applicant_email) as email, 
                    COALESCE(u.phone, a.applicant_phone) as phone, 
                    u.avatar_path, 
                    c.company_name, c.logo_path, a.status as status
                    FROM job_applications a
                    JOIN job_posts j ON a.job_id = j.job_id
                    LEFT JOIN users u ON a.seeker_id = u.user_id
                    JOIN companies c ON j.company_id = c.company_id
                    WHERE j.employer_id = ? AND a.admin_status = 'approved'";
        
        // Add other filters if provided
        if (!empty($filters['status'])) {
            $query .= " AND a.status = ?";
        }
        
        if (!empty($filters['job_id'])) {
            $query .= " AND j.job_id = ?";
        }
        
        // Add search term if provided
        if (!empty($filters['search'])) {
            $query .= " AND (COALESCE(u.full_name, 'Guest Applicant') LIKE ? OR j.title LIKE ?)";
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
                LEFT JOIN users u ON a.seeker_id = u.user_id
                JOIN companies c ON j.company_id = c.company_id
                ORDER BY a.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getRecentApplications($limit = 5) {
        $query = "SELECT a.*, j.title as job_title, u.full_name 
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  LEFT JOIN users u ON a.seeker_id = u.user_id
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

    public function createApplication($data) {
        $query = "INSERT INTO job_applications (job_id, seeker_id, applicant_full_name, 
                applicant_email, applicant_phone, resume_path, cover_letter, 
                status, admin_status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
        
        $this->db->query($query);
        $this->db->bind(1, $data['job_id']);
        $this->db->bind(2, $data['seeker_id'] ?? null);
        $this->db->bind(3, $data['full_name']);
        $this->db->bind(4, $data['email']);
        $this->db->bind(5, $data['phone']);
        $this->db->bind(6, $data['resume_path']);
        $this->db->bind(7, $data['cover_letter'] ?? null);
        $this->db->bind(8, $data['status'] ?? 'pending');
        
        return $this->db->execute();
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getApplicationsByEmployerPaginated($employerId, $filters = [], $limit, $offset) {
        $whereClause = "WHERE j.employer_id = ?";
        $params = [$employerId];
        
        $whereClause .= " AND a.admin_status = 'approved'";
        
        // Apply other filters
        if (!empty($filters['status'])) {
            $whereClause .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['job_id'])) {
            $whereClause .= " AND a.job_id = ?";
            $params[] = $filters['job_id'];
        }
        
        if (!empty($filters['search'])) {
            $search = "%" . $filters['search'] . "%";
            $whereClause .= " AND (u.full_name LIKE ? OR j.title LIKE ? OR a.applicant_full_name LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $query = "SELECT a.*, j.title as job_title, j.company_id, j.location, j.job_type,
                u.full_name as user_full_name, u.email as user_email, u.phone as user_phone, u.avatar_path,
                c.company_name, c.logo_path,
                /* Use the correct fields for guest applicants */
                COALESCE(a.applicant_full_name, u.full_name) as full_name,
                COALESCE(a.applicant_email, u.email) as email,
                COALESCE(a.applicant_phone, u.phone) as phone
                FROM job_applications a
                JOIN job_posts j ON a.job_id = j.job_id
                LEFT JOIN users u ON a.seeker_id = u.user_id
                LEFT JOIN companies c ON j.company_id = c.company_id
                $whereClause
                ORDER BY a.created_at DESC
                LIMIT ? OFFSET ?";
        
        $this->db->query($query);
        
        foreach ($params as $key => $value) {
            $this->db->bind($key + 1, $value);
        }
        
        $this->db->bind(count($params) + 1, $limit);
        $this->db->bind(count($params) + 2, $offset);
        
        return $this->db->resultSet();
    }

    public function countApplicationsByEmployerWithFilters($employerId, $filters = []) {
        $whereClause = "WHERE j.employer_id = ?";
        $params = [$employerId];
        
        $whereClause .= " AND a.admin_status = 'approved'";
        
        // Apply other filters
        if (!empty($filters['status'])) {
            $whereClause .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['job_id'])) {
            $whereClause .= " AND a.job_id = ?";
            $params[] = $filters['job_id'];
        }
        
        if (!empty($filters['search'])) {
            $search = "%" . $filters['search'] . "%";
            $whereClause .= " AND (u.full_name LIKE ? OR j.title LIKE ?)";
            $params[] = $search;
            $params[] = $search;
        }
        
        $query = "SELECT COUNT(*) as count
                FROM job_applications a
                JOIN job_posts j ON a.job_id = j.job_id
                LEFT JOIN users u ON a.seeker_id = u.user_id
                $whereClause";
        
        $this->db->query($query);
        
        foreach ($params as $key => $value) {
            $this->db->bind($key + 1, $value);
        }
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    public function getApplicationsByAdminStatusPaginated($adminStatus, $limit, $offset) {
        $query = "SELECT a.*, j.title as job_title, j.company_id,
                  u.full_name, u.email, u.phone, u.avatar_path,
                  c.company_name, c.logo_path
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  LEFT JOIN users u ON a.seeker_id = u.user_id
                  LEFT JOIN companies c ON j.company_id = c.company_id
                  WHERE a.admin_status = ?
                  ORDER BY a.created_at DESC
                  LIMIT ? OFFSET ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        $this->db->bind(2, $limit);
        $this->db->bind(3, $offset);
        
        return $this->db->resultSet();
    }
    
    public function getAllApplicationsPaginated($limit, $offset) {
        $query = "SELECT a.*, j.title as job_title, j.company_id,
                  u.full_name, u.email, u.phone, u.avatar_path,
                  c.company_name, c.logo_path
                  FROM job_applications a
                  JOIN job_posts j ON a.job_id = j.job_id
                  LEFT JOIN users u ON a.seeker_id = u.user_id
                  LEFT JOIN companies c ON j.company_id = c.company_id
                  ORDER BY a.created_at DESC
                  LIMIT ? OFFSET ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $limit);
        $this->db->bind(2, $offset);
        
        return $this->db->resultSet();
    }
    
    public function countApplicationsByAdminStatus($adminStatus) {
        $query = "SELECT COUNT(*) as count FROM job_applications WHERE admin_status = ?";
        $this->db->query($query);
        $this->db->bind(1, $adminStatus);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
}