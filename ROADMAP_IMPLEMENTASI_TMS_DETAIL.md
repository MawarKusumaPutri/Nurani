# 6.2 Roadmap Implementasi (Versi Detail)

Berikut ini adalah roadmap implementasi sistem perbaikan Teaching Management System (TMS) di MTS Nurul Aiman Tanjungsari Sumedang dengan breakdown detail per minggu dan aktivitas spesifik:

## Gambar 6.1. Roadmap Implementasi Sistem TMS

---

# TAHAP 1: PERSIAPAN DAN ANALISIS
**Timeline: Minggu 1 - 4 (4 minggu)**

---

## MINGGU 1: KICK-OFF DAN ANALISIS AWAL

### Hari 1-2: Kick-off Meeting
**Aktivitas:**
- [ ] Meeting kick-off dengan stakeholder (Kepala Sekolah, perwakilan Guru, Tenaga Usaha)
- [ ] Presentasi konsep sistem TMS
- [ ] Diskusi kebutuhan dan ekspektasi
- [ ] Identifikasi stakeholder utama dan kontak person
- [ ] Penetapan jadwal meeting rutin
- [ ] Penetapan metode komunikasi (WhatsApp group, email)

**Deliverables:**
- ✅ Minutes of Meeting (MoM) kick-off
- ✅ Daftar stakeholder dan kontak person
- ✅ Jadwal meeting rutin
- ✅ Kesepakatan scope project

**Resource:**
- Project Manager: 4 jam
- Stakeholder: 2 jam

---

### Hari 3-5: Analisis Kebutuhan Kepala Sekolah
**Aktivitas:**
- [ ] Interview dengan Kepala Sekolah
- [ ] Identifikasi kebutuhan dashboard Kepala Sekolah
- [ ] Identifikasi fitur laporan yang diperlukan
- [ ] Identifikasi kebutuhan statistik dan analitik
- [ ] Identifikasi kebutuhan monitoring aktivitas guru
- [ ] Identifikasi kebutuhan manajemen data guru dan siswa
- [ ] Dokumentasi kebutuhan dalam format use case

**Deliverables:**
- ✅ Dokumen Analisis Kebutuhan Kepala Sekolah
- ✅ Use case diagram untuk Kepala Sekolah
- ✅ Daftar fitur prioritas untuk Kepala Sekolah

**Resource:**
- Business Analyst: 8 jam
- Kepala Sekolah: 3 jam

---

## MINGGU 2: ANALISIS KEBUTUHAN USER

### Hari 1-3: Analisis Kebutuhan Guru
**Aktivitas:**
- [ ] Interview dengan 3-5 perwakilan Guru
- [ ] Identifikasi kebutuhan dashboard Guru
- [ ] Identifikasi kebutuhan manajemen jadwal mengajar
- [ ] Identifikasi kebutuhan upload dan manajemen materi
- [ ] Identifikasi kebutuhan pembuatan dan manajemen kuis
- [ ] Identifikasi kebutuhan notifikasi dan reminder
- [ ] Identifikasi kebutuhan laporan aktivitas mengajar
- [ ] Dokumentasi workflow guru dalam sistem

**Deliverables:**
- ✅ Dokumen Analisis Kebutuhan Guru
- ✅ Use case diagram untuk Guru
- ✅ Workflow diagram aktivitas Guru
- ✅ Daftar fitur prioritas untuk Guru

**Resource:**
- Business Analyst: 12 jam
- Perwakilan Guru: 6 jam (total)

---

### Hari 4-5: Analisis Kebutuhan Tenaga Usaha
**Aktivitas:**
- [ ] Interview dengan Tenaga Usaha
- [ ] Identifikasi kebutuhan dashboard Tenaga Usaha
- [ ] Identifikasi kebutuhan manajemen data guru
- [ ] Identifikasi kebutuhan manajemen data siswa
- [ ] Identifikasi kebutuhan manajemen kelas
- [ ] Identifikasi kebutuhan manajemen mata pelajaran
- [ ] Identifikasi kebutuhan backup dan maintenance data
- [ ] Dokumentasi workflow Tenaga Usaha

**Deliverables:**
- ✅ Dokumen Analisis Kebutuhan Tenaga Usaha
- ✅ Use case diagram untuk Tenaga Usaha
- ✅ Workflow diagram aktivitas Tenaga Usaha
- ✅ Daftar fitur prioritas untuk Tenaga Usaha

**Resource:**
- Business Analyst: 8 jam
- Tenaga Usaha: 3 jam

---

## MINGGU 3: PERENCANAAN TEKNIS

