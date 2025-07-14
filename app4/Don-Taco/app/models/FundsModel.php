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
        $this->db->query("SELECT * FROM funds");
        return $this->db->records();
    }

    public function addFund($data)
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
