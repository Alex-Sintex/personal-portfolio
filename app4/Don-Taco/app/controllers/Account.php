<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;

class Account extends Controller
{
    private $accountModel;

    public function __construct()
    {
        requireLogin();
        $this->accountModel = $this->model('AccountModel');
    }

    // Load account view with required resources
    public function index()
    {
        $data = [
            'loadStyles'        => true, // CSS
            'loadToastStyle'    => true, // CSS
            'loadAccountStyle'  => true, // CSS
            'loadJQueryLibrary' => true, // JS
            'loadScriptSideBar' => true, // JS
            'loadToasty'        => true  // JS
        ];
        $this->view('modules/profile', $data);
    }

    // Fetch all products
    /*
    public function fetch()
    {
        $account = $this->accountModel->getProducts();
        $cleaned = [];

        foreach ($account as $row) {
            $cleaned[] = [
                'id' => $row->in_product_id,
                'name' => $row->in_product_name,
                'price' => $row->unit_price_product,
                'measure_n' => $row->measure_name,
                'provider_n' => $row->provider_name
            ];
        }

        echo json_encode($cleaned);
    }*/

    // Insert new product
    /*
    public function insert()
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        // 🔍 Get unit_measure_id
        $measure = $this->modelProduct->getMeasureIdByName($cleanData['measure_n']);
        if (!$measure) {
            echo json_encode(['status' => 'error', 'message' => 'Unidad de medida no encontrada']);
            return;
        }

        // 🔍 Get provider_id
        $provider = $this->modelProduct->getProviderIdByName($cleanData['provider_n']);
        if (!$provider) {
            echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
            return;
        }

        $insertData = [
            'name'            => $cleanData['name'],
            'price'           => $cleanData['price'],
            'unit_measure_id' => $measure->unit_measure_id,
            'provider_id'     => $provider->provider_id
        ];

        $result = $this->modelProduct->addProduct($insertData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro añadido!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el registro!']);
        }
    }
    */

    // Update product
    /*
    public function update($id)
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitize($data);

        // 🔍 Get unit_measure_id
        $measure = $this->modelProduct->getMeasureIdByName($cleanData['measure_n']);
        if (!$measure) {
            echo json_encode(['status' => 'error', 'message' => 'Unidad de medida no encontrada']);
            return;
        }

        // 🔍 Get provider_id
        $provider = $this->modelProduct->getProviderIdByName($cleanData['provider_n']);
        if (!$provider) {
            echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
            return;
        }

        $insertData = [
            'name'            => $cleanData['name'],
            'price'           => $cleanData['price'],
            'unit_measure_id' => $measure->unit_measure_id,
            'provider_id'     => $provider->provider_id
        ];

        $result = $this->modelProduct->updateProduct($id, $insertData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro actualizado!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el registro!']);
        }
    }
    */

    // Delete product
    /*
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelProduct->deleteProduct($id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
    */

    // Update user status
    public function update_status()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'No user logged in']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $status = $data['status'] ?? '';

        $result = $this->accountModel->updateStatus($userId, ['status' => $status]);

        if ($result) {
            $_SESSION['user_status'] = $status; // ✅ Persist in session
            echo json_encode([
                'status' => 'success',
                'message' => '¡Estatus actualizado!',
                'newStatus' => $status
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al actualizar el estatus!'
            ]);
        }
    }
}
