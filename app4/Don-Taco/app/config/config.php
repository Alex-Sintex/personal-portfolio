<?php

// Path of the application
define('PATH_APP', dirname(dirname(__FILE__)));

// Check if running on HTTP or HTTPS
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Get the server domain and port
$serverDomain = $_SERVER['HTTP_HOST'];

// Get the base path
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Define the base URL
define('PATH_URL', $protocol . '://' . $serverDomain . $basePath . '/');

// Define the website name
define('WEBSITE', 'Don-Taco');
