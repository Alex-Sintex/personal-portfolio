<?php

namespace App\models;

use App\Libraries\Base;

class NotificationModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getUserNotifications($userId, $limit = 10)
    {
        $this->db->query("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit);
        return $this->db->records();
    }

    public function getAllNotifications($userId)
    {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->records();
    }

    public function getUnreadNotifications($userId)
    {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->records();
    }

    public function getGlobalNotifications($limit = 10)
    {
        $this->db->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->records();
    }

    public function markAllAsRead($userId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function countUnread($userId)
    {
        $this->db->query("SELECT COUNT(*) AS total FROM notifications WHERE user_id = :user_id AND is_read = 0");
        $this->db->bind(':user_id', $userId);
        return $this->db->record()->total ?? 0;
    }
}
