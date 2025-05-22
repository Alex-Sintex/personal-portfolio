<?php

// Class main controller
// It's in charge for loading the model and view

class Controller
{

    // Load the model
    public function model($model)
    {
        // Load
        require_once '../app/models/' . $model . '.php';
        // Instantiate the model
        return new $model();
    }

    // Load the view
    public function view($view, $data = [])
    {
        // Check if file view exists
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // If the view does not exist, show 404 error
            $this->view('errors/404');
        }
    }
}
