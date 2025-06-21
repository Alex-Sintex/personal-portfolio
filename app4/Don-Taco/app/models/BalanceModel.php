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

    public function getLastBalance()
    {
        $this->db->query("SELECT * FROM daily_balance ORDER BY id DESC LIMIT 1");
        return $this->db->record();
    }
}
