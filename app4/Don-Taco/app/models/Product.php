<?php

class Producto
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    public function getProducts()
    {
        $this->db->query("SELECT * FROM Productos");
        return $this->db->records();
    }

    public function addProduct($data)
    {
        $this->db->query("INSERT INTO Productos (Nombre_Prod, Prec_Unit_Prod) VALUES (:nombre, :precio)");
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':precio', $data['precio']);
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