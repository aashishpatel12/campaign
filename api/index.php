<?php
// Suppress PHP 8.4+ deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED);

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// --- VERCEL SPECIFIC FIXES ---
// Vercel apps are read-only except for the /tmp directory.
// We must redirect storage and cache directories to /tmp so Laravel doesn't crash trying to write logs or views.
$app->useStoragePath('/tmp/storage');
$app->useBootstrapDirectory('/tmp/bootstrap');

// Create the necessary temporary directories so Laravel doesn't complain they are missing
$paths = [
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache'
];

foreach ($paths as $path) {
    if (!is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}
// -----------------------------

// Handle request
$app->handleRequest(Illuminate\Http\Request::capture());
