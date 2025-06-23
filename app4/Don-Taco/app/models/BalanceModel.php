<?php

namespace App\models;

use App\Libraries\Base;

class BalanceModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Base();
    }

    // ✅ Retorna resumen semanal de ingresos (últimas 5 semanas)
    public function getWeeklyIncomeSummary()
    {
        $this->db->query("
        SELECT 
            YEAR(date) AS year,
            WEEK(date, 1) AS week_number,
            date AS end_of_week,
            total_income
        FROM daily_balance
        WHERE total_income IS NOT NULL
        ORDER BY date ASC
        LIMIT 5
    ");

        return $this->db->records();
    }

    public function getBalanceInfo()
    {
        $this->db->query("SELECT * FROM daily_balance");
        return $this->db->records();
    }

    public function getBalanceCal()
    {
        $this->db->query("
        SELECT 
            net_profit,
            total_expenses,
            closing_cash,
            card_sales_percent,
            total_income,
            floor_profit,
            available_profit,
            total_platforms,
            platform_net_profit
        FROM daily_balance
    ");
        return $this->db->records();
    }

    public function addBalance($data)
    {
        // Remove invalid keys
        $data = array_filter($data, fn($key) => $key !== '', ARRAY_FILTER_USE_KEY);

        $this->db->insert('daily_balance', $data);
        return $this->lastInsertId();
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function updateBalanceCalculations($data)
    {
        $sql = "UPDATE daily_balance SET 
            net_profit = :net_profit,
            total_expenses = :total_expenses,
            closing_cash = :closing_cash,
            card_sales_percent = :card_sales_percent,
            total_income = :total_income,
            floor_profit = :floor_profit,
            available_profit = :available_profit,
            total_platforms = :total_platforms,
            platform_net_profit = :platform_net_profit
            WHERE id = :id";

        $this->db->query($sql);

        foreach ($data as $key => $val) {
            $this->db->bind(":" . $key, $val);
        }

        return $this->db->execute();
    }

    public function updateBalance($data)
    {
        $sql = "UPDATE daily_balance SET 
        date = :date,
        cash_expenses = :cash_expenses,
        cash_sales = :cash_sales,
        transfer_sales = :transfer_sales,
        net_card_sales = :net_card_sales,
        platform_deposits = :platform_deposits,
        platform_name = :platform_name,
        profit_sharing = :profit_sharing,
        uber = :uber,
        didi = :didi,
        rappi = :rappi,
        tot_fixed_exp = :tot_fixed_exp,
        total_expenses = :total_expenses,
        card_sales_percent = :card_sales_percent,
        total_income = :total_income,
        floor_profit = :floor_profit,
        platform_net_profit = :platform_net_profit,
        net_profit = :net_profit,
        closing_cash = :closing_cash,
        available_profit = :available_profit,
        total_platforms = :total_platforms
        WHERE id = :id";

        $this->db->query($sql);

        foreach ($data as $key => $val) {
            $this->db->bind(":" . $key, $val);
        }

        return $this->db->execute();
    }

    public function deleteBalance($id)
    {
        return $this->db->delete('daily_balance', 'id = :id', ['id' => $id]);
    }

    public function getLastBalance()
    {
        $this->db->query("SELECT * FROM daily_balance ORDER BY id DESC LIMIT 1");
        return $this->db->record();
    }
}
