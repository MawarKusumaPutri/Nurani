========================================
CARA MEMBUAT TABEL RPP SECARA OTOMATIS
========================================

Ada beberapa cara untuk membuat tabel RPP:

========================================
CARA 1: VIA BROWSER (PALING MUDAH)
========================================

1. Pastikan XAMPP Apache dan MySQL sudah running (status hijau)
2. Buka browser
3. Ketik salah satu URL ini:
   
   a. http://localhost/nurani/public/BUAT_TABEL_RPP_OTOMATIS.php
      (Menampilkan halaman dengan informasi detail)
   
   b. http://localhost/nurani/public/BUAT_TABEL_RPP_SEKARANG.php
      (Membuat tabel dan redirect otomatis ke halaman RPP)
   
   c. http://localhost/nurani/public/BUAT_RPP_NOW.php
      (Membuat tabel dan redirect langsung)

4. Script akan otomatis membuat tabel RPP
5. Refresh halaman RPP di browser (Ctrl+F5)

========================================
CARA 2: VIA BATCH FILE (DOUBLE-CLICK)
========================================

Double-click salah satu file berikut:
- KLIK_INI_BUAT_TABEL_RPP.bat
- BUAT_TABEL_RPP_FINAL.bat
- JALANKAN_INI_BUAT_TABEL_RPP.bat
- BUAT_TABEL_RPP_LANGSUNG.bat

File ini akan menjalankan script PHP secara otomatis.

========================================
CARA 3: VIA COMMAND LINE
========================================

Buka Command Prompt atau PowerShell, lalu ketik:

cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php create_rpp_table_direct.php

ATAU

php MAKE_RPP_TABLE.php

ATAU

php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php

========================================
CARA 4: MANUAL VIA PHPMYADMIN
========================================

1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Pilih database "nurani"
3. Klik tab "SQL"
4. Buka file "SQL_RPP_LANGSUNG.txt"
5. Copy semua isinya (dari "USE nurani;" sampai akhir)
6. Paste ke textarea SQL
7. Klik "Go"
8. Refresh halaman RPP

========================================
VERIFIKASI
========================================

Setelah tabel dibuat, cek apakah berhasil:

1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Pilih database "nurani"
3. Di sidebar kiri, cari tabel "rpp"
4. Jika ada, berarti tabel berhasil dibuat!

ATAU

Buka Command Prompt dan ketik:
php -r "try { $pdo = new PDO('mysql:host=localhost;dbname=nurani', 'root', ''); $result = $pdo->query('SHOW TABLES LIKE \'rpp\''); echo $result->rowCount() > 0 ? 'SUCCESS: Tabel RPP sudah ada' : 'ERROR: Tabel RPP belum ada'; } catch (Exception $e) { echo 'ERROR: ' . $e->getMessage(); }"

========================================
TROUBLESHOOTING
========================================

Jika masih error:

1. Pastikan XAMPP MySQL sudah running (status hijau)
2. Pastikan database "nurani" sudah ada
3. Jika database belum ada, buat dulu di phpMyAdmin
4. Coba cara manual (Cara 4) - paling pasti berhasil

========================================
