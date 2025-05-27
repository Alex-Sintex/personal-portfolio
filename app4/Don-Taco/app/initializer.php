<?php
// Load libraries
require_once 'config/config.php';
require_once 'helpers/url_helper.php';
<<<<<<< HEAD
=======
require_once 'helpers/auth_helper.php';
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))

// AUTOLOAD php
spl_autoload_register(function ($nameClass) {
    require_once 'libraries/' . $nameClass . '.php';
});
