<?php

/**
 * Cek Lokasi Folder Database MySQL
 */

echo "========================================\n";
echo "  CEK LOKASI FOLDER DATABASE MYSQL\n";
echo "========================================\n\n";

// Lokasi yang mungkin
$possiblePaths = [
    'D:\\Praktikum DWBI\\xampp\\mysql\\data\\nurani',
    'C:\\xampp\\mysql\\data\\nurani',
    'D:\\xampp\\mysql\\data\\nurani',
    'C:\\Program Files\\xampp\\mysql\\data\\nurani',
    'D:\\Program Files\\xampp\\mysql\\data\\nurani',
];

echo "[INFO] Mencari folder database 'nurani'...\n\n";

$found = false;
foreach ($possiblePaths as $path) {
    if (is_dir($path)) {
        echo "[SUKSES] Folder ditemukan: $path\n";
        echo "[INFO] Isi folder:\n";
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $path . '\\' . $file;
                $size = is_file($filePath) ? filesize($filePath) : 0;
                $type = is_dir($filePath) ? '[DIR]' : '[FILE]';
                echo "  $type $file";
                if ($size > 0) {
                    echo " (" . round($size / 1024, 2) . " KB)";
                }
                echo "\n";
            }
        }
        $found = true;
        break;
    }
}

if (!$found) {
    echo "[WARNING] Folder database tidak ditemukan di lokasi standar!\n\n";
    echo "[INFO] Cara cek lokasi data MySQL:\n";
    echo "  1. Buka XAMPP Control Panel\n";
    echo "  2. Klik 'Config' pada MySQL\n";
    echo "  3. Pilih 'my.ini'\n";
    echo "  4. Cari baris 'datadir'\n";
    echo "  5. Lokasi folder database ada di sana\n\n";
    
    echo "[INFO] Lokasi yang sudah dicek:\n";
    foreach ($possiblePaths as $path) {
        echo "  - $path\n";
    }
}

echo "\n========================================\n";
