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
    public function createCompany($employerId, $companyName, $logoPath = null) {
        $query = "INSERT INTO companies (employer_id, company_name, logo_path, created_at) 
                  VALUES (?, ?, ?, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $employerId);
        $this->db->bind(2, $companyName);
        $this->db->bind(3, $logoPath);
        
        return $this->db->execute();
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
}