### Hari 1-2: Perencanaan Arsitektur Sistem
**Aktivitas:**
- [ ] Analisis teknologi stack (Laravel, MySQL, Bootstrap)
- [ ] Desain arsitektur sistem (3-tier: Presentation, Business Logic, Data)
- [ ] Identifikasi komponen sistem (Frontend, Backend, Database)
- [ ] Desain struktur folder dan modul
- [ ] Identifikasi library dan package yang diperlukan
- [ ] Desain API structure (jika diperlukan)
- [ ] Dokumentasi arsitektur sistem

**Deliverables:**
- ✅ Dokumen Arsitektur Sistem
- ✅ Diagram arsitektur sistem (high-level)
- ✅ Daftar teknologi dan tools
- ✅ Struktur folder dan modul

**Resource:**
- System Architect: 12 jam
- Senior Developer: 4 jam

---

### Hari 3-4: Perencanaan Database
**Aktivitas:**
- [ ] Identifikasi entitas utama (User, Guru, Siswa, Jadwal, Materi, Kuis, dll)
- [ ] Desain Entity Relationship Diagram (ERD)
- [ ] Identifikasi relasi antar entitas
- [ ] Desain struktur tabel database
- [ ] Identifikasi field dan tipe data
- [ ] Desain index untuk optimasi query
- [ ] Perencanaan migration database
- [ ] Dokumentasi database schema

**Deliverables:**
- ✅ Entity Relationship Diagram (ERD)
- ✅ Database schema design
- ✅ Daftar tabel dan field
- ✅ Migration plan

**Resource:**
- Database Designer: 12 jam
- Senior Developer: 4 jam

---

### Hari 5: Perencanaan UI/UX
**Aktivitas:**
- [ ] Analisis user persona (Kepala Sekolah, Guru, Tenaga Usaha)
- [ ] Desain wireframe untuk setiap halaman utama
- [ ] Desain user flow untuk setiap role
- [ ] Identifikasi komponen UI yang diperlukan
- [ ] Pemilihan color scheme dan typography
- [ ] Perencanaan responsive design (desktop dan mobile)
- [ ] Dokumentasi design system

**Deliverables:**
- ✅ Wireframe untuk halaman utama
- ✅ User flow diagram
- ✅ Design system document
- ✅ Mockup (low-fidelity)

**Resource:**
- UI/UX Designer: 8 jam

---

## MINGGU 4: DOKUMENTASI DAN FINALISASI

### Hari 1-2: Penyusunan Dokumen Spesifikasi
**Aktivitas:**
- [ ] Penyusunan Software Requirements Specification (SRS)
- [ ] Penyusunan Data Flow Diagram (DFD) level 0, 1, 2
- [ ] Penyusunan Use Case Specification
- [ ] Penyusunan Functional Requirements
- [ ] Penyusunan Non-Functional Requirements
- [ ] Review dokumen dengan stakeholder
- [ ] Revisi berdasarkan feedback

**Deliverables:**
- ✅ Software Requirements Specification (SRS) v1.0
- ✅ Data Flow Diagram (DFD) lengkap
- ✅ Use Case Specification
- ✅ Functional Requirements Document
- ✅ Non-Functional Requirements Document

**Resource:**
- Business Analyst: 12 jam
- System Analyst: 8 jam
- Stakeholder: 4 jam (review)

---

### Hari 3-4: Identifikasi Biaya dan Rencana Anggaran
**Aktivitas:**
- [ ] Breakdown biaya development
- [ ] Breakdown biaya hosting/server
- [ ] Breakdown biaya perangkat keras (jika diperlukan)
- [ ] Breakdown biaya maintenance
- [ ] Perhitungan total biaya implementasi
- [ ] Perhitungan biaya tahunan
- [ ] Penyusunan proposal anggaran
- [ ] Presentasi anggaran ke stakeholder

**Deliverables:**
- ✅ Dokumen Identifikasi Biaya Implementasi
- ✅ Rencana Anggaran Detail
- ✅ Proposal Anggaran
- ✅ Approval anggaran dari stakeholder

**Resource:**
- Project Manager: 8 jam
- Finance: 4 jam
- Stakeholder: 2 jam (approval)

---

### Hari 5: Finalisasi dan Sign-off
**Aktivitas:**
- [ ] Review semua dokumen tahap 1
- [ ] Finalisasi dokumen dengan stakeholder
- [ ] Sign-off dokumen analisis dan spesifikasi
- [ ] Persiapan untuk tahap 2 (Development)
- [ ] Setup project management tool (Trello/Jira)
- [ ] Setup repository Git
- [ ] Kick-off meeting untuk tahap 2

**Deliverables:**
- ✅ Sign-off dokumen tahap 1
- ✅ Project management tool setup
- ✅ Git repository setup
- ✅ MoM kick-off tahap 2

**Resource:**
- Project Manager: 4 jam
- Stakeholder: 2 jam
- Developer: 2 jam (setup)

---

