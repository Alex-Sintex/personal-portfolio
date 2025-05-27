<?php

class Balance extends Controller
{
    //private $modelBalance;

    public function __construct()
    {
<<<<<<< HEAD
=======
        requireLogin();
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
        //$this->modelBalance = $this->model('Balance');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
            'loadJQueryLibrary' => true,    // JS
            'loadDataTables' => true,       // JS
            'loadDataTablesBalance' => true,// JS
            'loadToasty' => true,           // JS
            'loadStyles' => true,           // CSS
            'loadDataTableStyles' => true,  // CSS
            'loadToastStyle' => true        // CSS
        ];
        $this->view('modules/balance', $data);
    }
}
