<?php
// Load libraries
require_once 'config/config.php';

//require_once 'libraries/Base.php';
//require_once 'libraries/Controller.php';
//require_once 'libraries/Core.php';

// AUTOLOAD php
spl_autoload_register(function ($nameClass) {
    require_once 'libraries/' . $nameClass . '.php';
});