## METRIK KEBERHASILAN TAHAP 1

- ✅ Semua stakeholder sudah di-interview
- ✅ 100% kebutuhan user sudah didokumentasikan
- ✅ ERD dan DFD sudah selesai dan disetujui
- ✅ SRS sudah selesai dan disetujui
- ✅ Anggaran sudah disetujui
- ✅ Sign-off dari semua stakeholder

---

# TAHAP 2: PENGEMBANGAN SISTEM
**Timeline: Minggu 5 - 12 (8 minggu)**

---

## MINGGU 5: SETUP ENVIRONMENT DAN DATABASE

### Hari 1-2: Setup Development Environment
**Aktivitas:**
- [ ] Install XAMPP (Apache, MySQL, PHP)
- [ ] Install Composer (PHP package manager)
- [ ] Install Laravel framework
- [ ] Setup Laravel project baru
- [ ] Konfigurasi .env file
- [ ] Setup database connection
- [ ] Install package dependencies (Bootstrap, jQuery, dll)
- [ ] Setup version control (Git)
- [ ] Setup code editor (VS Code/PhpStorm)
- [ ] Testing environment setup

**Deliverables:**
- ✅ Development environment siap digunakan
- ✅ Laravel project structure
- ✅ Git repository initialized
- ✅ Dependencies installed

**Resource:**
- Developer: 12 jam

---

### Hari 3-5: Setup Database dan Migration
**Aktivitas:**
- [ ] Create database `nurani_tms`
- [ ] Buat migration untuk tabel `users`
- [ ] Buat migration untuk tabel `guru`
- [ ] Buat migration untuk tabel `siswa`
- [ ] Buat migration untuk tabel `kelas`
- [ ] Buat migration untuk tabel `mata_pelajaran`
- [ ] Buat migration untuk tabel `jadwal_mengajar`
- [ ] Buat migration untuk tabel `materi`
- [ ] Buat migration untuk tabel `kuis`
- [ ] Buat migration untuk tabel `notifikasi`
- [ ] Setup foreign keys dan relationships
- [ ] Setup database seeder untuk data dummy
- [ ] Testing database structure

**Deliverables:**
- ✅ Database schema lengkap
- ✅ Semua migration files
- ✅ Database seeder dengan data dummy
- ✅ ERD sesuai dengan implementasi

**Resource:**
- Developer: 16 jam

---

## MINGGU 6: AUTHENTICATION DAN AUTHORIZATION

### Hari 1-3: Implementasi Authentication
**Aktivitas:**
- [ ] Setup Laravel Breeze/Jetstream untuk authentication
- [ ] Customize login page sesuai design
- [ ] Implementasi login dengan email dan password
- [ ] Implementasi remember me functionality
- [ ] Implementasi password reset
- [ ] Implementasi email verification (opsional)
- [ ] Setup middleware untuk authentication
- [ ] Testing authentication flow

**Deliverables:**
- ✅ Login system berfungsi
- ✅ Password reset berfungsi
- ✅ Authentication middleware aktif

**Resource:**
- Developer: 16 jam

---

### Hari 4-5: Implementasi Authorization (Role-based)
**Aktivitas:**
- [ ] Setup role system (Kepala Sekolah, Guru, Tenaga Usaha)
- [ ] Implementasi middleware untuk role-based access
- [ ] Setup permission untuk setiap role
- [ ] Implementasi route protection berdasarkan role
- [ ] Implementasi view protection berdasarkan role
- [ ] Testing authorization untuk setiap role

**Deliverables:**
- ✅ Role-based access control berfungsi
- ✅ Setiap role hanya bisa akses fitur yang diizinkan
- ✅ Authorization middleware aktif

**Resource:**
- Developer: 12 jam

---

## MINGGU 7: DASHBOARD KEPALA SEKOLAH

### Hari 1-2: Layout dan Struktur Dashboard
**Aktivitas:**
- [ ] Buat layout master untuk Kepala Sekolah
- [ ] Implementasi sidebar navigation
- [ ] Implementasi header dengan user info
- [ ] Implementasi responsive design
- [ ] Setup routing untuk dashboard Kepala Sekolah
- [ ] Implementasi breadcrumb navigation

**Deliverables:**
- ✅ Layout dashboard Kepala Sekolah
- ✅ Sidebar navigation berfungsi
- ✅ Responsive design untuk mobile

**Resource:**
- Developer: 12 jam
- UI/UX Designer: 4 jam

---

### Hari 3-5: Fitur Dashboard Kepala Sekolah
**Aktivitas:**
- [ ] Implementasi statistik overview (total guru, siswa, kelas)
- [ ] Implementasi chart aktivitas guru (mingguan/bulanan)
- [ ] Implementasi daftar notifikasi terbaru
- [ ] Implementasi quick access menu
- [ ] Implementasi widget laporan singkat
- [ ] Implementasi filter dan search
- [ ] Testing semua fitur dashboard

