# 🚨 PERBAIKAN URGEN: Email Tidak Terkirim!

## ❌ Masalah yang Ditemukan

**Email tidak terkirim sama sekali** karena konfigurasi SMTP belum diaktifkan!

**Status saat ini:**
- ❌ `MAIL_MAILER=log` (email hanya ditulis ke log, tidak terkirim)
- ❌ `MAIL_USERNAME` kosong
- ❌ Email tidak masuk ke Gmail (bahkan tidak masuk ke Spam)

## ✅ SOLUSI CEPAT (5 Menit)

### Langkah 1: Buat Gmail App Password

1. **Buka:** https://myaccount.google.com/
2. **Login dengan:** `mawarkusuma694@gmail.com` (atau email Gmail yang akan digunakan)
3. **Security** → **2-Step Verification** (aktifkan dulu jika belum)
4. **App passwords** → **Generate**
   - **App:** Mail
   - **Device:** Other (Custom name)
   - **Name:** "MTs Nurul Aiman System"
5. **Copy password 16 karakter** (contoh: `abcd efgh ijkl mnop`)

### Langkah 2: Jalankan Command Setup

**PENTING:** Ganti `xxxx xxxx xxxx xxxx` dengan App Password yang sudah dibuat!

```bash
php artisan gmail:setup mawarkusuma694@gmail.com "xxxx xxxx xxxx xxxx"
```

**Contoh:**
```bash
php artisan gmail:setup mawarkusuma694@gmail.com "abcd efgh ijkl mnop"
```

### Langkah 3: Test Email

```bash
php artisan email:test mawarkusuma694@gmail.com
```

**Jika berhasil, akan muncul:**
```
✅ Email berhasil dikirim!
📬 Cek inbox Gmail: mawarkusuma694@gmail.com
```

### Langkah 4: Login dan Cek Gmail

1. **Login ke sistem:**
   - Email: `mawarkusuma694@gmail.com`
   - Password: `Mawar2024!`
   - Role: `guru`

2. **Buka Gmail:** https://mail.google.com
3. **Cek Kotak Masuk** - Email notifikasi akan muncul!

---

## 🔍 Verifikasi Setup Berhasil

Jalankan command ini untuk cek konfigurasi:

```bash
php artisan tinker --execute="echo 'MAIL_MAILER: ' . config('mail.default') . PHP_EOL; echo 'MAIL_USERNAME: ' . env('MAIL_USERNAME', 'NOT SET') . PHP_EOL;"
```

**Harus muncul:**
```
MAIL_MAILER: smtp
MAIL_USERNAME: mawarkusuma694@gmail.com
```

**Jika masih `log` atau `NOT SET`, berarti setup belum berhasil!**

---

## ⚠️ Jika Masih Tidak Berhasil

### Cek File .env

Buka file `.env` di root project, pastikan ada:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mawarkusuma694@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=mawarkusuma694@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**Ganti `xxxx xxxx xxxx xxxx` dengan App Password yang sudah dibuat!**

### Clear Cache

Setelah update `.env`:

```bash
php artisan config:clear
php artisan cache:clear
```

### Test Lagi

```bash
php artisan email:test mawarkusuma694@gmail.com
```

---

## 📋 Checklist

- [ ] Gmail App Password sudah dibuat
- [ ] Command `gmail:setup` sudah dijalankan
- [ ] File `.env` sudah berisi konfigurasi SMTP
- [ ] `MAIL_MAILER=smtp` (bukan `log`)
- [ ] `MAIL_USERNAME` sudah diisi dengan email Gmail
- [ ] `MAIL_PASSWORD` sudah diisi dengan App Password
- [ ] Cache sudah di-clear
- [ ] Test email berhasil
- [ ] Login ke sistem berhasil
- [ ] Email masuk ke Gmail (Inbox atau Spam)

---

**Status:** 🚨 Perlu Setup Segera  
**Waktu:** ~5 menit  
**Tingkat Kesulitan:** ⭐ Mudah

