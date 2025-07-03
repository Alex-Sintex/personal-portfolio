<?php

namespace App\models;

use App\Libraries\Base;

class FundsModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getFunds()
    {
        return $this->db->rawSelect("
            SELECT f.*, db.date, c.name AS card_name
            FROM funds f
            LEFT JOIN daily_balance db ON f.balance_id = db.id
            LEFT JOIN cards c ON f.card_id = c.id
        ");
    }

    public function addFund(array $data)
    {
        return $this->db->insert('funds', $data);
    }

    public function updateFund($id, $data)
    {
        return $this->db->update('funds', $data, 'id = :id', ['id' => $id]);
    }

    public function deleteFund($id)
    {
        return $this->db->delete('funds', 'id = :id', ['id' => $id]);
    }

    /**
     * reuse getPreviousSaldo but skipping current ID if updating
     */
    public function getPreviousSaldo($card_id, $excludeId = null)
    {
        $sql = "SELECT saldo FROM funds
            WHERE card_id = :card_id";

        if ($excludeId) {
            $sql .= " AND id != :excludeId";
        }

        $sql .= " ORDER BY id DESC LIMIT 1";

        $params = ['card_id' => $card_id];
        if ($excludeId) {
            $params['excludeId'] = $excludeId;
        }

        return $this->db->rawRecord($sql, $params)?->saldo ?? 0;
    }
}
