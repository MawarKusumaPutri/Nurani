# 🔧 Troubleshooting Email Notifikasi

## ❌ Masalah: Email Tidak Masuk ke Gmail

Jika Anda sudah login dengan email `mawarkusuma694@gmail.com` tapi tidak ada notifikasi yang masuk, ikuti langkah-langkah berikut:

## 🔍 Langkah 1: Cek Konfigurasi SMTP

### 1.1 Cek File .env

Pastikan file `.env` di root project memiliki konfigurasi berikut:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password-16-karakter
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**⚠️ PENTING:**
- `MAIL_MAILER` harus `smtp`, BUKAN `log`
- `MAIL_PASSWORD` harus menggunakan **Gmail App Password**, bukan password Gmail biasa
- App Password adalah 16 karakter (bisa dengan atau tanpa spasi)

### 1.2 Clear Cache Setelah Update .env

Setelah mengubah `.env`, **WAJIB** jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

## 🔍 Langkah 2: Test Email dengan Command

Jalankan command test email:

```bash
php artisan email:test mawarkusuma694@gmail.com
```

Command ini akan:
- ✅ Cek konfigurasi mail
- ✅ Cek apakah user ada di database
- ✅ Kirim email test
- ✅ Tampilkan error jika ada masalah

## 🔍 Langkah 3: Cek Log Laravel

Cek file log untuk melihat apakah ada error:

```bash
# Windows
type storage\logs\laravel.log | findstr "email\|mail\|notification"

# Atau buka file langsung
notepad storage\logs\laravel.log
```

Cari log dengan keyword:
- `Login notification email sent`
- `Failed to send login notification`
- `email`
- `mail`

## 🔍 Langkah 4: Verifikasi Gmail App Password

### Cara Membuat Gmail App Password:

1. **Buka Google Account:**
   - Kunjungi: https://myaccount.google.com/
   - Login dengan Gmail yang akan digunakan untuk SMTP

2. **Aktifkan 2-Step Verification:**
   - Pilih **Security** (Keamanan)
   - Aktifkan **2-Step Verification** jika belum aktif
   - Ini WAJIB untuk membuat App Password

3. **Buat App Password:**
   - Masih di halaman Security
   - Scroll ke bawah, klik **App passwords**
   - Pilih:
     - **Select app:** Mail
     - **Select device:** Other (Custom name)
     - Masukkan: "MTs Nurul Aiman System"
   - Klik **Generate**

4. **Copy Password:**
   - Password 16 karakter akan muncul
   - Copy password tersebut (bisa dengan atau tanpa spasi)
   - Paste ke `MAIL_PASSWORD` di file `.env`

**Contoh App Password:**
```
abcd efgh ijkl mnop
```
atau
```
abcdefghijklmnop
```

## 🔍 Langkah 5: Cek Gmail Inbox

### 5.1 Cek Folder Inbox
- Buka Gmail: https://mail.google.com
- Login dengan: `mawarkusuma694@gmail.com`
- Cek folder **Inbox**

### 5.2 Cek Folder Spam
- Jika tidak ada di Inbox, cek folder **Spam** atau **Junk**
- Email mungkin masuk ke spam jika:
  - Gmail menganggap email sebagai spam
  - Domain pengirim tidak dikenal
  - Format email tidak standar

### 5.3 Cek "All Mail"
- Cek folder **All Mail** untuk memastikan email tidak terlewat

## 🔍 Langkah 6: Test Manual

### 6.1 Test dengan Command

```bash
php artisan email:test mawarkusuma694@gmail.com
```

### 6.2 Test dengan Login

1. Login ke sistem:
   - Email: `mawarkusuma694@gmail.com`
   - Password: `Mawar2024!`
   - Role: `guru`

2. Cek log:
   ```bash
   php artisan tinker
   ```
   Lalu jalankan:
   ```php
   \Log::info('Test log');
   ```

3. Cek Gmail dalam 30 detik

## 🐛 Error yang Sering Terjadi

### Error 1: "Authentication failed"

**Penyebab:**
- App Password salah
- 2-Step Verification tidak aktif
- Password Gmail biasa digunakan (bukan App Password)

**Solusi:**
- Buat App Password baru
- Pastikan 2-Step Verification aktif
- Gunakan App Password, bukan password Gmail

### Error 2: "Connection timeout"

**Penyebab:**
- Koneksi internet bermasalah
- Firewall memblokir SMTP
- Port 587 diblokir

**Solusi:**
- Cek koneksi internet
- Cek firewall settings
- Coba port 465 dengan `MAIL_ENCRYPTION=ssl`

### Error 3: Email masuk ke Spam

**Penyebab:**
- Gmail menganggap email sebagai spam
- Domain tidak dikenal

**Solusi:**
- Cek folder Spam
- Mark email sebagai "Not Spam"
- Tambahkan pengirim ke kontak

### Error 4: "Mail driver is log"

**Penyebab:**
- `MAIL_MAILER=log` di `.env`
- Email tidak terkirim, hanya ditulis ke log

**Solusi:**
- Ubah `MAIL_MAILER=smtp` di `.env`
- Jalankan `php artisan config:clear`

## ✅ Checklist Verifikasi

Gunakan checklist ini untuk memastikan semua sudah benar:

- [ ] File `.env` sudah dikonfigurasi dengan benar
- [ ] `MAIL_MAILER=smtp` (bukan `log`)
- [ ] `MAIL_HOST=smtp.gmail.com`
- [ ] `MAIL_PORT=587`
- [ ] `MAIL_USERNAME` sudah diisi dengan email Gmail
- [ ] `MAIL_PASSWORD` menggunakan App Password (16 karakter)
- [ ] `MAIL_ENCRYPTION=tls`
- [ ] `MAIL_FROM_ADDRESS` sama dengan `MAIL_USERNAME`
- [ ] Sudah menjalankan `php artisan config:clear`
- [ ] Sudah menjalankan `php artisan cache:clear`
- [ ] 2-Step Verification Gmail sudah aktif
- [ ] App Password sudah dibuat
- [ ] Sudah test dengan `php artisan email:test`
- [ ] Sudah cek folder Inbox Gmail
- [ ] Sudah cek folder Spam Gmail
- [ ] Sudah cek log Laravel untuk error

## 📞 Bantuan Tambahan

Jika masih bermasalah setelah mengikuti semua langkah:

1. **Cek Log Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Test Email Manual:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

3. **Cek Konfigurasi:**
   ```bash
   php artisan tinker
   ```
   Lalu:
   ```php
   config('mail.default');
   config('mail.mailers.smtp.host');
   config('mail.mailers.smtp.port');
   ```

4. **Cek User di Database:**
   ```bash
   php artisan tinker
   ```
   Lalu:
   ```php
   \App\Models\User::where('email', 'mawarkusuma694@gmail.com')->first();
   ```

---

**Update:** {{ date('d F Y') }}  
**Sistem:** TMS NURANI - MTs Nurul Aiman Tanjungsari

