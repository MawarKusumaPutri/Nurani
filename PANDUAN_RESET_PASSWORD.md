# 🔑 Panduan Reset Password - Mudah dan Sederhana

## ✅ Cara Kerja (Otomatis - Tidak Perlu Setup!)

Sistem reset password **sudah otomatis bekerja**! 

**Cara kerja:**
1. Klik "Forgot password?"
2. Masukkan email dan role
3. **Link reset password muncul langsung di halaman!**
4. Klik link → Reset password → Selesai!

**Tidak perlu menunggu email!** Link sudah muncul langsung di halaman.

## 📬 Cara Menggunakan

### Langkah 1: Klik "Forgot password?"

1. Buka halaman login
2. Klik link **"Forgot password?"** atau **"Lupa password?"**

### Langkah 2: Masukkan Email dan Role

1. Pilih **Role** (Guru/Kepala Sekolah/Tenaga Usaha)
2. Masukkan **Email** Gmail Anda
3. Klik **"Kirim Link Reset Password"**

### Langkah 3: Klik Link Reset Password

**Link reset password akan muncul langsung di halaman!**

1. **Setelah klik "Kirim Link Reset Password"**, link akan muncul di halaman
2. **Klik tombol hijau** "Klik di sini untuk Reset Password"
   - Atau copy-paste link yang ada di bawah tombol
3. **Halaman reset password akan terbuka**

**📧 Catatan:** Jika SMTP sudah dikonfigurasi, link juga akan dikirim ke email Gmail Anda. Tapi tidak perlu menunggu email - link sudah muncul langsung di halaman!

### Langkah 5: Masukkan Password Baru

1. **Masukkan password baru** (minimal 8 karakter)
2. **Konfirmasi password baru** (ulangi password yang sama)
3. Klik **"Reset Password"**

### Langkah 6: Login dengan Password Baru

1. Kembali ke halaman login
2. Login dengan:
   - **Email:** Email Gmail Anda
   - **Password:** Password baru yang sudah dibuat
   - **Role:** Role yang sesuai

**Selesai!** Password sudah berhasil direset.

---

## ⚠️ Jika Email Tidak Masuk

### Cek Folder Spam

1. Buka Gmail → Folder **"Spam"**
2. Jika ada email reset password:
   - Klik checkbox di sebelah email
   - Klik **"Bukan spam"** (Not spam)
   - Email akan dipindahkan ke Inbox

### Pastikan SMTP Sudah Dikonfigurasi

Jika email tidak terkirim sama sekali, pastikan SMTP sudah dikonfigurasi:

1. **Buat Gmail App Password** (lihat panduan di bawah)
2. **Jalankan command:**
   ```bash
   php artisan gmail:setup mawarkusuma694@gmail.com "xxxx xxxx xxxx xxxx"
   ```
   (Ganti dengan email dan App Password Anda)

3. **Test email:**
   ```bash
   php artisan email:test mawarkusuma694@gmail.com
   ```

**📖 Lihat `PERBAIKAN_URGEN_EMAIL.md` untuk panduan lengkap setup SMTP!**

---

## 🔒 Keamanan

✅ **Token Reset Password:**
- Berlaku selama **60 menit**
- Setelah 60 menit, token akan kadaluarsa
- Jika kadaluarsa, request reset password baru

✅ **Password Baru:**
- Minimal **8 karakter**
- Disarankan kombinasi huruf, angka, dan simbol

✅ **Email Reset:**
- Dikirim ke email Gmail yang terdaftar
- Hanya bisa diakses dari email yang sama

---

## ❓ Pertanyaan Umum

### Q: Email tidak masuk ke Gmail?
**A:** 
1. Cek folder **Spam** di Gmail
2. Pastikan SMTP sudah dikonfigurasi (lihat di atas)
3. Tunggu beberapa detik - email mungkin masih dalam proses pengiriman

### Q: Link reset password tidak bekerja?
**A:**
- Token mungkin sudah kadaluarsa (60 menit)
- Request reset password baru
- Pastikan link di-copy dengan lengkap

### Q: Lupa email yang terdaftar?
**A:**
- Hubungi admin sistem
- Admin akan membantu reset password

### Q: Berapa lama email terkirim?
**A:**
- Biasanya **5-30 detik** setelah klik "Kirim Link Reset Password"
- Jika lebih dari 1 menit, cek folder Spam atau pastikan SMTP sudah dikonfigurasi

---

## 📋 Checklist

- [ ] Klik "Forgot password?"
- [ ] Masukkan Role dan Email
- [ ] Klik "Kirim Link Reset Password"
- [ ] Cek Gmail (Inbox atau Spam)
- [ ] Klik link reset password di email
- [ ] Masukkan password baru
- [ ] Konfirmasi password baru
- [ ] Klik "Reset Password"
- [ ] Login dengan password baru

---

**Status:** ✅ Aktif dan Siap Digunakan  
**Tingkat Kesulitan:** ⭐ Sangat Mudah  
**Waktu:** ~2 menit

