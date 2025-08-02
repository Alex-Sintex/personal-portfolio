<?php

namespace App\models;

use App\Libraries\Base;

class AccountModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    // Obtener todos los usuarios
    public function getUsrAccountsInfo()
    {
        $this->db->query("SELECT * FROM users");
        return $this->db->records();
    }

    // Actualizar el estado del usuario (activo/inactivo)
    public function updateStatus($id, $status)
    {
        return $this->db->update('users', $status, 'id = :id', ['id' => $id]);
    }

    // ✅ Obtener datos de un usuario por su ID
    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->record();
    }

    // ✅ Actualizar el perfil del usuario
    public function updateProfile($id, array $data)
    {
        // Lista de campos válidos para actualizar
        $allowed = ['fname', 'lname', 'username', 'email', 'phone', 'password', 'img'];
        $updateData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $updateData[$key] = $value;
            }
        }

        if (empty($updateData)) {
            return false;
        }

        // Ejecutar el UPDATE usando método de la clase Base
        return $this->db->update('users', $updateData, 'id = :id', ['id' => $id]);
    }

    public function deleteUserById($id)
    {
        return $this->db->delete('users', 'id = :id', ['id' => $id]);
    }

    // Add method to set the token
    public function setEmailVerificationToken($userId, $token, $expiresAt)
    {
        $this->db->query("
            UPDATE users 
            SET email_verification_token = :token, 
                email_verification_expires_at = :expires 
            WHERE id = :id
        ");

        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expiresAt);
        $this->db->bind(':id', $userId);

        return $this->db->execute();
    }

    // Add method to verify token
    public function verifyEmailByToken($token)
    {
        // Check for valid token
        $this->db->query("
        SELECT * FROM users 
        WHERE email_verification_token = :token 
        LIMIT 1
    ");
        $this->db->bind(':token', $token);
        $user = $this->db->record();

        if (!$user) return false;

        // Check if token is expired
        if (strtotime($user->email_verification_expires_at) < time()) {
            // Expired — clean up
            $this->clearVerificationToken($user->id);
            return false;
        }

        // Token is valid — verify email
        $this->db->query("
        UPDATE users 
        SET is_email_verified = 1, 
            email_verification_token = NULL, 
            email_verification_expires_at = NULL 
        WHERE id = :id
    ");
        $this->db->bind(':id', $user->id);

        return $this->db->execute() ? $user : false;
    }

    public function clearVerificationToken($userId)
    {
        $this->db->query("
        UPDATE users 
        SET email_verification_token = NULL, 
            email_verification_expires_at = NULL 
        WHERE id = :id
    ");
        $this->db->bind(':id', $userId);
        return $this->db->execute();
    }
}
