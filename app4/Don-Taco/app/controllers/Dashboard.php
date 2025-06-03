<?php
// Class Pages extends the main controller

namespace App\controllers;

use App\Libraries\Controller;

class Dashboard extends Controller
{
    private $productModel;

    public function __construct()
    {
        requireLogin();
        $this->productModel = $this->model('ProductModel');
    }

    public function index()
    {
        $products = $this->productModel->getProducts();

        $data = [
            'loadJQueryLibrary' => true,    // JS
            'loadCharts' => true,           // JS
            'loadDataTablesSimple' => true, // JS
            'loadDataTableStyles' => true,  // CSS
            'loadStyles' => true,           // CSS
            'user_name' => $_SESSION['user_name'],
            'products' => $products
        ];
        $this->view('home/dashboard', $data);
    }
}
