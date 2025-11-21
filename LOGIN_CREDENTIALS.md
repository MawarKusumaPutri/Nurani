# 🔐 LOGIN CREDENTIALS - TMS NURANI

## ⚠️ **PENTING: Setup SMTP untuk Notifikasi Email**

**Sebelum login, pastikan SMTP sudah dikonfigurasi!**

Saat ini Mail Driver masih menggunakan `log`, sehingga email tidak terkirim ke Gmail. 

**Cara perbaiki:**
1. Buka file `.env` di root project
2. Ubah `MAIL_MAILER=log` menjadi `MAIL_MAILER=smtp`
3. Tambahkan konfigurasi SMTP Gmail (lihat bagian Setup SMTP)
4. Jalankan: `php artisan config:clear`
5. Test: `php artisan email:test mawarkusuma694@gmail.com`

**Lihat file `PERBAIKAN_EMAIL.md` untuk panduan lengkap!**

---

## 📋 **Data Login untuk Sistem TMS NURANI**

### 👨‍💼 **KEPALA SEKOLAH (Principal)**
```
Nama: Maman Suparman, A.KS - Kepala Madrasah
Email: mamansuparmanaks07@gmail.com
Password: AdminKS@2024
```

### 👩‍💼 **TENAGA USAHA (Administrative Staff)**
```
Email: internal.nurulaiman@gmail.com
Password: AdminTU@2024
```

---

## 👨‍🏫 **Daftar Login Guru Individual**

### **1. Nurhadi, S.Pd (Matematika)**
```
Email: mundarinurhadi@gmail.com
Password: Nurhadi2024!
Mata Pelajaran: Matematika (1 mata pelajaran)
```

### **2. Keysa Anjani (Bahasa Inggris)**
```
Email: keysa8406@gmail.com
Password: Keysha2024!
Mata Pelajaran: Bahasa Inggris (1 mata pelajaran)
```

### **3. Fadli (Bahasa Arab)**
```
Email: fadliziyad123@gmail.com
Password: Fadli2024!
Mata Pelajaran: Bahasa Arab (1 mata pelajaran)
```

### **4. Siti Mundari, S.Ag (IPA, Prakarya)**
```
Email: sitimundari54@gmail.com
Password: SitiMundari2024!
Mata Pelajaran: IPA, Prakarya (2 mata pelajaran)
```

### **5. Lola Nurlaela, S.Pd.I. (SKI, Akidah Akhlak)**
```
Email: lola.nurlaela@mtssnuraiman.sch.id
Password: LolaNurlaela2024!
Mata Pelajaran: SKI, Akidah Akhlak (2 mata pelajaran)
```

### **6. Desi Nurfalah (Bahasa Indonesia)**
```
Email: desinurfalah24@gmail.com
Password: DesyNurfalah2024!
Mata Pelajaran: Bahasa Indonesia (1 mata pelajaran)
```

### **7. M. Rizmal Maulana (QH, FIQIH)**
```
Email: rizmalmaulana25@gmail.com
Password: RizmalMaulana2024!
Mata Pelajaran: QH, FIQIH (2 mata pelajaran)
```

### **8. Hamzah Najmudin (PJOK, IPS)**
```
Email: zahnajmudin10@gmail.com
Password: HamzahNazmudin2024!
Mata Pelajaran: PJOK, IPS (2 mata pelajaran)
```

### **9. Sopyan (PKN)**
```
Email: sopyanikhsananda@gmail.com
Password: Sopyan2024!
Mata Pelajaran: PKN (1 mata pelajaran)
```

### **10. Syifa Restu R (Seni Budaya)**
```
Email: syifarestu81@gmail.com
Password: SyifaRestu2024!
Mata Pelajaran: Seni Budaya (1 mata pelajaran)
```

### **11. Weni Azmi (Tahsin)**
```
Email: wenibustamin27@gmail.com
Password: Weny2024!
Mata Pelajaran: Tahsin (1 mata pelajaran)
```

### **12. Tintin Martini (BTQ)**
```
Email: tintinmartini184@gmail.com
Password: TintinMartini2024!
Mata Pelajaran: BTQ (1 mata pelajaran)
```

### **13. Mawar**
```
Email: mawarkusuma694@gmail.com
Password: Mawar2024!
Mata Pelajaran: Belum ditentukan
```

---

## 📧 **Daftar Email Gmail yang Terdaftar (Sinkron untuk Notifikasi)**

Semua email berikut sudah terdaftar dan tersinkron dengan sistem untuk menerima notifikasi:

