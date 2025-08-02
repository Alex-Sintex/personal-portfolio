<?php

namespace App\models;

use App\Libraries\Base;

class UnitomsModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getUnitMS()
    {
        $this->db->query("SELECT * FROM unit_measure");
        return $this->db->records();
    }

    public function addUnit($data)
    {
        return $this->db->insert('unit_measure', $data);
    }

    public function updateUnit($id, $data)
    {
        return $this->db->update('unit_measure', $data, 'unit_measure_id = :id', ['id' => $id]);
    }

    public function deleteUnit($id)
    {
        return $this->db->delete('unit_measure', 'unit_measure_id = :id', ['id' => $id]);
    }
}
