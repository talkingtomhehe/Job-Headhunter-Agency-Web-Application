<?php
namespace models;

use core\Model;

class Company extends Model {
    
    // Get company by employer ID
    public function getCompanyByEmployerId($employerId) {
        $query = "SELECT * FROM companies WHERE employer_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        
        return $this->db->single();
    }
    
    // Create new company
    public function createCompany($employerId, $companyName, $logoPath = 'uploads/logo/defaultlogo.jpg') {
        $query = "INSERT INTO companies (employer_id, company_name, logo_path, created_at) 
                  VALUES (?, ?, ?, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $this->db->bind(2, $companyName);
        $this->db->bind(3, $logoPath);
        
        return $this->db->execute();
    }
    
    // Get company logo with fallback to default
    public function getCompanyLogo($company) {
        if (!empty($company['logo_path']) && file_exists(ROOT_PATH . '/public/' . $company['logo_path'])) {
            return $company['logo_path'];
        }
        
        return 'uploads/logo/defaultlogo.jpg';
    }
    
    // Update company
    public function updateCompany($companyId, $data) {
        $query = "UPDATE companies 
                SET company_name = ?, 
                    headquarters_address = ?, 
                    description = ?, 
                    website = ?, 
                    industry = ?, 
                    company_size = ?,
                    logo_path = ?, 
                    updated_at = CURRENT_TIMESTAMP 
                WHERE company_id = ?";
                
        try {
            $this->db->query($query);
            $this->db->bind(1, $data['company_name']);
            $this->db->bind(2, $data['headquarters_address']);
            $this->db->bind(3, $data['description']);
            $this->db->bind(4, $data['website']);
            $this->db->bind(5, $data['industry']);
            $this->db->bind(6, $data['company_size']);
            $this->db->bind(7, $data['logo_path']);
            $this->db->bind(8, $companyId);
            
            return $this->db->execute();
        } catch (\Exception $e) {
            error_log('Company update error: ' . $e->getMessage());
            return false;
        }
    }
    
    // Update company logo
    public function updateLogo($companyId, $logoPath) {
        $query = "UPDATE companies SET logo_path = ?, updated_at = NOW() WHERE company_id = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $logoPath);
        $this->db->bind(2, $companyId);
        
        return $this->db->execute();
    }
    
    // Get all companies
    public function getCompanies($limit = null) {
        $query = "SELECT c.*, COUNT(j.job_id) as job_count 
                  FROM companies c 
                  LEFT JOIN job_posts j ON c.company_id = j.company_id AND j.status = 'active' 
                  GROUP BY c.company_id 
                  ORDER BY job_count DESC";
                  
        if($limit) {
            $query .= " LIMIT ?";
        }
        
        $this->db->query($query);
        
        if($limit) {
            $this->db->bind(1, $limit);
        }
        
        return $this->db->resultSet();
    }
    
    // Get company by ID
    public function getCompanyById($id) {
        $query = "SELECT * FROM companies WHERE company_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $id);
        
        return $this->db->single();
    }

    // Get all companies
    public function getAllCompanies() {
        $query = "SELECT * FROM companies ORDER BY company_name ASC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getCompanyByUserId($userId) {
        try {
            $query = "SELECT * FROM companies WHERE employer_id = ?";
            $this->db->query($query);
            $this->db->bind(1, $userId);
            
            return $this->db->single();
        } catch (\Exception $e) {
            error_log('Error getting company by user ID: ' . $e->getMessage());
            return false;
        }
    }

    public function getCompanyWithFullDetails($companyId) {
        try {
            $query = "SELECT * FROM companies WHERE company_id = ?";
            $this->db->query($query);
            $this->db->bind(1, $companyId);
            
            return $this->db->single();
        } catch (\Exception $e) {
            error_log('Error getting company details: ' . $e->getMessage());
            return false;
        }
    }

    public function getTopCompanies($limit = 5) {
        $query = "SELECT c.*, 
                  (SELECT COUNT(*) FROM job_posts j WHERE j.company_id = c.company_id AND j.status = 'active' AND j.admin_status = 'approved') as job_count
                  FROM companies c
                  WHERE (SELECT COUNT(*) FROM job_posts j WHERE j.company_id = c.company_id AND j.status = 'active' AND j.admin_status = 'approved') > 0
                  ORDER BY job_count DESC
                  LIMIT ?";
        
        $this->db->query($query);
        $this->db->bind(1, $limit);
        
        return $this->db->resultSet();
    }
}