<?php

namespace App\models;

use App\Libraries\Base;

class ProductM
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getProducts()
    {
        $this->db->query("
    SELECT
        ip.in_product_id,
        ip.in_product_name,
        ip.unit_price_product,
        ip.unit_measure_id,
        ip.provider_id,
        um.measure_name,
        pr.provider_name
    FROM input_products ip
    LEFT JOIN unit_measure um ON ip.unit_measure_id = um.unit_measure_id
    LEFT JOIN providers pr ON ip.provider_id = pr.provider_id;
    ");
        return $this->db->records();
    }

    public function getMeasureIdByName($name)
    {
        $this->db->query("SELECT unit_measure_id FROM unit_measure WHERE measure_name = :name LIMIT 1");
        $this->db->bind(':name', $name);
        return $this->db->record(); // returns assoc array or false
    }

    public function getProviderIdByName($name)
    {
        $this->db->query("SELECT provider_id FROM providers WHERE provider_name = :name LIMIT 1");
        $this->db->bind(':name', $name);
        return $this->db->record(); // returns assoc array or false
    }

    public function addProduct($data)
    {
        $this->db->query("
        INSERT INTO input_products (
            in_product_name,
            unit_price_product,
            unit_measure_id,
            provider_id
        ) VALUES (:name, :price, :measure_id, :provider_id)
    ");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':measure_id', $data['unit_measure_id']);
        $this->db->bind(':provider_id', $data['provider_id']);
        return $this->db->execute();
    }

    public function updateProduct($id, $data)
    {
        $this->db->query("UPDATE input_products SET 
        in_product_name = :name,
        unit_price_product = :price,
        unit_measure_id = :unit_measure_id,
        provider_id = :provider_id
        WHERE in_product_id = :id");

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':unit_measure_id', $data['unit_measure_id']);
        $this->db->bind(':provider_id', $data['provider_id']);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function deleteProduct($id)
    {
        $this->db->query("DELETE FROM input_products WHERE in_product_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
