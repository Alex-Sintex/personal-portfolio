<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;

class Balance extends Controller
{
    private $modelBalance;

    public function __construct()
    {
        requireLogin();
        $this->modelBalance = $this->model('BalanceModel');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
            'loadJQueryLibrary' => true,    // JS
            'loadScriptSideBar' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesBalance' => true,// JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
        ];
        $this->view('modules/balance', $data);
    }

    // Fetch all balance info
    public function fetch()
    {
        $balance = $this->modelBalance->getBalanceInfo();
        $cleaned = [];

        foreach ($balance as $row) {
            $cleaned[] = [
                'id' => $row->id,
                'date' => $row->date,
                'gastEfect' => $row->cash_expenses,
                'ventEfect' => $row->cash_sales,
                'ventTransf' => $row->transfer_sales,
                'ventNetTar' => $row->net_card_sales,
                'depPlatf' => $row->platform_deposits,
                'nomPlatf' => $row->platform_name,
                'reparUtil' => $row->profit_sharing,
                'ub' => $row->uber,
                'did' => $row->didi,
                'rap' => $row->rappi,
                'totGF' => $row->total_fixed_expenses
            ];
        }

        echo json_encode($cleaned);
    }

    // Insert new product
    public function insert()
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $data['measure_n'] = $data['measure_n'] ?? '';
        $data['provider_n'] = $data['provider_n'] ?? '';

        $validator = new Validator();

        $rules = [
            'name'       => ['required' => true, 'type' => 'string', 'max' => 100],
            'price'      => ['required' => true, 'type' => 'numeric'],
            'measure_n'  => ['required' => true, 'type' => 'string', 'max' => 50],
            'provider_n' => ['required' => true, 'type' => 'string', 'max' => 100]
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422); // Unprocessable Entity
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitize($data);

        // 🔍 Get unit_measure_id
        $measure = $this->modelBalance->getMeasureIdByName($cleanData['measure_n']);
        if (!$measure) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Unidad de medida no encontrada']);
            return;
        }

        // 🔍 Get provider_id
        $provider = $this->modelBalance->getProviderIdByName($cleanData['provider_n']);
        if (!$provider) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
            return;
        }

        $insertData = [
            'name'            => $cleanData['name'],
            'price'           => $cleanData['price'],
            'unit_measure_id' => $measure->unit_measure_id,
            'provider_id'     => $provider->provider_id
        ];

        $result = $this->modelBalance->addProduct($insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro añadido!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el registro!']);
        }
    }

    // Update product
    public function update($id)
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $data['measure_n'] = $data['measure_n'] ?? '';
        $data['provider_n'] = $data['provider_n'] ?? '';

        $validator = new Validator();

        $rules = [
            'name'       => ['required' => true, 'type' => 'string', 'max' => 100],
            'price'      => ['required' => true, 'type' => 'numeric'],
            'measure_n'  => ['required' => true, 'type' => 'string', 'max' => 50],
            'provider_n' => ['required' => true, 'type' => 'string', 'max' => 100]
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422); // Unprocessable Entity
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitize($data);

        // 🔍 Get unit_measure_id
        $measure = $this->modelBalance->getMeasureIdByName($cleanData['measure_n']);
        if (!$measure) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Unidad de medida no encontrada']);
            return;
        }

        // 🔍 Get provider_id
        $provider = $this->modelBalance->getProviderIdByName($cleanData['provider_n']);
        if (!$provider) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
            return;
        }

        $insertData = [
            'name'            => $cleanData['name'],
            'price'           => $cleanData['price'],
            'unit_measure_id' => $measure->unit_measure_id,
            'provider_id'     => $provider->provider_id
        ];

        $result = $this->modelBalance->updateProduct($id, $insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro actualizado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el registro!']);
        }
    }

    // Delete product
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelBalance->deleteProduct($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
