# 📧 Setup Email Notifikasi Gmail

## ✅ Status: Sistem Notifikasi Email Sudah Aktif!

Sistem notifikasi email otomatis sudah terintegrasi. Setiap kali ada aktivitas login/logout, notifikasi akan otomatis dikirim ke email Gmail yang terdaftar.

## 🚀 Cara Setup SMTP Gmail

### 1. Buat Gmail App Password

1. Buka [Google Account](https://myaccount.google.com/)
2. Pilih **Security** (Keamanan)
3. Pastikan **2-Step Verification** sudah aktif
4. Scroll ke bawah, klik **App passwords**
5. Pilih:
   - **Select app:** Mail
   - **Select device:** Other (Custom name)
   - Masukkan: "MTs Nurul Aiman System"
6. Klik **Generate**
7. **Copy password 16 karakter** yang dihasilkan (tanpa spasi)

### 2. Konfigurasi File .env

Buka file `.env` di root project dan tambahkan/update konfigurasi berikut:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="MTs Nurul Aiman"
```

**Contoh:**
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

### 3. Clear Cache

Setelah update `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test Notifikasi

Login dengan akun guru (misalnya Mawar):
- **Email:** `mawarkusuma694@gmail.com`
- **Password:** `Mawar2024!`
- **Role:** `guru`

Notifikasi akan masuk ke Gmail dalam beberapa detik!

## 📋 Daftar Email yang Menerima Notifikasi

Semua email Gmail berikut akan otomatis menerima notifikasi:

### Guru:
- mundarinurhadi@gmail.com
- keysa8406@gmail.com
- fadliziyad123@gmail.com
- sitimundari54@gmail.com
- desinurfalah24@gmail.com
- rizmalmaulana25@gmail.com
- zahnajmudin10@gmail.com
- sopyanikhsananda@gmail.com
- syifarestu81@gmail.com
- wenibustamin27@gmail.com
- tintinmartini184@gmail.com
- mawarkusuma694@gmail.com
- lola.nurlaela@mtssnuraiman.sch.id

### Kepala Sekolah:
- mamansuparmanaks07@gmail.com

### Tenaga Usaha:
- internal.nurulaiman@gmail.com

## 🔔 Jenis Notifikasi

### 1. Notifikasi Login
**Dikirim saat:** User berhasil login  
**Berisi:**
- Nama user
- Email
- Waktu login
- IP Address
- Device/User Agent
- Peringatan keamanan jika login tidak dikenal

### 2. Notifikasi Logout
**Dikirim saat:** User logout  
**Berisi:**
- Nama user
- Email
- Waktu logout
- IP Address

## 🛠️ Troubleshooting

### Email tidak masuk?

1. **Cek Spam/Junk folder** - Email mungkin masuk ke folder spam
2. **Cek App Password** - Pastikan menggunakan App Password, bukan password biasa
3. **Cek 2-Step Verification** - Harus aktif untuk membuat App Password
4. **Cek Log Laravel** - Lihat `storage/logs/laravel.log` untuk error
5. **Test dengan Mailtrap** - Untuk development, bisa gunakan Mailtrap

### Error "Authentication failed"?

- Pastikan App Password benar (16 karakter tanpa spasi)
- Pastikan 2-Step Verification aktif
- Coba generate App Password baru

### Email masuk tapi lambat?

- Email dikirim secara synchronous (langsung)
- Untuk production, bisa setup queue untuk email lebih cepat
- Jalankan: `php artisan queue:work`

## 📝 Catatan Penting

- ✅ Semua email Gmail sudah tersinkron
- ✅ Notifikasi otomatis aktif setelah setup SMTP
- ✅ Email dikirim ke email yang digunakan untuk login
- ✅ Tidak perlu konfigurasi tambahan per user

## 🔒 Keamanan

- App Password hanya untuk aplikasi, bukan password utama
- Jika App Password bocor, bisa dihapus dan buat baru tanpa mengubah password Gmail
- Email notifikasi membantu deteksi aktivitas mencurigakan

---

**Dibuat:** {{ date('d F Y') }}  
**Sistem:** TMS NURANI - MTs Nurul Aiman Tanjungsari

