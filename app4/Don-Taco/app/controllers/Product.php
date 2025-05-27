<?php

class Product extends Controller
{
    private $modelProduct;

    public function __construct()
    {
        requireLogin();
        $this->modelProduct = $this->model('ProductM');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
            'loadJQueryLibrary' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesProduct' => true, // JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
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
                'id' => $row->in_product_id,
                'name' => $row->in_product_name,
                'price' => $row->unit_price_product,
                'measure_n' => $row->measure_name,
                'provider_n' => $row->provider_name
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
