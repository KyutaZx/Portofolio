<?php
echo "PHP Runtime is working! <br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";

// // Override path storage untuk Vercel (karena Vercel read-only)
// $storagePath = '/tmp/storage/framework';
// $folders = ['views', 'sessions', 'cache'];
// foreach ($folders as $folder) {
//     if (!is_dir($storagePath . '/' . $folder)) {
//         mkdir($storagePath . '/' . $folder, 0755, true);
//     }
// }
// 
// putenv("VIEW_COMPILED_PATH=$storagePath/views");
// putenv("SESSION_DRIVER=cookie"); 
// 
// // Forward request to public/index.php milik Laravel
// require __DIR__ . '/../public/index.php';
