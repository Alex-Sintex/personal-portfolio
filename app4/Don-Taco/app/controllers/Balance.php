<?php
// Class Balance extends the main controller
class Balance extends Controller {
    public function index(){
        $this->view('modules/balance/balance');
    }
}