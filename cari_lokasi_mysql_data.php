<?php

/**
 * Cari Lokasi MySQL Data Directory
 */

echo "========================================\n";
echo "  CARI LOKASI MYSQL DATA DIRECTORY\n";
echo "========================================\n\n";

// Lokasi yang mungkin
$possiblePaths = [
    'C:\\xampp\\mysql\\data',
    'D:\\xampp\\mysql\\data',
    'C:\\Program Files\\xampp\\mysql\\data',
    'D:\\Program Files\\xampp\\mysql\\data',
    'C:\\xampp\\mysql\\data\\nurani',
    'D:\\xampp\\mysql\\data\\nurani',
];

echo "[INFO] Mencari lokasi MySQL data directory...\n\n";

$found = false;
foreach ($possiblePaths as $path) {
    if (is_dir($path)) {
        echo "[SUKSES] Folder ditemukan: $path\n";
        $found = true;
        
        // Cek apakah ada folder nurani
        $nuraniPath = $path . '\\nurani';
        if (is_dir($nuraniPath)) {
            echo "  → Folder 'nurani' ada di: $nuraniPath\n";
            echo "  → Isi folder:\n";
            $files = scandir($nuraniPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    echo "    - $file\n";
                }
            }
        } else {
            echo "  → Folder 'nurani' tidak ada\n";
        }
        echo "\n";
    }
}

if (!$found) {
    echo "[WARNING] Folder MySQL data tidak ditemukan di lokasi standar!\n\n";
    echo "[INFO] Cara cek lokasi MySQL data directory:\n";
    echo "  1. Buka XAMPP Control Panel\n";
    echo "  2. Klik 'Config' pada MySQL\n";
    echo "  3. Pilih 'my.ini'\n";
    echo "  4. Cari baris 'datadir'\n";
    echo "  5. Lokasi folder database ada di sana\n\n";
    
    echo "[INFO] Atau cek di Registry Windows:\n";
    echo "  - Buka Registry Editor (regedit)\n";
    echo "  - Cari: HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Services\\MySQL\n";
    echo "  - Atau cek di XAMPP Control Panel → MySQL → Config\n\n";
}

// Coba cek dari my.ini
echo "[INFO] Mencoba cek dari my.ini...\n";
$myIniPaths = [
    'C:\\xampp\\mysql\\bin\\my.ini',
    'D:\\xampp\\mysql\\bin\\my.ini',
    'C:\\xampp\\mysql\\my.ini',
    'D:\\xampp\\mysql\\my.ini',
];

foreach ($myIniPaths as $iniPath) {
    if (file_exists($iniPath)) {
        echo "[SUKSES] File my.ini ditemukan: $iniPath\n";
        $content = file_get_contents($iniPath);
        if (preg_match('/datadir\s*=\s*["\']?([^"\'\r\n]+)["\']?/i', $content, $matches)) {
            $datadir = trim($matches[1]);
            echo "  → datadir: $datadir\n";
            if (is_dir($datadir)) {
                echo "  → Folder datadir ada!\n";
                $nuraniPath = $datadir . '\\nurani';
                if (is_dir($nuraniPath)) {
                    echo "  → Folder 'nurani' ada di: $nuraniPath\n";
                }
            }
        }
        break;
    }
}

echo "\n========================================\n";
echo "  SELESAI\n";
echo "========================================\n\n";
