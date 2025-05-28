<?php
// Class Pages extends the main controller

namespace App\controllers;

use App\Libraries\Controller;

class Pages extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductM');
        /*
        __construct() is use to prepare or set up things before using the rest of the class.
        Common examples:
            - Load models or helpers
            - Start a session
            - Set default values
            - Authorize access (e.g., check if user is logged in)
            - Load config files or dependencies
        */
    }

    public function index()
    {
        $products = $this->productModel->getProducts();

        $data = [
            'loadCharts' => true,          // JS
            'loadDataTablesSimple' => true, // JS
            'loadDataTableStyles' => true,  // CSS
            'products' => $products
        ];
        $this->view('home/dashboard', $data);
    }
}
