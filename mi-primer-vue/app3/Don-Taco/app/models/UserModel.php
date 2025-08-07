<?php

namespace App\models;

use App\Libraries\Base;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getUserInfo()
    {
        $this->db->query("SELECT * FROM users");
        return $this->db->records();
    }

    public function findUserByLogin($login)
    {
        $this->db->query("SELECT * FROM users WHERE email = :login OR username = :login");
        $this->db->bind(':login', $login);
        return $this->db->record(); // returns full user row or false
    }

    public function findById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->record();
    }

    public function addUser($data)
    {
        return $this->db->insert('users', $data);
    }

    public function userExists(string $email, string $username, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as total FROM users 
        WHERE (LOWER(email) = LOWER(:email) OR LOWER(username) = LOWER(:username))";

        $params = [
            'email' => $email,
            'username' => $username
        ];

        if (!is_null($excludeId)) {
            $sql .= " AND id != :excludeId";
            $params['excludeId'] = $excludeId;
        }

        $this->db->query($sql);
        $this->db->bindMultiple($params);
        $result = $this->db->record();

        return ($result && $result->total > 0);
    }

    public function updateUser($id, $data)
    {
        return $this->db->update('users', $data, 'id = :id', ['id' => $id]);
    }

    public function deleteUser($id)
    {
        return $this->db->delete('users', 'id = :id', ['id' => $id]);
    }

    public function setStatusOnline($userId)
    {
        return $this->updateUser($userId, ['status' => 'online']);
    }

    public function setStatusOffline($userId)
    {
        return $this->updateUser($userId, ['status' => 'offline']);
    }

    // Save password reset token
    public function saveResetToken(int $userId, string $token, string $expiresAt): bool
    {
        $sql = "INSERT INTO user_tokens (user_id, token, type, expires_at) 
            VALUES (:user_id, :token, 'reset', :expires_at)";
        $this->db->query($sql);
        $this->db->bindMultiple([
            'user_id'   => $userId,
            'token'     => $token,
            'expires_at' => $expiresAt
        ]);
        return $this->db->execute();
    }

    // Get most recent reset token (within X minutes)
    public function getRecentToken(int $userId, string $type, int $minutes): ?object
    {
        $sql = "SELECT * FROM user_tokens 
            WHERE user_id = :user_id AND type = :type 
              AND created_at >= NOW() - INTERVAL :minutes MINUTE 
            ORDER BY created_at DESC LIMIT 1";
        $this->db->query($sql);
        $this->db->bindMultiple([
            'user_id' => $userId,
            'type'    => $type,
            'minutes' => $minutes
        ]);

        $result = $this->db->record();
        return $result !== false ? $result : null;
    }

    // Find a valid reset token
    public function getValidResetToken(int $userId, string $token): ?object
    {
        $sql = "SELECT * FROM user_tokens 
            WHERE user_id = :user_id AND token = :token 
              AND type = 'reset' AND expires_at > NOW() 
            ORDER BY created_at DESC LIMIT 1";
        $this->db->query($sql);
        $this->db->bindMultiple([
            'user_id' => $userId,
            'token'   => $token
        ]);

        $result = $this->db->record();
        return $result !== false ? $result : null;
    }

    // Delete token once used
    public function deleteToken(int $tokenId): bool
    {
        $sql = "DELETE FROM user_tokens WHERE id_token = :id_token";
        $this->db->query($sql);
        $this->db->bind(':id_token', $tokenId);
        return $this->db->execute();
    }
}
