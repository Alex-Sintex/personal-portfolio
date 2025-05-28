<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

// Helpers y configuración (siguen cargándose manualmente)
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/helpers/url_helper.php';
require_once __DIR__ . '/../app/helpers/auth_helper.php';

use App\Libraries\Core;

$init = new Core();
