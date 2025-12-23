# CARA MUDAH: Import Jadwal Agar Muncul di Guru

## ❌ Masalah:
- Seeder error karena MySQL tidak running
- Jadwal belum muncul di menu "Jadwal Mengajar" guru

## ✅ Solusi Mudah:

### **LANGKAH 1: Start XAMPP**

1. Buka **XAMPP Control Panel**
2. Klik **"Start"** pada **Apache** → Tunggu sampai hijau
3. Klik **"Start"** pada **MySQL** → Tunggu sampai hijau
4. **PENTING**: Pastikan keduanya HIJAU sebelum lanjut!

---

### **LANGKAH 2: Buka phpMyAdmin**

1. Di XAMPP Control Panel, klik **"Admin"** pada MySQL
2. Atau buka browser: `http://localhost/phpmyadmin`
3. Login (biasanya tanpa password)

---

### **LANGKAH 3: Pilih Database**

1. Di sidebar kiri, klik database **`nurani`** (atau nama database Anda)
2. Klik tab **"SQL"** di atas

---

### **LANGKAH 4: Cek Data Guru**

Paste SQL ini dan klik **"Go"**:

```sql
SELECT g.id, u.name, g.mata_pelajaran 
FROM gurus g 
JOIN users u ON g.user_id = u.id 
WHERE g.status = 'aktif';
```

**Hasil yang diharapkan:**
```
id | name                    | mata_pelajaran
1  | Nurhadi, S.Pd          | Matematika, IPA, ...
2  | Maman Suparman, A.K.S  | Bahasa Indonesia
3  | Lola Nurlaelis, S.Pd.I | Bahasa Sunda
...
```

**Catat ID guru** untuk langkah berikutnya!

---

### **LANGKAH 5: Insert Jadwal Sample**

Ganti `GURU_ID_DISINI` dengan ID guru dari langkah 4, lalu paste SQL ini:

```sql
-- Contoh: Jadwal untuk Nurhadi (ganti 1 dengan ID Nurhadi)
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('matematika', 1, '7', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '7', 'senin', '11:20:00', '12:00:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('ipa', 1, '7', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('ips', 1, '7', 'senin', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW());

-- Contoh: Jadwal untuk Maman Suparman (ganti 2 dengan ID Maman)
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('bahasa_indonesia', 2, '8', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('bahasa_indonesia', 2, '9', 'senin', '07:00:00', '07:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW());
```

Klik **"Go"** untuk execute.

---

### **LANGKAH 6: Verifikasi Data Masuk**

Paste SQL ini:

```sql
SELECT j.*, u.name as nama_guru 
FROM jadwal j 
JOIN gurus g ON j.guru_id = g.id 
JOIN users u ON g.user_id = u.id 
ORDER BY j.hari, j.jam_mulai;
```

**Hasil yang diharapkan:**
Muncul data jadwal yang baru saja diinput.

---

### **LANGKAH 7: Test di Browser**

1. Buka: `http://localhost/nurani/public`
2. **Login sebagai Guru** (misal: Nurhadi)
3. Klik menu **"Jadwal Mengajar"**
4. **Hasil**: Jadwal yang tadi diinput akan muncul!

---

## 🎯 Alternatif: Import via Form TU

Jika SQL terlalu ribet:

1. Buka: `http://localhost/nurani/public`
2. **Login sebagai TU**
3. Klik menu **"Jadwal Pelajaran"**
4. Klik **"Tambah Jadwal"**
5. Isi form:
   - Guru Pengajar: Pilih guru
   - Mata Pelajaran: Pilih mapel
   - Kelas: Pilih kelas
   - Hari: Pilih hari
   - Jam Mulai: Isi jam
   - Jam Selesai: Isi jam
   - Semester: 1
   - Tahun Ajaran: 2025/2026
6. Klik **"Simpan"**
7. Ulangi untuk jadwal lainnya

---

## 📊 Mapping Guru dan Mata Pelajaran:

Untuk memudahkan input, ini mapping dari gambar:

### **Nurhadi, S.Pd:**
- Matematika: Kelas 7, 8, 9 (banyak jam)
- IPA: Kelas 7, 8, 9
- IPS: Kelas 7, 8, 9
- PKN: Kelas 7, 9
- Bahasa Inggris: Kelas 7, 8, 9
- Bahasa Arab: Kelas 7, 9
- Seni Budaya: Kelas 7, 9
- Prakarya: Kelas 8

### **Maman Suparman, A.K.S:**
- Bahasa Indonesia: Kelas 7, 8, 9

### **Lola Nurlaelis, S.Pd.I:**
- Bahasa Sunda: Kelas 7, 8, 9

### **Siti Mundari, S.Ag:**
- Pendidikan Agama: Kelas 7, 8, 9
- Tahsin: Kelas 8
- BTQ: Kelas 9
- Akidah Akhlak: Kelas 7

### **Fadli:**
- Pendidikan Jasmani: Kelas 7, 8, 9 (Kamis, di Lapangan)

### **Tintin Martini:**
- Informatika: Kelas 9 (Sabtu)

---

## ⚠️ Troubleshooting:

### **Jadwal tidak muncul di Guru**
**Cek:**
1. Apakah `guru_id` di tabel `jadwal` sesuai dengan ID guru?
2. Apakah `status` = 'aktif'?
3. Apakah guru sudah login ulang?

**SQL untuk cek:**
```sql
SELECT j.*, g.id as guru_id, u.name 
FROM jadwal j 
JOIN gurus g ON j.guru_id = g.id 
JOIN users u ON g.user_id = u.id 
WHERE u.name LIKE '%Nurhadi%';
```

### **Error saat insert**
**Kemungkinan:**
- ID guru salah
- Format waktu salah (harus HH:MM:SS)
- Mata pelajaran salah (lihat list di bawah)

**Mata Pelajaran yang Valid:**
- matematika
- bahasa_indonesia
- bahasa_inggris
- ipa
- ips
- pendidikan_agama
- pendidikan_kewarganegaraan
- pendidikan_jasmani
- seni_budaya
- teknologi_informasi
- lainnya

---

## 💡 Tips Cepat:

**Untuk input banyak jadwal sekaligus:**
1. Gunakan SQL INSERT dengan multiple VALUES
2. Copy-paste template di atas
3. Ganti ID guru dan detail jadwal
4. Execute sekali jalan

**Contoh:**
```sql
INSERT INTO jadwal (mata_pelajaran, guru_id, kelas, hari, jam_mulai, jam_selesai, semester, tahun_ajaran, status, is_berulang, ruang, created_by, created_at, updated_at) VALUES
('matematika', 1, '7', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 7', 1, NOW(), NOW()),
('matematika', 1, '8', 'senin', '10:00:00', '10:40:00', '1', '2025/2026', 'aktif', 1, 'Ruang 8', 1, NOW(), NOW()),
('matematika', 1, '9', 'senin', '07:40:00', '08:20:00', '1', '2025/2026', 'aktif', 1, 'Ruang 9', 1, NOW(), NOW());
```

---

Selamat mencoba! Jika masih ada masalah, screenshot error-nya dan tanyakan ke saya. 🚀
