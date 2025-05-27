<?php

class Product extends Controller
{
    private $modelProduct;

    public function __construct()
    {
<<<<<<< HEAD
=======
        requireLogin();
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
        $this->modelProduct = $this->model('ProductM');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
<<<<<<< HEAD
            'loadDataTables' => true,
            'loadDataTablesProduct' => true,
            'loadToasty' => true,
            'loadDataTableStyles' => true,
            'loadToastStyle' => true
=======
            'loadJQueryLibrary' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesProduct' => true, // JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
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
<<<<<<< HEAD
                'id' => $row->Id_Producto,
                'name' => $row->Nombre_Prod,
                'price' => $row->Prec_Unit_Prod
=======
                'id' => $row->in_product_id,
                'name' => $row->in_product_name,
                'price' => $row->unit_price_product,
                'measure_n' => $row->measure_name,
                'provider_n' => $row->provider_name
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
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
