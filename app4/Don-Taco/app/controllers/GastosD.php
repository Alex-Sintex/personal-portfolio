<?php
// Class Balance extends the main controller
class GastosD extends Controller
{
    public function __construct()
    {
        requireLogin();
    }

    public function index()
    {
        $data = [
            'loadJQueryLibrary' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesGD' => true,     // JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
        ];
        $this->view('modules/gastos_diarios', $data);
    }
}
