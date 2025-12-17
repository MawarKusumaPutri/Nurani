# ✅ Solusi Error "Email atau password tidak valid" di Railway

## 🎯 MASALAH

**Error:** "Email atau password tidak valid. Pastikan Anda adalah guru yang terdaftar."

**Penyebab:** Data guru belum ada di database Railway (migrations dan seeder belum berjalan).

---

## ✅ SOLUSI: Trigger Redeploy

### Langkah 1: Redeploy di Railway

1. **Buka Railway Dashboard** → `https://railway.app`
2. **Klik project "TMS Nurani"**
3. **Klik service "web"**
4. **Klik tab "Deployments"**
5. **Klik ikon tiga titik "..."** pada deployment terbaru
6. **Pilih "Redeploy"** dari dropdown menu
7. **Tunggu deploy selesai** (2-5 menit)

### Langkah 2: Cek Deploy Logs

1. **Setelah redeploy, klik "View logs"** pada deployment
2. **Atau klik tab "Deploy Logs"**
3. **Cek apakah ada:**
   - `[SUKSES] Migrations selesai!`
   - `[SUKSES] Seeder selesai! Data guru sudah dibuat!`
   - `Jumlah guru di database: 13`

### Langkah 3: Test Login dengan Password yang Benar

**Untuk Tintin Martini:**
- **Email:** `tintinmartini184@gmail.com`
- **Password:** `TintinMartini2024!` ← **HURUF BESAR di awal "T" dan "M"!**

**Atau coba dengan guru lain:**

**Nurhadi, S.Pd:**
- **Email:** `mundarinurhadi@gmail.com`
- **Password:** `Nurhadi2024!`

**Keysa Anjani:**
- **Email:** `keysa8406@gmail.com`
- **Password:** `Keysha2024!`

---

## 📋 DAFTAR EMAIL DAN PASSWORD GURU

### 1. Nurhadi, S.Pd (Matematika)
- Email: `mundarinurhadi@gmail.com`
- Password: `Nurhadi2024!`

### 2. Keysa Anjani (Bahasa Inggris)
- Email: `keysa8406@gmail.com`
- Password: `Keysha2024!`

### 3. Fadli (Bahasa Arab)
- Email: `fadliziyad123@gmail.com`
- Password: `Fadli2024!`

### 4. Siti Mundari, S.Ag (IPA, Prakarya)
- Email: `sitimundari54@gmail.com`
- Password: `SitiMundari2024!`

### 5. Lola Nurlaela, S.Pd.I. (SKI, Akidah Akhlak)
- Email: `lola.nurlaela@mtssnuraiman.sch.id`
- Password: `LolaNurlaela2024!`

### 6. Desi Nurfalah (Bahasa Indonesia)
- Email: `desinurfalah24@gmail.com`
- Password: `DesyNurfalah2024!`

### 7. M. Rizmal Maulana (QH, FIQIH)
- Email: `rizmalmaulana25@gmail.com`
- Password: `RizmalMaulana2024!`

### 8. Hamzah Najmudin (PJOK, IPS)
- Email: `zahnajmudin10@gmail.com`
- Password: `HamzahNazmudin2024!`

### 9. Sopyan (PKN)
- Email: `sopyanikhsananda@gmail.com`
- Password: `Sopyan2024!`

### 10. Syifa Restu R (Seni Budaya)
- Email: `syifarestu81@gmail.com`
- Password: `SyifaRestu2024!`

### 11. Weni Azmi (Tahsin)
- Email: `wenibustamin27@gmail.com`
- Password: `Weny2024!`

### 12. Tintin Martini (BTQ) ⭐
- Email: `tintinmartini184@gmail.com`
- Password: `TintinMartini2024!` ← **HURUF BESAR T dan M!**

### 13. Mawar
- Email: `mawarkusuma694@gmail.com`
- Password: `Mawar2024!`

---

## ⚠️ CATATAN PENTING

### Password Case-Sensitive!

**Password menggunakan huruf besar di awal nama!**

Contoh:
- ✅ `TintinMartini2024!` (benar)
- ❌ `tintinmartini2024!` (salah - semua huruf kecil)
- ❌ `TINTINMARTINI2024!` (salah - semua huruf besar)

### Setelah Redeploy

1. **Tunggu deploy selesai** (2-5 menit)
2. **Cek Deploy Logs** untuk memastikan migrations dan seeder berjalan
3. **Test login** dengan email dan password yang benar
4. **Jika masih error**, tunggu 1-2 menit lagi (database mungkin masih processing)

---

## 🎯 REKOMENDASI

**Langkah-langkah:**

1. **Trigger redeploy** di Railway Dashboard
2. **Tunggu deploy selesai** (2-5 menit)
3. **Cek Deploy Logs** - pastikan ada `[SUKSES] Seeder selesai!`
4. **Test login** dengan:
   - Email: `tintinmartini184@gmail.com`
   - Password: `TintinMartini2024!` (huruf besar T dan M!)

---

**Trigger redeploy dan gunakan password yang benar dengan huruf besar! 🚀**

