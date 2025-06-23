<?php

namespace App\controllers;

use App\Libraries\Controller;

class Dashboard extends Controller
{
    private $productModel;
    private $balanceModel;
    private $expenseModel;

    public function __construct()
    {
        requireLogin();
        $this->productModel = $this->model('ProductModel');
        $this->balanceModel = $this->model('BalanceModel');
        $this->expenseModel = $this->model('GastosDModel');
    }

    public function index()
    {
        $products = $this->productModel->getProducts();

        $data = [
            'loadJQueryLibrary' => true,
            'loadScriptSideBar' => true,
            'loadCharts' => true,
            'loadDataTablesSimple' => true,
            'loadDataTableStyles' => true,
            'loadStyles' => true,
            'products' => $products
        ];

        $this->view('home/dashboard', $data);
    }

    // API endpoint for the income chart
    public function getWeeklyIncomes()
    {
        header('Content-Type: application/json');

        try {
            $results = $this->balanceModel->getWeeklyIncomeSummary();
            echo json_encode($results);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error fetching weekly income data',
                'error' => $e->getMessage()
            ]);
        }
    }

    // New API endpoint for weekly expenses chart (tot_gto_diarios)
    public function getWeeklyExpenses()
    {
        header('Content-Type: application/json');

        try {
            $results = $this->expenseModel->getWeeklyExpenseSummary();
            echo json_encode($results);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error fetching weekly expense data',
                'error' => $e->getMessage()
            ]);
        }
    }
}
