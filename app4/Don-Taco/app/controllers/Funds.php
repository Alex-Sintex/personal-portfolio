<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;
use App\Helpers\DataHelper;
use App\Helpers\RecordHelper;

class Funds extends Controller
{
    private $modelFunds;
    private $balanceModel;

    public function __construct()
    {
        requireLogin();
        $this->modelFunds = $this->model('FundsModel');
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
            'loadDataTableF'      => true, // JS
            'loadToasty'          => true, // JS
            'loadJSRoleHelper'    => true  // JS
        ];
        $this->view('modules/funds', $data);
    }

    // Fetch info
    public function fetch()
    {
        $funds = $this->modelFunds->getFunds();
        $cleaned = [];

        foreach ($funds as $row) {
            $cleaned[] = [
                'id'       => $row->id,
                'date'     => $row->date,
                'card'     => $row->card_name ?? 'KLAR',
                'saldo'    => $row->saldo,
                'pagos'    => $row->pagos,
                'concepto' => $row->concepto_pagos,
                'observa'  => $row->observaciones
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($cleaned);
    }

    // Insert new record for funds
    public function insert()
    {
        requireAdmin();
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $rules = [
            'date'     => ['required' => true, 'type' => 'date'],
            'pagos'    => ['required' => false, 'type' => 'decimal'],
            'concepto' => ['required' => false, 'type' => 'string'],
            'observa'  => ['required' => false, 'type' => 'string'],
            // no 'card_id' here because we set it manually below
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
        if (RecordHelper::exists('funds', 'date', $cleanData['date'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un fondo con esa fecha'
            ]);
            return;
        }

        // Set card_id manually as 1 (KLAR)
        $cleanData['card_id'] = 1;

        // get last balance
        $lastBalance = $this->balanceModel->getLastBalance();
        if (!$lastBalance) {
            http_response_code(400);
            return;
        }

        $balanceId = $lastBalance->id;
        $totFixedExp = $lastBalance->tot_fixed_exp ?? 0;

        // get previous saldo for the card (id=1)
        $prevSaldo = $this->modelFunds->getPreviousSaldo(1) ?? 0;
        $pagos = $cleanData['pagos'] ?? 0;

        $calculatedSaldo = ($totFixedExp + $prevSaldo) - $pagos;

        $insertData = [
            'balance_id'      => $balanceId,
            'date'            => $cleanData['date'],
            'card_id'         => 1,
            'saldo'           => $calculatedSaldo,
            'pagos'           => $pagos,
            'concepto_pagos'  => $cleanData['concepto'],
            'observaciones'   => $cleanData['observa']
        ];

        $result = $this->modelFunds->addFund($insertData);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => '¡Registro de fondo añadido!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al añadir el fondo!'
            ]);
        }
    }

    // Update record for funds
    public function update($id)
    {
        requireAdmin();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'date'     => ['required' => true, 'type' => 'date'],
            'pagos'    => ['required' => false, 'type' => 'decimal'],
            'concepto' => ['required' => false, 'type' => 'string'],
            'observa'  => ['required' => false, 'type' => 'string'],
            // 'card_id' intentionally omitted
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
        $cleanData = DataHelper::setDecimalDefaults($cleanData, $rules);

        // Check for duplicate date
        if (RecordHelper::exists('funds', 'date', $cleanData['date'], $id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un fondo con esa fecha'
            ]);
            return;
        }

        // get last balance
        $lastBalance = $this->balanceModel->getLastBalance();
        if (!$lastBalance) {
            $balanceId = null;
            $totFixedExp = 0;
        } else {
            $balanceId = $lastBalance->id;
            $totFixedExp = $lastBalance->tot_fixed_exp ?? 0;
        }

        // Use fixed card_id = 1, do NOT use $cleanData['card_id']
        $prevSaldo = $this->modelFunds->getPreviousSaldo(1, $id) ?? 0;
        $pagos = $cleanData['pagos'] ?? 0;

        $calculatedSaldo = ($totFixedExp + $prevSaldo) - $pagos;

        $updateData = [
            'date'            => $cleanData['date'],
            'saldo'           => $calculatedSaldo,
            'pagos'           => $pagos,
            'concepto_pagos'  => $cleanData['concepto'],
            'observaciones'   => $cleanData['observa'],
            'balance_id'      => $balanceId,
            'card_id'         => 1  // fixed card_id here
        ];

        $result = $this->modelFunds->updateFund($id, $updateData);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => '¡Registro de fondo actualizado!'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al actualizar el registro!'
            ]);
        }
    }

    // Delete record for funds
    public function delete($id)
    {
        requireAdmin();
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelFunds->deleteFund($id);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => '¡Registro eliminado!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al eliminar el registro!'
            ]);
        }
    }
}
