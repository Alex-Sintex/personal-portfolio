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
            'loadDataTableStyles'  => true,     // CSS
            'loadStyles'           => true,     // CSS
            'loadJQueryLibrary'    => true,     // JS
            'loadScriptSideBar'    => true,     // JS
            'loadCharts'           => true,     // JS
            'loadDataTablesSimple' => true,     // JS
            'loadToasty'           => true,     // JS
            'products'             => $products // data
        ];

        $this->view('home/dashboard', $data);
    }

    // API endpoint for the income chart
    public function getWeeklyIncomes()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        try {
            $results = $this->balanceModel->getWeeklyIncomeSummary();

            if (empty($results)) {
                echo json_encode([
                    'status' => 'no_data',
                    'message' => 'No hay ingresos registrados para mostrar en la gráfica.'
                ]);
                return;
            }

            echo json_encode($results);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener los ingresos semanales.',
                'error' => $e->getMessage()
            ]);
        }
    }

    // API endpoint for weekly expenses chart
    public function getWeeklyExpenses()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        try {
            $results = $this->expenseModel->getWeeklyExpenseSummary();

            if (empty($results)) {
                echo json_encode([
                    'status' => 'no_data',
                    'message' => 'No hay gastos registrados para mostrar en la gráfica.'
                ]);
                return;
            }

            echo json_encode($results);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al obtener los gastos semanales.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
