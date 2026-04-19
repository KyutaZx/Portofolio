<?php

// 1. Definisikan folder writable di /tmp
$storagePath = '/tmp/storage';
$folders = [
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/bootstrap/cache',
    $storagePath . '/logs',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Set environment variables to force-bypass any uploaded caches
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("APP_CONFIG_CACHE=$storagePath/bootstrap/cache/config.php");
putenv("APP_SERVICES_CACHE=$storagePath/bootstrap/cache/services.php");
putenv("APP_PACKAGES_CACHE=$storagePath/bootstrap/cache/packages.php");
putenv("APP_ROUTES_CACHE=$storagePath/bootstrap/cache/routes.php");
putenv("LOG_CHANNEL=stderr");
putenv("SESSION_DRIVER=cookie");

// 3. Main Execution
try {
    // Register Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // Boostrap Laravel
    /** @var \Illuminate\Foundation\Application $app */
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Override Storage Path secara explisit
    $app->useStoragePath($storagePath);

    // Handle Request
    $request = \Illuminate\Http\Request::capture();
    $response = $app->handle($request);
    $response->send();

} catch (\Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo "Internal Server Error";
}
