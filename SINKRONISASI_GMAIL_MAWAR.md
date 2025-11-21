# 📧 Panduan Sinkronisasi Gmail untuk Mawar

## ✅ Status: Sinkronisasi Aktif

Sistem login dan notifikasi email untuk **mawarkusuma694@gmail.com** sudah tersinkron dengan Gmail Anda.

## 🔄 Cara Kerja Sinkronisasi

**Prinsip Utama:**
- Email yang digunakan untuk login = Email yang menerima notifikasi
- Login dengan `mawarkusuma694@gmail.com` → Notifikasi masuk ke `mawarkusuma694@gmail.com`
- **100% Sinkron Otomatis** - Tidak perlu konfigurasi manual

## 📋 Data Login Mawar

```
Email: mawarkusuma694@gmail.com
Password: Mawar2024!
Role: guru
Status: ✅ Aktif dan Tersinkron
```

## 🚀 Cara Login dan Menerima Notifikasi

### Langkah 1: Login ke Sistem

1. Buka website: `http://127.0.0.1:8000`
2. Klik tombol **LOGIN** di pojok kanan atas
3. Pilih role: **Guru**
4. Masukkan:
   - **Email:** `mawarkusuma694@gmail.com`
   - **Password:** `Mawar2024!`
5. Klik **Login**

### Langkah 2: Cek Notifikasi di Gmail

Setelah login berhasil:

1. **Buka Gmail:** https://mail.google.com
2. **Login dengan:** `mawarkusuma694@gmail.com`
3. **Cek folder Inbox** (atau **Spam** jika tidak ada)
4. **Notifikasi akan muncul** dalam 5-30 detik dengan subject:
   - `🔔 Notifikasi Login - Guru MTs Nurul Aiman`

**⚠️ Jika Email Masuk ke Spam:**
- Buka folder **Spam** di Gmail
- Klik email notifikasi → Klik **"Bukan spam"** (Not spam)
- Email akan dipindahkan ke Inbox
- **Buat filter Gmail** (lihat bagian "Cara Mencegah Email Masuk Spam" di bawah)

### Informasi yang Ada di Email Notifikasi:

- ✅ Nama: Mawar
- ✅ Email: mawarkusuma694@gmail.com
- ✅ Role: Guru
- ✅ Waktu login (tanggal & jam)
- ✅ IP Address
- ✅ Device/User Agent
- ✅ Peringatan keamanan (jika login tidak dikenal)

## 🔔 Jenis Notifikasi yang Dikirim

### 1. Notifikasi Login
- **Dikirim saat:** Berhasil login
- **Ke:** mawarkusuma694@gmail.com
- **Subject:** 🔔 Notifikasi Login - Guru MTs Nurul Aiman

### 2. Notifikasi Logout
- **Dikirim saat:** Logout dari sistem
- **Ke:** mawarkusuma694@gmail.com
- **Subject:** 🔔 Notifikasi Logout - Guru MTs Nurul Aiman

## ⚙️ Setup SMTP (Jika Belum Aktif)

Jika notifikasi belum masuk, pastikan SMTP sudah dikonfigurasi:

### 1. Buat Gmail App Password

1. Buka [Google Account](https://myaccount.google.com/)
2. Login dengan: `mawarkusuma694@gmail.com`
3. Pilih **Security** (Keamanan)
4. Aktifkan **2-Step Verification** (WAJIB!)
5. Scroll ke bawah, klik **App passwords**
6. Pilih:
   - **Select app:** Mail
   - **Select device:** Other (Custom name)
   - Masukkan: "MTs Nurul Aiman System"
7. Klik **Generate**
8. **Copy password 16 karakter** yang muncul

### 2. Update File .env

Buka file `.env` di root project dan pastikan ada konfigurasi:

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

**Ganti:**
- `xxxx xxxx xxxx xxxx` dengan App Password yang sudah dibuat

### 3. Clear Cache

Setelah update `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test Email

Test dengan command:

```bash
php artisan email:test mawarkusuma694@gmail.com
```

## 🛡️ Cara Mencegah Email Masuk ke Spam

### Buat Filter Gmail (Paling Efektif):

1. **Buka Gmail:** https://mail.google.com
2. **Klik Settings** (⚙️) → **"Lihat semua pengaturan"**
3. **Tab "Filter dan Alamat yang Diblokir"** → **"Buat filter baru"**
4. **Masukkan:**
   - **Dari (From):** `mawarkusuma694@gmail.com` (atau email di MAIL_FROM_ADDRESS)
   - **Atau subjek berisi:** `Notifikasi Login` atau `Notifikasi Logout`
5. **Klik "Buat filter"**
6. **Centang:**
   - ✅ "Jangan pernah mengirim ke Spam"
   - ✅ "Selalu tandai sebagai penting"
7. **Klik "Buat filter"**

**Hasil:** Email dari sistem akan selalu masuk ke Inbox dan tidak masuk ke Spam lagi.

**📖 Lihat file `CARA_HINDARI_SPAM.md` untuk panduan lengkap!**

## 🛠️ Troubleshooting

### Email Tidak Masuk?

1. **Cek Spam/Junk folder** - Email mungkin masuk ke spam
2. **Jika ada di Spam:** Klik email → Klik **"Bukan spam"** → Buat filter Gmail (lihat di atas)
3. **Cek App Password** - Pastikan benar dan tidak ada spasi
4. **Cek Log Laravel** - Lihat `storage/logs/laravel.log`
5. **Test dengan command:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

### Email Masih Masuk ke Spam?

1. **Pastikan `MAIL_FROM_ADDRESS` sama dengan `MAIL_USERNAME`** di file `.env`
2. **Buat filter Gmail** (lihat di atas) - Ini yang paling efektif
3. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Notifikasi Masuk ke Email Lain?

**TIDAK MUNGKIN!** Sistem sudah dipastikan:
- ✅ Email notifikasi = Email login (sinkron otomatis)
- ✅ Menggunakan `Mail::to($user->email)`
- ✅ `$user->email` adalah email yang digunakan untuk login
- ✅ Login dengan `mawarkusuma694@gmail.com` → Notifikasi pasti masuk ke `mawarkusuma694@gmail.com`

### Email Masuk Tapi Lambat?

- Email dikirim secara synchronous (langsung)
- Biasanya masuk dalam 5-30 detik
- Jika lambat, cek koneksi internet atau server SMTP

## ✅ Checklist Sinkronisasi

Pastikan semua sudah benar:

- [x] User Mawar sudah terdaftar di database
- [x] Email: mawarkusuma694@gmail.com
- [x] Password: Mawar2024!
- [x] Role: guru
- [x] SMTP sudah dikonfigurasi di .env
- [x] Gmail App Password sudah dibuat
- [x] Cache sudah di-clear
- [x] Test email berhasil

## 📝 Catatan Penting

✅ **Sinkronisasi Otomatis:**
- Email login = Email notifikasi (100% sinkron)
- Tidak perlu konfigurasi per user
- Sistem otomatis mengirim ke email yang sama dengan email login

✅ **Keamanan:**
- Notifikasi membantu deteksi aktivitas mencurigakan
- Jika login tidak dikenal, ada peringatan di email
- IP address dan device tercatat untuk audit

✅ **Otomatis:**
- Tidak perlu klik atau konfirmasi
- Email dikirim otomatis saat login/logout
- Tidak ada delay atau manual trigger

---

**Status:** ✅ Aktif dan Tersinkron  
**Email:** mawarkusuma694@gmail.com  
**Update:** 22 November 2024  
**Sistem:** TMS NURANI - MTs Nurul Aiman Tanjungsari

