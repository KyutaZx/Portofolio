<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Definisikan folder writable di /tmp
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/bootstrap/cache', // Pindahkan cache bootstrap ke sini juga
    $storagePath . '/logs',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Set environment variables
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("LOG_CHANNEL=stderr");
putenv("SESSION_DRIVER=cookie"); // Paksa session ke cookie agar tidak menulis file

// 3. Register Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 4. Boostrap Laravel
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Override Storage Path secara explisit
$app->useStoragePath($storagePath);

// 6. Handle Request
$request = \Illuminate\Http\Request::capture();
$response = $app->handle($request);
$response->send();
