<?php

namespace App\Libraries;

use App\Exceptions\ModelNotFoundException;

class Controller
{
    // Load a model
    public function model($model)
    {
        $modelClass = 'App\\Models\\' . $model;
        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            throw new ModelNotFoundException($modelClass);
        }
    }

    // Load a view
    public function view($view, $data = [])
    {
        $viewFile = '../app/views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            // If view is missing, fallback to error view
            $errorView = '../app/views/errors/404.php';
            if (file_exists($errorView)) {
                require_once $errorView;
            } else {
                echo "404 View not found";
            }
        }
    }
}
