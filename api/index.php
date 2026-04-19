<?php
echo "<h3>Diagnosa Sistem Vercel:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? '✅ Terpasang' : '❌ TIDAK TERPASANG') . "<br>";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "<br>";
echo "Postgres Driver (pgsql): " . (in_array('pgsql', PDO::getAvailableDrivers()) ? '✅ Ada' : '❌ TIDAK ADA') . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";

// Jika sudah ada pgsql dan APP_KEY, kita coba intip error Laravel
if (getenv('APP_KEY')) {
    echo "<hr>Mencoba booting Laravel...<br>";
    try {
        require __DIR__ . '/../public/index.php';
    } catch (\Exception $e) {
        echo "<b>Laravel Boot Error:</b> " . $e->getMessage();
    }
}
