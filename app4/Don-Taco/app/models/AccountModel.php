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

    public function getUsrAccountsInfo()
    {
        $this->db->query("SELECT * FROM users");
        return $this->db->records();
    }

    public function updateStatus($id, $status)
    {
        return $this->db->update('users', $status, 'id = :id', ['id' => $id]);
    }
}
