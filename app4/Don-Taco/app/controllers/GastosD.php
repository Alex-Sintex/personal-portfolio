<?php

namespace App\controllers;

use App\Libraries\Controller;
use App\helpers\Validator;
use App\Helpers\BalanceHelper;

class GastosD extends Controller
{
    private $modelGastosD;
    private $balanceModel;

    public function __construct()
    {
        requireLogin();
        $this->modelGastosD = $this->model('GastosDModel');
        $this->balanceModel = $this->model('BalanceModel');
    }

    public function index()
    {
        $data = [
            'loadJQueryLibrary'   => true, // JS
            'loadScriptSideBar'   => true, // JS
            'loadDataTables'      => true, // JS
            'loadDataTableGD'     => true, // JS
            'loadToasty'          => true, // JS
            'loadStyles'          => true, // CSS
            'loadDataTableStyles' => true, // CSS
            'loadToastStyle'      => true  // CSS
        ];
        $this->view('modules/gastos_diarios', $data);
    }

    // Fetch info
    public function fetch()
    {
        $gastosD = $this->modelGastosD->getDailyExpensesWithDate();
        $cleaned = [];

        foreach ($gastosD as $row) {
            $cleaned[] = [
                'id' => $row->id,
                'date' => $row->date ?? date('Y-m-d'), // fallback to current date
                'carne' => $row->carne,
                'queso' => $row->queso,
                'tortilla_maiz' => $row->tortilla_maiz,
                'tortilla_hna_gde' => $row->tortilla_h_gde,
                'longaniza' => $row->longaniza,
                'pan' => $row->pan,
                'vinagre' => $row->vinagre,
                'bodegon' => $row->bodegon,
                'adel_marcos' => $row->ad_marcos,
                'trans_marcos' => $row->transp_marcos,
                'nomina' => $row->nomina,
                'nomina_weekend' => $row->nom_weekend,
                'mundi_novi' => $row->mundi_novi,
                'color' => $row->color,
                'otros' => $row->otros,
                'observaciones' => $row->obs,
                'totalGD' => $row->tot_gto_diarios
            ];
        }

        echo json_encode($cleaned);
    }

    private function calculateTotalGD(array $data, array $exclude = ['observaciones', 'totalGD'])
    {
        $total = 0;

        foreach ($data as $key => $value) {
            if (!in_array($key, $exclude) && is_numeric($value)) {
                $total += (float) $value;
            }
        }

        return $total;
    }

    // Insert new record for daily expense
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
            'carne'              => ['required' => false, 'type' => 'decimal'],
            'queso'              => ['required' => false, 'type' => 'decimal'],
            'tortilla_maiz'      => ['required' => false, 'type' => 'decimal'],
            'tortilla_hna_gde'   => ['required' => false, 'type' => 'decimal'],
            'longaniza'          => ['required' => false, 'type' => 'decimal'],
            'pan'                => ['required' => false, 'type' => 'decimal'],
            'vinagre'            => ['required' => false, 'type' => 'decimal'],
            'bodegon'            => ['required' => false, 'type' => 'decimal'],
            'adel_marcos'        => ['required' => false, 'type' => 'decimal'],
            'trans_marcos'       => ['required' => false, 'type' => 'decimal'],
            'nomina'             => ['required' => false, 'type' => 'decimal'],
            'nomina_weekend'     => ['required' => false, 'type' => 'decimal'],
            'mundi_novi'         => ['required' => false, 'type' => 'decimal'],
            'color'              => ['required' => false, 'type' => 'decimal'],
            'otros'              => ['required' => false, 'type' => 'decimal'],
            'observaciones'      => ['required' => false, 'type' => 'string', 'max' => 100],
            'totalGD'            => ['required' => false, 'type' => 'decimal']
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
        $totalGD = $this->calculateTotalGD($cleanData);

        // ✅ Get the latest balance record
        $lastBalance = $this->balanceModel->getLastBalance();

