# ✅ Cara Jalankan Migrations dan Seeder di Railway

## 🎯 TUJUAN

**Menjalankan migrations dan seeder di Railway untuk membuat tabel dan data guru.**

---

## ✅ CARA 1: Via Shell (Manual)

### Langkah 1: Buka Shell

1. **Buka Railway Dashboard** → `https://railway.app`
2. **Klik project "TMS Nurani"**
3. **Klik service "web"** (bukan MySQL!)
4. **Klik tab "Shell"** (ada di bagian atas, sama seperti tab "Logs")
5. **Shell akan terbuka**

### Langkah 2: Jalankan Migrations

**Di Shell, ketik:**

```bash
php artisan migrate --force
```

**Tunggu sampai selesai** (akan muncul "DONE" untuk setiap migration)

### Langkah 3: Jalankan Seeder

**Masih di Shell yang sama, ketik:**

```bash
php artisan db:seed --class=UserSeeder
```

**Tunggu sampai selesai** (akan muncul "Seeding database.")

### Langkah 4: Verifikasi

**Cek apakah data guru sudah ada:**

```bash
php artisan tinker
```

**Lalu di tinker, ketik:**

```php
\App\Models\User::where('role', 'guru')->count();
```

**Harus muncul: 13**

**Ketik `exit` untuk keluar dari tinker**

---

## ✅ CARA 2: Otomatis (Sudah Dikonfigurasi)

**File `railway.json` sudah diupdate untuk menjalankan migrations dan seeder otomatis saat deploy.**

**Tinggal tunggu deploy selesai, lalu cek Deploy Logs untuk memastikan migrations dan seeder berjalan.**

---

## 📋 CEK HASIL

### Cek Deploy Logs

1. **Buka Railway Dashboard**
2. **Klik service "web"**
3. **Klik tab "Deployments"**
4. **Klik deployment terbaru**
5. **Klik tab "Deploy Logs"**
6. **Cek apakah ada:**
   - `[SUKSES] Migrations selesai!`
   - `[SUKSES] Seeder selesai! Data guru sudah dibuat!`
   - `Jumlah guru di database: 13`

### Test Login

1. **Buka aplikasi Railway** → URL Railway Anda
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Masukkan:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Klik "Login"**
5. **Jika berhasil masuk** = Berhasil! ✅

---

## 🆘 TROUBLESHOOTING

### Shell tidak muncul

**Solusi:**
- Pastikan klik service "web" (bukan MySQL)
- Refresh halaman (F5)
- Coba buka di browser lain

### Error: "Command not found"

**Solusi:**
- Pastikan Anda di Shell service "web"
- Pastikan path sudah benar (biasanya sudah di `/app`)

### Error: "Database connection failed"

**Solusi:**
- Cek environment variables di Railway
- Pastikan `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sudah benar
- Pastikan MySQL service sudah running

---

## 🎯 REKOMENDASI

**Gunakan Cara 1 (Via Shell) untuk hasil yang pasti!**

**Atau tunggu deploy otomatis selesai (Cara 2) jika sudah dikonfigurasi!**

---

**Buka Shell di Railway dan jalankan migrations + seeder! 🚀**

