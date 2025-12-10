@echo off
chcp 65001 >nul
title FIX ERROR TABEL RPP - FINAL
color 0A
cls

echo.
echo ============================================================
echo           FIX ERROR TABEL RPP - FINAL SOLUTION
echo ============================================================
echo.
echo Pastikan:
echo 1. XAMPP sudah running
echo 2. MySQL sudah running (hijau di XAMPP Control Panel)
echo.
pause

cd /d "%~dp0"

echo.
echo ============================================================
echo METODE 1: Script PHP Direct
echo ============================================================
echo.
php BUAT_TABEL_RPP_SEKARANG.php 2>&1

if %errorlevel% equ 0 (
    echo.
    echo ============================================================
    echo ✅ SUKSES! Tabel RPP sudah dibuat!
    echo ============================================================
    echo.
    echo Silakan refresh halaman RPP di browser (Ctrl+F5)
    echo.
    pause
    exit /b 0
)

echo.
echo ============================================================
echo METODE 1 GAGAL, Mencoba Metode 2: Artisan Tinker
echo ============================================================
echo.
php artisan tinker --execute="DB::statement('CREATE TABLE IF NOT EXISTS `rpp` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `guru_id` bigint(20) UNSIGNED NOT NULL, `judul` varchar(255) NOT NULL, `mata_pelajaran` varchar(255) NOT NULL, `kelas` varchar(255) NOT NULL, `semester` varchar(255) NOT NULL, `pertemuan_ke` int(11) NOT NULL, `alokasi_waktu` int(11) NOT NULL, `sekolah` varchar(255) DEFAULT NULL, `mata_pelajaran_detail` varchar(255) DEFAULT NULL, `kelas_detail` varchar(255) DEFAULT NULL, `semester_detail` varchar(255) DEFAULT NULL, `tahun_pelajaran` varchar(255) DEFAULT NULL, `ki_1` text DEFAULT NULL, `ki_2` text DEFAULT NULL, `ki_3` text DEFAULT NULL, `ki_4` text DEFAULT NULL, `kd_pengetahuan` text DEFAULT NULL, `kd_keterampilan` text DEFAULT NULL, `indikator_pencapaian_kompetensi` text DEFAULT NULL, `tujuan_pembelajaran` text DEFAULT NULL, `materi_pembelajaran` text DEFAULT NULL, `materi_pembelajaran_reguler` text DEFAULT NULL, `materi_pembelajaran_pengayaan` text DEFAULT NULL, `materi_pembelajaran_remedial` text DEFAULT NULL, `metode_pembelajaran` text DEFAULT NULL, `kegiatan_pendahuluan` text DEFAULT NULL, `kegiatan_inti` text DEFAULT NULL, `kegiatan_penutup` text DEFAULT NULL, `media_pembelajaran` text DEFAULT NULL, `sumber_belajar` text DEFAULT NULL, `teknik_penilaian` text DEFAULT NULL, `bentuk_instrumen` text DEFAULT NULL, `rubrik_penilaian` text DEFAULT NULL, `kriteria_ketuntasan` text DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`), KEY `rpp_guru_id_index` (`guru_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'); echo 'SUKSES';" 2>&1

if %errorlevel% equ 0 (
    echo.
    echo ============================================================
    echo ✅ SUKSES! Tabel RPP sudah dibuat via Tinker!
    echo ============================================================
    echo.
    echo Silakan refresh halaman RPP di browser (Ctrl+F5)
    echo.
    pause
    exit /b 0
)

echo.
echo ============================================================
echo SEMUA METODE OTOMATIS GAGAL
echo ============================================================
echo.
echo 🔧 SOLUSI MANUAL - VIA PHPMYADMIN:
echo.
echo 1. Buka http://localhost/phpmyadmin
echo 2. Pilih database 'nurani' di sidebar kiri
echo 3. Klik tab 'SQL' di bagian atas
echo 4. Buka file 'CREATE_RPP_TABLE.sql' di folder ini
echo 5. Copy-paste SEMUA isinya ke textarea SQL
echo 6. Klik tombol 'Go' atau 'Jalankan'
echo 7. Pastikan muncul pesan sukses
echo 8. Refresh halaman RPP di browser (Ctrl+F5)
echo.
echo Atau copy-paste SQL ini langsung:
echo.
type CREATE_RPP_TABLE.sql
echo.
pause
