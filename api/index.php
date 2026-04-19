<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Setup folder storage di /tmp (satu-satunya tempat writable di Vercel)
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/logs',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// Override environment variables untuk mengarahkan storage
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("LOG_CHANNEL=stderr");
putenv("VIEW_COMPILED_PATH=$storagePath/framework/views");
putenv("DATA_CACHE_PATH=$storagePath/framework/cache");

// Forward ke Laravel
require __DIR__ . '/../public/index.php';
