<?php
// Map the URL entered in the browser (Routing mechanism)
/*
Mapping of the URL entered to the browser
1. Controller
2. Method
3. Parameters
Example: /articles/update/1
*/

class Core
{
    protected $controllerActual = 'pages';
    protected $methodActual = 'index';
    protected $parameters = [];

    // Constructor
    public function __construct()
    {
        $url = $this->getUrl();

        // Search for the controller if it exists
        if (!empty($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if exists then set the controller by default
            $this->controllerActual = ucwords($url[0]);

            // Unset with index 0
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/' . $this->controllerActual . '.php';
        $this->controllerActual = new $this->controllerActual;

        // Check the second part of the URL that would be the method
        if (isset($url[1])) {
            // Check if the method exists in the controller
            if (method_exists($this->controllerActual, $url[1])) {
                $this->methodActual = $url[1];
                unset($url[1]);
            }
        }

        // Get possible parameters
        $this->parameters = $url ? array_values($url) : [];

        // Call a callback with an array of parameters
        call_user_func_array([$this->controllerActual, $this->methodActual], $this->parameters);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return []; // safer to return an empty array if no URL is set
    }
}
