<?php
// Suppress PHP 8.4+ deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED);

// Forward Vercel requests to the normal Laravel public/index.php
require __DIR__ . '/../public/index.php';
