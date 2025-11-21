# ✅ Solusi Lengkap: Email Notifikasi Masuk ke Gmail

## 🎯 Masalah

Email notifikasi **tidak masuk sama sekali** (tidak ada di Inbox maupun Spam).

## ✅ Solusi (Langkah Demi Langkah)

### ⚠️ LANGKAH 1: Setup SMTP (WAJIB - Sekali Saja)

**Masalah:** Email tidak terkirim karena SMTP belum dikonfigurasi.

#### 1.1 Buat Gmail App Password

1. Buka: https://myaccount.google.com/
2. Login dengan email Gmail (misalnya: `mawarkusuma694@gmail.com`)
3. **Security** → **2-Step Verification** (aktifkan dulu)
4. **App passwords** → **Generate**
   - **App:** Mail
   - **Device:** Other (Custom name)
   - **Name:** "MTs Nurul Aiman System"
5. **Copy password 16 karakter**

#### 1.2 Jalankan Command Setup

```bash
php artisan gmail:setup mawarkusuma694@gmail.com "xxxx xxxx xxxx xxxx"
```

**Ganti `xxxx xxxx xxxx xxxx` dengan App Password!**

#### 1.3 Verifikasi Setup

```bash
php artisan email:test mawarkusuma694@gmail.com
```

**Jika berhasil:**
```
✅ Email berhasil dikirim!
📬 Cek inbox Gmail: mawarkusuma694@gmail.com
```

**Jika gagal:**
- Cek App Password sudah benar
- Cek 2-Step Verification sudah aktif
- Cek file `.env` sudah diupdate

---

### 📬 LANGKAH 2: Cek Gmail (Setelah Login)

#### 2.1 Login ke Sistem

- Email: `mawarkusuma694@gmail.com`
- Password: `Mawar2024!`
- Role: `guru`

#### 2.2 Buka Gmail

1. Buka: https://mail.google.com
2. Login dengan: `mawarkusuma694@gmail.com`

#### 2.3 Cek Email

**Cek di 2 tempat:**

1. **Kotak Masuk (Inbox)**
   - Buka folder "Kotak Masuk"
   - Email notifikasi akan muncul dengan subject: "Notifikasi Login - Guru MTs Nurul Aiman"

2. **Spam (Jika tidak ada di Inbox)**
   - Buka folder "Spam"
   - Jika ada email notifikasi:
     - Klik checkbox di sebelah email
     - Klik "Bukan spam" (Not spam)
     - Email akan dipindahkan ke Inbox

---

### 🛡️ LANGKAH 3: Buat Filter Gmail (Opsional - Agar Selalu Masuk Inbox)

**Ini memastikan email selalu masuk ke Inbox, bukan Spam.**

1. Gmail → **Settings** (⚙️) → **"Lihat semua pengaturan"**
2. **"Filter dan Alamat yang Diblokir"** → **"Buat filter baru"**
3. **Dari (From):** `mawarkusuma694@gmail.com`
4. **"Buat filter"** → Centang:
   - ✅ **"Jangan pernah mengirim ke Spam"** (PENTING!)
   - ✅ "Selalu tandai sebagai penting"
5. **"Buat filter"**

**Hasil:** Email akan selalu masuk ke Inbox!

---

## 🔍 Troubleshooting

### Email Tidak Terkirim Sama Sekali?

1. **Cek konfigurasi:**
   ```bash
   php artisan tinker --execute="echo 'MAIL_MAILER: ' . config('mail.default');"
   ```
   **Harus:** `MAIL_MAILER: smtp` (bukan `log`)

2. **Cek file `.env`:**
   - Pastikan `MAIL_MAILER=smtp`
   - Pastikan `MAIL_USERNAME` sudah diisi
   - Pastikan `MAIL_PASSWORD` sudah diisi dengan App Password

3. **Clear cache:**
   ```bash
   php artisan config:clear
   ```

4. **Test lagi:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

### Email Terkirim Tapi Masuk ke Spam?

1. **Tandai "Bukan spam"** di Gmail
2. **Buat filter Gmail** (Langkah 3 di atas)
3. **Tunggu beberapa jam** - Gmail perlu waktu untuk belajar

### Email Masih Tidak Masuk?

1. **Cek folder Spam** - Mungkin masuk ke Spam
2. **Cek log Laravel:**
   ```bash
   type storage\logs\laravel.log | findstr "email\|mail\|notification"
   ```
3. **Pastikan App Password benar** - Harus 16 karakter
4. **Pastikan 2-Step Verification aktif**

---

## ✅ Checklist Lengkap

- [ ] **Gmail App Password sudah dibuat**
- [ ] **Command `gmail:setup` sudah dijalankan**
- [ ] **`MAIL_MAILER=smtp`** (bukan `log`)
- [ ] **`MAIL_USERNAME` sudah diisi**
- [ ] **`MAIL_PASSWORD` sudah diisi dengan App Password**
- [ ] **Cache sudah di-clear**
- [ ] **Test email berhasil**
- [ ] **Login ke sistem berhasil**
- [ ] **Email masuk ke Gmail** (Inbox atau Spam)
- [ ] **Filter Gmail sudah dibuat** (opsional)

---

## 📝 Catatan Penting

✅ **Setup hanya sekali:** Setelah setup, semua guru otomatis menerima notifikasi

✅ **Guru tidak perlu setup:** Cukup login dan cek Gmail

✅ **Sinkronisasi otomatis:** Login dengan email → Notifikasi masuk ke email yang sama

---

**Status:** ✅ Solusi Lengkap Tersedia  
**Waktu Setup:** ~5 menit (sekali saja)  
**Tingkat Kesulitan:** ⭐ Mudah

