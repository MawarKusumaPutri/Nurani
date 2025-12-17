# 🔧 Fix Error: Table 'users' doesn't exist

## ❌ MASALAH

**Error yang muncul:**
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'nurani.users' doesn't exist
```

**Lokasi error:**
- `app/Http/Controllers/AuthController.php:170`
- Saat query `User::where('email', $request->email)->where('role', $request->role)->first()`

**Artinya:**
- Tabel `users` belum ada di database
- Migrations belum jalan di localhost
- Perlu jalankan migrations

---

## ✅ SOLUSI: Jalankan Migrations

### Untuk Localhost (XAMPP):

#### Langkah 1: Pastikan MySQL Berjalan

1. **Buka XAMPP Control Panel**
2. **Start MySQL** (pastikan status "Running")
3. **Start Apache** (jika belum)

#### Langkah 2: Jalankan Migrations

**Buka PowerShell/Command Prompt di folder project:**

```powershell
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate
```

**Atau jika ada konfirmasi, tekan `y` atau gunakan `--force`:**

```powershell
php artisan migrate --force
```

**Tunggu sampai migrations selesai!**

**Output yang diharapkan:**
```
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table
Migrating: 2025_10_17_150326_add_role_to_users_table
Migrated:  2025_10_17_150326_add_role_to_users_table
...
```

#### Langkah 3: Verifikasi

**Cek apakah tabel sudah ada:**

```powershell
php artisan tinker
```

**Di dalam tinker, jalankan:**
```php
DB::table('users')->count();
```

**Jika muncul angka (bisa 0 jika belum ada data)** = Tabel sudah ada! ✅

**Keluar dari tinker:**
```php
exit
```

---

### Untuk Railway (Sudah Otomatis):

**Railway sudah di-setup untuk jalankan migrations otomatis:**
- ✅ Safe migration script sudah ada
- ✅ Start command sudah include migrations
- ✅ Migrations akan jalan saat service start

**Jika masih error di Railway:**
1. **Cek Deploy Logs** - pastikan migrations sudah jalan
2. **Cek service "web" status "Online"** (hijau)
3. **Jika masih error**, tunggu deploy selesai

---

## 📋 CHECKLIST

### ✅ Untuk Localhost:
- [ ] Pastikan MySQL berjalan di XAMPP
- [ ] Jalankan `php artisan migrate --force`
- [ ] Verifikasi tabel `users` sudah ada
- [ ] Test aplikasi di browser

### ✅ Untuk Railway:
- [x] Safe migration script sudah ada
- [x] Start command sudah include migrations
- [ ] Cek Deploy Logs - migrations berjalan
- [ ] Cek service "web" status "Online" (hijau)
- [ ] Test aplikasi di Railway URL

---

## 🆘 JIKA MASIH ERROR

### Error: "Migration table not found"
**Solusi:**
- Normal, migrations akan membuat tabel `migrations` sendiri
- Jalankan `php artisan migrate --force` lagi

### Error: "Connection refused"
**Solusi:**
- Pastikan MySQL berjalan di XAMPP
- Cek `.env` file - pastikan `DB_HOST=127.0.0.1` dan `DB_PORT=3306`

### Error: "Access denied"
**Solusi:**
- Cek `.env` file - pastikan `DB_USERNAME` dan `DB_PASSWORD` benar
- Default XAMPP: `DB_USERNAME=root` dan `DB_PASSWORD=` (kosong)

---

## 💡 TIPS

1. **Jalankan migrations setiap kali ada perubahan database**
2. **Gunakan `php artisan migrate:status`** untuk cek status migrations
3. **Gunakan `php artisan migrate:fresh`** jika ingin reset database (HATI-HATI: akan hapus semua data!)

---

**Jalankan migrations di localhost dulu! Setelah itu, test aplikasi! 🚀**