        if (!$lastBalance) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'No hay balances disponibles para asociar este gasto.']);
            return;
        }

        // ✅ Prevent duplicate expense per balance
        if ($this->modelGastosD->existsExpenseForBalance($lastBalance->id)) {
            http_response_code(409);
            echo json_encode(['status' => 'error', 'message' => 'Ya existe un gasto diario asociado a este balance.']);
            return;
        }

        // ✅ Insert expense
        $insertData = [
            'carne'           => $cleanData['carne'],
            'queso'           => $cleanData['queso'],
            'tortilla_maiz'   => $cleanData['tortilla_maiz'],
            'tortilla_h_gde'  => $cleanData['tortilla_hna_gde'],
            'longaniza'       => $cleanData['longaniza'],
            'pan'             => $cleanData['pan'],
            'vinagre'         => $cleanData['vinagre'],
            'bodegon'         => $cleanData['bodegon'],
            'ad_marcos'       => $cleanData['adel_marcos'],
            'transp_marcos'   => $cleanData['trans_marcos'],
            'nomina'          => $cleanData['nomina'],
            'nom_weekend'     => $cleanData['nomina_weekend'],
            'mundi_novi'      => $cleanData['mundi_novi'],
            'color'           => $cleanData['color'],
            'otros'           => $cleanData['otros'],
            'obs'             => $cleanData['observaciones'],
            'tot_gto_diarios' => $totalGD,
            'balance_id'      => $lastBalance->id
        ];

        $result = $this->modelGastosD->addDailyExp($insertData);

        if ($result) {
            // Recalculate updated values using BalanceHelper
            $rawBalanceData = (array) $lastBalance;
            $updatedCalculations = BalanceHelper::calculate($rawBalanceData);

            // Add the balance ID for update WHERE clause
            $updatedCalculations['id'] = $lastBalance->id;

            // Update the balance record with new calculations
            $updateSuccess = $this->balanceModel->updateBalanceCalculations($updatedCalculations);

            if (!$updateSuccess) {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el balance con los nuevos cálculos']);
                return;
            }

            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro de gasto añadido y balance actualizado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al añadir el gasto!']);
        }
    }

    // Update record for daily expense
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
            'carne'              => ['required' => false, 'type' => 'decimal'],
            'queso'              => ['required' => false, 'type' => 'decimal'],
            'tortilla_maiz'      => ['required' => false, 'type' => 'decimal'],
            'tortilla_hna_gde'   => ['required' => false, 'type' => 'decimal'],
            'longaniza'          => ['required' => false, 'type' => 'decimal'],
            'pan'                => ['required' => false, 'type' => 'decimal'],
            'vinagre'            => ['required' => false, 'type' => 'decimal'],
            'bodegon'            => ['required' => false, 'type' => 'decimal'],
            'adel_marcos'        => ['required' => false, 'type' => 'decimal'],
            'trans_marcos'       => ['required' => false, 'type' => 'decimal'],
            'nomina'             => ['required' => false, 'type' => 'decimal'],
            'nomina_weekend'     => ['required' => false, 'type' => 'decimal'],
            'mundi_novi'         => ['required' => false, 'type' => 'decimal'],
            'color'              => ['required' => false, 'type' => 'decimal'],
            'otros'              => ['required' => false, 'type' => 'decimal'],
            'observaciones'      => ['required' => false, 'type' => 'string', 'max' => 100],
            'totalGD'            => ['required' => false, 'type' => 'decimal']
        ];

        if (!$validator->validate($data, $rules)) {
            http_response_code(422);
            echo json_encode(['status' => 'error', 'message' => 'Error de validación', 'errors' => $validator->errors()]);
            return;
        }

        $cleanData = $validator->sanitizeAndCast($data, $rules);
        $totalGD = $this->calculateTotalGD($cleanData);

        $insertData = [
            'id'                 => $id,
            'carne'              => $cleanData['carne'],
            'queso'              => $cleanData['queso'],
            'tortilla_maiz'      => $cleanData['tortilla_maiz'],
            'tortilla_h_gde'     => $cleanData['tortilla_hna_gde'],
            'longaniza'          => $cleanData['longaniza'],
            'pan'                => $cleanData['pan'],
            'vinagre'            => $cleanData['vinagre'],
            'bodegon'            => $cleanData['bodegon'],
            'ad_marcos'          => $cleanData['adel_marcos'],
            'transp_marcos'      => $cleanData['trans_marcos'],
            'nomina'             => $cleanData['nomina'],
            'nom_weekend'        => $cleanData['nomina_weekend'],
            'mundi_novi'         => $cleanData['mundi_novi'],
            'color'              => $cleanData['color'],
            'otros'              => $cleanData['otros'],
            'obs'                => $cleanData['observaciones'],
            'tot_gto_diarios'    => $totalGD
        ];

        $result = $this->modelGastosD->updateDailyExp($insertData);

        if ($result) {
            // ✅ Recalcular balance asociado
            $previousBalance = $this->balanceModel->getLastBalance();
            if ($previousBalance) {
                $updated = BalanceHelper::calculate((array) $previousBalance);
                $updated['id'] = $previousBalance->id;
                $this->balanceModel->updateBalanceCalculations($updated);
            }

            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro actualizado y balance recalculado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al actualizar el registro!']);
        }
    }

    // Delete record for daily expense
    public function delete($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        // ✅ Get balance before deletion
        $balance = $this->balanceModel->getLastBalance();

        $result = $this->modelGastosD->deleteDailyExp($id);

        if ($result) {
            // ✅ Recalcular balance si existe
            if ($balance) {
                $recalculated = BalanceHelper::calculate((array) $balance);
                $recalculated['id'] = $balance->id;
                $this->balanceModel->updateBalanceCalculations($recalculated);
            }

            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado y balance actualizado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
