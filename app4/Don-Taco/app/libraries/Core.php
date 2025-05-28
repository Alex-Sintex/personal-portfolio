<?php

namespace App\Libraries;

class Core
{
    protected $controllerActual = 'App\controllers\Main';
    protected $methodActual = 'index';
    protected $parameters = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if (!empty($url)) {
            // Use ucfirst for class names if controllers use PascalCase
            $controllerName = 'App\\Controllers\\' . ucfirst($url[0]);
            if (class_exists($controllerName)) {
                $this->controllerActual = $controllerName;
                unset($url[0]);
            }
        }

        // Instantiate controller
        $this->controllerActual = new $this->controllerActual;

        // Check method
        if (isset($url[1]) && method_exists($this->controllerActual, $url[1])) {
            $this->methodActual = $url[1];
            unset($url[1]);
        }

        // Parameters
        $this->parameters = $url ? array_values($url) : [];

        // Call method with parameters
        call_user_func_array([$this->controllerActual, $this->methodActual], $this->parameters);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
