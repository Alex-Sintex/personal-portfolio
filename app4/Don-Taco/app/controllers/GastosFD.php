<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\helpers\Validator;

class GastosFD extends Controller
{
    private $modelGastosFD;
    private $balanceModel;

    public function __construct()
    {
        requireLogin();
        $this->modelGastosFD = $this->model('GastosFDModel');
        $this->balanceModel = $this->model('BalanceModel');
    }

    public function index()
    {
        $data = [
            'loadJQueryLibrary'   => true, // JS
            'loadScriptSideBar'   => true, // JS
            'loadDataTables'      => true, // JS
            'loadDataTableGFD'    => true, // JS
            'loadToasty'          => true, // JS
            'loadStyles'          => true, // CSS
            'loadDataTableStyles' => true, // CSS
            'loadToastStyle'      => true  // CSS
        ];
        $this->view('modules/gastos_fijos', $data);
    }

    // Fetch info
    public function fetch()
    {
        $gastosD = $this->modelGastosFD->getDailyFixExpWithDate();
        $cleaned = [];

        foreach ($gastosD as $row) {
            $cleaned[] = [
                'id' => $row->id,
                'date' => $row->date ?? date('Y-m-d'), // fallback to current date
                'rent' => $row->renta,
                'luz' => $row->luz,
                'gas_rich' => $row->gas_richard,
                'gas_milt' => $row->gas_milton,
                'gas' => $row->gas,
                'refrsco' => $row->refresco,
                'ver_sem' => $row->verds_semanal,
                'fond_ta' => $row->fond_taq
            ];
        }

        echo json_encode($cleaned);
    }

    // Insert new record for daily fixed expense
    public function insert()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'rent'     => ['required' => false, 'type' => 'decimal'],
            'luz'      => ['required' => false, 'type' => 'decimal'],
            'gas_rich' => ['required' => false, 'type' => 'decimal'],
            'gas_milt' => ['required' => false, 'type' => 'decimal'],
            'gas'      => ['required' => false, 'type' => 'decimal'],
            'refrsco'  => ['required' => false, 'type' => 'decimal'],
            'ver_sem'  => ['required' => false, 'type' => 'decimal'],
            'fond_ta'  => ['required' => false, 'type' => 'decimal']
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        // ✅ Get the latest balance record
        $lastBalance = $this->balanceModel->getLastBalance();

        $balanceId = null;
        $balanceDate = null;

        if ($lastBalance && isset($lastBalance->id)) {
            $balanceId = $lastBalance->id;

            // only if the date exists in daily_balance
            if (!empty($lastBalance->date)) {
                $balanceDate = $lastBalance->date;
            }

            // Check for duplicate only if balance exists
            if ($this->modelGastosFD->existsExpenseForBalance($balanceId)) {
                http_response_code(409);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Ya existe un gasto fijo diario asociado a este balance.'
                ]);
                return;
            }
        }

        // Insert anyway with date if available
        $insertData = [
            'renta'          => $cleanData['rent'],
            'luz'            => $cleanData['luz'],
            'gas_richard'    => $cleanData['gas_rich'],
            'gas_milton'     => $cleanData['gas_milt'],
            'gas'            => $cleanData['gas'],
            'refresco'       => $cleanData['refrsco'],
            'verds_semanal'  => $cleanData['ver_sem'],
            'fond_taq'       => $cleanData['fond_ta'],
            'dfe_balance_id' => $balanceId,
            'dfe_date'       => $balanceDate // this will be null if balance has no date
        ];

        $result = $this->modelGastosFD->addDailyFixedExp($insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro de gasto fijo añadido!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el gasto fijo!']);
        }
    }


    // Update record for daily fixed expense
    public function update($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'rent'     => ['required' => false, 'type' => 'decimal'],
            'luz'      => ['required' => false, 'type' => 'decimal'],
            'gas_rich' => ['required' => false, 'type' => 'decimal'],
            'gas_milt' => ['required' => false, 'type' => 'decimal'],
            'gas'      => ['required' => false, 'type' => 'decimal'],
            'refrsco'  => ['required' => false, 'type' => 'decimal'],
            'ver_sem'  => ['required' => false, 'type' => 'decimal'],
            'fond_ta'  => ['required' => false, 'type' => 'decimal']
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422);
            echo json_encode(['status' => 'error', 'message' => 'Error de validación', 'errors' => $validator->errors()]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        // ✅ Get the latest balance record
        $lastBalance = $this->balanceModel->getLastBalance();

        $balanceId = null;

        if ($lastBalance && isset($lastBalance->id)) {
            $balanceId = $lastBalance->id;

            // only if the date exists in daily_balance
            if (!empty($lastBalance->date)) {
                $balanceDate = $lastBalance->date;
            }

            // Check for duplicate only if balance exists
            if ($this->modelGastosFD->existsExpenseForBalance($balanceId)) {
                http_response_code(409);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Ya existe un gasto fijo diario asociado a este balance.'
                ]);
                return;
            }
        }

        $insertData = [
            'id'             => $id,
            'renta'          => $cleanData['rent'],
            'luz'            => $cleanData['luz'],
            'gas_richard'    => $cleanData['gas_rich'],
            'gas_milton'     => $cleanData['gas_milt'],
            'gas'            => $cleanData['gas'],
            'refresco'       => $cleanData['refrsco'],
            'verds_semanal'  => $cleanData['ver_sem'],
            'fond_taq'       => $cleanData['fond_ta'],
            'dfe_balance_id' => $balanceId
        ];

        $result = $this->modelGastosFD->updateDailyFixExp($insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro de gasto fijo actualizado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el gasto fijo!']);
        }
    }

    // Delete record for daily fixed expense
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelGastosFD->deleteDailyFixExp($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
