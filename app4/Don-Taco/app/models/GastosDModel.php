<?php

namespace App\models;

use App\Libraries\Base;

class GastosDModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getDailyExpensesWithDate()
    {
        return $this->db->rawSelect("
        SELECT de.*, db.date
        FROM daily_expense de
        LEFT JOIN daily_balance db ON de.balance_id = db.id
    ");
    }

    public function addDailyExp($data)
    {
        return $this->db->insert('daily_expense', $data);
    }

    public function updateDailyExp($data)
    {
        return $this->db->update('daily_expense', $data, 'id = :id', ['id' => $data['id']]);
    }

    public function deleteDailyExp($id)
    {
        return $this->db->delete('daily_expense', 'id = :id', ['id' => $id]);
    }
}
