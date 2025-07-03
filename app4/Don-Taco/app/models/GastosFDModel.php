<?php

namespace App\models;

use App\Libraries\Base;

class GastosFDModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getDailyFixExpWithDate()
    {
        return $this->db->rawSelect("
            SELECT dfe.*, db.date
            FROM daily_fixed_exp dfe
            LEFT JOIN daily_balance db ON dfe.dfe_balance_id = db.id
        ");
    }

    public function existsExpenseForBalance($balanceId)
    {
        $this->db->query("SELECT COUNT(*) as total FROM daily_fixed_exp WHERE dfe_balance_id = :balance_id");
        $this->db->bind(':balance_id', $balanceId);
        return $this->db->record()->total > 0;
    }

    public function addDailyFixedExp($data)
    {
        return $this->db->insert('daily_fixed_exp', $data);
    }

    public function updateDailyFixExp($data)
    {
        return $this->db->update('daily_fixed_exp', $data, 'id = :id', ['id' => $data['id']]);
    }

    public function deleteDailyFixExp($id)
    {
        return $this->db->delete('daily_fixed_exp', 'id = :id', ['id' => $id]);
    }
}
