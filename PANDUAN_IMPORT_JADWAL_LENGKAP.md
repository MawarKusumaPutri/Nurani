# Panduan Import Jadwal Lengkap

## ✅ Sudah Dibuat:

Saya telah membuat **seeder lengkap** yang berisi SEMUA jadwal dari Foto 2, dengan mapping yang benar ke setiap guru.

### **File yang Dibuat:**
- `database/seeders/JadwalLengkapSeeder.php` - Berisi 150+ jadwal lengkap

### **Data yang Akan Diimport:**

#### **Guru dan Jadwal Mereka:**

1. **Maman Suparman, A.K.S** (Bahasa Indonesia)
   - Kelas 7: Senin, Selasa, Rabu (3 jam)
   - Kelas 8: Senin, Rabu, Kamis, Sabtu
   - Kelas 9: Senin, Rabu, Kamis (4 jam)
   - **Total: ~15 jadwal**

2. **Nurhadi, S.Pd** (Multi Mata Pelajaran)
   - Matematika: Semua kelas (Senin-Sabtu)
   - IPA: Kelas 7, 8, 9
   - IPS: Kelas 7, 8, 9
   - PKN: Kelas 7, 9
   - Bahasa Inggris: Kelas 7, 8, 9
   - Bahasa Arab: Kelas 7, 9
   - Seni Budaya: Kelas 7, 9
   - Prakarya: Kelas 8
   - **Total: ~100+ jadwal** (guru utama)

3. **Lola Nurlaelis, S.Pd.I** (Bahasa Sunda)
   - Kelas 7: Senin (2x), Jumat (3x), Rabu
   - Kelas 8: Senin, Jumat (4x)
   - Kelas 9: Senin, Rabu, Sabtu
   - **Total: ~12 jadwal**

4. **Siti Mundari, S.Ag** (Pendidikan Agama & Tahsin)
   - Pendidikan Agama: Kelas 7, 8, 9
   - Tahsin: Kelas 8 (2x)
   - BTQ: Kelas 9
   - Akidah Akhlak: Kelas 7
   - **Total: ~15 jadwal**

5. **Fadli** (Pendidikan Jasmani)
   - Kelas 7: Kamis (3 jam di Lapangan)
   - Kelas 8: Kamis (3 jam di Lapangan)
   - Kelas 9: Kamis (1 jam di Lapangan)
   - **Total: ~7 jadwal**

6. **Tintin Martini** (Informatika)
   - Kelas 9: Sabtu (1 jam)
   - **Total: ~1 jadwal**

---

## 🚀 Cara Menjalankan Import:

### **Opsi 1: Via Artisan Command** (RECOMMENDED)

```bash
# Pastikan XAMPP MySQL sedang berjalan
# Buka terminal di folder project

cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan db:seed --class=JadwalLengkapSeeder
```

### **Opsi 2: Via Tinker** (Jika command gagal)

```bash
php artisan tinker

# Lalu jalankan:
$seeder = new \Database\Seeders\JadwalLengkapSeeder();
$seeder->run();
```

### **Opsi 3: Hapus Jadwal Lama Dulu** (Jika ada duplikat)

```bash
# Hapus semua jadwal yang ada
php artisan tinker
\App\Models\Jadwal::truncate();
exit

# Lalu import yang baru
php artisan db:seed --class=JadwalLengkapSeeder
```

---

## 📊 Hasil Setelah Import:

### **Di Dashboard TU:**
- Menu "Jadwal Pelajaran" akan menampilkan **150+ jadwal**
- Bisa filter berdasarkan kelas, hari, guru
- Bisa export ke CSV

### **Di Dashboard Guru:**
Setiap guru akan melihat jadwal mereka sendiri:

#### **Contoh: Login sebagai Nurhadi, S.Pd**
- Menu "Jadwal Mengajar" akan menampilkan:
  - Senin: Matematika kelas 7, 8, 9 + IPA kelas 8 + Seni Budaya kelas 9
  - Selasa: Bahasa Inggris kelas 7, 8, 9 + IPA kelas 8 + IPS kelas 8
  - Rabu: Bahasa Indonesia kelas 7 (3x) + Matematika kelas 7, 8, 9 + PKN kelas 9
  - Dan seterusnya...

