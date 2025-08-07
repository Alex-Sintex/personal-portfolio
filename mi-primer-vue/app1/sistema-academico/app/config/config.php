<?php

// Check if running on HTTP or HTTPS
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the server domain and port
$serverDomain = $_SERVER['HTTP_HOST'];

// Get the base path
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Define the base URL
define('BASE_URL', $protocol . '://' . $serverDomain . $basePath . '/');

// Set session timeout to 30 minutes
//ini_set('session.gc_maxlifetime', 1800);

// Set the cookie lifetime to match the session lifetime
//ini_set('session.cookie_lifetime', 1800);

// Configuration of database access
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '@Alex4976');
define('DB_NAME', 'sistema_academico');

// Path of application
define('PATH_APP', dirname(dirname(__FILE__)));
// Define the constant with the full file path for word template
define('WORD_TEMPLATE', '/Users/al3x/Sites/sistema-academico/public/template/F-DC-15.docx');
define('ACTA_TEMPLATE', '/Users/al3x/Sites/sistema-academico/public/template/acta_template.docx');

// Define a custom name for tab in the website
define('LOGIN', 'Login');
define('REGISTER', 'Register');
define('ERROR', 'Error page');
