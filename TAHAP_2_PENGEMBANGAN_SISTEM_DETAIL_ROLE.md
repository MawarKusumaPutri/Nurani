# TAHAP 2: PENGEMBANGAN SISTEM (Detail Per Role)
**Timeline: Minggu 5 - 12**

## Deskripsi Aktivitas:
**Kustomisasi dan pengembangan fitur sistem TMS menggunakan Laravel sesuai kebutuhan untuk setiap role (Kepala Sekolah, Guru, Tenaga Usaha).**

---

# MINGGU 5: SETUP ENVIRONMENT DAN DATABASE

## Aktivitas Umum (Semua Role):

### Setup Development Environment
- [ ] Install XAMPP (Apache, MySQL, PHP 8.0+)
- [ ] Install Composer (PHP package manager)
- [ ] Install Laravel framework (versi terbaru)
- [ ] Setup Laravel project baru dengan nama `nurani-tms`
- [ ] Konfigurasi `.env` file
- [ ] Setup database connection ke MySQL
- [ ] Install package dependencies:
  - [ ] Bootstrap 5 (untuk UI framework)
  - [ ] jQuery (untuk interaktivitas)
  - [ ] Chart.js (untuk grafik dan statistik)
  - [ ] DomPDF (untuk export PDF)
  - [ ] Laravel Breeze/Jetstream (untuk authentication)
- [ ] Setup version control (Git)
- [ ] Setup code editor (VS Code/PhpStorm)
- [ ] Testing environment setup

### Setup Database dan Migration
- [ ] Create database `nurani_tms`
- [ ] Buat migration untuk semua tabel:
  - [ ] `users` (id, name, email, password, role, foto, created_at, updated_at)
  - [ ] `guru` (id, user_id, nip, nama, email, foto, mata_pelajaran, created_at, updated_at)
  - [ ] `siswa` (id, nis, nama, kelas_id, foto, created_at, updated_at)
  - [ ] `kelas` (id, nama_kelas, tingkat, wali_kelas_id, created_at, updated_at)
  - [ ] `mata_pelajaran` (id, nama, kode, created_at, updated_at)
  - [ ] `jadwal_mengajar` (id, guru_id, mata_pelajaran_id, kelas_id, hari, jam_mulai, jam_selesai, created_at, updated_at)
  - [ ] `materi` (id, guru_id, mata_pelajaran_id, kelas_id, judul, deskripsi, file_path, video_url, link_url, created_at, updated_at)
  - [ ] `kuis` (id, guru_id, mata_pelajaran_id, kelas_id, judul, deskripsi, tipe, video_url, link_kuis, soal, durasi_menit, tanggal_mulai, tanggal_selesai, created_at, updated_at)
  - [ ] `notifikasi` (id, user_id, judul, pesan, jenis, dibaca, created_at, updated_at)
  - [ ] `aktivitas_guru` (id, guru_id, jenis_aktivitas, deskripsi, created_at, updated_at)
- [ ] Setup foreign keys dan relationships
- [ ] Setup database seeder untuk data dummy:
  - [ ] Seeder untuk users (Kepala Sekolah, Guru, Tenaga Usaha)
  - [ ] Seeder untuk guru (5-10 data)
  - [ ] Seeder untuk siswa (20-30 data)
  - [ ] Seeder untuk kelas (5-10 kelas)
  - [ ] Seeder untuk mata_pelajaran (10-15 mata pelajaran)
  - [ ] Seeder untuk jadwal_mengajar (20-30 jadwal)
- [ ] Testing database structure

**Deliverables:**
- ✅ Development environment siap digunakan
- ✅ Database schema lengkap dengan semua tabel
- ✅ Migration files untuk semua tabel
- ✅ Database seeder dengan data dummy

---

# MINGGU 6: AUTHENTICATION DAN AUTHORIZATION

## Aktivitas Umum (Semua Role):

### Implementasi Authentication
- [ ] Setup Laravel Breeze untuk authentication
- [ ] Customize login page sesuai design sekolah
  - [ ] Tambahkan logo sekolah
  - [ ] Customize warna dan styling
  - [ ] Responsive design untuk mobile
- [ ] Implementasi login dengan email dan password
- [ ] Implementasi remember me functionality
- [ ] Implementasi password reset via email
- [ ] Implementasi email verification (opsional)
- [ ] Setup middleware untuk authentication
- [ ] Testing authentication flow

### Implementasi Authorization (Role-based)
- [ ] Setup role system di database:
  - [ ] Role: `kepala_sekolah`
  - [ ] Role: `guru`
  - [ ] Role: `tenaga_usaha`
- [ ] Implementasi middleware untuk role-based access:
  - [ ] `CheckRole` middleware
  - [ ] `CheckPermission` middleware
- [ ] Setup permission untuk setiap role:
  - [ ] **Kepala Sekolah:** akses semua fitur (read-only untuk beberapa)
  - [ ] **Guru:** akses fitur jadwal, materi, kuis
  - [ ] **Tenaga Usaha:** akses fitur manajemen data
- [ ] Implementasi route protection berdasarkan role:
  - [ ] Route group untuk Kepala Sekolah
  - [ ] Route group untuk Guru
  - [ ] Route group untuk Tenaga Usaha
- [ ] Implementasi view protection berdasarkan role:
  - [ ] Blade directive `@role('kepala_sekolah')`
  - [ ] Blade directive `@role('guru')`
  - [ ] Blade directive `@role('tenaga_usaha')`
- [ ] Testing authorization untuk setiap role

**Deliverables:**
- ✅ Login system berfungsi untuk semua role
- ✅ Password reset berfungsi
- ✅ Role-based access control aktif
- ✅ Setiap role hanya bisa akses fitur yang diizinkan

---

# MINGGU 7: PENGEMBANGAN FITUR KEPALA SEKOLAH

## 7.1 Dashboard Kepala Sekolah

### Layout dan Struktur
- [ ] Buat layout master untuk Kepala Sekolah (`layouts/kepala_sekolah.blade.php`)
- [ ] Implementasi sidebar navigation dengan menu:
  - [ ] Dashboard (aktif)
  - [ ] Laporan
  - [ ] Data Guru
  - [ ] Data Siswa
  - [ ] Aktivitas Guru
  - [ ] Notifikasi
  - [ ] Profil
