<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;

// Class for Unit of Measures
class Unitoms extends Controller
{
    private $uomModel;

    public function __construct()
    {
        requireLogin();
        $this->uomModel = $this->model('UnitomsModel');
    }

    // Show login view
    public function index()
    {
        $data = [
            'loadStyles'           => true, // CSS
            'loadDataTableStyles'  => true, // CSS
            'loadToastStyle'       => true, // CSS
            'loadJQueryLibrary'    => true, // JS
            'loadScriptSideBar'    => true, // JS
            'loadDataTables'       => true, // JS
            'loadDataTableUnitoms' => true, // JS
            'loadToasty'           => true  // JS
        ];

        $this->view('modules/unitoms', $data);
    }

    // Fetch info
    public function fetch()
    {
        $units = $this->uomModel->getUnitMS();
        $cleaned = [];

        foreach ($units as $row) {
            $cleaned[] = [
                'id'     => $row->unit_measure_id,
                'unit_n' => $row->measure_name,
                'unit_d' => $row->measure_descrip
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
            'unit_n' => ['required' => true, 'type' => 'string', 'max' => 50],
            'unit_d' => ['required' => false, 'type' => 'string']
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
            'measure_name'    => $cleanData['unit_n'],
            'measure_descrip' => $cleanData['unit_d']
        ];

        $result = $this->uomModel->addUnit($insertData);

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
            'unit_n' => ['required' => true, 'type' => 'string', 'max' => 50],
            'unit_d' => ['required' => false, 'type' => 'string']
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
            'measure_name'    => $cleanData['unit_n'],
            'measure_descrip' => $cleanData['unit_d']
        ];

        $result = $this->uomModel->updateUnit($id, $insertData);

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

        $result = $this->uomModel->deleteUnit($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
