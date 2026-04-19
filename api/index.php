<?php
// Override path storage untuk Vercel (karena Vercel read-only)
$storagePath = '/tmp/storage/framework';
$folders = ['views', 'sessions', 'cache'];
foreach ($folders as $folder) {
    if (!is_dir($storagePath . '/' . $folder)) {
        mkdir($storagePath . '/' . $folder, 0755, true);
    }
}

putenv("VIEW_COMPILED_PATH=$storagePath/views");
putenv("SESSION_DRIVER=cookie"); // Hindari menulis session ke file

// Forward request to public/index.php milik Laravel
require __DIR__ . '/../public/index.php';
