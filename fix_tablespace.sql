-- Fix MySQL Tablespace Error (TANPA DROP DATABASE)
-- Jalankan di phpMyAdmin → Pilih database 'nurani' → Tab "SQL"

-- 1. Cek apakah tabel migrations ada
SHOW TABLES LIKE 'migrations';

-- 2. Drop tabel migrations (hanya tabel, bukan database)
DROP TABLE IF EXISTS migrations;

-- 3. Setelah itu, jalankan di terminal:
-- php artisan migrate --force