**Deliverables:**
- ✅ Dashboard Kepala Sekolah lengkap
- ✅ Statistik dan chart berfungsi
- ✅ Notifikasi terintegrasi

**Resource:**
- Developer: 20 jam

---

## MINGGU 8: FITUR LAPORAN DAN DATA GURU

### Hari 1-3: Fitur Laporan
**Aktivitas:**
- [ ] Implementasi halaman laporan utama
- [ ] Implementasi filter laporan (periode, guru, kelas)
- [ ] Implementasi export laporan ke PDF
- [ ] Implementasi chart laporan aktivitas guru
- [ ] Implementasi statistik performa guru
- [ ] Implementasi detail laporan per guru
- [ ] Testing fitur laporan

**Deliverables:**
- ✅ Fitur laporan lengkap
- ✅ Export PDF berfungsi
- ✅ Chart dan statistik akurat

**Resource:**
- Developer: 20 jam

---

### Hari 4-5: Fitur Data Guru
**Aktivitas:**
- [ ] Implementasi halaman daftar guru
- [ ] Implementasi search dan filter guru
- [ ] Implementasi detail profil guru
- [ ] Implementasi edit data guru
- [ ] Implementasi upload foto guru
- [ ] Implementasi pagination
- [ ] Testing fitur data guru

**Deliverables:**
- ✅ Fitur data guru lengkap
- ✅ CRUD guru berfungsi
- ✅ Upload foto berfungsi

**Resource:**
- Developer: 12 jam

---

## MINGGU 9: FITUR DATA SISWA DAN AKTIVITAS GURU

### Hari 1-3: Fitur Data Siswa
**Aktivitas:**
- [ ] Implementasi halaman daftar siswa
- [ ] Implementasi search dan filter siswa
- [ ] Implementasi detail profil siswa
- [ ] Implementasi edit data siswa
- [ ] Implementasi upload foto siswa
- [ ] Implementasi export data siswa
- [ ] Implementasi pagination
- [ ] Testing fitur data siswa

**Deliverables:**
- ✅ Fitur data siswa lengkap
- ✅ CRUD siswa berfungsi
- ✅ Export data berfungsi

**Resource:**
- Developer: 20 jam

---

### Hari 4-5: Fitur Aktivitas Guru
**Aktivitas:**
- [ ] Implementasi halaman aktivitas guru
- [ ] Implementasi timeline aktivitas
- [ ] Implementasi filter aktivitas (tanggal, jenis)
- [ ] Implementasi detail aktivitas
- [ ] Implementasi statistik aktivitas
- [ ] Testing fitur aktivitas guru

**Deliverables:**
- ✅ Fitur aktivitas guru lengkap
- ✅ Timeline aktivitas berfungsi
- ✅ Statistik akurat

**Resource:**
- Developer: 12 jam

---

## MINGGU 10: DASHBOARD GURU DAN JADWAL MENGAJAR

### Hari 1-2: Layout Dashboard Guru
**Aktivitas:**
- [ ] Buat layout master untuk Guru
- [ ] Implementasi sidebar navigation untuk Guru
- [ ] Implementasi header dengan user info
- [ ] Setup routing untuk dashboard Guru
- [ ] Implementasi responsive design

**Deliverables:**
- ✅ Layout dashboard Guru
- ✅ Navigation berfungsi

**Resource:**
- Developer: 12 jam

---

### Hari 3-5: Fitur Jadwal Mengajar
**Aktivitas:**
- [ ] Implementasi halaman jadwal mengajar
- [ ] Implementasi tampilan jadwal (list/calendar view)
- [ ] Implementasi filter jadwal (hari, kelas, mata pelajaran)
- [ ] Implementasi detail jadwal
- [ ] Implementasi reminder jadwal
- [ ] Implementasi notifikasi jadwal mendatang
- [ ] Testing fitur jadwal mengajar

**Deliverables:**
- ✅ Fitur jadwal mengajar lengkap
- ✅ Calendar view berfungsi
- ✅ Notifikasi jadwal aktif

**Resource:**
- Developer: 20 jam

---

## MINGGU 11: FITUR MATERI DAN KUIS

### Hari 1-3: Fitur Manajemen Materi
**Aktivitas:**
- [ ] Implementasi halaman daftar materi
- [ ] Implementasi upload materi (file, video, link)
- [ ] Implementasi edit dan delete materi
- [ ] Implementasi kategori materi
- [ ] Implementasi search dan filter materi
- [ ] Implementasi preview materi
- [ ] Implementasi download materi
- [ ] Testing fitur materi

