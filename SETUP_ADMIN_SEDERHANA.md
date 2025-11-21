# ⚙️ Setup Email untuk Admin (Sekali Saja)

## 🎯 Untuk Admin Sistem

Panduan ini **hanya untuk admin** yang akan setup email notifikasi. **Guru tidak perlu melakukan ini!**

## ✅ Setup Sekali Saja (5 Menit)

### Langkah 1: Buat Gmail App Password

1. Buka: https://myaccount.google.com/
2. Login dengan email Gmail yang akan digunakan (misalnya: `internal.nurulaiman@gmail.com`)
3. **Security** → **2-Step Verification** (aktifkan dulu jika belum)
4. Scroll ke bawah → **App passwords**
5. Pilih:
   - **App:** Mail
   - **Device:** Other (Custom name)
   - **Name:** "MTs Nurul Aiman System"
6. Klik **Generate**
7. **Copy password 16 karakter** (contoh: `abcd efgh ijkl mnop`)

### Langkah 2: Jalankan Command Setup

Jalankan di terminal:

```bash
php artisan gmail:setup internal.nurulaiman@gmail.com "xxxx xxxx xxxx xxxx"
```

**Ganti `xxxx xxxx xxxx xxxx` dengan App Password yang sudah dibuat.**

### Langkah 3: Selesai!

Setup selesai! Sekarang semua guru akan otomatis menerima notifikasi email.

---

## ✅ Cara Test

Test dengan command:

```bash
php artisan email:test mawarkusuma694@gmail.com
```

Atau test dengan login:
- Email: `mawarkusuma694@gmail.com`
- Password: `Mawar2024!`
- Role: `guru`

---

## 📋 Konfigurasi yang Benar

Setelah setup, file `.env` akan berisi:

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

---

## 🎯 Hasil Setelah Setup

✅ **Semua guru otomatis menerima notifikasi:**
- Login dengan email mereka → Notifikasi masuk ke email mereka
- Tidak perlu setup manual per guru
- Sistem bekerja otomatis untuk semua

✅ **Guru hanya perlu:**
- Login ke sistem
- Cek Gmail mereka
- Selesai!

---

**Waktu Setup:** ~5 menit (sekali saja)  
**Untuk:** Admin sistem  
**Guru:** Tidak perlu setup apapun!

