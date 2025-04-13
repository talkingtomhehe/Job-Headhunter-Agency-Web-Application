<?php
namespace models;

use core\Model;

class JobSeeker extends Model {
    
    // Create job seeker record
    public function createJobSeeker($userId) {
        $query = "INSERT INTO job_seekers (seeker_id, created_at)
                  VALUES (?, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $userId);
        
        return $this->db->execute();
    }
    
    // Get job seeker profile
    public function getSeekerProfile($seekerId) {
        $query = "SELECT s.*, u.full_name, u.email, u.phone
                  FROM job_seekers s
                  JOIN users u ON s.seeker_id = u.user_id
                  WHERE s.seeker_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $seekerId);
        
        return $this->db->single();
    }
    
    // Update job seeker profile
    public function updateProfile($seekerId, $data) {
        $query = "UPDATE job_seekers
                  SET headline = ?, summary = ?, experience_years = ?,
                  skills = ?, education = ?, updated_at = NOW()
                  WHERE seeker_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $data['headline'] ?? null);
        $this->db->bind(2, $data['summary'] ?? null);
        $this->db->bind(3, $data['experience_years'] ?? null);
        $this->db->bind(4, $data['skills'] ?? null);
        $this->db->bind(5, $data['education'] ?? null);
        $this->db->bind(6, $seekerId);
        
        return $this->db->execute();
    }
    
    // Update resume
    public function updateResume($seekerId, $resumePath) {
        $query = "UPDATE job_seekers
                  SET resume_path = ?, updated_at = NOW()
                  WHERE seeker_id = ?";
                  
        $this->db->query($query);
        $this->db->bind(1, $resumePath);
        $this->db->bind(2, $seekerId);
        
        return $this->db->execute();
    }
}