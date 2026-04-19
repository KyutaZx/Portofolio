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

// 2. Set environment variables to force-bypass any uploaded caches
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("APP_CONFIG_CACHE=$storagePath/bootstrap/cache/config.php");
putenv("APP_SERVICES_CACHE=$storagePath/bootstrap/cache/services.php");
putenv("APP_PACKAGES_CACHE=$storagePath/bootstrap/cache/packages.php");
putenv("APP_ROUTES_CACHE=$storagePath/bootstrap/cache/routes.php");
putenv("LOG_CHANNEL=stderr");
putenv("SESSION_DRIVER=cookie");

// 3. Main Execution with Global Error Catching
try {
    // Register Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // Diagnosa: Pastikan file provider ada
    if (!class_exists('Illuminate\View\ViewServiceProvider')) {
        throw new \Exception("Kritikal: ViewServiceProvider tidak ditemukan di vendor! Coba cek 'composer install' di Vercel Build Logs.");
    }

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
    http_response_code(500);
    echo "<h1>Debug Laravel Error</h1>";
    echo "<p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><b>File:</b> " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
