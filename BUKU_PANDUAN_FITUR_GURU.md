# 📚 BUKU PANDUAN LENGKAP: FITUR GURU
## TMS NURANI - MTs Nurul Aiman

---

## 📖 DAFTAR ISI

1. [Pendahuluan](#pendahuluan)
2. [Login & Akses Sistem](#login--akses-sistem)
3. [Dashboard Guru](#dashboard-guru)
4. [Fitur RPP (Rencana Pelaksanaan Pembelajaran)](#fitur-rpp)
5. [Fitur Materi Pembelajaran](#fitur-materi-pembelajaran)
6. [Fitur Kuis](#fitur-kuis)
7. [Fitur Presensi Siswa](#fitur-presensi-siswa)
8. [Fitur Evaluasi & Penilaian](#fitur-evaluasi--penilaian)
9. [Fitur Jadwal Mengajar](#fitur-jadwal-mengajar)
10. [Fitur Profil Guru](#fitur-profil-guru)
11. [Troubleshooting](#troubleshooting)

---

## 1. PENDAHULUAN

### 1.1 Tentang Sistem

**TMS NURANI** adalah sistem manajemen sekolah digital yang membantu guru dalam:
- Membuat dan mengelola RPP
- Menyediakan materi pembelajaran
- Membuat kuis dan evaluasi
- Mencatat presensi siswa
- Mengelola nilai siswa

### 1.2 Hak Akses Guru

Sebagai **Guru**, Anda memiliki akses ke:
- ✅ Dashboard pribadi
- ✅ RPP (Rencana Pelaksanaan Pembelajaran)
- ✅ Materi Pembelajaran
- ✅ Kuis & Evaluasi
- ✅ Presensi Siswa
- ✅ Jadwal Mengajar
- ✅ Profil Pribadi

---

## 2. LOGIN & AKSES SISTEM

### 2.1 Cara Login

**Langkah-langkah:**

1. **Buka browser** (Chrome, Firefox, Edge)
2. **Akses URL:**
   ```
   https://[ngrok-url]/nurani/public/
   ```
3. **Klik tombol "Login"** di pojok kanan atas
4. **Pilih Role:** Guru
5. **Masukkan Email & Password:**
   - Email: `[email guru Anda]`
   - Password: `[password Anda]`
6. **Klik "Login"**

**Contoh:**
```
Email: desinurfalah24@gmail.com
Password: desi123456
Role: Guru
```

### 2.2 Lupa Password

Jika lupa password:
1. Klik "Lupa Password?"
2. Masukkan email Anda
3. Cek email untuk link reset password
4. Klik link dan buat password baru

### 2.3 Logout

Untuk logout:
1. Klik nama Anda di pojok kanan atas
2. Klik "Logout"

---

## 3. DASHBOARD GURU

### 3.1 Tampilan Dashboard

Setelah login, Anda akan melihat:

```
┌─────────────────────────────────────────┐
│  Selamat Datang, [Nama Guru]!           │
│  Kelola materi pembelajaran dan         │
│  aktivitas mengajar Anda                │
├─────────────────────────────────────────┤
│                                         │
│  📚 Materi Pembelajaran                 │
│  • Identitas Sekolah                    │
│  • Kompetensi Inti                      │
│  • Unit Pembelajaran                    │
│  • Pendekatan Pembelajaran              │
│  • Model Pembelajaran                   │
│  • Kegiatan Pembelajaran                │
│  • Penilaian                            │
│  • Sarana & Prasarana                   │
│                                         │
└─────────────────────────────────────────┘
```

### 3.2 Switch Mata Pelajaran

Jika Anda mengajar **lebih dari 1 mata pelajaran**:

1. **Lihat dropdown** di pojok kanan atas
2. **Klik dropdown** "Pilih Mata Pelajaran"
3. **Pilih mata pelajaran** yang ingin Anda kelola
4. Dashboard akan **reload** dengan data mata pelajaran tersebut

---

## 4. FITUR RPP (Rencana Pelaksanaan Pembelajaran)

### 4.1 Apa itu RPP?

**RPP** adalah dokumen perencanaan pembelajaran yang berisi:
- Identitas pembelajaran (judul, kelas, semester)
- Kompetensi Inti (KI 1-4)
- Kompetensi Dasar (KD)
- Tujuan Pembelajaran
- Materi Pembelajaran
- Metode Pembelajaran
- Kegiatan Pembelajaran (Pendahuluan, Inti, Penutup)
- Penilaian
- Pengesahan (TTD Kepala Sekolah & Guru)

### 4.2 Cara Membuat RPP Baru

**Langkah-langkah:**

1. **Klik menu "RPP"** di sidebar
2. **Klik tombol "Buat RPP Baru"**
3. **Pilih Mata Pelajaran** (jika mengajar >1 mapel)
4. **Pilih Pertemuan Ke-** (1 sampai 16)
5. **Isi Form RPP:**

#### **A. Identitas**
```
• Judul RPP: [Auto-fill: RPP Bahasa Indonesia Pertemuan 1]
• Mata Pelajaran: [Auto-fill dari pilihan]
• Kelas: [Pilih: VII, VIII, atau IX]
• Semester: [Pilih: Ganjil atau Genap]
• Pertemuan Ke: [Auto-fill]
• Alokasi Waktu: [Isi: contoh 120 menit]
• Sekolah: [Isi: MTs Nurul Aiman]
• Tahun Pelajaran: [Isi: 2024/2025]
```

#### **B. Kompetensi Inti**
```
• KI 1 (Spiritual): [Isi kompetensi spiritual]
• KI 2 (Sosial): [Isi kompetensi sosial]
• KI 3 (Pengetahuan): [Isi kompetensi pengetahuan]
• KI 4 (Keterampilan): [Isi kompetensi keterampilan]
```

#### **C. Kompetensi Dasar**
```
• KD Pengetahuan: [Isi KD pengetahuan]
• KD Keterampilan: [Isi KD keterampilan]
```

#### **D. Indikator & Tujuan**
```
• Indikator Pencapaian Kompetensi: [Isi indikator]
• Tujuan Pembelajaran: [Isi tujuan]
```

#### **E. Materi Pembelajaran**
```
• Materi Pembelajaran: [Isi materi umum]
• Materi Reguler: [Isi materi untuk siswa reguler]
• Materi Pengayaan: [Isi materi untuk siswa cepat]
• Materi Remedial: [Isi materi untuk siswa lambat]
```

#### **F. Metode & Media**
```
• Metode Pembelajaran: [Contoh: Ceramah, Diskusi, Praktik]
• Media Pembelajaran: [Contoh: PPT, Video, Buku]
• Sumber Belajar: [Contoh: Buku paket, Internet]
```

#### **G. Kegiatan Pembelajaran**
```
• Kegiatan Pendahuluan: [Isi kegiatan pembuka]
• Kegiatan Inti: [Isi kegiatan inti]
• Kegiatan Penutup: [Isi kegiatan penutup]
```

#### **H. Penilaian**
```
• Teknik Penilaian: [Contoh: Tes tertulis, Observasi]
• Bentuk Instrumen: [Contoh: Pilihan ganda, Essay]
• Rubrik Penilaian: [Isi rubrik]
• Kriteria Ketuntasan: [Contoh: KKM 75]
```

#### **I. Pengesahan**
```
• Nama Kepala Sekolah: [Auto-fill: Maman Suparman]
• NIP Kepala Sekolah: [Auto-fill: 123123123]
• Upload TTD Kepala Sekolah: [Optional, upload gambar]
• Upload TTD Guru: [Optional, upload gambar]
```

6. **Klik "Simpan RPP"**
7. **Tunggu loading** (akan muncul overlay "Menyimpan RPP...")
8. **Redirect ke Dashboard** dengan pesan sukses

### 4.3 Cara Edit RPP

**Langkah-langkah:**

1. **Klik menu "RPP"** di sidebar
2. **Lihat daftar RPP** yang sudah dibuat
3. **Klik tombol "Edit"** pada RPP yang ingin diedit
4. **Ubah data** yang ingin diubah
5. **Klik "Update RPP"**
6. **Pesan sukses** akan muncul

### 4.4 Cara Hapus RPP

**Langkah-langkah:**

1. **Klik menu "RPP"** di sidebar
2. **Lihat daftar RPP** yang sudah dibuat
3. **Klik tombol "Hapus"** pada RPP yang ingin dihapus
4. **Konfirmasi** penghapusan
5. **RPP terhapus** dengan pesan sukses

### 4.5 Cara Cetak RPP

**Langkah-langkah:**

1. **Klik menu "RPP"** di sidebar
2. **Klik tombol "Cetak"** pada RPP yang ingin dicetak
3. **Preview RPP** akan muncul
4. **Klik "Print"** atau Ctrl+P
5. **Pilih printer** atau "Save as PDF"
6. **Klik "Print"**

### 4.6 Tips Membuat RPP

✅ **Isi semua field yang ada tanda bintang merah (*)**
✅ **Gunakan bahasa yang jelas dan mudah dipahami**
✅ **Sesuaikan dengan kurikulum yang berlaku**
✅ **Buat RPP untuk semua pertemuan (1-16)**
✅ **Simpan backup RPP di komputer Anda**

---

## 5. FITUR MATERI PEMBELAJARAN

### 5.1 Apa itu Materi Pembelajaran?

**Materi Pembelajaran** adalah konten pembelajaran yang berisi:
- Identitas Sekolah & Program
- Kompetensi Inti & Capaian Pembelajaran
- Unit-Unit Pembelajaran
- Pendekatan Pembelajaran Humanis
- Model-Model Pembelajaran
- Kegiatan Pembelajaran
- Penilaian (Assessment)
- Sarana & Prasarana

### 5.2 Cara Edit Materi Pembelajaran

**Langkah-langkah:**

1. **Klik menu "Dashboard"** di sidebar
2. **Scroll ke section "Materi Pembelajaran"**
3. **Klik tombol "Edit Materi"** di pojok kanan
4. **Isi/Edit 8 section:**

#### **A. Identitas Sekolah & Program**
```
Contoh:
Nama Sekolah: MTs Nurul Aiman
Alamat: Jl. Raya Sumedang No. 123
Mata Pelajaran: Bahasa Indonesia
Kelas: VII, VIII, IX
Semester: Ganjil/Genap
Tahun Pelajaran: 2024/2025
```

#### **B. Kompetensi Inti & Capaian Pembelajaran**
```
Contoh:
KI 1: Menghargai dan menghayati ajaran agama yang dianutnya
KI 2: Menghargai dan menghayati perilaku jujur, disiplin...
KI 3: Memahami pengetahuan (faktual, konseptual, dan prosedural)...
KI 4: Mencoba, mengolah, dan menyaji dalam ranah konkret...

Capaian Pembelajaran:
Siswa mampu memahami dan menganalisis teks...
```

#### **C. Unit-Unit Pembelajaran**
```
Contoh:
Unit 1: Teks Deskripsi (4 pertemuan)
Unit 2: Teks Narasi (4 pertemuan)
Unit 3: Teks Eksposisi (4 pertemuan)
Unit 4: Teks Argumentasi (4 pertemuan)
```

#### **D. Pendekatan Pembelajaran Humanis**
```
Contoh:
- Student-centered learning
- Pembelajaran berbasis masalah
- Pembelajaran kolaboratif
- Pembelajaran berbasis proyek
```

#### **E. Model-Model Pembelajaran**
```
Contoh:
- Discovery Learning
- Problem Based Learning
- Project Based Learning
- Inquiry Learning
```

#### **F. Kegiatan Pembelajaran**
```
Contoh:
Pendahuluan (10 menit):
- Salam dan doa
- Apersepsi
- Motivasi

Inti (60 menit):
- Mengamati
- Menanya
- Mengumpulkan informasi
- Mengasosiasi
- Mengkomunikasikan

Penutup (10 menit):
- Kesimpulan
- Refleksi
- Tugas
```

#### **G. Penilaian (Assessment)**
```
Contoh:
- Penilaian Sikap: Observasi, Jurnal
- Penilaian Pengetahuan: Tes tertulis, Tes lisan
- Penilaian Keterampilan: Praktik, Proyek, Portofolio
```

#### **H. Sarana & Prasarana**
```
Contoh:
- Ruang kelas yang nyaman
- Proyektor dan layar
- Laptop/komputer
- Buku paket
- Internet
```

5. **Klik "Simpan Materi"**
6. **Pesan sukses** akan muncul

### 5.3 Cara Lihat Materi Pembelajaran

**Langkah-langkah:**

1. **Klik menu "Dashboard"** di sidebar
2. **Scroll ke section "Materi Pembelajaran"**
3. **Lihat semua 8 section** yang sudah diisi

---

## 6. FITUR KUIS

### 6.1 Apa itu Kuis?

**Kuis** adalah evaluasi pembelajaran berbentuk soal yang bisa berupa:
- Pilihan Ganda
- Essay/Uraian
- Benar/Salah
- Menjodohkan

### 6.2 Cara Membuat Kuis Baru

**Langkah-langkah:**

1. **Klik menu "Kuis"** di sidebar
2. **Klik tombol "Buat Kuis Baru"**
3. **Isi Form Kuis:**

```
• Judul Kuis: [Contoh: Kuis Teks Deskripsi]
• Mata Pelajaran: [Auto-fill]
• Kelas: [Pilih: VII, VIII, atau IX]
• Deskripsi: [Isi deskripsi kuis]
• Durasi: [Contoh: 60 menit]
• Tanggal Mulai: [Pilih tanggal]
• Tanggal Selesai: [Pilih tanggal]
• Passing Grade: [Contoh: 75]
```

4. **Tambah Soal:**

#### **Soal Pilihan Ganda:**
```
• Soal: [Isi soal]
• Pilihan A: [Isi pilihan A]
• Pilihan B: [Isi pilihan B]
• Pilihan C: [Isi pilihan C]
• Pilihan D: [Isi pilihan D]
• Jawaban Benar: [Pilih A/B/C/D]
• Poin: [Contoh: 10]
```

#### **Soal Essay:**
```
• Soal: [Isi soal]
• Poin: [Contoh: 20]
```

5. **Klik "Tambah Soal"** untuk soal berikutnya
6. **Klik "Simpan Kuis"** setelah semua soal ditambahkan
7. **Pesan sukses** akan muncul

### 6.3 Cara Publish/Unpublish Kuis

**Langkah-langkah:**

1. **Klik menu "Kuis"** di sidebar
2. **Lihat daftar kuis** yang sudah dibuat
3. **Klik toggle "Publish"** pada kuis yang ingin dipublish
4. **Kuis akan terlihat** oleh siswa jika sudah dipublish

### 6.4 Cara Lihat Hasil Kuis Siswa

**Langkah-langkah:**

1. **Klik menu "Kuis"** di sidebar
2. **Klik tombol "Lihat Hasil"** pada kuis yang ingin dilihat
3. **Lihat daftar siswa** yang sudah mengerjakan
4. **Lihat nilai** setiap siswa
5. **Klik nama siswa** untuk lihat detail jawaban

### 6.5 Cara Edit Kuis

**Langkah-langkah:**

1. **Klik menu "Kuis"** di sidebar
2. **Klik tombol "Edit"** pada kuis yang ingin diedit
3. **Ubah data** yang ingin diubah
4. **Klik "Update Kuis"**
5. **Pesan sukses** akan muncul

### 6.6 Cara Hapus Kuis

**Langkah-langkah:**

1. **Klik menu "Kuis"** di sidebar
2. **Klik tombol "Hapus"** pada kuis yang ingin dihapus
3. **Konfirmasi** penghapusan
4. **Kuis terhapus** dengan pesan sukses

---

## 7. FITUR PRESENSI SISWA

### 7.1 Apa itu Presensi?

**Presensi** adalah pencatatan kehadiran siswa setiap pertemuan.

**Status Presensi:**
- ✅ **Hadir** (H)
- ❌ **Sakit** (S)
- ❌ **Izin** (I)
- ❌ **Alpa** (A)

### 7.2 Cara Isi Presensi

**Langkah-langkah:**

1. **Klik menu "Presensi"** di sidebar
2. **Pilih Kelas** (VII, VIII, atau IX)
3. **Pilih Tanggal** presensi
4. **Pilih Pertemuan Ke-** (1-16)
5. **Isi status** setiap siswa:
   - Klik **"H"** untuk Hadir
   - Klik **"S"** untuk Sakit
   - Klik **"I"** untuk Izin
   - Klik **"A"** untuk Alpa
6. **Klik "Simpan Presensi"**
7. **Pesan sukses** akan muncul

### 7.3 Cara Lihat Rekap Presensi

**Langkah-langkah:**

1. **Klik menu "Presensi"** di sidebar
2. **Klik tab "Rekap"**
3. **Pilih Kelas** (VII, VIII, atau IX)
4. **Pilih Bulan** (Januari - Desember)
5. **Lihat rekap** kehadiran setiap siswa:
   - Total Hadir
   - Total Sakit
   - Total Izin
   - Total Alpa
   - Persentase Kehadiran

### 7.4 Cara Export Presensi

**Langkah-langkah:**

1. **Klik menu "Presensi"** di sidebar
2. **Klik tab "Rekap"**
3. **Klik tombol "Export Excel"**
4. **File Excel** akan terdownload
5. **Buka file** di Microsoft Excel

---

## 8. FITUR EVALUASI & PENILAIAN

### 8.1 Apa itu Evaluasi?

**Evaluasi** adalah penilaian hasil belajar siswa yang meliputi:
- Penilaian Harian (PH)
- Penilaian Tengah Semester (PTS)
- Penilaian Akhir Semester (PAS)

### 8.2 Cara Input Nilai Siswa

**Langkah-langkah:**

1. **Klik menu "Evaluasi"** di sidebar
2. **Klik "Input Nilai"**
3. **Pilih Kelas** (VII, VIII, atau IX)
4. **Pilih Jenis Penilaian** (PH, PTS, atau PAS)
5. **Isi nilai** setiap siswa (0-100)
6. **Klik "Simpan Nilai"**
7. **Pesan sukses** akan muncul

### 8.3 Cara Lihat Statistik Nilai

**Langkah-langkah:**

1. **Klik menu "Evaluasi"** di sidebar
2. **Klik tab "Statistik"**
3. **Pilih Kelas** (VII, VIII, atau IX)
4. **Lihat statistik:**
   - Nilai Tertinggi
   - Nilai Terendah
   - Nilai Rata-rata
   - Jumlah Siswa Tuntas
   - Jumlah Siswa Tidak Tuntas
   - Grafik distribusi nilai

### 8.4 Cara Export Nilai

**Langkah-langkah:**

1. **Klik menu "Evaluasi"** di sidebar
2. **Klik tombol "Export Excel"**
3. **File Excel** akan terdownload
4. **Buka file** di Microsoft Excel

---

## 9. FITUR JADWAL MENGAJAR

### 9.1 Cara Lihat Jadwal Mengajar

**Langkah-langkah:**

1. **Klik menu "Jadwal Mengajar"** di sidebar
2. **Lihat jadwal** mengajar Anda:
   - Hari
   - Jam
   - Kelas
   - Mata Pelajaran
   - Ruangan

### 9.2 Cara Export Jadwal

**Langkah-langkah:**

1. **Klik menu "Jadwal Mengajar"** di sidebar
2. **Klik tombol "Export PDF"**
3. **File PDF** akan terdownload
4. **Buka file** di PDF Reader

---

## 10. FITUR PROFIL GURU

### 10.1 Cara Lihat Profil

**Langkah-langkah:**

1. **Klik nama Anda** di pojok kanan atas
2. **Klik "Profil"**
3. **Lihat data profil:**
   - Nama Lengkap
   - NIP
   - Email
   - Mata Pelajaran
   - Foto Profil
   - Kontak
   - Biodata

### 10.2 Cara Edit Profil

**Langkah-langkah:**

1. **Klik nama Anda** di pojok kanan atas
2. **Klik "Profil"**
3. **Klik tombol "Edit Profil"**
4. **Ubah data** yang ingin diubah:
   - Nama Lengkap
   - Kontak
   - Biodata
   - Upload Foto Profil (JPG/PNG, max 2MB)
5. **Klik "Simpan Profil"**
6. **Pesan sukses** akan muncul

### 10.3 Cara Ganti Password

**Langkah-langkah:**

1. **Klik nama Anda** di pojok kanan atas
2. **Klik "Profil"**
3. **Klik tab "Ganti Password"**
4. **Isi form:**
   - Password Lama
   - Password Baru
   - Konfirmasi Password Baru
5. **Klik "Ganti Password"**
6. **Pesan sukses** akan muncul
7. **Login ulang** dengan password baru

---

## 11. TROUBLESHOOTING

### 11.1 Tidak Bisa Login

**Masalah:** Email atau password salah

**Solusi:**
1. Pastikan email dan password benar
2. Pastikan role yang dipilih adalah "Guru"
3. Jika lupa password, klik "Lupa Password?"
4. Hubungi admin jika masih tidak bisa

---

### 11.2 RPP Tidak Tersimpan

**Masalah:** Klik "Simpan RPP" tapi tidak ada pesan sukses

**Solusi:**
1. Pastikan semua field yang ada tanda * sudah diisi
2. Cek koneksi internet
3. Refresh halaman (F5) dan coba lagi
4. Buka Developer Console (F12) untuk lihat error

---

### 11.3 Data Guru Tidak Ditemukan

**Masalah:** Setelah login muncul "Data guru tidak ditemukan"

**Solusi:**
1. Hubungi admin untuk cek data guru di database
2. Pastikan data guru sudah di-input oleh TU

---

### 11.4 Halaman Blank/Putih

**Masalah:** Halaman tidak muncul, hanya putih

**Solusi:**
1. Refresh halaman (Ctrl + F5)
2. Clear cache browser (Ctrl + Shift + Delete)
3. Coba browser lain (Chrome, Firefox, Edge)
4. Cek apakah ngrok masih running

---

### 11.5 File Upload Gagal

**Masalah:** Upload foto/file gagal

**Solusi:**
1. Pastikan ukuran file < 2MB
2. Pastikan format file benar (JPG, PNG, PDF)
3. Coba compress file terlebih dahulu
4. Coba upload ulang

---

## 📞 KONTAK BANTUAN

Jika mengalami masalah yang tidak bisa diselesaikan:

**Email:** internal.nurulaiman@gmail.com  
**WhatsApp:** [Nomor admin]

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