#### **Contoh: Login sebagai Maman Suparman, A.K.S**
- Menu "Jadwal Mengajar" akan menampilkan:
  - Senin: Bahasa Indonesia kelas 8, 9
  - Selasa: Bahasa Indonesia kelas 7
  - Rabu: Bahasa Indonesia kelas 7 (3x), 8 (3x), 9
  - Kamis: Bahasa Indonesia kelas 8, 9 (4x)
  - Sabtu: Bahasa Indonesia kelas 8

#### **Contoh: Login sebagai Fadli**
- Menu "Jadwal Mengajar" akan menampilkan:
  - Kamis: Pendidikan Jasmani kelas 7, 8, 9 (di Lapangan)

---

## ⚠️ Troubleshooting:

### **Error: "Guru tidak ditemukan"**
**Penyebab**: Nama guru di database tidak sesuai dengan mapping

**Solusi**:
1. Cek nama guru di database:
   ```bash
   php artisan tinker
   \App\Models\Guru::with('user')->get()->pluck('user.name')
   ```

2. Update mapping di seeder jika perlu

### **Error: "Database connection"**
**Penyebab**: MySQL tidak running

**Solusi**:
1. Buka XAMPP Control Panel
2. Start Apache dan MySQL
3. Pastikan keduanya hijau
4. Coba lagi

### **Error: "Duplicate entry"**
**Penyebab**: Jadwal sudah ada di database

**Solusi**:
1. Hapus jadwal lama:
   ```bash
   php artisan tinker
   \App\Models\Jadwal::truncate();
   ```
2. Import ulang

---

## 🎯 Verifikasi Hasil:

### **1. Cek Total Jadwal**
```bash
php artisan tinker
\App\Models\Jadwal::count()
# Seharusnya: ~150
```

### **2. Cek Jadwal per Guru**
```bash
php artisan tinker

# Nurhadi
$nurhadi = \App\Models\Guru::whereHas('user', fn($q) => $q->where('name', 'LIKE', '%Nurhadi%'))->first();
\App\Models\Jadwal::where('guru_id', $nurhadi->id)->count();
# Seharusnya: ~100+

# Maman Suparman
$maman = \App\Models\Guru::whereHas('user', fn($q) => $q->where('name', 'LIKE', '%Maman%'))->first();
\App\Models\Jadwal::where('guru_id', $maman->id)->count();
# Seharusnya: ~15

# Fadli
$fadli = \App\Models\Guru::whereHas('user', fn($q) => $q->where('name', 'LIKE', '%Fadli%'))->first();
\App\Models\Jadwal::where('guru_id', $fadli->id)->count();
# Seharusnya: ~7
```

### **3. Test di Browser**

#### **Sebagai TU:**
1. Login: `http://localhost/nurani/public/login`
2. Email: TU email
3. Buka menu "Jadwal Pelajaran"
4. **Hasil**: Muncul 150+ jadwal

#### **Sebagai Guru:**
1. Login dengan akun guru (misal: Nurhadi)
2. Buka menu "Jadwal Mengajar"
3. **Hasil**: Muncul jadwal sesuai guru tersebut

---

## 📝 Catatan Penting:

1. **Seeder ini sudah include mapping nama guru** yang benar
2. **Semua jadwal di-set sebagai berulang** (is_berulang = true)
3. **Semester 1, Tahun Ajaran 2025/2026**
4. **Status: Aktif**
5. **Jadwal Penjaskes otomatis di Lapangan**

---

## 🔄 Update ke Railway:

Setelah berhasil di localhost, untuk sync ke Railway:

### **Opsi 1: Via Railway CLI**
```bash
railway run php artisan db:seed --class=JadwalLengkapSeeder
```

### **Opsi 2: Via Database Export/Import**
1. Export database dari localhost (phpMyAdmin)
2. Import ke Railway MySQL
3. Jadwal akan muncul di production

---

Selamat mencoba! Jika ada error, screenshot dan tanyakan ke saya. 🚀
