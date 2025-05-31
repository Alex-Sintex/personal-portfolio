<?php

namespace App\Controllers;

use App\Libraries\Controller;

class Errors extends Controller
{
    public function notFound()
    {
        $this->view('errors/404');
    }
}