- [ ] Implementasi header dengan:
  - [ ] Logo sekolah
  - [ ] Nama user (Kepala Sekolah)
  - [ ] Foto profil
  - [ ] Dropdown menu (Profil, Logout)
- [ ] Implementasi responsive design (desktop dan mobile)
- [ ] Implementasi sidebar toggle untuk mobile
- [ ] Setup routing untuk dashboard Kepala Sekolah
- [ ] Implementasi breadcrumb navigation

### Statistik Overview
- [ ] Implementasi card statistik:
  - [ ] **Total Guru:** Menampilkan jumlah total guru aktif
  - [ ] **Total Siswa:** Menampilkan jumlah total siswa
  - [ ] **Total Kelas:** Menampilkan jumlah total kelas
  - [ ] **Total Mata Pelajaran:** Menampilkan jumlah mata pelajaran
- [ ] Implementasi query untuk menghitung statistik dari database
- [ ] Implementasi real-time update statistik
- [ ] Styling card statistik dengan icon dan warna

### Chart Aktivitas Guru
- [ ] Implementasi chart aktivitas guru (mingguan):
  - [ ] Menggunakan Chart.js
  - [ ] Line chart atau bar chart
  - [ ] Data dari tabel `aktivitas_guru`
  - [ ] Filter berdasarkan periode (minggu ini, bulan ini)
- [ ] Implementasi chart aktivitas guru (bulanan):
  - [ ] Bar chart atau area chart
  - [ ] Data agregat per bulan
  - [ ] Filter berdasarkan tahun
- [ ] Implementasi chart distribusi mata pelajaran:
  - [ ] Pie chart atau doughnut chart
  - [ ] Menampilkan distribusi jumlah guru per mata pelajaran
- [ ] Implementasi filter chart (periode, guru, mata pelajaran)

### Notifikasi Terbaru
- [ ] Implementasi widget notifikasi terbaru:
  - [ ] Menampilkan 5-10 notifikasi terbaru
  - [ ] Badge untuk notifikasi belum dibaca
  - [ ] Link ke halaman notifikasi lengkap
- [ ] Implementasi real-time notification (jika diperlukan)
- [ ] Styling notifikasi dengan icon dan warna

### Quick Access Menu
- [ ] Implementasi quick access button:
  - [ ] "Lihat Laporan Bulan Ini"
  - [ ] "Lihat Aktivitas Guru"
  - [ ] "Lihat Data Guru"
  - [ ] "Lihat Data Siswa"

**Deliverables:**
- ✅ Dashboard Kepala Sekolah lengkap dengan layout
- ✅ Statistik overview berfungsi
- ✅ Chart aktivitas guru berfungsi
- ✅ Notifikasi terintegrasi
- ✅ Responsive design untuk mobile

---

## 7.2 Fitur Laporan (Kepala Sekolah)

### Halaman Laporan Utama
- [ ] Implementasi halaman laporan (`kepala_sekolah/laporan.blade.php`)
- [ ] Implementasi filter laporan:
  - [ ] Filter berdasarkan periode (bulan, tahun)
  - [ ] Filter berdasarkan guru
  - [ ] Filter berdasarkan kelas
  - [ ] Filter berdasarkan mata pelajaran
- [ ] Implementasi search laporan
- [ ] Implementasi pagination untuk daftar laporan

### Statistik Laporan
- [ ] Implementasi statistik performa guru:
  - [ ] Jumlah aktivitas per guru
  - [ ] Jumlah materi yang diupload per guru
  - [ ] Jumlah kuis yang dibuat per guru
  - [ ] Grafik perbandingan performa antar guru
- [ ] Implementasi statistik aktivitas mengajar:
  - [ ] Total jam mengajar per guru
  - [ ] Frekuensi upload materi
  - [ ] Frekuensi pembuatan kuis
- [ ] Implementasi chart laporan:
  - [ ] Bar chart aktivitas guru
  - [ ] Line chart trend aktivitas
  - [ ] Pie chart distribusi aktivitas

### Export Laporan ke PDF
- [ ] Implementasi export laporan ke PDF:
  - [ ] Menggunakan DomPDF
  - [ ] Template PDF dengan header dan footer
  - [ ] Include statistik dan chart dalam PDF
- [ ] Implementasi button "Export PDF"
- [ ] Testing export PDF

### Detail Laporan per Guru
- [ ] Implementasi halaman detail laporan per guru
- [ ] Menampilkan:
  - [ ] Profil guru
  - [ ] Statistik aktivitas
  - [ ] Daftar materi yang diupload
  - [ ] Daftar kuis yang dibuat
  - [ ] Timeline aktivitas

**Deliverables:**
- ✅ Fitur laporan lengkap dengan filter
- ✅ Statistik dan chart laporan akurat
- ✅ Export PDF berfungsi
- ✅ Detail laporan per guru tersedia

---

## 7.3 Fitur Data Guru (Kepala Sekolah)

### Halaman Daftar Guru
- [ ] Implementasi halaman daftar guru (`kepala_sekolah/guru.blade.php`)
- [ ] Implementasi tabel daftar guru dengan kolom:
  - [ ] Foto
  - [ ] NIP
  - [ ] Nama
  - [ ] Email
  - [ ] Mata Pelajaran
  - [ ] Aksi (Lihat, Edit)
- [ ] Implementasi search guru (nama, NIP, email)
- [ ] Implementasi filter guru (mata pelajaran)
- [ ] Implementasi pagination
- [ ] Implementasi sorting (nama, NIP)

### Detail Profil Guru
- [ ] Implementasi halaman detail profil guru
- [ ] Menampilkan:
  - [ ] Foto profil (besar)
  - [ ] NIP
  - [ ] Nama lengkap
  - [ ] Email
  - [ ] Mata Pelajaran yang diajar
  - [ ] Jadwal mengajar
  - [ ] Statistik aktivitas
  - [ ] Daftar materi yang diupload
  - [ ] Daftar kuis yang dibuat

### Edit Data Guru (Read-only atau Limited)
- [ ] Implementasi halaman edit data guru (jika diizinkan)
- [ ] Form edit dengan field:
  - [ ] Nama
  - [ ] Email
  - [ ] Mata Pelajaran
  - [ ] Foto (upload)
