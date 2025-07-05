<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;

class Suppliers extends Controller
{
    private $supplierMdl;

    public function __construct()
    {
        requireLogin();
        $this->supplierMdl = $this->model('SupplierModel');
    }

    // Show login view
    public function index()
    {
        $data = [
            'loadStyles'          => true, // CSS
            'loadDataTableStyles' => true, // CSS
            'loadToastStyle'      => true, // CSS
            'loadJQueryLibrary'   => true, // JS
            'loadScriptSideBar'   => true, // JS
            'loadDataTables'      => true, // JS
            'loadDataTableSupp'   => true, // JS
            'loadToasty'          => true  // JS
        ];

        $this->view('modules/suppliers', $data);
    }

    // Fetch info
    public function fetch()
    {
        $sups = $this->supplierMdl->getSups();
        $cleaned = [];

        foreach ($sups as $row) {
            $cleaned[] = [
                'id'        => $row->provider_id,
                'name_prov' => $row->provider_name,
                'des_prov'  => $row->provider_descrip
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($cleaned);
    }

    // Insert new supplier
    public function insert()
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $validator = new Validator();

        $rules = [
            'name_prov' => ['required' => true, 'type' => 'string', 'max' => 50],
            'des_prov'  => ['required' => false, 'type' => 'string']
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

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        $insertData = [
            'provider_name'    => $cleanData['name_prov'],
            'provider_descrip' => $cleanData['des_prov']
        ];

        $result = $this->supplierMdl->addSup($insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro añadido!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el registro!']);
        }
    }

    // Update supplier
    public function update($id)
    {
        header('Content-Type: application/json'); // ✅ Asegura salida JSON

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $validator = new Validator();

        $rules = [
            'name_prov' => ['required' => true, 'type' => 'string', 'max' => 50],
            'des_prov'  => ['required' => false, 'type' => 'string']
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

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        $insertData = [
            'provider_name'    => $cleanData['name_prov'],
            'provider_descrip' => $cleanData['des_prov']
        ];

        $result = $this->supplierMdl->updateSup($id, $insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro actualizado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el registro!']);
        }
    }

    // Delete supplier
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->supplierMdl->deleteSup($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
