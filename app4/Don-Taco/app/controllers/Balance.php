<?php

namespace App\controllers;

use App\Libraries\Controller;

class Balance extends Controller
{
    public function __construct()
    {
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
