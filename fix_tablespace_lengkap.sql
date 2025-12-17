-- ========================================
-- FIX TABLESPACE ERROR - LENGKAP
-- ========================================
-- Jalankan di phpMyAdmin → Tab "SQL" (tidak perlu pilih database dulu)
-- Copy semua SQL di bawah ini, paste di phpMyAdmin SQL tab, lalu klik "Go"

-- Langkah 1: Hapus database (jika ada)
DROP DATABASE IF EXISTS nurani;

-- Langkah 2: Buat database baru
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Selesai! Setelah ini, jalankan di terminal:
-- php artisan migrate --force
-- php artisan db:seed --class=UserSeeder