**Deliverables:**
- ✅ Fitur manajemen materi lengkap
- ✅ Upload berbagai format file berfungsi
- ✅ Preview dan download berfungsi

**Resource:**
- Developer: 20 jam

---

### Hari 4-5: Fitur Kuis dan Evaluasi
**Aktivitas:**
- [ ] Implementasi halaman daftar kuis
- [ ] Implementasi pembuatan kuis (pilihan ganda, esai)
- [ ] Implementasi edit dan delete kuis
- [ ] Implementasi setting durasi kuis
- [ ] Implementasi jadwal kuis (tanggal mulai/selesai)
- [ ] Implementasi integrasi video YouTube
- [ ] Implementasi link kuis eksternal
- [ ] Testing fitur kuis

**Deliverables:**
- ✅ Fitur kuis lengkap
- ✅ Pembuatan kuis berfungsi
- ✅ Integrasi video berfungsi

**Resource:**
- Developer: 12 jam

---

## MINGGU 12: NOTIFIKASI DAN FINALISASI DEVELOPMENT

### Hari 1-3: Sistem Notifikasi Email
**Aktivitas:**
- [ ] Setup email configuration (Gmail SMTP)
- [ ] Implementasi email notification untuk jadwal
- [ ] Implementasi email notification untuk kuis baru
- [ ] Implementasi email notification untuk materi baru
- [ ] Implementasi email notification untuk reminder
- [ ] Setup email queue untuk performa
- [ ] Testing email notification

**Deliverables:**
- ✅ Sistem notifikasi email berfungsi
- ✅ Semua jenis notifikasi terkirim
- ✅ Email queue aktif

**Resource:**
- Developer: 20 jam

---

### Hari 4-5: Finalisasi dan Code Review
**Aktivitas:**
- [ ] Code review untuk semua modul
- [ ] Refactoring code yang perlu diperbaiki
- [ ] Penambahan code comments
- [ ] Testing end-to-end semua fitur
- [ ] Fix minor bugs yang ditemukan
- [ ] Update dokumentasi kode
- [ ] Persiapan untuk tahap testing

**Deliverables:**
- ✅ Code review selesai
- ✅ Semua fitur sudah di-test
- ✅ Dokumentasi kode lengkap
- ✅ Sistem siap untuk UAT

**Resource:**
- Developer: 12 jam
- Senior Developer: 8 jam (code review)

---

## METRIK KEBERHASILAN TAHAP 2

- ✅ 100% fitur yang direncanakan sudah dikembangkan
- ✅ Semua fitur sudah di-test di development environment
- ✅ Code coverage minimal 70%
- ✅ Tidak ada critical bug
- ✅ Dokumentasi kode lengkap
- ✅ Sistem siap untuk UAT

---

# TAHAP 3: UJI SISTEM DAN VALIDASI
**Timeline: Minggu 13 - 14 (2 minggu)**

---

## MINGGU 13: FUNCTIONAL TESTING DAN INTEGRATION TESTING

### Hari 1-2: Functional Testing - Authentication & Authorization
**Aktivitas:**
- [ ] Test login dengan email dan password
- [ ] Test login dengan kredensial salah
- [ ] Test password reset
- [ ] Test logout
- [ ] Test akses halaman berdasarkan role
- [ ] Test middleware authorization
- [ ] Dokumentasi hasil testing
- [ ] Fix bug yang ditemukan

**Deliverables:**
- ✅ Test case untuk authentication
- ✅ Test case untuk authorization
- ✅ Bug report dan fix log
- ✅ Test result document

**Resource:**
- QA Tester: 12 jam
- Developer: 4 jam (fix bug)

---

### Hari 3-4: Functional Testing - Fitur Kepala Sekolah
**Aktivitas:**
- [ ] Test dashboard Kepala Sekolah
- [ ] Test fitur laporan (filter, export PDF)
- [ ] Test fitur data guru (CRUD, search, filter)
- [ ] Test fitur data siswa (CRUD, search, export)
- [ ] Test fitur aktivitas guru
- [ ] Test fitur notifikasi
- [ ] Dokumentasi hasil testing
- [ ] Fix bug yang ditemukan

**Deliverables:**
- ✅ Test case untuk fitur Kepala Sekolah
- ✅ Bug report dan fix log
- ✅ Test result document

**Resource:**
- QA Tester: 16 jam
- Developer: 8 jam (fix bug)

---

### Hari 5: Functional Testing - Fitur Guru
**Aktivitas:**
- [ ] Test dashboard Guru
- [ ] Test fitur jadwal mengajar
- [ ] Test fitur manajemen materi (upload, edit, delete)
- [ ] Test fitur kuis (buat, edit, delete)
- [ ] Test notifikasi email
- [ ] Dokumentasi hasil testing
- [ ] Fix bug yang ditemukan

