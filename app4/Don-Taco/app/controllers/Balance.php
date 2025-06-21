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
            'loadDataTablesBalance' => true,
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

    public function insert()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        // Reglas de validación
        $rules = [
            'date'       => ['required' => true, 'type' => 'date'],
            'gastEfect'  => ['required' => true, 'type' => 'decimal'],
            'ventEfect'  => ['required' => true, 'type' => 'decimal'],
            'ventTransf' => ['required' => true, 'type' => 'decimal'],
            'ventNetTar' => ['required' => true, 'type' => 'decimal'],
            'depPlatf'   => ['required' => true, 'type' => 'decimal'],
            'nomPlatf'   => ['required' => false, 'type' => 'string'],
            'reparUtil'  => ['required' => true, 'type' => 'decimal'],
            'ub'         => ['required' => true, 'type' => 'decimal'],
            'did'        => ['required' => true, 'type' => 'decimal'],
            'rap'        => ['required' => true, 'type' => 'decimal'],
            'totGF'      => ['required' => true, 'type' => 'decimal'],
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

    // Update record
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

    // Delete record
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