- [ ] Validasi form
- [ ] Update data ke database

**Deliverables:**
- ✅ Fitur data guru lengkap
- ✅ Search dan filter berfungsi
- ✅ Detail profil guru lengkap
- ✅ Pagination berfungsi

---

## 7.4 Fitur Data Siswa (Kepala Sekolah)

### Halaman Daftar Siswa
- [ ] Implementasi halaman daftar siswa (`kepala_sekolah/siswa/index.blade.php`)
- [ ] Implementasi tabel daftar siswa dengan kolom:
  - [ ] Foto
  - [ ] NIS
  - [ ] Nama
  - [ ] Kelas
  - [ ] Aksi (Lihat, Edit)
- [ ] Implementasi search siswa (nama, NIS)
- [ ] Implementasi filter siswa (kelas)
- [ ] Implementasi pagination
- [ ] Implementasi sorting (nama, NIS, kelas)

### Detail Profil Siswa
- [ ] Implementasi halaman detail profil siswa
- [ ] Menampilkan:
  - [ ] Foto profil (besar)
  - [ ] NIS
  - [ ] Nama lengkap
  - [ ] Kelas
  - [ ] Wali Kelas
  - [ ] Daftar mata pelajaran yang diikuti

### Export Data Siswa
- [ ] Implementasi export data siswa ke Excel/CSV
- [ ] Implementasi button "Export"
- [ ] Testing export

**Deliverables:**
- ✅ Fitur data siswa lengkap
- ✅ Search dan filter berfungsi
- ✅ Export data berfungsi
- ✅ Pagination berfungsi

---

## 7.5 Fitur Aktivitas Guru (Kepala Sekolah)

### Halaman Aktivitas Guru
- [ ] Implementasi halaman aktivitas guru (`kepala_sekolah/guru_activity.blade.php`)
- [ ] Implementasi timeline aktivitas:
  - [ ] Timeline vertikal dengan tanggal
  - [ ] Card aktivitas per hari
  - [ ] Icon untuk jenis aktivitas (upload materi, buat kuis, dll)
- [ ] Implementasi filter aktivitas:
  - [ ] Filter berdasarkan tanggal
  - [ ] Filter berdasarkan guru
  - [ ] Filter berdasarkan jenis aktivitas
- [ ] Implementasi search aktivitas

### Detail Aktivitas
- [ ] Implementasi halaman detail aktivitas
- [ ] Menampilkan:
  - [ ] Waktu aktivitas
  - [ ] Guru yang melakukan aktivitas
  - [ ] Jenis aktivitas
  - [ ] Deskripsi lengkap aktivitas
  - [ ] Link ke materi/kuis terkait (jika ada)

### Statistik Aktivitas
- [ ] Implementasi statistik aktivitas:
  - [ ] Total aktivitas per hari/minggu/bulan
  - [ ] Aktivitas per guru
  - [ ] Aktivitas per jenis
- [ ] Implementasi chart aktivitas

**Deliverables:**
- ✅ Fitur aktivitas guru lengkap
- ✅ Timeline aktivitas berfungsi
- ✅ Filter dan search berfungsi
- ✅ Statistik akurat

---

# MINGGU 8: PENGEMBANGAN FITUR GURU (Bagian 1)

## 8.1 Dashboard Guru

### Layout dan Struktur
- [ ] Buat layout master untuk Guru (`layouts/guru.blade.php`)
- [ ] Implementasi sidebar navigation dengan menu:
  - [ ] Dashboard (aktif)
  - [ ] Jadwal Mengajar
  - [ ] Materi Pembelajaran
  - [ ] Kuis dan Evaluasi
  - [ ] Notifikasi
  - [ ] Profil
- [ ] Implementasi header dengan:
  - [ ] Logo sekolah
  - [ ] Nama user (Guru)
  - [ ] Foto profil
  - [ ] Dropdown menu (Profil, Logout)
- [ ] Implementasi responsive design (desktop dan mobile)
- [ ] Implementasi sidebar toggle untuk mobile
- [ ] Setup routing untuk dashboard Guru

### Statistik Overview Guru
- [ ] Implementasi card statistik:
  - [ ] **Jadwal Hari Ini:** Menampilkan jumlah jadwal mengajar hari ini
  - [ ] **Total Materi:** Menampilkan jumlah materi yang sudah diupload
  - [ ] **Total Kuis:** Menampilkan jumlah kuis yang sudah dibuat
  - [ ] **Notifikasi Baru:** Menampilkan jumlah notifikasi belum dibaca
- [ ] Implementasi query untuk menghitung statistik dari database
- [ ] Styling card statistik dengan icon dan warna

### Jadwal Hari Ini
- [ ] Implementasi widget jadwal hari ini:
  - [ ] Menampilkan jadwal mengajar hari ini
  - [ ] Menampilkan waktu, kelas, dan mata pelajaran
  - [ ] Link ke halaman jadwal lengkap
- [ ] Implementasi reminder untuk jadwal yang akan datang (1 jam sebelumnya)

### Notifikasi Terbaru
- [ ] Implementasi widget notifikasi terbaru:
  - [ ] Menampilkan 5 notifikasi terbaru
  - [ ] Badge untuk notifikasi belum dibaca
  - [ ] Link ke halaman notifikasi lengkap

**Deliverables:**
- ✅ Dashboard Guru lengkap dengan layout
- ✅ Statistik overview berfungsi
- ✅ Jadwal hari ini terintegrasi
- ✅ Responsive design untuk mobile

---

## 8.2 Fitur Jadwal Mengajar (Guru)

### Halaman Jadwal Mengajar
- [ ] Implementasi halaman jadwal mengajar (`guru/jadwal/index.blade.php`)
- [ ] Implementasi dua view mode:
  - [ ] **List View:** Tabel daftar jadwal
  - [ ] **Calendar View:** Kalender dengan jadwal
- [ ] Implementasi toggle antara list dan calendar view

### List View Jadwal
- [ ] Implementasi tabel jadwal dengan kolom:
  - [ ] Hari
  - [ ] Jam (Mulai - Selesai)
  - [ ] Kelas
  - [ ] Mata Pelajaran
  - [ ] Aksi (Detail)
