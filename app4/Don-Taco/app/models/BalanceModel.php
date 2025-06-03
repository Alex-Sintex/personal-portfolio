<?php

namespace App\models;

use App\Libraries\Base;

class BalanceModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getBalanceInfo()
    {
        $this->db->query("SELECT * FROM daily_balance");
        return $this->db->records();
    }
}
