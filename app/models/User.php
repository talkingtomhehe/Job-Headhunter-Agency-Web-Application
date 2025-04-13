<?php
namespace models;

use core\Model;

class User extends Model {
    
    // Find user by email and role
    public function findUserByEmailAndRole($email, $role) {
        $query = "SELECT * FROM users WHERE email = ? AND role = ?";
        $this->db->query($query);
        $this->db->bind(1, $email);
        $this->db->bind(2, $role);
        
        return $this->db->single();
    }
    
    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $this->db->query($query);
        $this->db->bind(1, $email);
        
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
    
    // Register user
    public function register($email, $password, $fullName, $role, $phone) {
        $query = "INSERT INTO users (email, password, full_name, role, phone, active, created_at) 
                  VALUES (?, ?, ?, ?, ?, 1, NOW())";
                  
        $this->db->query($query);
        $this->db->bind(1, $email);
        $this->db->bind(2, $password);
        $this->db->bind(3, $fullName);
        $this->db->bind(4, $role);
        $this->db->bind(5, $phone);
        
        return $this->db->execute();
    }
    
    // Get user by ID
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $id);
        
        return $this->db->single();
    }
    
    // Update user
    public function updateUser($id, $data) {
        $query = "UPDATE users SET full_name = ?, email = ?, phone = ?, updated_at = NOW() WHERE user_id = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $data['full_name']);
        $this->db->bind(2, $data['email']);
        $this->db->bind(3, $data['phone']);
        $this->db->bind(4, $id);
        
        return $this->db->execute();
    }
    
    // Change password
    public function changePassword($id, $password) {
        $query = "UPDATE users SET password = ?, updated_at = NOW() WHERE user_id = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $password);
        $this->db->bind(2, $id);
        
        return $this->db->execute();
    }
    
    // Get last insert ID
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}