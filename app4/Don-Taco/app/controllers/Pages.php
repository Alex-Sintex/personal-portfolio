<?php
// Class Pages extends the main controller
class Pages extends Controller
{
    public function __construct()
    {
        //echo 'Pages controller loaded';
    }

    public function index()
    {
        /*$data = [
            'title' => 'Welcome to Don-Taco MVC'
        ];*/

        $this->view('home/dashboard');
    }
}