### **Guru:**
1. `mundarinurhadi@gmail.com` - Nurhadi, S.Pd
2. `keysa8406@gmail.com` - Keysa Anjani
3. `fadliziyad123@gmail.com` - Fadli
4. `sitimundari54@gmail.com` - Siti Mundari, S.Ag
5. `desinurfalah24@gmail.com` - Desi Nurfalah
6. `rizmalmaulana25@gmail.com` - M. Rizmal Maulana
7. `zahnajmudin10@gmail.com` - Hamzah Najmudin
8. `sopyanikhsananda@gmail.com` - Sopyan
9. `syifarestu81@gmail.com` - Syifa Restu R
10. `wenibustamin27@gmail.com` - Weni Azmi
11. `tintinmartini184@gmail.com` - Tintin Martini
12. `mawarkusuma694@gmail.com` - Mawar
13. `lola.nurlaela@mtssnuraiman.sch.id` - Lola Nurlaela, S.Pd.I.

### **Kepala Sekolah:**
- `mamansuparmanaks07@gmail.com` - Maman Suparman, A.KS

### **Tenaga Usaha:**
- `internal.nurulaiman@gmail.com` - Tenaga Usaha MTs Nurul Aiman

---

## 🔑 **Informasi Tambahan**

### **Format Email:**
- Email guru, kepala sekolah, dan tenaga usaha menggunakan Gmail individual sesuai dengan data yang telah ditentukan
- Semua email Gmail sudah tersinkron dan siap menerima notifikasi dari sistem

### **Sinkronisasi Gmail untuk Notifikasi:**

✅ **Sistem notifikasi email sudah aktif!** Setiap kali ada aktivitas login/logout, notifikasi otomatis akan dikirim ke email Gmail yang terdaftar.

#### **Setup Konfigurasi SMTP Gmail:**

Untuk mengaktifkan notifikasi email Gmail, pastikan konfigurasi SMTP sudah diatur di file `.env`:

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

#### **Cara Membuat Gmail App Password:**

1. Buka [Google Account Settings](https://myaccount.google.com/)
2. Pilih **Security** → **2-Step Verification** (harus aktif dulu)
3. Scroll ke bawah, pilih **App passwords**
4. Pilih **Mail** dan **Other (Custom name)**
5. Masukkan nama: "MTs Nurul Aiman System"
6. Klik **Generate**
7. **Copy password yang dihasilkan** (16 karakter tanpa spasi)
8. Paste password tersebut di `MAIL_PASSWORD` di file `.env`

#### **Jenis Notifikasi yang Dikirim:**

✅ **Notifikasi Login:**
- Dikirim otomatis saat user berhasil login
- **SINKRON OTOMATIS:** Email notifikasi = Email yang digunakan untuk login
- Contoh: Login dengan `mawarkusuma694@gmail.com` → Notifikasi masuk ke `mawarkusuma694@gmail.com`
- Berisi informasi: nama, email, waktu login, IP address, device
- Mengingatkan keamanan akun jika login tidak dikenal

✅ **Notifikasi Logout:**
- Dikirim otomatis saat user logout
- **SINKRON OTOMATIS:** Email notifikasi = Email yang digunakan untuk login
- Berisi informasi: nama, email, waktu logout, IP address

#### **Testing Notifikasi:**

Setelah setup SMTP, test dengan login menggunakan:
- **Email:** `mawarkusuma694@gmail.com`
- **Password:** `Mawar2024!`
- **Role:** `guru`

Notifikasi akan otomatis masuk ke Gmail dalam beberapa detik setelah login berhasil.

### **Format Password:**
- Minimal 8 karakter
- Kombinasi huruf besar, huruf kecil, angka, dan simbol
- Menggunakan format yang mudah diingat

### **Role Access:**
- **Guru**: Akses ke modul pembelajaran, materi, kuis, dan laporan siswa
- **Kepala Sekolah**: Akses penuh ke semua modul dan laporan sekolah
- **TU**: Akses ke modul administrasi, data siswa, dan laporan keuangan

---

## 📝 **Cara Login:**

1. **Buka Website**: Akses `http://127.0.0.1:8000`
2. **Klik Tombol LOGIN**: Di pojok kanan atas
3. **Pilih Role**: Guru, Kepala Sekolah, atau Tenaga Usaha
4. **Masukkan Kredensial**: Email dan password sesuai role
5. **Klik Login**: Untuk masuk ke dashboard

---

## ⚠️ **Catatan Penting:**

- **Jangan bagikan kredensial** ini kepada pihak yang tidak berwenang
- **Ganti password** secara berkala untuk keamanan
- **Logout** setelah selesai menggunakan sistem
- **Hubungi admin** jika ada masalah dengan login

---

## 🆘 **Troubleshooting:**

### **Jika Login Gagal:**
1. Pastikan email dan password benar
2. Periksa koneksi internet
3. Clear cache browser
4. Hubungi admin sistem

### **Jika Lupa Password:**
- Hubungi admin untuk reset password
- Email: admin@mtssnuraiman.sch.id
- Phone: 0856-2452-5034

---

**📅 Dibuat:** 22 Oktober 2025  
**👨‍💻 Admin:** TMS NURANI Development Team  
**🏫 Sekolah:** MTs Nurul Aiman Tanjungsari