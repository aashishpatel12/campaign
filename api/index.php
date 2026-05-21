<?php
// Suppress PHP 8.4+ deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED);

define('LARAVEL_START', microtime(true));

// Create writable directories in /tmp (Vercel's only writable path)
$tmpDirs = [
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// --- VERCEL SPECIFIC FIXES ---
// Ensure the public path is correct so Vite find the manifest
$app->bind('path.public', function() {
    return __DIR__ . '/../public';
});

// Redirect storage to /tmp (Vercel filesystem is read-only)
$app->useStoragePath('/tmp/storage');

// Create the necessary temporary directories and subdirectories
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
