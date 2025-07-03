<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;
use App\Helpers\BalanceHelper;

class Balance extends Controller
{
    private $modelBalance;

    public function __construct()
    {
        requireLogin();
        $this->modelBalance = $this->model('BalanceModel');
    }

    public function index()
    {
        $this->view('modules/balance', [
            'loadJQueryLibrary'     => true,
            'loadScriptSideBar'     => true,
            'loadDataTables'        => true,
            'loadDataTableBalance'  => true,
            'loadToasty'            => true,
            'loadStyles'            => true,
            'loadDataTableStyles'   => true,
            'loadToastStyle'        => true
        ]);
    }

    public function fetch()
    {
        $balance = $this->modelBalance->getBalanceInfo();
        $cleaned = [];

        foreach ($balance as $row) {
            $cleaned[] = [
                'id'         => $row->id,
                'date'       => $row->date,
                'gastEfect'  => $row->cash_expenses,
                'ventEfect'  => $row->cash_sales,
                'ventTransf' => $row->transfer_sales,
                'ventNetTar' => $row->net_card_sales,
                'depPlatf'   => $row->platform_deposits,
                'nomPlatf'   => $row->platform_name,
                'reparUtil'  => $row->profit_sharing,
                'ub'         => $row->uber,
                'did'        => $row->didi,
                'rap'        => $row->rappi,
                'totGF'      => $row->tot_fixed_exp
            ];
        }

        echo json_encode($cleaned);
    }

    public function fetch_cal()
    {
        $balance_cal = $this->modelBalance->getBalanceCal();
        $cleaned = [];

        foreach ($balance_cal as $row) {
            $cleaned[] = [
                'utilidadNeta'        => $row->net_profit,
                'totalEgresos'        => $row->total_expenses,
                'efectivoCierre'      => $row->closing_cash,
                'ventaTarjeta'        => $row->card_sales_percent,
                'totalIngresos'       => $row->total_income,
                'utilidadPiso'        => $row->floor_profit,
                'utilidadDisponible'  => $row->available_profit,
                'total'               => $row->total_platforms,
                'utilidadPlataforma'  => $row->platform_net_profit
            ];
        }

        echo json_encode($cleaned);
    }

    // Insert method for balance
    public function insert()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Reglas de validación
        $rules = [
            'date'       => ['required' => true, 'type' => 'date'],
            'gastEfect'  => ['required' => false, 'type' => 'decimal'],
            'ventEfect'  => ['required' => false, 'type' => 'decimal'],
            'ventTransf' => ['required' => false, 'type' => 'decimal'],
            'ventNetTar' => ['required' => false, 'type' => 'decimal'],
            'depPlatf'   => ['required' => false, 'type' => 'decimal'],
            'nomPlatf'   => ['required' => false, 'type' => 'string'],
            'reparUtil'  => ['required' => false, 'type' => 'decimal'],
            'ub'         => ['required' => false, 'type' => 'decimal'],
            'did'        => ['required' => false, 'type' => 'decimal'],
            'rap'        => ['required' => false, 'type' => 'decimal'],
            'totGF'      => ['required' => false, 'type' => 'decimal'],
        ];

        // ✅ Validación de datos
        $validator = new Validator();

        if (!$validator->validate($data, $rules)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Error de validación',
                'errors'  => $validator->errors()
            ]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        // Prepara datos para el cálculo automático
        $inputForCalc = [
            'gastEfect'  => $cleanData['gastEfect'],
            'ventEfect'  => $cleanData['ventEfect'],
            'ventTransf' => $cleanData['ventTransf'],
            'ventNetTar' => $cleanData['ventNetTar'],
            'depPlatf'   => $cleanData['depPlatf'],
            'nomPlatf'   => $cleanData['nomPlatf'],
            'reparUtil'  => $cleanData['reparUtil'],
            'ub'         => $cleanData['ub'],
            'did'        => $cleanData['did'],
            'rap'        => $cleanData['rap'],
            'totGF'      => $cleanData['totGF']
        ];

        $calculations = BalanceHelper::calculate($inputForCalc);

