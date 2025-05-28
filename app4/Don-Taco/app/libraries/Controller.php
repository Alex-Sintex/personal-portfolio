<?php
namespace App\Libraries;

use App\exceptions\ModelNotFoundException;

class Controller
{
    // Load the model
    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            throw new ModelNotFoundException("Model $modelClass not found");
        }
    }

    // Load the view
    public function view($view, $data = [])
    {
        $viewFile = '../app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // View not found: maybe load a 404 page
            $errorView = '../app/views/errors/404.php';
            if (file_exists($errorView)) {
                require_once $errorView;
            } else {
                echo "404 View not found";
            }
        }
    }
}
