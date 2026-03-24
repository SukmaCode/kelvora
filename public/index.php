<?php

/**
 * ==============================================================
 * KELVORA — Front Controller
 * ==============================================================
 * 
 * All HTTP requests are routed through this single entry point.
 * 
 * Flow:
 *   1. Define constants & start session
 *   2. Autoload classes (PSR-4 style)
 *   3. Load helper functions
 *   4. Load app config
 *   5. Create Router instance
 *   6. Load route definitions
 *   7. Dispatch the request
 * 
 * Request → Router → Controller → Model → View → HTML Response
 * ==============================================================
 */

// -------------------------------------------------------------------------
// 1. Constants
// -------------------------------------------------------------------------
define('BASE_PATH', dirname(__DIR__));

// -------------------------------------------------------------------------
// 2. Session
// -------------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -------------------------------------------------------------------------
// 3. Autoloader (PSR-4 style)
// -------------------------------------------------------------------------
spl_autoload_register(function (string $class) {
    // Map namespace prefixes to base directories
    $map = [
        'Core\\'           => BASE_PATH . '/core/',
        'App\\Controllers\\'=> BASE_PATH . '/app/controllers/',
        'App\\Models\\'     => BASE_PATH . '/app/models/',
    ];

    foreach ($map as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// -------------------------------------------------------------------------
// 4. Helpers
// -------------------------------------------------------------------------
require BASE_PATH . '/core/helpers.php';

// -------------------------------------------------------------------------
// 5. App Config
// -------------------------------------------------------------------------
$appConfig = require BASE_PATH . '/config/app.php';

define('BASE_URL', rtrim($appConfig['base_url'], '/'));
define('APP_DEBUG', $appConfig['debug']);

date_default_timezone_set($appConfig['timezone']);

// Error reporting based on debug mode
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// -------------------------------------------------------------------------
// 6. Router — Load & Dispatch
// -------------------------------------------------------------------------
$router = new \Core\Router();

// Load route definitions
require BASE_PATH . '/routes/web.php';

// Dispatch the current request
$router->dispatch();
