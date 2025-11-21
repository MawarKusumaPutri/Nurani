# 🔧 PERBAIKAN: Email Notifikasi Tidak Masuk

## ❌ Masalah yang Ditemukan

Setelah test, ditemukan bahwa:
- ⚠️ **Mail Driver masih menggunakan "log"**
- ⚠️ Email tidak terkirim ke Gmail, hanya ditulis ke log file
- ⚠️ Perlu mengubah konfigurasi di file `.env`

## ✅ Solusi: Setup SMTP Gmail

### Langkah 1: Buat Gmail App Password

1. **Buka Google Account:**
   - Kunjungi: https://myaccount.google.com/
   - Login dengan Gmail yang akan digunakan

2. **Aktifkan 2-Step Verification:**
   - Pilih **Security** (Keamanan)
   - Aktifkan **2-Step Verification** (WAJIB!)

3. **Buat App Password:**
   - Masih di Security, scroll ke bawah
   - Klik **App passwords**
   - Pilih:
     - **Select app:** Mail
     - **Select device:** Other (Custom name)
     - Masukkan: "MTs Nurul Aiman System"
   - Klik **Generate**
   - **Copy password 16 karakter** yang muncul

### Langkah 2: Update File .env

Buka file `.env` di root project dan **UBAH** konfigurasi berikut:

**SEBELUM (SALAH):**
```env
MAIL_MAILER=log
```

**SESUDAH (BENAR):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=internal.nurulaiman@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=internal.nurulaiman@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**Contoh lengkap:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=internal.nurulaiman@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=internal.nurulaiman@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**⚠️ PENTING:**
- Ganti `internal.nurulaiman@gmail.com` dengan email Gmail Anda
- Ganti `abcd efgh ijkl mnop` dengan App Password yang sudah dibuat
- App Password bisa dengan atau tanpa spasi

### Langkah 3: Clear Cache

Setelah update `.env`, **WAJIB** jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### Langkah 4: Test Email

Jalankan command test:

```bash
php artisan email:test mawarkusuma694@gmail.com
```

**Hasil yang diharapkan:**
```
📧 Mail Driver: smtp
✅ Email berhasil dikirim!
```

### Langkah 5: Test Login

1. **Login ke sistem:**
   - Email: `mawarkusuma694@gmail.com`
   - Password: `Mawar2024!`
   - Role: `guru`

2. **Cek Gmail:**
   - Buka: https://mail.google.com
   - Login dengan: `mawarkusuma694@gmail.com`
   - Cek folder **Inbox**
   - Jika tidak ada, cek folder **Spam**

3. **Notifikasi akan masuk dalam 5-30 detik!**

## ✅ Verifikasi Setup

Setelah setup, jalankan:

```bash
php artisan email:test mawarkusuma694@gmail.com
```

**Jika berhasil, akan muncul:**
```
📧 Mail Driver: smtp
✅ User ditemukan: Mawar (mawarkusuma694@gmail.com)
📤 Mengirim email test...
✅ Email berhasil dikirim!
```

**Jika masih error, cek:**
- Apakah App Password benar?
- Apakah 2-Step Verification aktif?
- Apakah sudah `php artisan config:clear`?

## 🔄 Sinkronisasi Otomatis

Setelah SMTP dikonfigurasi dengan benar:

✅ **Login dengan:** `mawarkusuma694@gmail.com`  
✅ **Notifikasi masuk ke:** `mawarkusuma694@gmail.com`  
✅ **Sinkron otomatis:** Email login = Email notifikasi

## 📋 Checklist

Gunakan checklist ini:

- [ ] 2-Step Verification Gmail sudah aktif
- [ ] App Password sudah dibuat (16 karakter)
- [ ] File `.env` sudah diupdate:
  - [ ] `MAIL_MAILER=smtp` (bukan `log`)
  - [ ] `MAIL_HOST=smtp.gmail.com`
  - [ ] `MAIL_PORT=587`
  - [ ] `MAIL_USERNAME` sudah diisi
  - [ ] `MAIL_PASSWORD` menggunakan App Password
  - [ ] `MAIL_ENCRYPTION=tls`
- [ ] Sudah menjalankan `php artisan config:clear`
- [ ] Sudah menjalankan `php artisan cache:clear`
- [ ] Sudah test dengan `php artisan email:test`
- [ ] Sudah login dan cek Gmail

## 🆘 Masih Bermasalah?

Jika masih tidak masuk setelah semua langkah:

1. **Cek Log:**
   ```bash
   type storage\logs\laravel.log | findstr "email\|mail"
   ```

2. **Test Manual:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

3. **Cek Spam Folder:**
   - Email mungkin masuk ke Spam
   - Mark sebagai "Not Spam"

4. **Cek App Password:**
   - Pastikan menggunakan App Password, bukan password Gmail
   - Buat App Password baru jika perlu

---

**Status:** ⚠️ Perlu Setup SMTP  
**Update:** {{ date('d F Y') }}  
**Sistem:** TMS NURANI - MTs Nurul Aiman Tanjungsari

