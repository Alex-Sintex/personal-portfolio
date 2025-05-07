<?php
// Load libraries
require_once('config/config.php');

require_once('helpers/session_helper.php');

// Include Composer autoloader
require_once('libraries/vendor/autoload.php');

// Autoload php
spl_autoload_register(function($nameClass){
    require_once 'libraries/' . $nameClass. '.php';
});