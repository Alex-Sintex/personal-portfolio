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

    public function addProduct($data)
    {
        $this->db->query("INSERT INTO in_products (in_product_name, unit_price_product) VALUES (:name, :price)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        return $this->db->execute();
    }

    public function updateProduct($id, $data)
    {
        $this->db->query("UPDATE Productos SET Nombre_Prod = :nombre, Prec_Unit_Prod = :precio WHERE Id_Producto = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':precio', $data['precio']);
        return $this->db->execute();
    }

    public function deleteProduct($id)
    {
        $this->db->query("DELETE FROM Productos WHERE Id_Producto = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
