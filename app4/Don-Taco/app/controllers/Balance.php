<?php

class Balance extends Controller
{
    //private $modelBalance;

    public function __construct()
    {
        //$this->modelBalance = $this->model('Balance');
    }

    // Load balance view with required resources
    public function index()
    {
        $data = [
            'loadDataTables' => true,
            'loadDataTablesBalance' => true,
            'loadToasty' => true,
            'loadDataTableStyles' => true,
            'loadToastStyle' => true
        ];
        $this->view('modules/balance', $data);
    }
}
