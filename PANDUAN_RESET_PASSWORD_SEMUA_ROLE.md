# 🔑 Panduan Reset Password untuk Semua Role

## ✅ Bekerja untuk Semua!

Sistem reset password **sudah bekerja untuk semua role**:
- ✅ **Guru** - Semua guru bisa reset password
- ✅ **Tenaga Usaha (TU)** - TU bisa reset password
- ✅ **Kepala Sekolah** - Kepala sekolah bisa reset password

**Tidak perlu setup apapun!** Sistem sudah otomatis bekerja.

---

## 📬 Cara Menggunakan (Sama untuk Semua Role)

### Langkah 1: Klik "Forgot password?"

1. Buka halaman login: http://127.0.0.1:8000/login
2. Klik link **"Forgot password?"** atau **"Lupa password?"**

### Langkah 2: Masukkan Email dan Role

1. **Pilih Role:**
   - **Guru** - Untuk semua guru
   - **Kepala Sekolah** - Untuk kepala sekolah
   - **Tenaga Usaha** - Untuk TU

2. **Masukkan Email Gmail** yang terdaftar

3. Klik **"Kirim Link Reset Password"**

### Langkah 3: Langsung ke Halaman Reset Password

**Setelah klik "Kirim Link Reset Password", Anda akan langsung diarahkan ke halaman reset password!**

- Email sudah terisi otomatis
- Siap untuk memasukkan password baru

### Langkah 4: Masukkan Password Baru

1. **Masukkan password baru** (minimal 8 karakter)
2. **Konfirmasi password baru** (ulangi password yang sama)
3. Klik **"Reset Password"**

### Langkah 5: Login dengan Password Baru

1. Kembali ke halaman login
2. Login dengan:
   - **Email:** Email Gmail Anda
   - **Password:** Password baru yang sudah dibuat
   - **Role:** Role yang sesuai (Guru/TU/Kepala Sekolah)

**Selesai!** Password sudah berhasil direset.

---

## 👨‍🏫 Contoh untuk Guru

### Data Login:
- **Email:** `mawarkusuma694@gmail.com`
- **Password:** `Mawar2024!` (sebelum reset)
- **Role:** `guru`

### Cara Reset:
1. Klik "Forgot password?"
2. Pilih Role: **Guru**
3. Masukkan Email: `mawarkusuma694@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung diarahkan ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

---

## 👨‍💼 Contoh untuk Kepala Sekolah

### Data Login:
- **Email:** `mamansuparmanaks07@gmail.com`
- **Password:** `AdminKS@2024` (sebelum reset)
- **Role:** `kepala_sekolah`

### Cara Reset:
1. Klik "Forgot password?"
2. Pilih Role: **Kepala Sekolah**
3. Masukkan Email: `mamansuparmanaks07@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung diarahkan ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

---

## 👩‍💼 Contoh untuk Tenaga Usaha (TU)

### Data Login:
- **Email:** `internal.nurulaiman@gmail.com`
- **Password:** `AdminTU@2024` (sebelum reset)
- **Role:** `tu`

### Cara Reset:
1. Klik "Forgot password?"
2. Pilih Role: **Tenaga Usaha**
3. Masukkan Email: `internal.nurulaiman@gmail.com`
4. Klik "Kirim Link Reset Password"
5. Langsung diarahkan ke halaman reset password
6. Masukkan password baru
7. Login dengan password baru

---

## ✅ Checklist untuk Semua Role

Pastikan:
- [ ] Role yang dipilih sesuai dengan role Anda
- [ ] Email yang dimasukkan sesuai dengan email terdaftar
- [ ] Email dan Role harus cocok (contoh: email guru harus dengan role guru)
- [ ] Password baru minimal 8 karakter
- [ ] Konfirmasi password sama dengan password baru

---

## ❓ Pertanyaan Umum

### Q: Apakah semua role bisa reset password?
**A: Ya!** Semua role (Guru, TU, Kepala Sekolah) bisa reset password dengan cara yang sama.

### Q: Apakah perlu setup apapun?
**A: TIDAK!** Sistem sudah otomatis bekerja untuk semua role.

### Q: Apakah email harus sesuai dengan role?
**A: Ya!** Email dan role harus cocok. Contoh:
- Email `mawarkusuma694@gmail.com` harus dengan role **Guru**
- Email `mamansuparmanaks07@gmail.com` harus dengan role **Kepala Sekolah**
- Email `internal.nurulaiman@gmail.com` harus dengan role **Tenaga Usaha**

### Q: Berapa lama link berlaku?
**A:** Link berlaku selama **60 menit**. Setelah itu, request reset password baru jika perlu.

### Q: Apakah aman?
**A: Ya!** 
- Link hanya bisa digunakan sekali
- Link berlaku 60 menit
- Token di-hash di database
- Password baru minimal 8 karakter

---

## 🆘 Jika Ada Masalah

### Email tidak ditemukan?

1. **Pastikan email benar** - Cek email yang terdaftar di sistem
2. **Pastikan role benar** - Email guru harus dengan role guru, dst.
3. **Cek di LOGIN_CREDENTIALS.md** - Lihat daftar email yang terdaftar

### Token tidak valid?

1. **Link mungkin sudah kadaluarsa** (lebih dari 60 menit)
2. **Request reset password baru**
3. **Pastikan link di-copy dengan lengkap**

### Password tidak bisa direset?

1. **Pastikan password baru minimal 8 karakter**
2. **Pastikan konfirmasi password sama dengan password baru**
3. **Coba request reset password baru**

---

## 📋 Daftar Email yang Bisa Reset Password

### Guru:
- `mundarinurhadi@gmail.com`
- `keysa8406@gmail.com`
- `fadliziyad123@gmail.com`
- `sitimundari54@gmail.com`
- `desinurfalah24@gmail.com`
- `rizmalmaulana25@gmail.com`
- `zahnajmudin10@gmail.com`
- `sopyanikhsananda@gmail.com`
- `syifarestu81@gmail.com`
- `wenibustamin27@gmail.com`
- `tintinmartini184@gmail.com`
- `mawarkusuma694@gmail.com`
- `lola.nurlaela@mtssnuraiman.sch.id`

### Kepala Sekolah:
- `mamansuparmanaks07@gmail.com`

### Tenaga Usaha:
- `internal.nurulaiman@gmail.com`

**Semua email di atas bisa reset password dengan cara yang sama!**

---

**Status:** ✅ Aktif untuk Semua Role  
**Tingkat Kesulitan:** ⭐ Sangat Mudah  
**Waktu:** ~1 menit