**Deliverables:**
- ✅ Test case untuk fitur Guru
- ✅ Bug report dan fix log
- ✅ Test result document

**Resource:**
- QA Tester: 8 jam
- Developer: 4 jam (fix bug)

---

## MINGGU 14: USER ACCEPTANCE TESTING DAN VALIDASI

### Hari 1-2: UAT dengan Kepala Sekolah
**Aktivitas:**
- [ ] Demo sistem ke Kepala Sekolah
- [ ] UAT dashboard Kepala Sekolah
- [ ] UAT fitur laporan
- [ ] UAT fitur data guru dan siswa
- [ ] UAT fitur aktivitas guru
- [ ] Kumpulkan feedback dari Kepala Sekolah
- [ ] Dokumentasi feedback
- [ ] Prioritaskan perbaikan berdasarkan feedback

**Deliverables:**
- ✅ UAT report dari Kepala Sekolah
- ✅ Feedback document
- ✅ Action plan untuk perbaikan

**Resource:**
- Project Manager: 8 jam
- Kepala Sekolah: 4 jam
- Developer: 4 jam (perbaikan urgent)

---

### Hari 3-4: UAT dengan Guru
**Aktivitas:**
- [ ] Demo sistem ke perwakilan Guru (3-5 guru)
- [ ] UAT dashboard Guru
- [ ] UAT fitur jadwal mengajar
- [ ] UAT fitur manajemen materi
- [ ] UAT fitur kuis
- [ ] UAT notifikasi email
- [ ] Kumpulkan feedback dari Guru
- [ ] Dokumentasi feedback
- [ ] Prioritaskan perbaikan

**Deliverables:**
- ✅ UAT report dari Guru
- ✅ Feedback document
- ✅ Action plan untuk perbaikan

**Resource:**
- Project Manager: 12 jam
- Perwakilan Guru: 8 jam (total)
- Developer: 8 jam (perbaikan)

---

### Hari 5: UAT dengan Tenaga Usaha dan Finalisasi
**Aktivitas:**
- [ ] Demo sistem ke Tenaga Usaha
- [ ] UAT dashboard Tenaga Usaha
- [ ] UAT fitur manajemen data
- [ ] Kumpulkan feedback
- [ ] Review semua feedback dari semua user
- [ ] Implementasi perbaikan prioritas tinggi
- [ ] Final testing setelah perbaikan
- [ ] Sign-off UAT dari semua stakeholder

**Deliverables:**
- ✅ UAT report lengkap
- ✅ Sistem sudah diperbaiki berdasarkan feedback
- ✅ Sign-off UAT dari semua stakeholder
- ✅ Sistem siap untuk deployment

**Resource:**
- Project Manager: 8 jam
- Tenaga Usaha: 3 jam
- Developer: 8 jam (perbaikan)
- Stakeholder: 2 jam (sign-off)

---

## METRIK KEBERHASILAN TAHAP 3

- ✅ 100% test case sudah dijalankan
- ✅ Tidak ada critical bug
- ✅ Maksimal 5 minor bug yang tidak critical
- ✅ UAT dari semua stakeholder sudah selesai
- ✅ Sign-off dari semua stakeholder
- ✅ Sistem siap untuk production

---

# TAHAP 4: DEPLOYMENT DAN GO LIVE
**Timeline: Minggu 15 - 16 (2 minggu)**

---

## MINGGU 15: SETUP PRODUCTION ENVIRONMENT

### Hari 1-2: Setup Hosting/Server
**Aktivitas:**
- [ ] Pilih dan setup hosting/server (VPS/Cloud/Shared hosting)
- [ ] Install web server (Apache/Nginx)
- [ ] Install PHP dan extension yang diperlukan
- [ ] Install MySQL/MariaDB
- [ ] Setup domain name
- [ ] Setup SSL certificate (HTTPS)
- [ ] Konfigurasi firewall dan security
- [ ] Testing server environment

**Deliverables:**
- ✅ Server production siap
- ✅ Domain dan SSL aktif
- ✅ Security configuration selesai

**Resource:**
- DevOps: 12 jam
- Developer: 4 jam

---

### Hari 3-4: Deploy Aplikasi
**Aktivitas:**
- [ ] Clone repository ke server
- [ ] Setup .env untuk production
- [ ] Install dependencies (Composer, NPM jika ada)
- [ ] Generate application key
- [ ] Run database migration
- [ ] Run database seeder (data awal)
- [ ] Setup file permissions
- [ ] Konfigurasi web server (virtual host)
- [ ] Testing aplikasi di production

**Deliverables:**
- ✅ Aplikasi terdeploy di production
- ✅ Database terisi data awal
- ✅ Aplikasi bisa diakses via domain

**Resource:**
- Developer: 16 jam
- DevOps: 4 jam

