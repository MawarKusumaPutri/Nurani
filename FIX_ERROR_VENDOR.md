# Cara Memperbaiki Error Vendor/Autoload.php

## Masalah
Error: `Failed to open stream: No such file or directory` untuk `vendor/autoload.php`

## Penyebab
Folder `vendor` belum ada karena dependencies Composer belum diinstall.

## Solusi

### Opsi 1: Menggunakan Composer (Recommended)
1. Buka Command Prompt atau PowerShell
2. Masuk ke folder project:
   ```
   cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
   ```
3. Install dependencies:
   ```
   composer install
   ```
   
   Jika composer tidak terinstall, download dulu:
   ```
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   php composer.phar install
   ```

### Opsi 2: Menggunakan File Batch
1. Double-click file `INSTALL_COMPOSER_DEPENDENCIES.bat`
2. Tunggu sampai proses selesai

### Opsi 3: Manual (Jika Composer tidak tersedia)
1. Download folder vendor dari project Laravel yang sudah berjalan
2. Copy folder `vendor` ke root project
3. Pastikan file `vendor/autoload.php` ada

## Setelah Install
1. Refresh browser
2. Error seharusnya sudah hilang

## Catatan
- Proses install bisa memakan waktu beberapa menit
- Pastikan koneksi internet aktif untuk download dependencies
- Pastikan PHP sudah terinstall dan bisa diakses dari command line
