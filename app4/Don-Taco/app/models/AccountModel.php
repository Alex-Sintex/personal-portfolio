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
}
