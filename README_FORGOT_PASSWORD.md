# 🔑 Forgot Password - Bekerja untuk Semua Role

## ✅ Status: Aktif untuk Semua!

Sistem forgot password **sudah bekerja dengan benar** untuk:
- ✅ **13 Guru** - Semua guru bisa reset password
- ✅ **1 Tenaga Usaha (TU)** - TU bisa reset password  
- ✅ **1 Kepala Sekolah** - Kepala sekolah bisa reset password

**Total: 15 user bisa reset password!**

---

## 🚀 Cara Menggunakan (Sangat Mudah!)

### Untuk Semua Role (Guru/TU/Kepala Sekolah):

1. **Klik "Forgot password?"** di halaman login
2. **Pilih Role** sesuai dengan role Anda:
   - **Guru** - Untuk semua guru
   - **Kepala Sekolah** - Untuk kepala sekolah
   - **Tenaga Usaha** - Untuk TU
3. **Masukkan Email Gmail** yang terdaftar
4. **Klik "Kirim Link Reset Password"**
5. **Langsung diarahkan ke halaman reset password**
6. **Masukkan password baru** (minimal 8 karakter)
7. **Konfirmasi password baru**
8. **Klik "Reset Password"**
9. **Login dengan password baru**

**Selesai!** Tidak perlu setup apapun, langsung bekerja!

---

## 📋 Contoh untuk Setiap Role

### 👨‍🏫 Contoh: Guru (Mawar)

1. Klik "Forgot password?"
2. Role: **Guru**
3. Email: `mawarkusuma694@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

### 👨‍💼 Contoh: Kepala Sekolah

1. Klik "Forgot password?"
2. Role: **Kepala Sekolah**
3. Email: `mamansuparmanaks07@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

### 👩‍💼 Contoh: Tenaga Usaha (TU)

1. Klik "Forgot password?"
2. Role: **Tenaga Usaha**
3. Email: `internal.nurulaiman@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

---

## ✅ Verifikasi Semua Role Bisa Reset Password

Jalankan command untuk cek:

```bash
php artisan password:test
```

Command ini akan menampilkan:
- ✅ Daftar semua guru yang bisa reset password
- ✅ Daftar TU yang bisa reset password
- ✅ Daftar kepala sekolah yang bisa reset password
- ✅ Cara test untuk setiap role

---

## 🔒 Keamanan

✅ **Validasi Role:**
- Email dan role harus cocok
- Email guru harus dengan role guru
- Email kepala sekolah harus dengan role kepala sekolah
- Email TU harus dengan role tenaga usaha

✅ **Token Reset:**
- Token berlaku 60 menit
- Token di-hash di database
- Token hanya bisa digunakan sekali

✅ **Password Baru:**
- Minimal 8 karakter
- Harus dikonfirmasi (ulangi password)

---

## 📝 Catatan Penting

✅ **Sistem Otomatis:**
- Tidak perlu setup apapun
- Bekerja untuk semua role
- Langsung redirect ke halaman reset password

✅ **Email Opsional:**
- Jika SMTP sudah dikonfigurasi, email juga dikirim ke Gmail
- Jika belum, tetap bisa reset password langsung di halaman

✅ **Sinkronisasi:**
- Email reset password = Email yang digunakan untuk request
- Sama seperti sistem notifikasi login/logout

---

## 🆘 Troubleshooting

### Email tidak ditemukan?

**Pastikan:**
- Email benar sesuai dengan yang terdaftar
- Role benar (email guru harus dengan role guru)
- Lihat daftar email di `LOGIN_CREDENTIALS.md`

### Token tidak valid?

- Link mungkin sudah kadaluarsa (lebih dari 60 menit)
- Request reset password baru
- Pastikan link di-copy dengan lengkap

---

**Status:** ✅ Aktif untuk Semua Role  
**Total User:** 15 (13 Guru + 1 TU + 1 Kepala Sekolah)  
**Tingkat Kesulitan:** ⭐ Sangat Mudah

