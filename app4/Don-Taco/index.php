<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize
$path = trim($path, '/');

// Redirect if the user is accessing Don-Taco folder directly
if ($path === 'app4/Don-Taco' || $path === 'app4/Don-Taco/') {
    header("Location: /app4/Don-Taco/balance.php");
    exit;
}

// Only allow access to these pages
$allowedPages = ['app4/Don-Taco/gastos_diarios.php', 'app4/Don-Taco/balance.php'];

if (in_array($path, $allowedPages)) {
    include __DIR__ . '/' . $path;
    exit;
}

// Otherwise, block
http_response_code(403);
echo 'Access Denied.';
exit;
?>