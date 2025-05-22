<?php
// Class Balance extends the main controller
class GastosD extends Controller
{
    public function index()
    {
        $data = [
            'loadDataTables' => true,       // JS
            'loadToasty' => true,           // JS
            'loadDataTablesGD' => true,     // JS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
        ];
        $this->view('modules/gastos_diarios', $data);
    }
}