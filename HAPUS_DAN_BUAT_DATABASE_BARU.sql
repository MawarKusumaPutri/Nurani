-- ========================================
-- HAPUS DAN BUAT DATABASE BARU
-- ========================================
-- Copy semua SQL di bawah ini, paste di phpMyAdmin SQL tab, lalu klik "Go"
-- PASTIKAN: Jalankan di tab SQL (tidak perlu pilih database dulu)

-- Langkah 1: Hapus database yang sudah ada
DROP DATABASE IF EXISTS nurani;

-- Langkah 2: Buat database baru
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Selesai! Setelah ini, jalankan di terminal:
-- php artisan migrate --force
-- php artisan db:seed --class=UserSeeder
