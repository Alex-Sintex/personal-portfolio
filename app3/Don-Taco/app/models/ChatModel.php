<?php

namespace App\models;

use App\Libraries\Base;

class ChatModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getUsers($currentUserId)
    {
        $this->db->query("SELECT id, username, status FROM users WHERE id != :id");
        $this->db->bind(':id', $currentUserId);
        return $this->db->records();
    }

    public function getUsersByStatus($status, $currentUserId)
    {
        $sql = "SELECT id, username, img, status 
            FROM users 
            WHERE status = :status AND id != :id";
        $this->db->query($sql);
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $currentUserId);
        return $this->db->records();
    }

    public function getMessages($user1, $user2, $since = null)
    {
        $sql = "
        SELECT m.*, 
            u1.username AS outgoing_username, 
            u2.username AS incoming_username,
            u1.img AS outgoing_avatar,
            u2.img AS incoming_avatar,
            u2.status AS incoming_status
        FROM messages m
        JOIN users u1 ON m.outgoing_msg_id = u1.id
        JOIN users u2 ON m.incoming_msg_id = u2.id
        WHERE ((m.incoming_msg_id = :user1 AND m.outgoing_msg_id = :user2)
            OR (m.incoming_msg_id = :user2 AND m.outgoing_msg_id = :user1))
    ";

        if ($since) {
            $sql .= " AND m.created_at > :since";
        }

        $sql .= " ORDER BY m.created_at ASC";

        $this->db->query($sql);
        $this->db->bind(':user1', $user1);
        $this->db->bind(':user2', $user2);

        if ($since) {
            $this->db->bind(':since', $since);
        }

        return $this->db->records();
    }

    public function sendMessage($from, $to, $message)
    {
        $data = [
            'incoming_msg_id' => $to,
            'outgoing_msg_id' => $from,
            'msg'             => $message,
        ];
        return $this->db->insert('messages', $data);
    }

    public function deleteMessage($msgId, $userId)
    {
        $where = "msg_id = :msg_id AND outgoing_msg_id = :user_id";
        $whereData = [
            'msg_id'  => $msgId,
            'user_id' => $userId
        ];

        $result = $this->db->delete('messages', $where, $whereData);

        // ✅ Only return true if a row was actually deleted
        return $result && $this->db->rowCount() > 0;
    }

    public function editMessage($msgId, $userId, $newMessage)
    {
        $data = [
            'msg' => $newMessage,
            'edited' => 1
        ];

        $where = "msg_id = :msg_id AND outgoing_msg_id = :user_id";
        $whereData = [
            'msg_id' => $msgId,
            'user_id' => $userId
        ];

        $result = $this->db->update('messages', $data, $where, $whereData);

        if (!$result) {
            return false; // Query failed
        }

        // Check if any row was actually updated
        return $this->db->rowCount() > 0;
    }

    public function getUnreadMessagesGrouped($currentUserId)
    {
        $sql = "
        SELECT 
            m.outgoing_msg_id AS sender_id,
            u.username AS sender_username,
            u.img AS sender_avatar,
            COUNT(*) AS unread_count,
            MAX(m.created_at) AS last_message_time,
            (
                SELECT msg FROM messages 
                WHERE incoming_msg_id = :user_id 
                  AND outgoing_msg_id = m.outgoing_msg_id 
                  AND is_seen = 0 
                ORDER BY created_at DESC 
                LIMIT 1
            ) AS last_message
        FROM messages m
        JOIN users u ON m.outgoing_msg_id = u.id
        WHERE m.incoming_msg_id = :user_id AND m.is_seen = 0
        GROUP BY m.outgoing_msg_id, u.username, u.img
        ORDER BY last_message_time DESC
    ";

        $this->db->query($sql);
        $this->db->bind(':user_id', $currentUserId);
        return $this->db->records();
    }

    public function markMessagesAsRead($fromUserId, $toUserId)
    {
        $sql = "UPDATE messages 
            SET is_seen = 1 
            WHERE outgoing_msg_id = :from AND incoming_msg_id = :to AND is_seen = 0";
        $this->db->query($sql);
        $this->db->bind(':from', $fromUserId);
        $this->db->bind(':to', $toUserId);
        return $this->db->execute();
    }
}
