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

    // Count all users
    public function countAllUsers() {
        $query = "SELECT COUNT(*) as count FROM users";
        $this->db->query($query);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Get recent users
    public function getRecentUsers($limit = 5) {
        $query = "SELECT * FROM users ORDER BY created_at DESC LIMIT ?";
        $this->db->query($query);
        $this->db->bind(1, $limit);
        return $this->db->resultSet();
    }

    // Get users by role
    public function getUsersByRole($role) {
        $query = "SELECT * FROM users WHERE role = ? ORDER BY created_at DESC";
        $this->db->query($query);
        $this->db->bind(1, $role);
        return $this->db->resultSet();
    }

    // Get all users
    public function getAllUsers() {
        $query = "SELECT * FROM users ORDER BY created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // Update user
    public function updateUser($userId, $data) {
        $query = "UPDATE users SET 
                full_name = ?, 
                email = ?,
                role = ?,
                status = ?,
                updated_at = NOW()
                WHERE user_id = ?";
                
        $this->db->query($query);
        $this->db->bind(1, $data['full_name']);
        $this->db->bind(2, $data['email']);
        $this->db->bind(3, $data['role']);
        $this->db->bind(4, $data['status']);
        $this->db->bind(5, $userId);
        
        return $this->db->execute();
    }

    // Delete user
    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE user_id = ?";
        $this->db->query($query);
        $this->db->bind(1, $userId);
        return $this->db->execute();
    }

    // Get count of users by role
    public function getUserCountByRole($role) {
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $role);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    public function getUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = ?");
        $this->db->bind(1, $email);
        
        $row = $this->db->single();
        
        if ($this->db->rowCount() > 0) {
            return $row;
        }
        
        return false;
    }

    public function getTotalUserCount() {
        $this->db->query("SELECT COUNT(*) as count FROM users");
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
}