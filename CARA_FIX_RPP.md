# Cara Memperbaiki Error Tabel RPP

## Masalah
Error: `Table 'nurani.rpp' doesn't exist`

## Solusi 1: Jalankan Migration (Otomatis)

### Cara 1: Via Batch File
1. Double-click file `FIX_RPP_TABLE.bat`
2. Tunggu sampai selesai
3. Refresh halaman RPP di browser

### Cara 2: Via Command Line
```bash
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php --force
```

## Solusi 2: Buat Tabel Manual (Jika Migration Gagal)

### Via phpMyAdmin:
1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Pilih database `nurani`
3. Klik tab "SQL"
4. Copy-paste isi dari file `CREATE_RPP_TABLE.sql`
5. Klik "Go" atau "Jalankan"

### Via MySQL Command Line:
```bash
mysql -u root -p nurani < CREATE_RPP_TABLE.sql
```

## Verifikasi

Setelah menjalankan salah satu solusi di atas, verifikasi dengan:
1. Buka phpMyAdmin
2. Pilih database `nurani`
3. Cek apakah tabel `rpp` sudah ada di daftar tabel
4. Refresh halaman RPP di aplikasi

## File-file yang Tersedia:
- `FIX_RPP_TABLE.bat` - Script otomatis untuk menjalankan migration
- `CREATE_RPP_TABLE.sql` - SQL script untuk membuat tabel manual
- `JALANKAN_MIGRATION_RPP.bat` - Alternatif script migration