- [ ] Implementasi filter jadwal:
  - [ ] Filter berdasarkan hari
  - [ ] Filter berdasarkan kelas
  - [ ] Filter berdasarkan mata pelajaran
- [ ] Implementasi search jadwal
- [ ] Implementasi pagination

### Calendar View Jadwal
- [ ] Implementasi calendar view menggunakan library (FullCalendar.js)
- [ ] Menampilkan jadwal dalam bentuk event di kalender
- [ ] Implementasi navigasi bulan
- [ ] Implementasi click event untuk melihat detail jadwal
- [ ] Styling calendar dengan warna berbeda per kelas/mata pelajaran

### Detail Jadwal
- [ ] Implementasi halaman detail jadwal
- [ ] Menampilkan:
  - [ ] Hari dan tanggal
  - [ ] Jam mulai dan selesai
  - [ ] Kelas
  - [ ] Mata Pelajaran
  - [ ] Link ke materi terkait (jika ada)
  - [ ] Link ke kuis terkait (jika ada)

### Reminder dan Notifikasi Jadwal
- [ ] Implementasi reminder jadwal:
  - [ ] Notifikasi 1 jam sebelum jadwal
  - [ ] Notifikasi 30 menit sebelum jadwal
  - [ ] Email reminder (jika diaktifkan)
- [ ] Implementasi badge "Jadwal Hari Ini" di dashboard
- [ ] Implementasi highlight jadwal yang akan datang

**Deliverables:**
- ✅ Fitur jadwal mengajar lengkap
- ✅ List view dan calendar view berfungsi
- ✅ Filter dan search berfungsi
- ✅ Reminder dan notifikasi aktif

---

# MINGGU 9: PENGEMBANGAN FITUR GURU (Bagian 2)

## 9.1 Fitur Manajemen Materi (Guru)

### Halaman Daftar Materi
- [ ] Implementasi halaman daftar materi (`guru/materi/index.blade.php`)
- [ ] Implementasi tabel daftar materi dengan kolom:
  - [ ] Judul
  - [ ] Mata Pelajaran
  - [ ] Kelas
  - [ ] Tipe (File, Video, Link)
  - [ ] Tanggal Upload
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search materi (judul, mata pelajaran)
- [ ] Implementasi filter materi (mata pelajaran, kelas, tipe)
- [ ] Implementasi pagination
- [ ] Implementasi sorting (tanggal, judul)

### Upload Materi
- [ ] Implementasi halaman upload materi (`guru/materi/create.blade.php`)
- [ ] Implementasi form upload dengan field:
  - [ ] Judul materi (required)
  - [ ] Deskripsi (textarea)
  - [ ] Mata Pelajaran (dropdown, required)
  - [ ] Kelas (dropdown, required)
  - [ ] Tipe Materi (radio button):
    - [ ] File (PDF, DOC, PPT, dll)
    - [ ] Video (YouTube URL)
    - [ ] Link (URL eksternal)
  - [ ] Upload File (jika tipe File)
  - [ ] Video URL (jika tipe Video)
  - [ ] Link URL (jika tipe Link)
- [ ] Implementasi validasi form:
  - [ ] Validasi file size (max 10MB)
  - [ ] Validasi file type
  - [ ] Validasi URL format (untuk video dan link)
- [ ] Implementasi upload file ke storage:
  - [ ] Simpan file di `storage/app/public/materi/`
  - [ ] Generate nama file unik
  - [ ] Simpan path file ke database
- [ ] Implementasi preview materi:
  - [ ] Preview file PDF
  - [ ] Preview video YouTube (embed)
  - [ ] Preview link (open in new tab)