        // Combina los datos originales con los cálculos
        $insertData = array_merge(
            ['date' => $cleanData['date']],
            $inputForCalc,
            $calculations
        );

        // Mapea nombres del frontend a nombres reales de columnas en la base de datos
        $map = [
            'gastEfect'  => 'cash_expenses',
            'ventEfect'  => 'cash_sales',
            'ventTransf' => 'transfer_sales',
            'ventNetTar' => 'net_card_sales',
            'depPlatf'   => 'platform_deposits',
            'nomPlatf'   => 'platform_name',
            'reparUtil'  => 'profit_sharing',
            'ub'         => 'uber',
            'did'        => 'didi',
            'rap'        => 'rappi',
            'totGF'      => 'tot_fixed_exp'
        ];

        foreach ($map as $oldKey => $newKey) {
            $insertData[$newKey] = $insertData[$oldKey];
            unset($insertData[$oldKey]);
        }

        // Inserta el balance
        $result = $this->modelBalance->addBalance($insertData);

        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result
                ? 'Balance insertado y cálculos completados'
                : 'Error al insertar balance'
        ]);
    }

    // Update record for balance
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
            'date'       => ['required' => true, 'type' => 'date'],
            'gastEfect'  => ['required' => false, 'type' => 'decimal'],
            'ventEfect'  => ['required' => false, 'type' => 'decimal'],
            'ventTransf' => ['required' => false, 'type' => 'decimal'],
            'ventNetTar' => ['required' => false, 'type' => 'decimal'],
            'depPlatf'   => ['required' => false, 'type' => 'decimal'],
            'nomPlatf'   => ['required' => false, 'type' => 'string'],
            'reparUtil'  => ['required' => false, 'type' => 'decimal'],
            'ub'         => ['required' => false, 'type' => 'decimal'],
            'did'        => ['required' => false, 'type' => 'decimal'],
            'rap'        => ['required' => false, 'type' => 'decimal'],
            'totGF'      => ['required' => false, 'type' => 'decimal'],
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422);
            echo json_encode(['status' => 'error', 'message' => 'Error de validación', 'errors' => $validator->errors()]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);

        // Prepara datos para cálculos
        $inputForCalc = [
            'cash_expenses'     => $cleanData['gastEfect'],
            'cash_sales'        => $cleanData['ventEfect'],
            'transfer_sales'    => $cleanData['ventTransf'],
            'net_card_sales'    => $cleanData['ventNetTar'],
            'platform_deposits' => $cleanData['depPlatf'],
            'profit_sharing'    => $cleanData['reparUtil'],
            'uber'              => $cleanData['ub'],
            'didi'              => $cleanData['did'],
            'rappi'             => $cleanData['rap'],
            'tot_fixed_exp'     => $cleanData['totGF'],
        ];

        $calculations = BalanceHelper::calculate($inputForCalc);

        $updateData = array_merge(
            [
                'id'               => $id,
                'date'             => $cleanData['date'],
                'cash_expenses'    => $cleanData['gastEfect'],
                'cash_sales'       => $cleanData['ventEfect'],
                'transfer_sales'   => $cleanData['ventTransf'],
                'net_card_sales'   => $cleanData['ventNetTar'],
                'platform_deposits' => $cleanData['depPlatf'],
                'platform_name'    => $cleanData['nomPlatf'],
                'profit_sharing'   => $cleanData['reparUtil'],
                'uber'             => $cleanData['ub'],
                'didi'             => $cleanData['did'],
                'rappi'            => $cleanData['rap'],
                'tot_fixed_exp'    => $cleanData['totGF']
            ],
            $calculations
        );

        $result = $this->modelBalance->updateBalance($updateData);

        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? '¡Balance actualizado correctamente!' : '¡Error al actualizar el balance!'
        ]);
    }

    // Delete record
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID inválido']);
            return;
        }

        $result = $this->modelBalance->deleteBalance($id);

        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? '¡Balance eliminado correctamente!' : '¡Error al eliminar el balance!'
        ]);
    }
}
