# 📧 Sistem Notifikasi Email - Sinkron Otomatis

## ✅ Cara Kerja Notifikasi Email

Sistem notifikasi email **sudah aktif dan tersinkron otomatis**. Setiap kali Anda login menggunakan email tertentu, notifikasi akan **otomatis masuk ke Gmail yang sama** dengan email yang Anda gunakan untuk login.

## 🔄 Prinsip Sinkronisasi

**Email Login = Email Notifikasi**

Contoh:
- Jika login dengan: `mawarkusuma694@gmail.com`
- Maka notifikasi masuk ke: `mawarkusuma694@gmail.com` ✅
- **TIDAK** masuk ke email lain

## 📋 Contoh Skenario

### Skenario 1: Login sebagai Mawar
```
Email Login: mawarkusuma694@gmail.com
Password: Mawar2024!
Role: guru
```

**Hasil:**
- ✅ Notifikasi login masuk ke: `mawarkusuma694@gmail.com`
- ✅ Email berisi informasi login Mawar
- ✅ Waktu, IP address, dan device tercatat

### Skenario 2: Login sebagai Keysa
```
Email Login: keysa8406@gmail.com
Password: Keysha2024!
Role: guru
```

**Hasil:**
- ✅ Notifikasi login masuk ke: `keysa8406@gmail.com`
- ✅ Email berisi informasi login Keysa
- ✅ Setiap guru mendapat notifikasi di email masing-masing

### Skenario 3: Login sebagai Kepala Sekolah
```
Email Login: mamansuparmanaks07@gmail.com
Password: AdminKS@2024
Role: kepala_sekolah
```

**Hasil:**
- ✅ Notifikasi login masuk ke: `mamansuparmanaks07@gmail.com`
- ✅ Email berisi informasi login Kepala Sekolah

## 🔔 Jenis Notifikasi yang Dikirim

### 1. Notifikasi Login (Otomatis)
**Dikirim saat:** User berhasil login  
**Ke:** Email yang digunakan untuk login  
**Berisi:**
- Nama lengkap user
- Email yang digunakan
- Role (Guru/Kepala Sekolah/TU)
- Waktu login (tanggal & jam)
- IP Address
- Device/User Agent
- Peringatan keamanan

**Contoh Subject:**
```
🔔 Notifikasi Login - Guru MTs Nurul Aiman
```

### 2. Notifikasi Logout (Otomatis)
**Dikirim saat:** User logout  
**Ke:** Email yang digunakan untuk login  
**Berisi:**
- Nama lengkap user
- Email yang digunakan
- Waktu logout
- IP Address

**Contoh Subject:**
```
👋 Notifikasi Logout - MTs Nurul Aiman
```

## 📧 Daftar Email yang Menerima Notifikasi

Semua email berikut **otomatis menerima notifikasi** saat login/logout:

### Guru (13 orang):
1. `mundarinurhadi@gmail.com` → Notifikasi masuk ke email ini
2. `keysa8406@gmail.com` → Notifikasi masuk ke email ini
3. `fadliziyad123@gmail.com` → Notifikasi masuk ke email ini
4. `sitimundari54@gmail.com` → Notifikasi masuk ke email ini
5. `desinurfalah24@gmail.com` → Notifikasi masuk ke email ini
6. `rizmalmaulana25@gmail.com` → Notifikasi masuk ke email ini
7. `zahnajmudin10@gmail.com` → Notifikasi masuk ke email ini
8. `sopyanikhsananda@gmail.com` → Notifikasi masuk ke email ini
9. `syifarestu81@gmail.com` → Notifikasi masuk ke email ini
10. `wenibustamin27@gmail.com` → Notifikasi masuk ke email ini
11. `tintinmartini184@gmail.com` → Notifikasi masuk ke email ini
12. `mawarkusuma694@gmail.com` → Notifikasi masuk ke email ini ⭐
13. `lola.nurlaela@mtssnuraiman.sch.id` → Notifikasi masuk ke email ini

### Kepala Sekolah:
- `mamansuparmanaks07@gmail.com` → Notifikasi masuk ke email ini

### Tenaga Usaha:
- `internal.nurulaiman@gmail.com` → Notifikasi masuk ke email ini

## ✅ Verifikasi Sistem

### Cara Test Notifikasi:

1. **Login dengan email Mawar:**
   ```
   Email: mawarkusuma694@gmail.com
   Password: Mawar2024!
   Role: guru
   ```

2. **Cek Gmail:**
   - Buka Gmail: `mawarkusuma694@gmail.com`
   - Cek folder **Inbox** atau **Spam**
   - Notifikasi akan masuk dalam **beberapa detik**

3. **Isi Email Notifikasi:**
   - Subject: "🔔 Notifikasi Login - Guru MTs Nurul Aiman"
   - Nama: Mawar
   - Email: mawarkusuma694@gmail.com
   - Waktu login
   - IP Address
   - Device info

## 🔧 Setup SMTP (Jika Belum)

Untuk mengaktifkan pengiriman email, setup SMTP di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**Cara membuat Gmail App Password:**
1. Buka [Google Account](https://myaccount.google.com/)
2. Security → 2-Step Verification (aktifkan dulu)
3. App passwords → Generate untuk "Mail"
4. Copy password 16 karakter ke `MAIL_PASSWORD`

## 🛠️ Troubleshooting

### Email tidak masuk?

1. **Cek Spam/Junk folder** - Email mungkin masuk ke spam
2. **Cek App Password** - Pastikan benar dan tidak ada spasi
3. **Cek Log Laravel** - Lihat `storage/logs/laravel.log`
4. **Test dengan email lain** - Coba login dengan email guru lain

### Notifikasi masuk ke email yang salah?

**TIDAK MUNGKIN!** Sistem sudah dipastikan:
- ✅ Email notifikasi = Email login (sinkron otomatis)
- ✅ Menggunakan `Mail::to($user->email)` 
- ✅ `$user->email` adalah email yang digunakan untuk login

### Email masuk tapi lambat?

- Email dikirim secara synchronous (langsung)
- Biasanya masuk dalam 5-30 detik
- Jika lambat, cek koneksi internet atau server SMTP

## 📝 Catatan Penting

✅ **Sinkronisasi Otomatis:**
- Email login = Email notifikasi (100% sinkron)
- Tidak perlu konfigurasi per user
- Semua email Gmail sudah terdaftar

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
**Update:** {{ date('d F Y') }}  
**Sistem:** TMS NURANI - MTs Nurul Aiman Tanjungsari

