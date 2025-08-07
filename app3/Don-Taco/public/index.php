<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

// Helpers y configuración (siguen cargándose manualmente)
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/helpers/url_helper.php';
require_once __DIR__ . '/../app/helpers/auth_helper.php';
require_once __DIR__ . '/../app/helpers/Validator.php';

use App\Libraries\Core;
use Dotenv\Dotenv;

// ✅ Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Support direct token link (e.g., /verify?token=abc123)
// Rewrite 'verify?token=abc123' to hit Verification controller
if (isset($_GET['url']) && $_GET['url'] === 'verify') {
    $_GET['url'] = 'verification';
}

// ✅ Start the app
$init = new Core();
