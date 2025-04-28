<?php
namespace models;

use core\Model;

class User extends Model {
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
        $query = "INSERT INTO users (email, password, full_name, role, phone, avatar_path, active, created_at) 
                  VALUES (?, ?, ?, ?, ?, 'assets/images/defaultavatar.jpg', 1, NOW())";
                  
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
                avatar_path = ?,
                updated_at = NOW()
                WHERE user_id = ?";
                
        $this->db->query($query);
        $this->db->bind(1, $data['full_name']);
        $this->db->bind(2, $data['email']);
        $this->db->bind(3, $data['role']);
        $this->db->bind(4, $data['status']);
        $this->db->bind(5, $data['avatar_path'] ?? 'assets/images/defaultavatar.jpg');
        $this->db->bind(6, $userId);
        
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

    public function getUserAvatar($user) {
        if (!empty($user['avatar_path']) && file_exists(ROOT_PATH . '/public/' . $user['avatar_path'])) {
            return $user['avatar_path'];
        }
        
        return 'assets/images/defaultavatar.jpg';
    }

    public function updateAvatar($userId, $avatarPath) {
        $query = "UPDATE users SET avatar_path = ?, updated_at = NOW() WHERE user_id = ?";
        
        $this->db->query($query);
        $this->db->bind(1, $avatarPath);
        $this->db->bind(2, $userId);
        
        return $this->db->execute();
    }

    // Find user by email and role
    public function findUserByEmailAndRole($email, $role) {
        // For employer role, we need to check for 'company_admin'
        if ($role === 'employer') {
            $role = 'company_admin';
        }
        
        $query = "SELECT * FROM users WHERE email = ? AND role = ?";
        $this->db->query($query);
        $this->db->bind(1, $email);
        $this->db->bind(2, $role);
        
        return $this->db->single();
    }

    // Register user with verification
    public function registerWithVerification($email, $password, $fullName, $role, $phone) {
        // Generate verification token
        $verificationToken = bin2hex(random_bytes(32));
        $tokenExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        $query = "INSERT INTO users (email, password, full_name, role, phone, 
                avatar_path, active, verification_token, token_expiry, created_at) 
                VALUES (?, ?, ?, ?, ?, 'assets/images/defaultavatar.jpg', 0, ?, ?, NOW())";
                
        $this->db->query($query);
        $this->db->bind(1, $email);
        $this->db->bind(2, $password);
        $this->db->bind(3, $fullName);
        $this->db->bind(4, $role);
        $this->db->bind(5, $phone);
        $this->db->bind(6, $verificationToken);
        $this->db->bind(7, $tokenExpiry);
        
        if ($this->db->execute()) {
            return [
                'success' => true,
                'user_id' => $this->db->lastInsertId(),
                'verification_token' => $verificationToken
            ];
        } else {
            return ['success' => false];
        }
    }

    // Verify user with token
    public function verifyUser($token) {
        // First, find the user with this token
        $this->db->query("SELECT * FROM users WHERE verification_token = ? AND token_expiry > NOW()");
        $this->db->bind(1, $token);
        $user = $this->db->single();
        
        if ($user) {
            // Update user to be active and clear verification token
            $this->db->query("UPDATE users SET active = 1, verification_token = NULL, 
                            token_expiry = NULL, email_verified_at = NOW() 
                            WHERE user_id = ?");
            $this->db->bind(1, $user['user_id']);
            
            if ($this->db->execute()) {
                return $user;
            }
        }
        
        return false;
    }

    // Check if user is verified
    public function isVerified($userId) {
        $this->db->query("SELECT active FROM users WHERE user_id = ?");
        $this->db->bind(1, $userId);
        $result = $this->db->single();
        
        return ($result && $result['active'] == 1);
    }

    // Find an unverified user by email
    public function findUnverifiedUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = ? AND active = 0");
        $this->db->bind(1, $email);
        return $this->db->single();
    }

    // Update verification token
    public function updateVerificationToken($userId, $token, $expiry) {
        $this->db->query("UPDATE users SET verification_token = ?, token_expiry = ? WHERE user_id = ?");
        $this->db->bind(1, $token);
        $this->db->bind(2, $expiry);
        $this->db->bind(3, $userId);
        return $this->db->execute();
    }

    public function getUsersByRolePaginated($role, $limit, $offset) {
        $query = "SELECT * FROM users WHERE role = ? 
                  ORDER BY created_at DESC LIMIT ? OFFSET ?";
        
        $this->db->query($query);
        $this->db->bind(1, $role);
        $this->db->bind(2, $limit);
        $this->db->bind(3, $offset);
        
        return $this->db->resultSet();
    }
    
    public function getAllUsersPaginated($limit, $offset) {
        $query = "SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $this->db->query($query);
        $this->db->bind(1, $limit);
        $this->db->bind(2, $offset);
        
        return $this->db->resultSet();
    }
    
    public function countUsersByRole($role) {
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
        $this->db->query($query);
        $this->db->bind(1, $role);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
}