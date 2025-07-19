<?php

namespace App\helpers;

use App\models\GastosDModel;

class BalanceHelper
{
    /**
     * Calculate derived fields for balance from given raw input.
     * Auto-fetches totGD (gastos diarios) and utilidad_disponible_ant (last available profit)
     */
    public static function calculate(array $data): array
    {
        $expModel = new GastosDModel();

        // ✅ Obtener el balance anterior (OFFSET 1)
        $prevBalance = $expModel->getPreviousBalance(); // nuevo método
        $utilidadDisponibleAnt = isset($prevBalance->available_profit)
            ? $prevBalance->available_profit
            : 0;

        // ✅ Obtener el balance actual (último) para el cálculo del gasto diario
        $lastBalance = $expModel->getLastRecord();
        $totGD = 0;
        if ($lastBalance && isset($lastBalance->id)) {
            $totGD = $expModel->getTotalGDByBalanceId($lastBalance->id);
        }

        // Extracción de datos como ya tenías
        //$cashExpenses     = (float) ($data['cash_expenses']     ?? 0);
        $cashSales        = (float) ($data['cash_sales']        ?? 0);
        $netCardSales     = (float) ($data['net_card_sales']    ?? 0);
        $transferSales    = (float) ($data['transfer_sales']    ?? 0);
        $platformDeposits = (float) ($data['platform_deposits'] ?? 0);
        $profitSharing    = (float) ($data['profit_sharing']    ?? 0);
        $uber             = (float) ($data['uber']              ?? 0);
        $didi             = (float) ($data['didi']              ?? 0);
        $rappi            = (float) ($data['rappi']             ?? 0);
        $totFixedExp      = (float) ($data['tot_fixed_exp']     ?? 0);

        // Cálculos
        $ventaTarjeta       = $netCardSales * 0.9651;
        $totalIngresos      = $transferSales + $ventaTarjeta + $cashSales;
        $utilidadPiso       = $totalIngresos + $platformDeposits;
        $utilidadPlataforma = ($uber + $didi + $rappi) / 2;
        $totalEgresos       = $totFixedExp + $totGD;
        $utilidadNeta       = ($utilidadPiso + $utilidadPlataforma) - $totalEgresos;
        //$efectivoCierre     = $cashSales - $cashExpenses;
        $utilidadDisponible = ($utilidadPiso + $utilidadDisponibleAnt) - ($profitSharing + $totFixedExp + $totGD);
        $totalPlataformas   = $uber + $didi + $rappi;

        return [
            'total_expenses'       => round($totalEgresos, 2),
            'card_sales_percent'   => round($ventaTarjeta, 2),
            'total_income'         => round($totalIngresos, 2),
            'floor_profit'         => round($utilidadPiso, 2),
            'platform_net_profit'  => round($utilidadPlataforma, 2),
            'net_profit'           => round($utilidadNeta, 2),
            //'closing_cash'         => round($efectivoCierre, 2),
            'available_profit'     => round($utilidadDisponible, 2),
            'total_platforms'      => round($totalPlataformas, 2)
        ];
    }
}
