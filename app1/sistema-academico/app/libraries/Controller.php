<?php

// Main class controller
// It's in charge for loading the model and view
class Controller {

    // Load model
    public function loadModel($model){
        // Load
        require_once '../app/models/' . $model . '.php';

        // Instanciate the model
        return new $model();
    }

    // Load view
    public function view($view, $data = []){
        // Check if file view exists
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        }else{
            // If the view file doesn't exist
            $this->view('error/error-404');
        }
    }
}