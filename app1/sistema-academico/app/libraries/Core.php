<?php
// Map the URL entered in the browser (Routing mechanism)

class Core {
    protected $ActualController = 'pages';
    protected $Actualmethod = 'index';
    protected $parameters = [];

    public function __construct() {
        $url = $this->getUrl();

        // Search in controllers if controller exists
        if (!empty($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->ActualController = ucwords($url[0]);
            unset($url[0]);
        }

        require_once('../app/controllers/' . $this->ActualController . '.php');

        $this->ActualController = new $this->ActualController;

        // Check the second part of the URL that would be the method
        if (isset($url[1])) {
            if (method_exists($this->ActualController, $url[1])) {
                $this->Actualmethod = $url[1];
                unset($url[1]);
            } else {
                // Method doesn't exist, redirect to errorPage
                $this->Actualmethod = 'errorPage';
            }
        }

        // Get possible parameters
        $this->parameters = $url ? array_values($url) : [];

        // Call the callback with parameters
        call_user_func_array([$this->ActualController, $this->Actualmethod], $this->parameters);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return []; // safer to return an empty array if no URL is set
    }
}