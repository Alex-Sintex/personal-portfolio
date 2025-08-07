<?php

namespace App\Helpers;

class PdfTemplate
{
    /**
     * Build the HTML for the balance PDF.
     *
     * @param array $balanceData Array of objects or associative arrays with balance info.
     * @return string The HTML content.
     */
    public static function buildBalancePdf(array $balanceData): string
    {
        // Start building rows for the table
        $rows = '';

        if (!empty($balanceData)) {
            foreach ($balanceData as $row) {
                // Support both object or associative array access
                $date = htmlspecialchars(is_object($row) ? $row->date : $row['date']);
                $closing_cash = number_format(is_object($row) ? $row->closing_cash : $row['closing_cash'], 2);
                $cash_expenses = number_format(is_object($row) ? $row->cash_expenses : $row['cash_expenses'], 2);
                $cash_sales = number_format(is_object($row) ? $row->cash_sales : $row['cash_sales'], 2);
                $transfer_sales = number_format(is_object($row) ? $row->transfer_sales : $row['transfer_sales'], 2);
                $net_card_sales = number_format(is_object($row) ? $row->net_card_sales : $row['net_card_sales'], 2);
                $platform_deposits = number_format(is_object($row) ? $row->platform_deposits : $row['platform_deposits'], 2);
                $platform_name = htmlspecialchars(is_object($row) ? $row->platform_name : $row['platform_name']);
                $profit_sharing = number_format(is_object($row) ? $row->profit_sharing : $row['profit_sharing'], 2);
                $uber = number_format(is_object($row) ? $row->uber : $row['uber'], 2);
                $didi = number_format(is_object($row) ? $row->didi : $row['didi'], 2);
                $rappi = number_format(is_object($row) ? $row->rappi : $row['rappi'], 2);
                $tot_fixed_exp = number_format(is_object($row) ? $row->tot_fixed_exp : $row['tot_fixed_exp'], 2);

                $rows .= "
                    <tr>
                        <td>{$date}</td>
                        <td style='text-align:right;'>{$closing_cash}</td>
                        <td style='text-align:right;'>{$cash_expenses}</td>
                        <td style='text-align:right;'>{$cash_sales}</td>
                        <td style='text-align:right;'>{$transfer_sales}</td>
                        <td style='text-align:right;'>{$net_card_sales}</td>
                        <td style='text-align:right;'>{$platform_deposits}</td>
                        <td>{$platform_name}</td>
                        <td style='text-align:right;'>{$profit_sharing}</td>
                        <td style='text-align:right;'>{$uber}</td>
                        <td style='text-align:right;'>{$didi}</td>
                        <td style='text-align:right;'>{$rappi}</td>
                        <td style='text-align:right;'>{$tot_fixed_exp}</td>
                    </tr>
                ";
            }
        } else {
            $rows = "
                <tr>
                    <td colspan='13' style='text-align:center;'>No hay datos de balance disponibles.</td>
                </tr>
            ";
        }

        // Return full HTML document string with inline CSS styling
        return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Reporte de Balance Diario</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    margin: 20px;
                    background: #fff;
                    color: #000;
                }
                h2 {
                    text-align: center;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #ccc;
                    padding: 6px 8px;
                }
                th {
                    background-color: #f0f0f0;
                    text-align: left;
                }
                td {
                    vertical-align: middle;
                }
                td:nth-child(n+2) {
                    text-align: right;
                }
                .footer {
                    text-align: center;
                    font-size: 10px;
                    color: #555;
                    margin-top: 30px;
                }
            </style>
        </head>
        <body>
            <h2>Reporte de Balance Diario</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Efectivo Cierre</th>
                        <th>Gastos Efectivo</th>
                        <th>Ventas Efectivo</th>
                        <th>Ventas Transferencia</th>
                        <th>Ventas Netas Tarjeta</th>
                        <th>Depósitos Plataforma</th>
                        <th>Plataforma</th>
                        <th>Utilidad Repartida</th>
                        <th>Uber</th>
                        <th>Didi</th>
                        <th>Rappi</th>
                        <th>Gastos Fijos</th>
                    </tr>
                </thead>
                <tbody>
                    {$rows}
                </tbody>
            </table>
            <div class='footer'>
                Generado automáticamente el " . date('d/m/Y H:i') . "
            </div>
        </body>
        </html>
        ";
    }
}