### Edit Materi
- [ ] Implementasi halaman edit materi (`guru/materi/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Validasi form
- [ ] Update data ke database
- [ ] Update file jika file baru diupload

### Hapus Materi
- [ ] Implementasi fungsi hapus materi
- [ ] Hapus file dari storage
- [ ] Hapus data dari database
- [ ] Confirmation dialog sebelum hapus

### Detail Materi
- [ ] Implementasi halaman detail materi
- [ ] Menampilkan:
  - [ ] Judul dan deskripsi
  - [ ] Mata Pelajaran dan Kelas
  - [ ] Tipe materi
  - [ ] Preview/embed (file, video, atau link)
  - [ ] Download button (jika file)
  - [ ] Tanggal upload

**Deliverables:**
- ✅ Fitur manajemen materi lengkap
- ✅ Upload berbagai format file berfungsi
- ✅ Upload video YouTube berfungsi
- ✅ Upload link berfungsi
- ✅ Preview dan download berfungsi
- ✅ Edit dan hapus berfungsi

---

## 9.2 Fitur Kuis dan Evaluasi (Guru)

### Halaman Daftar Kuis
- [ ] Implementasi halaman daftar kuis (`guru/kuis/index.blade.php`)
- [ ] Implementasi tabel daftar kuis dengan kolom:
  - [ ] Judul
  - [ ] Mata Pelajaran
  - [ ] Kelas
  - [ ] Tipe (Pilihan Ganda, Esai, Link Eksternal)
  - [ ] Status (Belum Mulai, Berlangsung, Selesai)
  - [ ] Tanggal Mulai - Selesai
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search kuis (judul, mata pelajaran)
- [ ] Implementasi filter kuis (mata pelajaran, kelas, tipe, status)
- [ ] Implementasi pagination
- [ ] Implementasi badge status (warna berbeda per status)

### Buat Kuis Baru
- [ ] Implementasi halaman buat kuis (`guru/kuis/create.blade.php`)
- [ ] Implementasi form dengan field:
  - [ ] Judul kuis (required)
  - [ ] Deskripsi (textarea)
  - [ ] Mata Pelajaran (dropdown, required)
  - [ ] Kelas (dropdown, required)
  - [ ] Tipe Kuis (radio button):
    - [ ] Pilihan Ganda
    - [ ] Esai
    - [ ] Link Eksternal (Google Form, dll)
  - [ ] Video YouTube (opsional, untuk video pembelajaran)
  - [ ] Link Kuis Eksternal (jika tipe Link Eksternal)
  - [ ] Durasi (menit, required)
  - [ ] Tanggal Mulai (date time, required)
  - [ ] Tanggal Selesai (date time, required)
- [ ] Implementasi form soal (jika tipe Pilihan Ganda):
  - [ ] Dynamic form untuk menambah soal
  - [ ] Setiap soal memiliki:
    - [ ] Pertanyaan (textarea)
    - [ ] Opsi A, B, C, D (text input)
    - [ ] Jawaban Benar (radio button)
    - [ ] Button hapus soal
  - [ ] Button "Tambah Soal"
- [ ] Implementasi form soal esai (jika tipe Esai):
  - [ ] Pertanyaan (textarea)
  - [ ] Petunjuk pengerjaan (textarea)
- [ ] Implementasi validasi form:
  - [ ] Validasi tanggal (tanggal selesai > tanggal mulai)
  - [ ] Validasi durasi (min 5 menit)
  - [ ] Validasi minimal 1 soal (untuk pilihan ganda)
  - [ ] Validasi URL format (untuk link eksternal)
- [ ] Implementasi integrasi video YouTube:
  - [ ] Extract video ID dari URL YouTube
  - [ ] Generate embed URL
  - [ ] Preview video di form
- [ ] Simpan data kuis ke database:
  - [ ] Simpan kuis ke tabel `kuis`
  - [ ] Simpan soal ke JSON atau tabel terpisah
  - [ ] Simpan video URL dan embed URL

### Edit Kuis
- [ ] Implementasi halaman edit kuis (`guru/kuis/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Load data kuis yang sudah ada
- [ ] Load soal yang sudah ada (jika pilihan ganda)
- [ ] Validasi form
- [ ] Update data ke database
- [ ] Validasi: tidak bisa edit jika kuis sudah dimulai

### Hapus Kuis
- [ ] Implementasi fungsi hapus kuis
- [ ] Hapus data dari database
- [ ] Confirmation dialog sebelum hapus
- [ ] Validasi: tidak bisa hapus jika kuis sudah dimulai

### Detail Kuis
- [ ] Implementasi halaman detail kuis
- [ ] Menampilkan:
  - [ ] Judul dan deskripsi
  - [ ] Mata Pelajaran dan Kelas
  - [ ] Tipe kuis
  - [ ] Video YouTube (jika ada, dengan embed)
  - [ ] Link kuis eksternal (jika ada)
  - [ ] Durasi
  - [ ] Tanggal mulai dan selesai
  - [ ] Status
  - [ ] Daftar soal (jika pilihan ganda atau esai)

**Deliverables:**
- ✅ Fitur kuis lengkap
- ✅ Pembuatan kuis pilihan ganda berfungsi
- ✅ Pembuatan kuis esai berfungsi
- ✅ Integrasi video YouTube berfungsi
- ✅ Link kuis eksternal berfungsi
- ✅ Edit dan hapus berfungsi

---

# MINGGU 10: PENGEMBANGAN FITUR TENAGA USAHA

## 10.1 Dashboard Tenaga Usaha

### Layout dan Struktur
- [ ] Buat layout master untuk Tenaga Usaha (`layouts/tenaga_usaha.blade.php`)
- [ ] Implementasi sidebar navigation dengan menu:
  - [ ] Dashboard (aktif)
  - [ ] Data Guru
  - [ ] Data Siswa
  - [ ] Data Kelas
  - [ ] Data Mata Pelajaran
  - [ ] Profil
- [ ] Implementasi header dengan:
  - [ ] Logo sekolah
  - [ ] Nama user (Tenaga Usaha)
  - [ ] Foto profil
  - [ ] Dropdown menu (Profil, Logout)
- [ ] Implementasi responsive design (desktop dan mobile)
- [ ] Implementasi sidebar toggle untuk mobile
- [ ] Setup routing untuk dashboard Tenaga Usaha

### Statistik Overview Tenaga Usaha
- [ ] Implementasi card statistik:
  - [ ] **Total Guru:** Menampilkan jumlah total guru
  - [ ] **Total Siswa:** Menampilkan jumlah total siswa
  - [ ] **Total Kelas:** Menampilkan jumlah total kelas
  - [ ] **Total Mata Pelajaran:** Menampilkan jumlah mata pelajaran
- [ ] Implementasi query untuk menghitung statistik dari database
- [ ] Styling card statistik dengan icon dan warna

**Deliverables:**
- ✅ Dashboard Tenaga Usaha lengkap dengan layout
- ✅ Statistik overview berfungsi
- ✅ Responsive design untuk mobile

---

## 10.2 Fitur Manajemen Data Guru (Tenaga Usaha)

### Halaman Daftar Guru
- [ ] Implementasi halaman daftar guru (`tenaga_usaha/guru/index.blade.php`)
- [ ] Implementasi tabel daftar guru dengan kolom:
  - [ ] Foto
  - [ ] NIP
  - [ ] Nama
  - [ ] Email
  - [ ] Mata Pelajaran
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search guru (nama, NIP, email)
- [ ] Implementasi filter guru (mata pelajaran)
- [ ] Implementasi pagination
- [ ] Implementasi sorting (nama, NIP)

### Tambah Data Guru
- [ ] Implementasi halaman tambah guru (`tenaga_usaha/guru/create.blade.php`)
- [ ] Implementasi form dengan field:
  - [ ] NIP (required, unique)
  - [ ] Nama (required)
  - [ ] Email (required, unique, email format)
  - [ ] Password (required, min 8 karakter)
  - [ ] Mata Pelajaran (multi-select atau checkbox)
  - [ ] Foto (file upload, opsional)
- [ ] Implementasi validasi form
- [ ] Implementasi upload foto:
  - [ ] Simpan foto di `storage/app/public/guru/`
  - [ ] Generate nama file unik
  - [ ] Resize foto jika terlalu besar
- [ ] Simpan data ke database:
  - [ ] Simpan ke tabel `users` (dengan role `guru`)
  - [ ] Simpan ke tabel `guru`
  - [ ] Hash password sebelum simpan

### Edit Data Guru
- [ ] Implementasi halaman edit guru (`tenaga_usaha/guru/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Load data guru yang sudah ada
- [ ] Validasi form
- [ ] Update data ke database
- [ ] Update foto jika foto baru diupload
- [ ] Update password jika password diubah

### Hapus Data Guru
- [ ] Implementasi fungsi hapus guru
- [ ] Hapus foto dari storage
- [ ] Hapus data dari tabel `guru` dan `users`
- [ ] Confirmation dialog sebelum hapus
- [ ] Validasi: tidak bisa hapus jika guru memiliki jadwal/materi/kuis

### Detail Profil Guru
- [ ] Implementasi halaman detail profil guru
- [ ] Menampilkan:
  - [ ] Foto profil (besar)
  - [ ] NIP
  - [ ] Nama lengkap
  - [ ] Email
  - [ ] Mata Pelajaran yang diajar
  - [ ] Jadwal mengajar
  - [ ] Statistik aktivitas

**Deliverables:**
- ✅ Fitur manajemen data guru lengkap
- ✅ CRUD guru berfungsi
- ✅ Upload foto berfungsi
- ✅ Search dan filter berfungsi

---

## 10.3 Fitur Manajemen Data Siswa (Tenaga Usaha)

### Halaman Daftar Siswa
- [ ] Implementasi halaman daftar siswa (`tenaga_usaha/siswa/index.blade.php`)
- [ ] Implementasi tabel daftar siswa dengan kolom:
  - [ ] Foto
  - [ ] NIS
  - [ ] Nama
  - [ ] Kelas
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search siswa (nama, NIS)
- [ ] Implementasi filter siswa (kelas)
- [ ] Implementasi pagination
- [ ] Implementasi sorting (nama, NIS, kelas)

### Tambah Data Siswa
- [ ] Implementasi halaman tambah siswa (`tenaga_usaha/siswa/create.blade.php`)
- [ ] Implementasi form dengan field:
  - [ ] NIS (required, unique)
  - [ ] Nama (required)
  - [ ] Kelas (dropdown, required)
  - [ ] Foto (file upload, opsional)
- [ ] Implementasi validasi form
- [ ] Implementasi upload foto:
  - [ ] Simpan foto di `storage/app/public/siswa/`
  - [ ] Generate nama file unik
  - [ ] Resize foto jika terlalu besar
- [ ] Simpan data ke database (tabel `siswa`)

### Edit Data Siswa
- [ ] Implementasi halaman edit siswa (`tenaga_usaha/siswa/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Load data siswa yang sudah ada
- [ ] Validasi form
- [ ] Update data ke database
- [ ] Update foto jika foto baru diupload

### Hapus Data Siswa
- [ ] Implementasi fungsi hapus siswa
- [ ] Hapus foto dari storage
- [ ] Hapus data dari database
- [ ] Confirmation dialog sebelum hapus

### Detail Profil Siswa
- [ ] Implementasi halaman detail profil siswa
- [ ] Menampilkan:
  - [ ] Foto profil (besar)
  - [ ] NIS
  - [ ] Nama lengkap
  - [ ] Kelas
  - [ ] Wali Kelas
  - [ ] Daftar mata pelajaran yang diikuti

### Import Data Siswa (Opsional)
- [ ] Implementasi fitur import data siswa dari Excel/CSV
- [ ] Implementasi template Excel untuk download
- [ ] Implementasi validasi data import
- [ ] Implementasi preview data sebelum import
- [ ] Simpan data import ke database

**Deliverables:**
- ✅ Fitur manajemen data siswa lengkap
- ✅ CRUD siswa berfungsi
- ✅ Upload foto berfungsi
- ✅ Search dan filter berfungsi
- ✅ Import data (jika diimplementasikan)

---

## 10.4 Fitur Manajemen Data Kelas (Tenaga Usaha)

### Halaman Daftar Kelas
- [ ] Implementasi halaman daftar kelas (`tenaga_usaha/kelas/index.blade.php`)
- [ ] Implementasi tabel daftar kelas dengan kolom:
  - [ ] Nama Kelas
  - [ ] Tingkat
  - [ ] Wali Kelas
  - [ ] Jumlah Siswa
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search kelas (nama kelas)
- [ ] Implementasi filter kelas (tingkat)
- [ ] Implementasi pagination

### Tambah Data Kelas
- [ ] Implementasi halaman tambah kelas (`tenaga_usaha/kelas/create.blade.php`)
- [ ] Implementasi form dengan field:
  - [ ] Nama Kelas (required, unique, contoh: "VII-A")
  - [ ] Tingkat (dropdown: VII, VIII, IX, required)
  - [ ] Wali Kelas (dropdown dari daftar guru, required)
- [ ] Implementasi validasi form
- [ ] Simpan data ke database (tabel `kelas`)

### Edit Data Kelas
- [ ] Implementasi halaman edit kelas (`tenaga_usaha/kelas/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Load data kelas yang sudah ada
- [ ] Validasi form
- [ ] Update data ke database

### Hapus Data Kelas
- [ ] Implementasi fungsi hapus kelas
- [ ] Hapus data dari database
- [ ] Confirmation dialog sebelum hapus
- [ ] Validasi: tidak bisa hapus jika kelas memiliki siswa

### Detail Kelas
- [ ] Implementasi halaman detail kelas
- [ ] Menampilkan:
  - [ ] Nama kelas dan tingkat
  - [ ] Wali Kelas
  - [ ] Daftar siswa di kelas tersebut
  - [ ] Statistik siswa

**Deliverables:**
- ✅ Fitur manajemen data kelas lengkap
- ✅ CRUD kelas berfungsi
- ✅ Search dan filter berfungsi

---

## 10.5 Fitur Manajemen Data Mata Pelajaran (Tenaga Usaha)

### Halaman Daftar Mata Pelajaran
- [ ] Implementasi halaman daftar mata pelajaran (`tenaga_usaha/mata_pelajaran/index.blade.php`)
- [ ] Implementasi tabel daftar mata pelajaran dengan kolom:
  - [ ] Kode
  - [ ] Nama Mata Pelajaran
  - [ ] Jumlah Guru
  - [ ] Aksi (Lihat, Edit, Hapus)
- [ ] Implementasi search mata pelajaran (nama, kode)
- [ ] Implementasi pagination

### Tambah Data Mata Pelajaran
- [ ] Implementasi halaman tambah mata pelajaran (`tenaga_usaha/mata_pelajaran/create.blade.php`)
- [ ] Implementasi form dengan field:
  - [ ] Kode (required, unique, contoh: "MTK", "BIN", dll)
  - [ ] Nama Mata Pelajaran (required, contoh: "Matematika", "Bahasa Indonesia")
- [ ] Implementasi validasi form
- [ ] Simpan data ke database (tabel `mata_pelajaran`)

### Edit Data Mata Pelajaran
- [ ] Implementasi halaman edit mata pelajaran (`tenaga_usaha/mata_pelajaran/edit.blade.php`)
- [ ] Form edit dengan field yang sama seperti create
- [ ] Load data mata pelajaran yang sudah ada
- [ ] Validasi form
- [ ] Update data ke database

### Hapus Data Mata Pelajaran
- [ ] Implementasi fungsi hapus mata pelajaran
- [ ] Hapus data dari database
- [ ] Confirmation dialog sebelum hapus
- [ ] Validasi: tidak bisa hapus jika mata pelajaran digunakan di jadwal/materi/kuis

### Detail Mata Pelajaran
- [ ] Implementasi halaman detail mata pelajaran
- [ ] Menampilkan:
  - [ ] Kode dan nama mata pelajaran
  - [ ] Daftar guru yang mengajar mata pelajaran tersebut
  - [ ] Daftar kelas yang mempelajari mata pelajaran tersebut

**Deliverables:**
- ✅ Fitur manajemen data mata pelajaran lengkap
- ✅ CRUD mata pelajaran berfungsi
- ✅ Search berfungsi

---

# MINGGU 11: PENGEMBANGAN FITUR UMUM (Semua Role)

## 11.1 Fitur Notifikasi (Semua Role)

### Sistem Notifikasi
- [ ] Implementasi tabel `notifikasi` di database
- [ ] Implementasi model `Notifikasi`
- [ ] Implementasi controller untuk notifikasi
- [ ] Implementasi fungsi create notifikasi:
  - [ ] Notifikasi untuk jadwal baru
  - [ ] Notifikasi untuk materi baru
  - [ ] Notifikasi untuk kuis baru
  - [ ] Notifikasi untuk reminder jadwal

### Halaman Notifikasi
- [ ] Implementasi halaman notifikasi untuk setiap role:
  - [ ] `kepala_sekolah/notifications.blade.php`
  - [ ] `guru/notifications.blade.php`
  - [ ] `tenaga_usaha/notifications.blade.php`
- [ ] Implementasi daftar notifikasi dengan:
  - [ ] Icon jenis notifikasi
  - [ ] Judul notifikasi
  - [ ] Pesan notifikasi
  - [ ] Waktu notifikasi
  - [ ] Badge "Belum Dibaca" / "Sudah Dibaca"
- [ ] Implementasi filter notifikasi:
  - [ ] Semua
  - [ ] Belum Dibaca
  - [ ] Sudah Dibaca
- [ ] Implementasi pagination
- [ ] Implementasi mark as read (tandai sudah dibaca)
- [ ] Implementasi mark all as read (tandai semua sudah dibaca)
- [ ] Implementasi delete notifikasi

### Widget Notifikasi di Dashboard
- [ ] Implementasi widget notifikasi di dashboard setiap role
- [ ] Menampilkan jumlah notifikasi belum dibaca
- [ ] Menampilkan 5 notifikasi terbaru
- [ ] Link ke halaman notifikasi lengkap
- [ ] Real-time update (jika diperlukan)

**Deliverables:**
- ✅ Sistem notifikasi berfungsi
- ✅ Halaman notifikasi lengkap untuk semua role
- ✅ Widget notifikasi di dashboard berfungsi

---

## 11.2 Fitur Profil (Semua Role)

### Halaman Profil
- [ ] Implementasi halaman profil untuk setiap role:
  - [ ] `kepala_sekolah/profile/index.blade.php`
  - [ ] `guru/profile/index.blade.php`
  - [ ] `tenaga_usaha/profile/index.blade.php`
- [ ] Menampilkan:
  - [ ] Foto profil (besar)
  - [ ] Nama
  - [ ] Email
  - [ ] Role
  - [ ] Informasi tambahan sesuai role:
    - [ ] Kepala Sekolah: Jabatan
    - [ ] Guru: NIP, Mata Pelajaran
    - [ ] Tenaga Usaha: Jabatan
- [ ] Button "Edit Profil"

### Edit Profil
- [ ] Implementasi halaman edit profil untuk setiap role:
  - [ ] `kepala_sekolah/profile/edit.blade.php`
  - [ ] `guru/profile/edit.blade.php`
  - [ ] `tenaga_usaha/profile/edit.blade.php`
- [ ] Form edit dengan field:
  - [ ] Nama (required)
  - [ ] Email (required, email format)
  - [ ] Foto (file upload, opsional)
  - [ ] Password (opsional, untuk ganti password)
  - [ ] Konfirmasi Password (jika password diisi)
- [ ] Implementasi validasi form
- [ ] Implementasi upload foto:
  - [ ] Simpan foto di `storage/app/public/profiles/`
  - [ ] Generate nama file unik
  - [ ] Resize foto jika terlalu besar
  - [ ] Hapus foto lama jika foto baru diupload
- [ ] Update data ke database
- [ ] Update password jika password diubah (hash password)

**Deliverables:**
- ✅ Fitur profil lengkap untuk semua role
- ✅ Edit profil berfungsi
- ✅ Upload foto profil berfungsi
- ✅ Ganti password berfungsi

---

# MINGGU 12: NOTIFIKASI EMAIL DAN FINALISASI

## 12.1 Sistem Notifikasi Email

### Setup Email Configuration
- [ ] Konfigurasi email di `.env`:
  - [ ] `MAIL_MAILER=smtp`
  - [ ] `MAIL_HOST=smtp.gmail.com`
  - [ ] `MAIL_PORT=587`
  - [ ] `MAIL_USERNAME=email@gmail.com`
  - [ ] `MAIL_PASSWORD=app-password`
  - [ ] `MAIL_ENCRYPTION=tls`
  - [ ] `MAIL_FROM_ADDRESS=email@gmail.com`
  - [ ] `MAIL_FROM_NAME="TMS Nurani"`
- [ ] Testing koneksi email

### Email Notification untuk Jadwal
- [ ] Implementasi email notifikasi untuk jadwal baru
- [ ] Implementasi email reminder jadwal (1 jam sebelum)
- [ ] Template email untuk jadwal:
  - [ ] Subject: "Reminder: Jadwal Mengajar Anda"
  - [ ] Body: Hari, jam, kelas, mata pelajaran
- [ ] Testing email jadwal

### Email Notification untuk Materi
- [ ] Implementasi email notifikasi untuk materi baru (jika diperlukan)
- [ ] Template email untuk materi:
  - [ ] Subject: "Materi Baru: [Judul Materi]"
  - [ ] Body: Judul, deskripsi, link ke materi
- [ ] Testing email materi

### Email Notification untuk Kuis
- [ ] Implementasi email notifikasi untuk kuis baru
- [ ] Template email untuk kuis:
  - [ ] Subject: "Kuis Baru: [Judul Kuis]"
  - [ ] Body: Judul, deskripsi, tanggal mulai-selesai, link ke kuis
- [ ] Testing email kuis

### Email Queue untuk Performa
- [ ] Setup email queue menggunakan database
- [ ] Implementasi queue job untuk email
- [ ] Setup queue worker
- [ ] Testing email queue

**Deliverables:**
- ✅ Sistem notifikasi email berfungsi
- ✅ Email jadwal terkirim
- ✅ Email kuis terkirim
- ✅ Email queue aktif

---

## 12.2 Code Review dan Refactoring

### Code Review
- [ ] Review semua controller
- [ ] Review semua model
- [ ] Review semua view (Blade)
- [ ] Review semua migration
- [ ] Review semua route
- [ ] Identifikasi code yang perlu diperbaiki

### Refactoring
- [ ] Refactor code yang duplikat
- [ ] Optimasi query database
- [ ] Perbaiki naming convention
- [ ] Perbaiki struktur folder
- [ ] Tambahkan code comments
- [ ] Perbaiki error handling

### Dokumentasi Kode
- [ ] Dokumentasi untuk setiap controller
- [ ] Dokumentasi untuk setiap model
- [ ] Dokumentasi untuk setiap fungsi penting
- [ ] Dokumentasi untuk API (jika ada)

**Deliverables:**
- ✅ Code review selesai
- ✅ Refactoring selesai
- ✅ Dokumentasi kode lengkap

---

## 12.3 Testing End-to-End

### Testing Authentication dan Authorization
- [ ] Test login untuk setiap role
- [ ] Test logout
- [ ] Test password reset
- [ ] Test akses halaman berdasarkan role
- [ ] Test middleware authorization

### Testing Fitur Kepala Sekolah
- [ ] Test dashboard Kepala Sekolah
- [ ] Test fitur laporan (filter, export PDF)
- [ ] Test fitur data guru (CRUD, search, filter)
- [ ] Test fitur data siswa (CRUD, search, export)
- [ ] Test fitur aktivitas guru

### Testing Fitur Guru
- [ ] Test dashboard Guru
- [ ] Test fitur jadwal mengajar (list, calendar)
- [ ] Test fitur materi (upload, edit, hapus)
- [ ] Test fitur kuis (buat, edit, hapus)
- [ ] Test notifikasi email

### Testing Fitur Tenaga Usaha
- [ ] Test dashboard Tenaga Usaha
- [ ] Test fitur manajemen data guru (CRUD)
- [ ] Test fitur manajemen data siswa (CRUD)
- [ ] Test fitur manajemen data kelas (CRUD)
- [ ] Test fitur manajemen data mata pelajaran (CRUD)

### Testing Fitur Umum
- [ ] Test fitur notifikasi
- [ ] Test fitur profil (edit, ganti password)
- [ ] Test responsive design (mobile, tablet, desktop)
- [ ] Test browser compatibility (Chrome, Firefox, Edge)

**Deliverables:**
- ✅ Testing end-to-end selesai
- ✅ Semua fitur sudah di-test
- ✅ Bug yang ditemukan sudah diperbaiki

---

## 12.4 Finalisasi Development

### Final Check
- [ ] Check semua fitur sudah dikembangkan
- [ ] Check semua bug sudah diperbaiki
- [ ] Check dokumentasi lengkap
- [ ] Check responsive design
- [ ] Check browser compatibility

### Persiapan untuk Tahap 3 (Testing)
- [ ] Siapkan environment testing
- [ ] Siapkan data testing
- [ ] Siapkan test case
- [ ] Siapkan dokumentasi untuk tester

**Deliverables:**
- ✅ Sistem TMS lengkap dengan semua fitur
- ✅ Sistem siap untuk UAT
- ✅ Dokumentasi lengkap

---

## SUMMARY TAHAP 2: PENGEMBANGAN SISTEM

### Fitur yang Dikembangkan per Role:

#### **KEPALA SEKOLAH:**
- ✅ Dashboard dengan statistik dan chart
- ✅ Fitur laporan dengan export PDF
- ✅ Fitur data guru (view, search, filter)
- ✅ Fitur data siswa (view, search, export)
- ✅ Fitur aktivitas guru dengan timeline
- ✅ Fitur notifikasi
- ✅ Fitur profil

#### **GURU:**
- ✅ Dashboard dengan statistik
- ✅ Fitur jadwal mengajar (list dan calendar view)
- ✅ Fitur manajemen materi (upload file, video, link)
- ✅ Fitur kuis (pilihan ganda, esai, link eksternal)
- ✅ Integrasi video YouTube
- ✅ Fitur notifikasi
- ✅ Fitur profil

#### **TENAGA USAHA:**
- ✅ Dashboard dengan statistik
- ✅ Fitur manajemen data guru (CRUD)
- ✅ Fitur manajemen data siswa (CRUD)
- ✅ Fitur manajemen data kelas (CRUD)
- ✅ Fitur manajemen data mata pelajaran (CRUD)
- ✅ Fitur notifikasi
- ✅ Fitur profil

#### **UMUM (Semua Role):**
- ✅ Authentication dan Authorization
- ✅ Sistem notifikasi email
- ✅ Responsive design (desktop dan mobile)
- ✅ UI/UX yang konsisten

**Total Durasi: 8 minggu (Minggu 5 - 12)**

---

*Dokumen ini adalah detail lengkap TAHAP 2: PENGEMBANGAN SISTEM dengan breakdown per role untuk sistem TMS di MTS Nurul Aiman Tanjungsari Sumedang.*