---

### Hari 5: Setup Backup dan Monitoring
**Aktivitas:**
- [ ] Setup automated backup database (harian)
- [ ] Setup automated backup files (mingguan)
- [ ] Setup monitoring tools (uptime, error log)
- [ ] Setup email alert untuk error
- [ ] Testing backup dan restore
- [ ] Dokumentasi backup procedure

**Deliverables:**
- ✅ Backup otomatis aktif
- ✅ Monitoring tools aktif
- ✅ Dokumentasi backup procedure

**Resource:**
- DevOps: 8 jam
- Developer: 4 jam

---

## MINGGU 16: TRAINING DAN GO LIVE

### Hari 1-2: Training Admin Sistem
**Aktivitas:**
- [ ] Training untuk admin sistem (Tenaga Usaha)
- [ ] Training manajemen user
- [ ] Training backup dan restore
- [ ] Training monitoring sistem
- [ ] Training troubleshooting dasar
- [ ] Dokumentasi admin manual
- [ ] Q&A session

**Deliverables:**
- ✅ Admin sudah terlatih
- ✅ Admin manual lengkap
- ✅ Admin bisa handle operasional dasar

**Resource:**
- Trainer: 12 jam
- Admin: 8 jam

---

### Hari 3-4: Training User (Kepala Sekolah dan Guru)
**Aktivitas:**
- [ ] Training untuk Kepala Sekolah
  - [ ] Cara login dan navigasi
  - [ ] Cara melihat laporan
  - [ ] Cara melihat data guru dan siswa
  - [ ] Cara melihat aktivitas guru
- [ ] Training untuk Guru (batch 1-2)
  - [ ] Cara login dan navigasi
  - [ ] Cara melihat jadwal mengajar
  - [ ] Cara upload materi
  - [ ] Cara membuat kuis
  - [ ] Cara melihat notifikasi
- [ ] Q&A session
- [ ] Dokumentasi user manual

**Deliverables:**
- ✅ User manual lengkap
- ✅ Video tutorial (jika dibuat)
- ✅ User sudah terlatih

**Resource:**
- Trainer: 16 jam
- Kepala Sekolah: 4 jam
- Guru: 12 jam (total)

---

### Hari 5: Go Live dan Monitoring
**Aktivitas:**
- [ ] Final check semua fitur di production
- [ ] Announcement go live ke semua user
- [ ] Launch sistem ke user
- [ ] Monitoring sistem pasca launch (24 jam pertama)
- [ ] Handle issue yang muncul
- [ ] Collect feedback awal
- [ ] Dokumentasi go live

**Deliverables:**
- ✅ Sistem sudah go live
- ✅ Semua user bisa akses
- ✅ Monitoring report 24 jam pertama
- ✅ Go live document

**Resource:**
- Project Manager: 8 jam
- Developer: 8 jam (standby)
- Support: 8 jam

---

## METRIK KEBERHASILAN TAHAP 4

- ✅ Server production stabil
- ✅ Aplikasi bisa diakses tanpa error
- ✅ Backup otomatis berjalan
- ✅ 100% user sudah terlatih
- ✅ Sistem go live sukses
- ✅ Tidak ada critical issue dalam 24 jam pertama

---

# TAHAP 5: MAINTENANCE DAN SUPPORT
**Timeline: Setelah Go Live (Ongoing)**

---

## AKTIVITAS RUTIN

### Harian:
- [ ] Monitoring uptime sistem
- [ ] Check error logs
- [ ] Check backup status
- [ ] Handle support ticket dari user

### Mingguan:
- [ ] Review performa sistem
- [ ] Review error logs
- [ ] Update dokumentasi jika ada perubahan
- [ ] Backup database dan files

### Bulanan:
- [ ] Update sistem dan security patches
- [ ] Review dan optimasi database
- [ ] Review feedback dari user
- [ ] Laporan maintenance bulanan
- [ ] Meeting dengan stakeholder

### Triwulanan:
- [ ] Evaluasi fitur dan improvement
- [ ] Planning untuk enhancement
- [ ] Review anggaran maintenance

---

## DELIVERABLES TAHAP 5

- ✅ Sistem selalu update dan aman
- ✅ Data selalu terbackup
- ✅ User mendapat dukungan teknis
- ✅ Laporan maintenance bulanan
- ✅ Dokumentasi selalu update

---

# TIMELINE RINGKAS DETAIL

