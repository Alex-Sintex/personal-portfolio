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
            'loadJQueryLibrary' => true,    // JS
            'loadScriptSideBar' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesGD' => true,     // JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
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

    // Insert new record
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
            'carne'              => ['required' => true, 'type' => 'decimal'],
            'queso'              => ['required' => true, 'type' => 'decimal'],
            'tortilla_maiz'      => ['required' => true, 'type' => 'decimal'],
            'tortilla_hna_gde'   => ['required' => true, 'type' => 'decimal'],
            'longaniza'          => ['required' => true, 'type' => 'decimal'],
            'pan'                => ['required' => true, 'type' => 'decimal'],
            'vinagre'            => ['required' => true, 'type' => 'decimal'],
            'bodegon'            => ['required' => true, 'type' => 'decimal'],
            'adel_marcos'        => ['required' => true, 'type' => 'decimal'],
            'trans_marcos'       => ['required' => true, 'type' => 'decimal'],
            'nomina'             => ['required' => true, 'type' => 'decimal'],
            'nomina_weekend'     => ['required' => true, 'type' => 'decimal'],
            'mundi_novi'         => ['required' => true, 'type' => 'decimal'],
            'color'              => ['required' => true, 'type' => 'decimal'],
            'otros'              => ['required' => true, 'type' => 'decimal'],
            'observaciones'      => ['required' => false, 'type' => 'string', 'max' => 100],
            'totalGD'            => ['required' => true, 'type' => 'decimal']
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

        $validator = new Validator();

        $rules = [
            'carne'              => ['required' => true, 'type' => 'decimal'],
            'queso'              => ['required' => true, 'type' => 'decimal'],
            'tortilla_maiz'      => ['required' => true, 'type' => 'decimal'],
            'tortilla_hna_gde'   => ['required' => true, 'type' => 'decimal'],
            'longaniza'          => ['required' => true, 'type' => 'decimal'],
            'pan'                => ['required' => true, 'type' => 'decimal'],
            'vinagre'            => ['required' => true, 'type' => 'decimal'],
            'bodegon'            => ['required' => true, 'type' => 'decimal'],
            'adel_marcos'        => ['required' => true, 'type' => 'decimal'],
            'trans_marcos'       => ['required' => true, 'type' => 'decimal'],
            'nomina'             => ['required' => true, 'type' => 'decimal'],
            'nomina_weekend'     => ['required' => true, 'type' => 'decimal'],
            'mundi_novi'         => ['required' => true, 'type' => 'decimal'],
            'color'              => ['required' => true, 'type' => 'decimal'],
            'otros'              => ['required' => true, 'type' => 'decimal'],
            'observaciones'      => ['required' => false, 'type' => 'string', 'max' => 100],
            'totalGD'            => ['required' => true, 'type' => 'decimal']
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
        $cleanData = $validator->cast($cleanData, $rules);

        // ✅ Calculate totalGD from provided fields
        $totalGD = $this->calculateTotalGD($cleanData);

        // ✅ Prepare insert data
        $insertData = [
            // Left side values are table name columns
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

        $result = $this->modelGastosD->deleteDailyExp($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => '¡Registro eliminado!']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => '¡Error al eliminar el registro!']);
        }
    }
}
