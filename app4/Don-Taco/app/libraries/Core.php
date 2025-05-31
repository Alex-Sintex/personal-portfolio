<?php

namespace App\Libraries;

class Core
{
    protected $controllerActual = 'App\\Controllers\\Main';
    protected $methodActual = 'index';
    protected $parameters = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Get controller
        if (!empty($url)) {
            $controllerName = 'App\\Controllers\\' . ucfirst($url[0]);

            if (class_exists($controllerName)) {
                $this->controllerActual = $controllerName;
                unset($url[0]);
            } else {
                $this->loadErrorPage();
                return;
            }
        }

        // Instantiate controller
        $this->controllerActual = new $this->controllerActual;

        // Get method
        if (isset($url[1])) {
            if (method_exists($this->controllerActual, $url[1])) {
                $this->methodActual = $url[1];
                unset($url[1]);
            } else {
                $this->loadErrorPage();
                return;
            }
        }

        // Get parameters
        $this->parameters = $url ? array_values($url) : [];

        // Call the method with parameters
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

    private function loadErrorPage()
    {
        // Use a controller to show the 404 view
        $errorController = new \App\Controllers\Errors();
        $errorController->notFound();
    }
}