| Minggu | Tahap | Aktivitas Utama | Deliverables |
|--------|-------|-----------------|--------------|
| **1** | 1 | Kick-off, Analisis Kepala Sekolah | MoM, Analisis Kebutuhan KS |
| **2** | 1 | Analisis Guru dan Tenaga Usaha | Analisis Kebutuhan User |
| **3** | 1 | Perencanaan Teknis (Arsitektur, DB, UI/UX) | ERD, DFD, Wireframe |
| **4** | 1 | Dokumentasi dan Finalisasi | SRS, Anggaran, Sign-off |
| **5** | 2 | Setup Environment dan Database | Environment siap, DB schema |
| **6** | 2 | Authentication dan Authorization | Login, Role-based access |
| **7** | 2 | Dashboard Kepala Sekolah | Dashboard KS lengkap |
| **8** | 2 | Laporan dan Data Guru | Fitur laporan dan data guru |
| **9** | 2 | Data Siswa dan Aktivitas Guru | Fitur data siswa dan aktivitas |
| **10** | 2 | Dashboard Guru dan Jadwal | Dashboard Guru dan jadwal |
| **11** | 2 | Materi dan Kuis | Fitur materi dan kuis |
| **12** | 2 | Notifikasi dan Finalisasi | Notifikasi email, code review |
| **13** | 3 | Functional Testing | Test case, bug report |
| **14** | 3 | UAT dan Validasi | UAT report, sign-off |
| **15** | 4 | Setup Production dan Deploy | Server siap, aplikasi terdeploy |
| **16** | 4 | Training dan Go Live | User terlatih, sistem go live |
| **17+** | 5 | Maintenance dan Support | Ongoing support |

**Total Durasi: 16 minggu (4 bulan) untuk implementasi awal**

---

# DEPENDENCIES ANTAR TAHAP

- **Tahap 2** tidak bisa dimulai sebelum **Tahap 1** selesai dan sign-off
- **Tahap 3** tidak bisa dimulai sebelum **Tahap 2** selesai
- **Tahap 4** tidak bisa dimulai sebelum **Tahap 3** selesai dan UAT sign-off
- **Tahap 5** dimulai setelah **Tahap 4** go live

---

# RESOURCE ALLOCATION DETAIL

## Tim yang Diperlukan:

### Full-time:
- **1-2 Developer Laravel** (40 jam/minggu)
- **1 QA Tester** (40 jam/minggu, mulai minggu 13)

### Part-time:
- **1 Project Manager** (20 jam/minggu)
- **1 Business Analyst** (20 jam/minggu, minggu 1-4)
- **1 System Architect** (16 jam/minggu, minggu 3-4)
- **1 UI/UX Designer** (16 jam/minggu, minggu 3-4, 7)
- **1 DevOps** (20 jam/minggu, minggu 15)
- **1 Trainer** (20 jam/minggu, minggu 16)

### Support:
- **1 Support Staff** (part-time, setelah go live)

---

# BUDGET BREAKDOWN DETAIL

## Tahap 1: Persiapan dan Analisis (Minggu 1-4)
- Business Analyst: 40 jam × Rp 100.000 = Rp 4.000.000
- System Architect: 32 jam × Rp 150.000 = Rp 4.800.000
- UI/UX Designer: 20 jam × Rp 120.000 = Rp 2.400.000
- Project Manager: 20 jam × Rp 150.000 = Rp 3.000.000
- **Subtotal: Rp 14.200.000**

## Tahap 2: Pengembangan Sistem (Minggu 5-12)
- Developer: 320 jam × Rp 125.000 = Rp 40.000.000
- UI/UX Designer: 8 jam × Rp 120.000 = Rp 960.000
- **Subtotal: Rp 40.960.000**

## Tahap 3: Uji Sistem dan Validasi (Minggu 13-14)
- QA Tester: 80 jam × Rp 100.000 = Rp 8.000.000
- Developer (fix bug): 24 jam × Rp 125.000 = Rp 3.000.000
- **Subtotal: Rp 11.000.000**

## Tahap 4: Deployment dan Go Live (Minggu 15-16)
- DevOps: 28 jam × Rp 150.000 = Rp 4.200.000
- Developer: 32 jam × Rp 125.000 = Rp 4.000.000
- Trainer: 28 jam × Rp 100.000 = Rp 2.800.000
- **Subtotal: Rp 11.000.000**

## Infrastruktur:
- Hosting/Server (1 tahun): Rp 2.000.000
- Domain (1 tahun): Rp 200.000
- SSL Certificate: Rp 0 (gratis dengan Let's Encrypt)
- **Subtotal: Rp 2.200.000**

## Total Biaya Implementasi:
**Rp 79.360.000**

## Biaya Tahunan (Setelah Tahun Pertama):
- Maintenance & Support: Rp 24.000.000/tahun
- Hosting: Rp 2.000.000/tahun
- Domain: Rp 200.000/tahun
- **Total: Rp 26.200.000/tahun**

---

*Dokumen ini adalah versi detail dari roadmap implementasi sistem TMS di MTS Nurul Aiman Tanjungsari Sumedang.*

