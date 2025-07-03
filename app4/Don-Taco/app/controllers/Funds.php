<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\helpers\Validator;

class Funds extends Controller
{
    private $modelFunds;
    private $balanceModel;
    private $modelGastosD;

    public function __construct()
    {
        requireLogin();
        $this->modelFunds = $this->model('FundsModel');
        $this->balanceModel = $this->model('BalanceModel');
        $this->modelGastosD = $this->model('GastosDModel');
    }

    public function index()
    {
        $data = [
            'loadJQueryLibrary'   => true, // JS
            'loadScriptSideBar'   => true, // JS
            'loadDataTables'      => true, // JS
            'loadDataTableF'      => true, // JS
            'loadToasty'          => true, // JS
            'loadStyles'          => true, // CSS
            'loadDataTableStyles' => true, // CSS
            'loadToastStyle'      => true  // CSS
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
                'date'     => $row->date ?? date('Y-m-d'),
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
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'pagos'    => ['required' => false, 'type' => 'decimal'],
            'concepto' => ['required' => false, 'type' => 'string'],
            'observa'  => ['required' => false, 'type' => 'string'],
            // no 'card_id' here because we set it manually below
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
            'saldo'           => $calculatedSaldo,
            'pagos'           => $pagos,
            'concepto_pagos'  => $cleanData['concepto'],
            'observaciones'   => $cleanData['observa'],
            'balance_id'      => $balanceId,
            'card_id'         => 1
        ];

        $result = $this->modelFunds->addFund($insertData);

        if ($result) {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => '¡Registro de fondo añadido!',
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al añadir el fondo!'
            ]);
        }
    }

    // Update record for funds
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
            'saldo'           => $calculatedSaldo,
            'pagos'           => $pagos,
            'concepto_pagos'  => $cleanData['concepto'],
            'observaciones'   => $cleanData['observa'],
            'balance_id'      => $balanceId,
            'card_id'         => 1  // fixed card_id here
        ];

        $result = $this->modelFunds->updateFund($id, $updateData);

        if ($result) {
            http_response_code(200);
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
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $result = $this->modelFunds->deleteFund($id);

        if ($result) {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => '¡Registro eliminado!'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => '¡Error al eliminar el registro!'
            ]);
        }
    }
}
