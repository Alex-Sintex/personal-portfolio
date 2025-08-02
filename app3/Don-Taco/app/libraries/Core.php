<?php

namespace App\Libraries;

use App\Controllers\Dashboard;
use App\Controllers\Errors;

class Core
{
    // Main page Dashboard controller
    protected string $controllerClass = Dashboard::class;
    protected object $controllerActual;
    protected string $methodActual = 'index';
    protected array $parameters = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Controller resolution
        if (!empty($url)) {
            $controllerName = 'App\\Controllers\\' . ucfirst($url[0]);

            if (class_exists($controllerName)) {
                $this->controllerClass = $controllerName;
                unset($url[0]);
            } else {
                return $this->loadErrorPage();
            }
        }

        // Instantiate controller
        $this->controllerActual = new $this->controllerClass;

        // Method resolution
        if (isset($url[1])) {
            if (method_exists($this->controllerActual, $url[1])) {
                $this->methodActual = $url[1];
                unset($url[1]);
            } else {
                return $this->loadErrorPage();
            }
        }

        // Parameters
        $this->parameters = $url ? array_values($url) : [];

        // Call the method
        call_user_func_array([$this->controllerActual, $this->methodActual], $this->parameters);
    }

    private function getUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    private function loadErrorPage(): void
    {
        $errorController = new Errors();
        $errorController->notFound();
    }
}
