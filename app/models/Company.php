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
        $query = "UPDATE companies SET 
                  company_name = ?, 
                  website = ?, 
                  industry = ?, 
                  description = ?, 
                  address = ?, 
                  city = ?, 
                  state = ?, 
                  zip = ?, 
                  country = ?, 
                  updated_at = NOW() 
                  WHERE company_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $data['company_name']);
        $this->db->bind(2, $data['website'] ?? null);
        $this->db->bind(3, $data['industry'] ?? null);
        $this->db->bind(4, $data['description'] ?? null);
        $this->db->bind(5, $data['address'] ?? null);
        $this->db->bind(6, $data['city'] ?? null);
        $this->db->bind(7, $data['state'] ?? null);
        $this->db->bind(8, $data['zip'] ?? null);
        $this->db->bind(9, $data['country'] ?? null);
        $this->db->bind(10, $companyId);
        
        return $this->db->execute();
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