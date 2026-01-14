# 📚 BUKU PANDUAN LENGKAP: FITUR TENAGA USAHA (TU)
## TMS NURANI - MTs Nurul Aiman

---

## 📖 DAFTAR ISI

1. [Pendahuluan](#pendahuluan)
2. [Login & Akses Sistem](#login--akses-sistem)
3. [Dashboard TU](#dashboard-tu)
4. [Fitur Manajemen Siswa](#fitur-manajemen-siswa)
5. [Fitur Manajemen Guru](#fitur-manajemen-guru)
6. [Fitur Jadwal Pelajaran](#fitur-jadwal-pelajaran)
7. [Fitur Kalender Akademik](#fitur-kalender-akademik)
8. [Fitur Surat Menyurat](#fitur-surat-menyurat)
9. [Fitur Pengumuman](#fitur-pengumuman)
10. [Fitur Profil TU](#fitur-profil-tu)
11. [Troubleshooting](#troubleshooting)

---

## 1. PENDAHULUAN

### 1.1 Tentang Sistem

**TMS NURANI** adalah sistem manajemen sekolah digital yang membantu Tenaga Usaha dalam:
- Mengelola data siswa
- Mengelola data guru
- Mengatur jadwal pelajaran
- Mengelola kalender akademik
- Membuat surat-menyurat
- Membuat pengumuman

### 1.2 Hak Akses Tenaga Usaha

Sebagai **Tenaga Usaha**, Anda memiliki akses ke:
- ✅ Dashboard TU
- ✅ Manajemen Siswa (CRUD)
- ✅ Manajemen Guru (CRUD)
- ✅ Jadwal Pelajaran
- ✅ Kalender Akademik
- ✅ Surat Menyurat
- ✅ Pengumuman
- ✅ Profil TU

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
4. **Pilih Role:** Tenaga Usaha
5. **Masukkan Email & Password:**
   ```
   Email: internal.nurulaiman@gmail.com
   Password: AdminTU@2024
   Role: Tenaga Usaha
   ```
6. **Klik "Login"**

### 2.2 Logout

Untuk logout:
1. Klik nama Anda di pojok kanan atas
2. Klik "Logout"

---

## 3. DASHBOARD TU

### 3.1 Tampilan Dashboard

Setelah login, Anda akan melihat:

```
┌─────────────────────────────────────────┐
│  Selamat Datang, Tenaga Usaha!          │
│  Kelola data sekolah dengan efisien     │
├─────────────────────────────────────────┤
│                                         │
│  📊 STATISTIK                           │
│  ┌──────────┬──────────┬──────────┐     │
│  │ 👥 Siswa │ 👨‍🏫 Guru │ 📅 Jadwal│     │
│  │   150    │    25    │    45    │     │
│  └──────────┴──────────┴──────────┘     │
│                                         │
│  📋 MENU UTAMA                          │
│  • Manajemen Siswa                      │
│  • Manajemen Guru                       │
│  • Jadwal Pelajaran                     │
│  • Kalender Akademik                    │
│  • Surat Menyurat                       │
│  • Pengumuman                           │
│                                         │
└─────────────────────────────────────────┘
```

---

## 4. FITUR MANAJEMEN SISWA

### 4.1 Cara Lihat Data Siswa

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Lihat daftar siswa** dengan informasi:
   - NISN
   - Nama Lengkap
   - Kelas
   - Jenis Kelamin
   - Status (Aktif/Nonaktif)
3. **Gunakan fitur pencarian** untuk cari siswa tertentu
4. **Gunakan filter** untuk filter berdasarkan kelas

### 4.2 Cara Tambah Siswa Baru

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Klik tombol "Tambah Siswa"**
3. **Isi Form Siswa:**

```
A. DATA PRIBADI
• NISN: [Isi NISN siswa]
• Nama Lengkap: [Isi nama lengkap]
• Tempat Lahir: [Isi tempat lahir]
• Tanggal Lahir: [Pilih tanggal]
• Jenis Kelamin: [Pilih: Laki-laki/Perempuan]
• Agama: [Pilih: Islam/Kristen/Katolik/Hindu/Buddha/Konghucu]
• Alamat: [Isi alamat lengkap]
• No. HP: [Isi nomor HP]

B. DATA AKADEMIK
• Kelas: [Pilih: VII, VIII, atau IX]
• Tahun Masuk: [Isi tahun masuk]
• Status: [Pilih: Aktif/Nonaktif]

C. DATA ORANG TUA
• Nama Ayah: [Isi nama ayah]
• Pekerjaan Ayah: [Isi pekerjaan ayah]
• Nama Ibu: [Isi nama ibu]
• Pekerjaan Ibu: [Isi pekerjaan ibu]
• No. HP Orang Tua: [Isi nomor HP orang tua]

D. FOTO SISWA
• Upload Foto: [Upload foto JPG/PNG, max 2MB]
```

4. **Klik "Simpan Siswa"**
5. **Pesan sukses** akan muncul

### 4.3 Cara Edit Data Siswa

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Cari siswa** yang ingin diedit
3. **Klik tombol "Edit"** pada siswa tersebut
4. **Ubah data** yang ingin diubah
5. **Klik "Update Siswa"**
6. **Pesan sukses** akan muncul

### 4.4 Cara Hapus Data Siswa

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Cari siswa** yang ingin dihapus
3. **Klik tombol "Hapus"** pada siswa tersebut
4. **Konfirmasi** penghapusan
5. **Siswa terhapus** dengan pesan sukses

⚠️ **PERINGATAN:** Data yang sudah dihapus tidak bisa dikembalikan!

### 4.5 Cara Import Siswa dari Excel

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Klik tombol "Import Excel"**
3. **Download template** Excel terlebih dahulu
4. **Isi data siswa** di template Excel
5. **Upload file** Excel yang sudah diisi
6. **Klik "Import"**
7. **Pesan sukses** akan muncul dengan jumlah siswa yang berhasil diimport

### 4.6 Cara Export Data Siswa

**Langkah-langkah:**

1. **Klik menu "Siswa"** di sidebar
2. **Klik tombol "Export Excel"**
3. **File Excel** akan terdownload
4. **Buka file** di Microsoft Excel

---

## 5. FITUR MANAJEMEN GURU

### 5.1 Cara Lihat Data Guru

**Langkah-langkah:**

1. **Klik menu "Guru"** di sidebar
2. **Lihat daftar guru** dengan informasi:
   - NIP
   - Nama Lengkap
   - Mata Pelajaran
   - Email
   - Status (Aktif/Nonaktif)
3. **Gunakan fitur pencarian** untuk cari guru tertentu

### 5.2 Cara Tambah Guru Baru

**Langkah-langkah:**

1. **Klik menu "Guru"** di sidebar
2. **Klik tombol "Tambah Guru"**
3. **Isi Form Guru:**

```
A. DATA AKUN
• Email: [Isi email guru untuk login]
• Password: [Isi password default]
• Konfirmasi Password: [Isi ulang password]

B. DATA PRIBADI
• Nama Lengkap: [Isi nama lengkap]
• NIP: [Isi NIP guru]
• Mata Pelajaran: [Isi mata pelajaran yang diajar]
  Contoh: Matematika, IPA
  (Jika >1 mapel, pisahkan dengan koma)
• Kontak: [Isi nomor HP]
• Biodata: [Isi biodata singkat]

C. FOTO GURU
• Upload Foto: [Upload foto JPG/PNG, max 2MB]

D. STATUS
• Status: [Pilih: Aktif/Nonaktif]
```

4. **Klik "Simpan Guru"**
5. **Pesan sukses** akan muncul
6. **Guru bisa login** dengan email dan password yang sudah dibuat

### 5.3 Cara Edit Data Guru

**Langkah-langkah:**

1. **Klik menu "Guru"** di sidebar
2. **Cari guru** yang ingin diedit
3. **Klik tombol "Edit"** pada guru tersebut
4. **Ubah data** yang ingin diubah
5. **Klik "Update Guru"**
6. **Pesan sukses** akan muncul

### 5.4 Cara Hapus Data Guru

**Langkah-langkah:**

1. **Klik menu "Guru"** di sidebar
2. **Cari guru** yang ingin dihapus
3. **Klik tombol "Hapus"** pada guru tersebut
4. **Konfirmasi** penghapusan
5. **Guru terhapus** dengan pesan sukses

⚠️ **PERINGATAN:** 
- Data yang sudah dihapus tidak bisa dikembalikan!
- Semua data terkait guru (RPP, materi, kuis) juga akan terhapus!

### 5.5 Cara Reset Password Guru

**Langkah-langkah:**

1. **Klik menu "Guru"** di sidebar
2. **Cari guru** yang ingin direset passwordnya
3. **Klik tombol "Reset Password"** pada guru tersebut
4. **Masukkan password baru**
5. **Klik "Reset"**
6. **Pesan sukses** akan muncul
7. **Beritahu guru** password barunya

---

## 6. FITUR JADWAL PELAJARAN

### 6.1 Cara Lihat Jadwal Pelajaran

**Langkah-langkah:**

1. **Klik menu "Jadwal Pelajaran"** di sidebar
2. **Pilih Kelas** (VII, VIII, atau IX)
3. **Lihat jadwal** per hari:
   - Senin
   - Selasa
   - Rabu
   - Kamis
   - Jumat
   - Sabtu

### 6.2 Cara Tambah Jadwal Pelajaran

**Langkah-langkah:**

1. **Klik menu "Jadwal Pelajaran"** di sidebar
2. **Klik tombol "Tambah Jadwal"**
3. **Isi Form Jadwal:**

```
• Kelas: [Pilih: VII, VIII, atau IX]
• Hari: [Pilih: Senin - Sabtu]
• Jam Mulai: [Pilih jam, contoh: 07:00]
• Jam Selesai: [Pilih jam, contoh: 08:30]
• Mata Pelajaran: [Pilih mata pelajaran]
• Guru: [Pilih guru pengajar]
• Ruangan: [Isi ruangan, contoh: Ruang 7A]
```

4. **Klik "Simpan Jadwal"**
5. **Pesan sukses** akan muncul

### 6.3 Cara Edit Jadwal Pelajaran

**Langkah-langkah:**

1. **Klik menu "Jadwal Pelajaran"** di sidebar
2. **Pilih Kelas** yang jadwalnya ingin diedit
3. **Klik tombol "Edit"** pada jadwal yang ingin diedit
4. **Ubah data** yang ingin diubah
5. **Klik "Update Jadwal"**
6. **Pesan sukses** akan muncul

### 6.4 Cara Hapus Jadwal Pelajaran

**Langkah-langkah:**

1. **Klik menu "Jadwal Pelajaran"** di sidebar
2. **Pilih Kelas** yang jadwalnya ingin dihapus
3. **Klik tombol "Hapus"** pada jadwal yang ingin dihapus
4. **Konfirmasi** penghapusan
5. **Jadwal terhapus** dengan pesan sukses

### 6.5 Cara Print Jadwal Pelajaran

**Langkah-langkah:**

1. **Klik menu "Jadwal Pelajaran"** di sidebar
2. **Pilih Kelas** yang jadwalnya ingin diprint
3. **Klik tombol "Print Jadwal"**
4. **Preview jadwal** akan muncul
5. **Klik "Print"** atau Ctrl+P
6. **Pilih printer** atau "Save as PDF"

---

## 7. FITUR KALENDER AKADEMIK

### 7.1 Cara Lihat Kalender Akademik

**Langkah-langkah:**

1. **Klik menu "Kalender Akademik"** di sidebar
2. **Lihat kalender** dengan event-event:
   - Libur Nasional
   - Ujian Tengah Semester
   - Ujian Akhir Semester
   - Kegiatan Sekolah
   - dll

### 7.2 Cara Tambah Event Kalender

**Langkah-langkah:**

1. **Klik menu "Kalender Akademik"** di sidebar
2. **Klik tombol "Tambah Event"**
3. **Isi Form Event:**

```
• Judul Event: [Contoh: Ujian Tengah Semester]
• Deskripsi: [Isi deskripsi event]
• Tanggal Mulai: [Pilih tanggal]
• Tanggal Selesai: [Pilih tanggal]
• Kategori: [Pilih: Libur/Ujian/Kegiatan/Lainnya]
• Warna: [Pilih warna untuk tampilan kalender]
• Upload Foto: [Optional, upload foto event]
```

4. **Klik "Simpan Event"**
5. **Pesan sukses** akan muncul
6. **Event muncul** di kalender

### 7.3 Cara Edit Event Kalender

**Langkah-langkah:**

1. **Klik menu "Kalender Akademik"** di sidebar
2. **Klik event** yang ingin diedit
3. **Klik tombol "Edit"**
4. **Ubah data** yang ingin diubah
5. **Klik "Update Event"**
6. **Pesan sukses** akan muncul

### 7.4 Cara Hapus Event Kalender

**Langkah-langkah:**

1. **Klik menu "Kalender Akademik"** di sidebar
2. **Klik event** yang ingin dihapus
3. **Klik tombol "Hapus"**
4. **Konfirmasi** penghapusan
5. **Event terhapus** dengan pesan sukses

---

## 8. FITUR SURAT MENYURAT

### 8.1 Cara Lihat Daftar Surat

**Langkah-langkah:**

1. **Klik menu "Surat Menyurat"** di sidebar
2. **Lihat daftar surat** dengan informasi:
   - Nomor Surat
   - Perihal
   - Tanggal
   - Jenis (Masuk/Keluar)
   - Status

### 8.2 Cara Buat Surat Baru

**Langkah-langkah:**

1. **Klik menu "Surat Menyurat"** di sidebar
2. **Klik tombol "Buat Surat"**
3. **Isi Form Surat:**

```
• Jenis Surat: [Pilih: Surat Masuk/Surat Keluar]
• Nomor Surat: [Isi nomor surat]
• Tanggal Surat: [Pilih tanggal]
• Perihal: [Isi perihal surat]
• Pengirim: [Isi pengirim (untuk surat masuk)]
• Penerima: [Isi penerima (untuk surat keluar)]
• Isi Surat: [Isi isi surat]
• Upload File: [Upload file surat PDF/DOC, max 5MB]
```

4. **Klik "Simpan Surat"**
5. **Pesan sukses** akan muncul

### 8.3 Cara Edit Surat

**Langkah-langkah:**

1. **Klik menu "Surat Menyurat"** di sidebar
2. **Cari surat** yang ingin diedit
3. **Klik tombol "Edit"** pada surat tersebut
4. **Ubah data** yang ingin diubah
5. **Klik "Update Surat"**
6. **Pesan sukses** akan muncul

### 8.4 Cara Hapus Surat

**Langkah-langkah:**

1. **Klik menu "Surat Menyurat"** di sidebar
2. **Cari surat** yang ingin dihapus
3. **Klik tombol "Hapus"** pada surat tersebut
4. **Konfirmasi** penghapusan
5. **Surat terhapus** dengan pesan sukses

### 8.5 Cara Download Surat

**Langkah-langkah:**

1. **Klik menu "Surat Menyurat"** di sidebar
2. **Cari surat** yang ingin didownload
3. **Klik tombol "Download"** pada surat tersebut
4. **File surat** akan terdownload

---

## 9. FITUR PENGUMUMAN

### 9.1 Cara Lihat Pengumuman

**Langkah-langkah:**

1. **Klik menu "Pengumuman"** di sidebar
2. **Lihat daftar pengumuman** dengan informasi:
   - Judul
   - Tanggal
   - Status (Published/Draft)

### 9.2 Cara Buat Pengumuman Baru

**Langkah-langkah:**

1. **Klik menu "Pengumuman"** di sidebar
2. **Klik tombol "Buat Pengumuman"**
3. **Isi Form Pengumuman:**

```
• Judul: [Isi judul pengumuman]
• Isi Pengumuman: [Isi isi pengumuman]
• Tanggal Mulai: [Pilih tanggal mulai ditampilkan]
• Tanggal Selesai: [Pilih tanggal selesai ditampilkan]
• Target: [Pilih: Semua/Guru/Siswa]
• Upload Gambar: [Optional, upload gambar JPG/PNG]
• Status: [Pilih: Published/Draft]
```

4. **Klik "Simpan Pengumuman"**
5. **Pesan sukses** akan muncul
6. **Pengumuman muncul** di dashboard (jika Published)

### 9.3 Cara Edit Pengumuman

**Langkah-langkah:**

1. **Klik menu "Pengumuman"** di sidebar
2. **Cari pengumuman** yang ingin diedit
3. **Klik tombol "Edit"** pada pengumuman tersebut
4. **Ubah data** yang ingin diubah
5. **Klik "Update Pengumuman"**
6. **Pesan sukses** akan muncul

### 9.4 Cara Hapus Pengumuman

**Langkah-langkah:**

1. **Klik menu "Pengumuman"** di sidebar
2. **Cari pengumuman** yang ingin dihapus
3. **Klik tombol "Hapus"** pada pengumuman tersebut
4. **Konfirmasi** penghapusan
5. **Pengumuman terhapus** dengan pesan sukses

---

## 10. FITUR PROFIL TU

### 10.1 Cara Lihat Profil

**Langkah-langkah:**

1. **Klik nama Anda** di pojok kanan atas
2. **Klik "Profil"**
3. **Lihat data profil:**
   - Nama
   - Email
   - Foto Profil

### 10.2 Cara Edit Profil

**Langkah-langkah:**

1. **Klik nama Anda** di pojok kanan atas
2. **Klik "Profil"**
3. **Klik tombol "Edit Profil"**
4. **Ubah data** yang ingin diubah
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

**Solusi:**
1. Pastikan email dan password benar
2. Pastikan role yang dipilih adalah "Tenaga Usaha"
3. Hubungi admin jika masih tidak bisa

### 11.2 Data Tidak Tersimpan

**Solusi:**
1. Pastikan semua field required sudah diisi
2. Cek koneksi internet
3. Refresh halaman dan coba lagi

### 11.3 File Upload Gagal

**Solusi:**
1. Pastikan ukuran file sesuai batas (2MB untuk foto, 5MB untuk dokumen)
2. Pastikan format file benar
3. Coba compress file terlebih dahulu

### 11.4 Halaman Blank/Putih

**Solusi:**
1. Refresh halaman (Ctrl + F5)
2. Clear cache browser
3. Coba browser lain

---

## 📞 KONTAK BANTUAN

Jika mengalami masalah yang tidak bisa diselesaikan:

**Email:** internal.nurulaiman@gmail.com  
**WhatsApp:** [Nomor admin]

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
