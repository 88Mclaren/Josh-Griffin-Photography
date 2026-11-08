<?php
declare(strict_types=1);

/*
 * Update these settings for your hosting environment.
 * Prefer environment variables in production.
 */
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'josh_griffin_photography');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('BASE_URL', getenv('BASE_URL') ?: ''); // Example: https://example.com (no trailing slash)
define('UPLOAD_DIR', dirname(__DIR__) . '/jgp-private-uploads');
define('MAX_UPLOAD_BYTES', 15 * 1024 * 1024); // 15 MB per photo

if (session_status() !== PHP_SESSION_ACTIVE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'secure' => $secure,
        'httponly' => true, 'samesite' => 'Lax'
    ]);
    session_start();
}

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
