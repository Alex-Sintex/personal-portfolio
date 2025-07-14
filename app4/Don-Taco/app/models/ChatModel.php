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

    public function getChatInfo()
    {
        $this->db->query("SELECT * FROM chat");
        return $this->db->records();
    }

    /*public function findUserByLogin($login)
    {
        $this->db->query("SELECT * FROM users WHERE email = :login OR username = :login");
        $this->db->bind(':login', $login);
        return $this->db->record(); // returns full user row or false
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
    }*/
}
