<?php
// Auth.php — Controller for login, registration, logout, etc.

namespace App\controllers;

use App\Libraries\Controller;

class Users extends Controller
{
    private $usersModel;

    public function __construct()
    {
        //$this->usersModel = $this->model('UsersModel');
    }

    // Show login view
    public function index()
    {
        /*
        $data = [
            'loadStyleforAuth' => true, // CSS
            'loadJSLogin' => true       // JS
        ];*/

        $this->view('modules/users');
    }

    // Stub: register user
    /*public function register()
    {
        // To be implemented
    }*/

    // Stub: forgot password logic
    /*public function forgotPassword()
    {
        // To be implemented
    }*/
}
