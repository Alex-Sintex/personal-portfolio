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

    public function existsExpenseForBalance($balanceId)
    {
        $this->db->query("SELECT COUNT(*) as total FROM daily_expense WHERE balance_id = :balance_id");
        $this->db->bind(':balance_id', $balanceId);
        return $this->db->record()->total > 0;
    }

    // ✅ Needed by BalanceHelper
    public function getLastRecord()
    {
        $this->db->query("SELECT * FROM daily_balance ORDER BY id DESC LIMIT 1 OFFSET 1");
        return $this->db->record();
    }

    // ✅ Needed by BalanceHelper
    public function getTotalGDByBalanceId($balanceId)
    {
        $this->db->query("SELECT SUM(tot_gto_diarios) as total FROM daily_expense WHERE balance_id = :balance_id");
        $this->db->bind(':balance_id', $balanceId);
        $result = $this->db->record();
        return $result && $result->total !== null ? (float)$result->total : 0.0;
    }
}
