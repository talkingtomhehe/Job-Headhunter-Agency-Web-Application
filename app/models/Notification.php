<?php
namespace models;

use core\Model;

class Notification extends Model {
    public function createNotification($data) {
        $this->db->query("INSERT INTO notifications (user_id, title, message, type, reference_id, is_read, created_at)
                          VALUES (?, ?, ?, ?, ?, 0, NOW())");
        
        $this->db->bind(1, $data['user_id']);
        $this->db->bind(2, $data['title']);
        $this->db->bind(3, $data['message']);
        $this->db->bind(4, $data['type']);
        $this->db->bind(5, $data['reference_id'] ?? null);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    public function getNotificationsByUser($userId, $limit = null) {
        $query = "SELECT * FROM notifications 
                  WHERE user_id = ? 
                  ORDER BY created_at DESC";
                  
        if ($limit) {
            $query .= " LIMIT ?";
        }
        
        $this->db->query($query);
        $this->db->bind(1, $userId);
        
        if ($limit) {
            $this->db->bind(2, $limit);
        }
        
        return $this->db->resultSet();
    }
    
    public function getUnreadCount($userId) {
        $this->db->query("SELECT COUNT(*) as count FROM notifications 
                         WHERE user_id = ? AND is_read = 0");
        $this->db->bind(1, $userId);
        
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }
    
    public function markAsRead($notificationId) {
        $this->db->query("UPDATE notifications SET is_read = 1 WHERE notification_id = ?");
        $this->db->bind(1, $notificationId);
        
        return $this->db->execute();
    }
    
    public function markAllAsRead($userId) {
        $this->db->query("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $this->db->bind(1, $userId);
        
        return $this->db->execute();
    }
    
    public function deleteNotification($notificationId) {
        $this->db->query("DELETE FROM notifications WHERE notification_id = ?");
        $this->db->bind(1, $notificationId);
        
        return $this->db->execute();
    }
    
    public function getNotificationById($notificationId) {
        $this->db->query("SELECT * FROM notifications WHERE notification_id = ?");
        $this->db->bind(1, $notificationId);
        
        return $this->db->single();
    }
    
    public function getRecentNotifications($limit = 10) {
        $this->db->query("SELECT n.*, u.full_name 
                          FROM notifications n
                          JOIN users u ON n.user_id = u.user_id
                          ORDER BY n.created_at DESC
                          LIMIT ?");
        $this->db->bind(1, $limit);
        
        return $this->db->resultSet();
    }
}