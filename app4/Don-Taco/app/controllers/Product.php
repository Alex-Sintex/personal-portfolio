<?php

class Product extends Controller
{
    private $modelProduct;

    public function __construct()
    {
        $this->modelProduct = $this->model('ProductM');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
            'loadDataTables' => true,
            'loadDataTablesProduct' => true,
            'loadToasty' => true,
            'loadDataTableStyles' => true,
            'loadToastStyle' => true
        ];
        $this->view('modules/product', $data);
    }

    // Fetch all products
    public function fetch()
    {
        header('Content-Type: application/json');
        $product = $this->modelProduct->getProducts();
        $cleaned = [];

        foreach ($product as $row) {
            $cleaned[] = [
                'id' => $row->Id_Producto,
                'name' => $row->Nombre_Prod,
                'price' => $row->Prec_Unit_Prod
            ];
        }

        echo json_encode($cleaned);
    }

    // Insert new product
    public function insert()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');

        if (!isset($data['nombre']) || !isset($data['precio'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
            return;
        }

        $result = $this->modelProduct->addProduct($data);
        echo json_encode(['status' => $result ? 'Added' : 'error']);
    }

    // Update product
    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');

        if (!isset($data['nombre']) || !isset($data['precio'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
            return;
        }

        $result = $this->modelProduct->updateProduct($id, $data);
        echo json_encode(['status' => $result ? 'Updated' : 'error']);
    }

    // Delete product
    public function delete($id)
    {
        header('Content-Type: application/json');
        $result = $this->modelProduct->deleteProduct($id);
        echo json_encode(['status' => $result ? 'Deleted' : 'error']);
    }
}
