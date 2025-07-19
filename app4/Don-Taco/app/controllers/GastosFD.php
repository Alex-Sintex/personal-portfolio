<?php

namespace App\controllers;

use App\libraries\Controller;
use App\helpers\Validator;
use App\helpers\DataHelper;
use App\Helpers\RecordHelper;

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
            'loadStyles'          => true, // CSS
            'loadDataTableStyles' => true, // CSS
            'loadToastStyle'      => true, // CSS
            'loadJQueryLibrary'   => true, // JS
            'loadScriptSideBar'   => true, // JS
            'loadDataTables'      => true, // JS
            'loadDataTableGFD'    => true, // JS
            'loadToasty'          => true, // JS
            'loadJSRoleHelper'    => true  // JS
        ];
        $this->view('modules/gastos_fijos', $data);
    }

    // Fetch info
    public function fetch()
    {
        $gastosD = $this->modelGastosFD->getDailyFixExpInfo();
        $cleaned = [];

        foreach ($gastosD as $row) {
            $cleaned[] = [
                'id' => $row->id,
                'date' => $row->date,
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
        requireAdmin();
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $rules = [
            'date'     => ['required' => true, 'type' => 'date'],
            'rent'     => ['required' => false, 'type' => 'decimal'],
            'luz'      => ['required' => false, 'type' => 'decimal'],
            'gas_rich' => ['required' => false, 'type' => 'decimal'],
            'gas_milt' => ['required' => false, 'type' => 'decimal'],
            'gas'      => ['required' => false, 'type' => 'decimal'],
            'refrsco'  => ['required' => false, 'type' => 'decimal'],
            'ver_sem'  => ['required' => false, 'type' => 'decimal'],
            'fond_ta'  => ['required' => false, 'type' => 'decimal']
        ];

        // ✅ Validación de datos
        $validator = new Validator();

        if (!$validator->validate($data, $rules)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);
        $cleanData = DataHelper::setDecimalDefaults($cleanData, $rules);

        // Check for duplicate date
        if (RecordHelper::exists('daily_fixed_exp', 'date', $cleanData['date'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un gasto fijo diario con esa fecha'
            ]);
            return;
        }

        // ✅ Get the latest balance record
        $lastBalance = $this->balanceModel->getLastBalance();

        $balanceId = null;

        if ($lastBalance && isset($lastBalance->id)) {
            $balanceId = $lastBalance->id;

            // Check for duplicate only if balance exists
            /*if ($this->modelGastosFD->existsExpenseForBalance($balanceId)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Ya existe un gasto fijo diario asociado a este balance.'
                ]);
                return;
            }*/
        }

        // Insert anyway with date if available
        $insertData = [
            'dfe_balance_id' => $balanceId,
            'date'           => $cleanData['date'],
            'renta'          => $cleanData['rent'],
            'luz'            => $cleanData['luz'],
            'gas_richard'    => $cleanData['gas_rich'],
            'gas_milton'     => $cleanData['gas_milt'],
            'gas'            => $cleanData['gas'],
            'refresco'       => $cleanData['refrsco'],
            'verds_semanal'  => $cleanData['ver_sem'],
            'fond_taq'       => $cleanData['fond_ta']
        ];

        $result = $this->modelGastosFD->addDailyFixedExp($insertData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro de gasto fijo añadido!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el gasto fijo!']);
        }
    }


    // Update record for daily fixed expense
    public function update($id)
    {
        requireAdmin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'date'     => ['required' => true, 'type' => 'date'],
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
            echo json_encode(['status' => 'error', 'message' => 'Error de validación', 'errors' => $validator->errors()]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);
        $cleanData = DataHelper::setDecimalDefaults($cleanData, $rules);

        // Check for duplicate date
        if (RecordHelper::exists('daily_fixed_exp', 'date', $cleanData['date'], $id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un gasto fijo diario con esa fecha'
            ]);
            return;
        }

        // ✅ Get the latest balance record
        $lastBalance = $this->balanceModel->getLastBalance();

        $balanceId = null;

        if ($lastBalance && isset($lastBalance->id)) {
            $balanceId = $lastBalance->id;
        }

        $insertData = [
            'id'             => $id,
            'dfe_balance_id' => $balanceId,
            'date'           => $cleanData['date'],
            'renta'          => $cleanData['rent'],
            'luz'            => $cleanData['luz'],
            'gas_richard'    => $cleanData['gas_rich'],
            'gas_milton'     => $cleanData['gas_milt'],
            'gas'            => $cleanData['gas'],
            'refresco'       => $cleanData['refrsco'],
            'verds_semanal'  => $cleanData['ver_sem'],
            'fond_taq'       => $cleanData['fond_ta']
        ];

        $result = $this->modelGastosFD->updateDailyFixExp($insertData);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro de gasto fijo actualizado!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el gasto fijo!']);
        }
    }

    // Delete record for daily fixed expense
    public function delete($id)
    {
        requireAdmin();
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelGastosFD->deleteDailyFixExp($id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
