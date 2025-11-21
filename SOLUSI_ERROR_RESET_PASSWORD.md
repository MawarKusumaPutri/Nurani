# 🔧 Solusi Error: Gagal Mengirim Email Reset Password

## ❌ Masalah

Muncul error: **"Gagal mengirim email. Pastikan SMTP sudah dikonfigurasi dengan benar."**

**Penyebab:**
- SMTP belum dikonfigurasi (`MAIL_MAILER=log`)
- `MAIL_USERNAME` belum diisi
- Email tidak bisa terkirim ke Gmail

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

**Buka terminal/command prompt di folder project, lalu jalankan:**

```bash
php artisan gmail:setup mawarkusuma694@gmail.com "xxxx xxxx xxxx xxxx"
```

**Ganti `xxxx xxxx xxxx xxxx` dengan App Password yang sudah dibuat!**

**Contoh:**
```bash
php artisan gmail:setup mawarkusuma694@gmail.com "abcd efgh ijkl mnop"
```

**Command ini akan:**
- ✅ Update file `.env` dengan konfigurasi SMTP
- ✅ Set `MAIL_MAILER=smtp`
- ✅ Set `MAIL_USERNAME` dan `MAIL_FROM_ADDRESS`
- ✅ Clear cache otomatis

### Langkah 3: Verifikasi Setup

Jalankan command untuk cek:

```bash
php artisan tinker --execute="echo 'MAIL_MAILER: ' . config('mail.default') . PHP_EOL; echo 'MAIL_USERNAME: ' . (env('MAIL_USERNAME') ?: 'NOT SET') . PHP_EOL;"
```

**Harus muncul:**
```
MAIL_MAILER: smtp
MAIL_USERNAME: mawarkusuma694@gmail.com
```

**Jika masih `log` atau `NOT SET`, ulangi Langkah 2!**

### Langkah 4: Test Email Reset Password

1. **Buka halaman:** http://127.0.0.1:8000/forgot-password
2. **Masukkan:**
   - Role: Guru
   - Email: `mawarkusuma694@gmail.com`
3. **Klik "Kirim Link Reset Password"**
4. **Jika berhasil:** Akan muncul pesan "Link reset password telah dikirim ke email Gmail Anda!"
5. **Cek Gmail:** Buka Gmail dan cek Kotak Masuk (atau Spam)

---

## 🔍 Troubleshooting

### Error: "Authentication failed"

**Penyebab:** App Password salah atau tidak valid

**Solusi:**
1. Buat App Password baru di Google Account
2. Pastikan 2-Step Verification sudah aktif
3. Pastikan menggunakan App Password (16 karakter), bukan password Gmail biasa
4. Jalankan command setup lagi dengan App Password yang baru

### Error: "Connection timeout"

**Penyebab:** Tidak bisa terhubung ke server SMTP

**Solusi:**
1. Cek koneksi internet
2. Pastikan `MAIL_HOST=smtp.gmail.com`
3. Pastikan `MAIL_PORT=587`
4. Pastikan `MAIL_ENCRYPTION=tls`

### Error: "SMTP belum dikonfigurasi"

**Penyebab:** `MAIL_MAILER=log` atau `MAIL_USERNAME` kosong

**Solusi:**
1. Jalankan command setup (Langkah 2 di atas)
2. Pastikan file `.env` sudah diupdate
3. Clear cache: `php artisan config:clear`

---

## 📋 Checklist

Pastikan semua sudah dilakukan:

- [ ] Gmail App Password sudah dibuat
- [ ] Command `gmail:setup` sudah dijalankan
- [ ] `MAIL_MAILER=smtp` (bukan `log`)
- [ ] `MAIL_USERNAME` sudah diisi dengan email Gmail
- [ ] `MAIL_PASSWORD` sudah diisi dengan App Password
- [ ] Cache sudah di-clear (`php artisan config:clear`)
- [ ] Test email reset password berhasil
- [ ] Email masuk ke Gmail (Inbox atau Spam)

---

## 🆘 Jika Masih Error

1. **Cek log Laravel:**
   ```bash
   type storage\logs\laravel.log | findstr "password\|reset\|email"
   ```

2. **Test email dengan command:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

3. **Hubungi admin sistem** jika masih bermasalah

---

**Status:** ✅ Solusi Tersedia  
**Waktu Setup:** ~5 menit  
**Tingkat Kesulitan:** ⭐ Mudah

