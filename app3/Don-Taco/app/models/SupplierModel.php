<?php

namespace App\models;

use App\Libraries\Base;

class SupplierModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getSups()
    {
        $this->db->query("SELECT * FROM suppliers");
        return $this->db->records();
    }

    public function addSup($data)
    {
        return $this->db->insert('suppliers', $data);
    }

    public function updateSup($id, $data)
    {
        return $this->db->update('suppliers', $data, 'provider_id = :id', ['id' => $id]);
    }

    public function deleteSup($id)
    {
        return $this->db->delete('suppliers', 'provider_id = :id', ['id' => $id]);
    }
}
