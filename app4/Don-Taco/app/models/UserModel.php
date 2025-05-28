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

    public function findUserByLogin($login)
    {
        $this->db->query("SELECT * FROM users WHERE email = :login OR username = :login");
        $this->db->bind(':login', $login);
        return $this->db->record(); // returns full user row or false
    }
}
