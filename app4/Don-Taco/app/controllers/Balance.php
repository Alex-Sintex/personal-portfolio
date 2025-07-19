<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\Helpers\Validator;
use App\Helpers\BalanceHelper;
use App\Helpers\DataHelper;
use App\Helpers\RecordHelper;

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
            'loadStyles'            => true, // CSS
            'loadDataTableStyles'   => true, // CSS
            'loadToastStyle'        => true, // CSS
            'loadJQueryLibrary'     => true, // JS
            'loadScriptSideBar'     => true, // JS
            'loadDataTables'        => true, // JS
            'loadDataTableBalance'  => true, // JS
            'loadToasty'            => true, // JS
            'loadJSRoleHelper'      => true, // JS
        ]);
    }

    public function fetch()
    {
        $balance = $this->modelBalance->getBalanceInfo();
        $cleaned = [];

        foreach ($balance as $row) {
            $cleaned[] = [
                'id'             => $row->id,
                'date'           => $row->date,
                'efectivoCierre' => $row->closing_cash,
                'gastEfect'      => $row->cash_expenses,
                'ventEfect'      => $row->cash_sales,
                'ventTransf'     => $row->transfer_sales,
                'ventNetTar'     => $row->net_card_sales,
                'depPlatf'       => $row->platform_deposits,
                'nomPlatf'       => $row->platform_name,
                'reparUtil'      => $row->profit_sharing,
                'ub'             => $row->uber,
                'did'            => $row->didi,
                'rap'            => $row->rappi,
                'totGF'          => $row->tot_fixed_exp
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
                'date'                => $row->date,
                'utilidadNeta'        => $row->net_profit,
                'totalEgresos'        => $row->total_expenses,
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

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        // Reglas de validación
        $rules = [
            'date'           => ['required' => true, 'type' => 'date'],
            'efectivoCierre' => ['required' => false, 'type' => 'decimal'],
            'gastEfect'      => ['required' => false, 'type' => 'decimal'],
            'ventEfect'      => ['required' => false, 'type' => 'decimal'],
            'ventTransf'     => ['required' => false, 'type' => 'decimal'],
            'ventNetTar'     => ['required' => false, 'type' => 'decimal'],
            'depPlatf'       => ['required' => false, 'type' => 'decimal'],
            'nomPlatf'       => ['required' => false, 'type' => 'string'],
            'reparUtil'      => ['required' => false, 'type' => 'decimal'],
            'ub'             => ['required' => false, 'type' => 'decimal'],
            'did'            => ['required' => false, 'type' => 'decimal'],
            'rap'            => ['required' => false, 'type' => 'decimal'],
            'totGF'          => ['required' => false, 'type' => 'decimal']
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
        $cleanData = DataHelper::setDecimalDefaults($cleanData, $rules);

        // Check for duplicate date
        if (RecordHelper::exists('daily_balance', 'date', $cleanData['date'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe un balance con esa fecha'
            ]);
            return;
        }

        // Prepara datos para el cálculo automático
        $inputForCalc = [
            'cash_expenses'     => $cleanData['gastEfect'] ?? 0,
            'cash_sales'        => $cleanData['ventEfect'] ?? 0,
            'transfer_sales'    => $cleanData['ventTransf'] ?? 0,
            'net_card_sales'    => $cleanData['ventNetTar'] ?? 0,
            'platform_deposits' => $cleanData['depPlatf'] ?? 0,
            'platform_name'     => $cleanData['nomPlatf'] ?? '',
            'profit_sharing'    => $cleanData['reparUtil'] ?? 0,
            'uber'              => $cleanData['ub'] ?? 0,
            'didi'              => $cleanData['did'] ?? 0,
            'rappi'             => $cleanData['rap'] ?? 0,
            'tot_fixed_exp'     => $cleanData['totGF'] ?? 0
        ];

        $calculations = BalanceHelper::calculate($inputForCalc);

        // Combina los datos originales con los cálculos
        $insertData = array_merge(
            ['date' => $cleanData['date']],
            ['closing_cash' => $cleanData['efectivoCierre']],
            $inputForCalc,
            $calculations
        );

        // Mapea nombres del frontend a nombres reales de columnas en la base de datos
        $map = [
            'gastEfect'      => 'cash_expenses',
            'ventEfect'      => 'cash_sales',
            'ventTransf'     => 'transfer_sales',
            'ventNetTar'     => 'net_card_sales',
            'depPlatf'       => 'platform_deposits',
            'nomPlatf'       => 'platform_name',
            'reparUtil'      => 'profit_sharing',
            'ub'             => 'uber',
            'did'            => 'didi',
            'rap'            => 'rappi',
            'totGF'          => 'tot_fixed_exp'
        ];

        foreach ($map as $oldKey => $newKey) {
            if (isset($cleanData[$oldKey])) {
                $insertData[$newKey] = $cleanData[$oldKey];
            }
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
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $validator = new Validator();

        $rules = [
            'date'           => ['required' => true, 'type' => 'date'],
            'efectivoCierre' => ['required' => false, 'type' => 'decimal'],
            'gastEfect'      => ['required' => false, 'type' => 'decimal'],
            'ventEfect'      => ['required' => false, 'type' => 'decimal'],
            'ventTransf'     => ['required' => false, 'type' => 'decimal'],
            'ventNetTar'     => ['required' => false, 'type' => 'decimal'],
            'depPlatf'       => ['required' => false, 'type' => 'decimal'],
            'nomPlatf'       => ['required' => false, 'type' => 'string'],
            'reparUtil'      => ['required' => false, 'type' => 'decimal'],
            'ub'             => ['required' => false, 'type' => 'decimal'],
            'did'            => ['required' => false, 'type' => 'decimal'],
            'rap'            => ['required' => false, 'type' => 'decimal'],
            'totGF'          => ['required' => false, 'type' => 'decimal']
        ];

        if (!$validator->validate($data, $rules)) {
            echo json_encode(['status' => 'error', 'message' => 'Error de validación', 'errors' => $validator->errors()]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);
        $cleanData = DataHelper::setDecimalDefaults($cleanData, $rules);

        // Check for duplicate date (excluding current record)
        if (RecordHelper::exists('daily_balance', 'date', $cleanData['date'], $id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ya existe otro balance con esa fecha'
            ]);
            return;
        }

        // Prepara datos para cálculos
        $inputForCalc = [
            'cash_expenses'     => $cleanData['gastEfect'] ?? 0,
            'cash_sales'        => $cleanData['ventEfect'] ?? 0,
            'transfer_sales'    => $cleanData['ventTransf'] ?? 0,
            'net_card_sales'    => $cleanData['ventNetTar'] ?? 0,
            'platform_deposits' => $cleanData['depPlatf'] ?? 0,
            'platform_name'     => $cleanData['nomPlatf'] ?? '',
            'profit_sharing'    => $cleanData['reparUtil'] ?? 0,
            'uber'              => $cleanData['ub'] ?? 0,
            'didi'              => $cleanData['did'] ?? 0,
            'rappi'             => $cleanData['rap'] ?? 0,
            'tot_fixed_exp'     => $cleanData['totGF'] ?? 0
        ];

        $calculations = BalanceHelper::calculate($inputForCalc);

        $updateData = array_merge(
            [
                'id'                => $id,
                'date'              => $cleanData['date'],
                'closing_cash'      => $cleanData['efectivoCierre'],
                'cash_expenses'     => $cleanData['gastEfect'],
                'cash_sales'        => $cleanData['ventEfect'],
                'transfer_sales'    => $cleanData['ventTransf'],
                'net_card_sales'    => $cleanData['ventNetTar'],
                'platform_deposits' => $cleanData['depPlatf'],
                'platform_name'     => $cleanData['nomPlatf'],
                'profit_sharing'    => $cleanData['reparUtil'],
                'uber'              => $cleanData['ub'],
                'didi'              => $cleanData['did'],
                'rappi'             => $cleanData['rap'],
                'tot_fixed_exp'     => $cleanData['totGF']
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

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            return;
        }

        if (!is_numeric($id)) {
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
