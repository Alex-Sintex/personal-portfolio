<?php
// Get requested URI path (e.g., /balance.php or /style.css)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize path to prevent directory traversal
$path = ltrim($path, '/');
$allowedPages = ['gastos_diarios.php', 'balance.php']; // Add allowed .php files here

// Only allow access to allowed PHP pages
if (in_array($path, $allowedPages)) {
    include $path;
    exit;
}

// If it's empty (root /), load default page
if ($path === '' || $path === 'index.php') {
    include 'gastos_diarios.php';
    exit;
}

// For everything else: deny access or show 404
http_response_code(403); // Or use 404 if you prefer
echo 'Access Denied.';
exit;
?>
