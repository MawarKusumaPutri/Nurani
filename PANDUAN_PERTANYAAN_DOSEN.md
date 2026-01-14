# 🎓 PANDUAN PERTANYAAN DOSEN & JAWABAN
## TMS NURANI - Persiapan Presentasi & Ujian

---

## 📖 DAFTAR ISI

1. [Pertanyaan Umum Sistem](#pertanyaan-umum-sistem)
2. [Pertanyaan Teknologi](#pertanyaan-teknologi)
3. [Pertanyaan Fitur](#pertanyaan-fitur)
4. [Pertanyaan Database](#pertanyaan-database)
5. [Pertanyaan Keamanan](#pertanyaan-keamanan)
6. [Pertanyaan Pengembangan](#pertanyaan-pengembangan)
7. [Tips Menjawab](#tips-menjawab)

---

## 1. PERTANYAAN UMUM SISTEM

### ❓ **"Apa itu TMS NURANI?"**

**Jawaban:**
> "TMS NURANI adalah **Teaching Management System** untuk MTs Nurul Aiman, Pak/Bu. Sistem ini membantu sekolah dalam mengelola proses pembelajaran secara digital.
> 
> **Fitur utama:**
> - Guru bisa membuat RPP, materi, dan kuis secara online
> - Tenaga Usaha bisa mengelola data siswa dan guru
> - Kepala Sekolah bisa monitoring dan approve RPP
> 
> Jadi semua proses administrasi pembelajaran jadi lebih efisien dan terorganisir."

---

### ❓ **"Kenapa buat sistem ini?"**

**Jawaban:**
> "Pak/Bu, berdasarkan observasi di MTs Nurul Aiman, ada beberapa masalah:
> 
> **Masalah yang ada:**
> 1. RPP masih manual (tulis tangan atau Word)
> 2. Data siswa tersebar di berbagai file Excel
> 3. Kepala Sekolah sulit monitoring kinerja guru
> 4. Tidak ada sistem terpusat
> 
> **Solusi TMS NURANI:**
> 1. RPP digital dengan template standar
> 2. Database terpusat untuk semua data
> 3. Dashboard monitoring untuk Kepala Sekolah
> 4. Sistem multi-role yang terintegrasi
> 
> Jadi sistem ini menjawab kebutuhan nyata sekolah."

---

### ❓ **"Siapa saja yang pakai sistem ini?"**

**Jawaban:**
> "Ada 3 role utama, Pak/Bu:
> 
> **1. Guru (13 orang)**
> - Buat RPP untuk setiap pertemuan
> - Upload materi pembelajaran
> - Buat kuis dan input nilai
> - Isi presensi siswa
> 
> **2. Tenaga Usaha / TU (1 orang)**
> - Kelola data siswa (CRUD, import/export)
> - Kelola data guru
> - Atur jadwal pelajaran
> - Kelola kalender akademik
> 
> **3. Kepala Sekolah (1 orang)**
> - Monitoring kinerja guru dan siswa
> - Approve/reject RPP
> - Lihat laporan akademik
> - Analisis statistik
> 
> Setiap role punya hak akses berbeda sesuai tugasnya."

---

## 2. PERTANYAAN TEKNOLOGI

### ❓ **"Teknologi apa yang dipakai?"**

**Jawaban:**
> "Pak/Bu, saya menggunakan stack teknologi modern:
> 
> **Backend:**
> - Laravel 11 (PHP Framework)
> - PHP 8.2
> 
> **Frontend:**
> - Blade Template Engine
> - HTML5, CSS3
> - Bootstrap 5 (responsive design)
> - JavaScript (vanilla)
> 
> **Database:**
> - MySQL
> 
> **Arsitektur:**
> - MVC (Model-View-Controller)
> 
> **Server:**
> - Apache (XAMPP)
> - Ngrok (untuk tunneling)
> 
> Semua teknologi ini dipilih karena mature, well-documented, dan cocok untuk sistem manajemen sekolah."

---

### ❓ **"Kenapa pakai Laravel, bukan PHP biasa?"**

**Jawaban:**
> "Pak/Bu, Laravel punya banyak keuntungan dibanding PHP biasa:
> 
> **1. Lebih Mudah & Cepat**
> 
> PHP Biasa (10 baris):
> ```php
> $conn = mysqli_connect("localhost", "root", "", "nurani");
> $query = "SELECT * FROM siswas WHERE kelas = 'VII'";
> $result = mysqli_query($conn, $query);
> while($row = mysqli_fetch_assoc($result)) {
>     echo $row['nama_lengkap'];
> }
> mysqli_close($conn);
> ```
> 
> Laravel (2 baris):
> ```php
> $siswas = Siswa::where('kelas', 'VII')->get();
> foreach($siswas as $siswa) echo $siswa->nama_lengkap;
> ```
> 
> **2. Keamanan Built-in**
> - Auto-escape XSS
> - CSRF protection
> - SQL injection prevention
> - Password hashing otomatis
> 
> **3. Fitur Lengkap**
> - Eloquent ORM (query database mudah)
> - Blade Template (view lebih rapi)
> - Middleware (proteksi route)
> - Validation (validasi input)
> - Migration (database versioning)
> 
> **4. Maintainable**
> - Kode terstruktur (MVC)
> - Mudah dikembangkan
> - Banyak dokumentasi
> 
> Jadi Laravel menghemat waktu development dan lebih aman."

---

### ❓ **"Apa itu MVC?"**

**Jawaban:**
> "MVC itu Model-View-Controller, Pak/Bu. Pola desain untuk memisahkan kode jadi 3 bagian:
> 
> **Analogi Restoran:**
> 
> **Model** = Gudang
> - Simpan data (database)
> - Query data
> - Relasi antar tabel
> 
> **View** = Ruang Makan
> - Tampilan yang dilihat customer
> - HTML, CSS, JavaScript
> - Form, tabel, button
> 
> **Controller** = Pelayan
> - Terima pesanan (request)
> - Proses pesanan (logic)
> - Ambil dari gudang (Model)
> - Sajikan ke customer (View)
> 
> **Contoh di TMS NURANI:**
> 
> User mau lihat daftar siswa:
> 1. **Controller** terima request
> 2. **Controller** panggil **Model** Siswa
> 3. **Model** query database
> 4. **Controller** kirim data ke **View**
> 5. **View** tampilkan tabel siswa
> 
> **Keuntungan:**
> - Kode terorganisir
> - Mudah maintenance
> - Bisa dikerjakan tim (Model, View, Controller terpisah)"

---

### ❓ **"Apa itu Eloquent ORM?"**

**Jawaban:**
> "Eloquent adalah ORM (Object-Relational Mapping) bawaan Laravel, Pak/Bu.
> 
> **Fungsi:** Mengubah tabel database jadi object PHP.
> 
> **Contoh:**
> 
> Tabel `siswas` → Class `Siswa`
> 
> **Query dengan Eloquent:**
> ```php
> // Ambil semua siswa
> $siswas = Siswa::all();
> 
> // Filter by kelas
> $siswas = Siswa::where('kelas', 'VII')->get();
> 
> // Cari by ID
> $siswa = Siswa::find(1);
> 
> // Relasi (ambil RPP dari guru)
> $rpps = $guru->rpps;
> ```
> 
> **Keuntungan:**
> - Lebih mudah dibaca
> - Lebih aman (auto-escape)
> - Support relasi (One-to-One, One-to-Many)
> - Chainable (bisa digabung)
> 
> Jadi tidak perlu tulis SQL manual, cukup pakai method PHP."

---

## 3. PERTANYAAN FITUR

### ❓ **"Fitur apa saja yang ada?"**

**Jawaban:**
> "Pak/Bu, ada 3 grup fitur sesuai role:
> 
> **FITUR GURU:**
> 1. **RPP** - Buat RPP digital untuk 16 pertemuan
> 2. **Materi Pembelajaran** - Upload materi per mata pelajaran
> 3. **Kuis** - Buat soal pilihan ganda dan essay
> 4. **Presensi** - Isi kehadiran siswa
> 5. **Nilai** - Input nilai siswa
> 6. **Jadwal Mengajar** - Lihat jadwal mengajar
> 7. **Profil** - Edit profil dan ganti password
> 
> **FITUR TENAGA USAHA:**
> 1. **Manajemen Siswa** - CRUD siswa, import/export Excel
> 2. **Manajemen Guru** - CRUD guru, reset password
> 3. **Jadwal Pelajaran** - Atur jadwal per kelas
> 4. **Kalender Akademik** - Kelola event sekolah
> 5. **Surat Menyurat** - Arsip surat masuk/keluar
> 6. **Pengumuman** - Buat pengumuman sekolah
> 
> **FITUR KEPALA SEKOLAH:**
> 1. **Dashboard Statistik** - Lihat ringkasan data
> 2. **Monitoring Guru** - Lihat kinerja guru
> 3. **Monitoring Siswa** - Lihat nilai dan presensi
> 4. **Approval RPP** - Approve/reject RPP guru
> 5. **Laporan Akademik** - Export laporan PDF
> 6. **Analytics** - Grafik dengan Chart.js
> 
> Total ada 20 fitur yang terintegrasi."

---

### ❓ **"Jelaskan fitur RPP!"**

**Jawaban:**
> "Fitur RPP adalah fitur utama untuk guru, Pak/Bu.
> 
> **Fungsi:**
> Guru bisa membuat Rencana Pelaksanaan Pembelajaran secara digital.
> 
> **Isi RPP:**
> 1. Identitas (judul, kelas, semester, pertemuan ke-)
> 2. Kompetensi Inti (KI 1-4)
> 3. Kompetensi Dasar (KD)
> 4. Tujuan Pembelajaran
> 5. Materi Pembelajaran (reguler, pengayaan, remedial)
> 6. Metode & Media Pembelajaran
> 7. Kegiatan Pembelajaran (pendahuluan, inti, penutup)
> 8. Penilaian (teknik, instrumen, rubrik)
> 9. Pengesahan (TTD Kepala Sekolah & Guru)
> 
> **Flow:**
> 1. Guru pilih mata pelajaran
> 2. Pilih pertemuan ke- (1-16)
> 3. Isi form RPP
> 4. Upload tanda tangan (opsional)
> 5. Klik Simpan
> 6. RPP masuk ke sistem dengan status 'pending'
> 7. Kepala Sekolah review dan approve/reject
> 8. Jika approved, RPP bisa dicetak
> 
> **Teknologi:**
> - Validasi input (Laravel Validator)
> - File upload (Laravel Storage)
> - Cek duplikasi (prevent double submit)
> - Loading overlay (JavaScript)
> 
> Jadi guru tidak perlu bikin RPP manual lagi."

---

### ❓ **"Bagaimana cara approve RPP?"**

**Jawaban:**
> "Pak/Bu, ini fitur khusus Kepala Sekolah:
> 
> **Flow Approval:**
> 
> 1. **Guru submit RPP** → Status: 'pending'
> 2. **Kepala Sekolah login** → Lihat notifikasi RPP pending
> 3. **Klik menu Approval RPP** → Lihat daftar RPP pending
> 4. **Klik Review** → Baca isi RPP lengkap
> 5. **Pilih:**
>    - **Approve** → Status jadi 'approved', bisa dicetak
>    - **Reject** → Status jadi 'rejected', guru harus revisi
> 6. **Isi catatan** (opsional untuk approve, wajib untuk reject)
> 7. **Konfirmasi** → RPP diupdate
> 8. **Notifikasi** → Guru dapat notifikasi (TODO)
> 
> **Fitur Tambahan:**
> - **Bulk Approve** - Approve banyak RPP sekaligus
> - **Filter** - Filter by status (pending/approved/rejected)
> - **History** - Lihat RPP yang sudah di-approve
> 
> **Teknologi:**
> - Middleware (hanya Kepala Sekolah bisa akses)
> - Checkbox (untuk bulk approve)
> - JavaScript (select all checkbox)
> - Timestamp (catat waktu approve)
> 
> Jadi Kepala Sekolah punya kontrol penuh atas RPP yang dibuat guru."

---

## 4. PERTANYAAN DATABASE

### ❓ **"Bagaimana struktur database?"**

**Jawaban:**
> "Pak/Bu, database saya beri nama 'nurani' dengan 30 tabel. Yang utama:
> 
> **Tabel Utama:**
> 
> **1. users** - Data login semua user
> - id, name, email, password, role
> 
> **2. gurus** - Data detail guru
> - id, user_id (FK), nip, mata_pelajaran, foto, status
> 
> **3. siswas** - Data siswa
> - id, nisn, nama_lengkap, kelas, status
> 
> **4. rpp** - Data RPP
> - id, guru_id (FK), judul, mata_pelajaran, pertemuan_ke, status_approval
> 
> **5. jadwal** - Jadwal pelajaran
> - id, kelas, hari, jam_mulai, jam_selesai, guru_id (FK)
> 
> **6. events** - Kalender akademik
> - id, judul, tanggal_mulai, tanggal_selesai, kategori
> 
> **Relasi:**
> ```
> users (1) → (1) gurus (1) → (N) rpp
> gurus (1) → (N) jadwal
> ```
> 
> **Normalisasi:**
> - Sudah 3NF (Third Normal Form)
> - Tidak ada redundansi data
> - Relasi dengan Foreign Key
> 
> **Indexing:**
> - Primary Key di semua tabel
> - Index di email (users)
> - Index di nisn (siswas)
> 
> Jadi database terstruktur dan efisien."

---

### ❓ **"Apa itu Foreign Key?"**

**Jawaban:**
> "Foreign Key adalah kolom yang merujuk ke Primary Key tabel lain, Pak/Bu.
> 
> **Fungsi:**
> - Menjaga integritas data
> - Membuat relasi antar tabel
> 
> **Contoh di TMS NURANI:**
> 
> Tabel `gurus`:
> - `user_id` → Foreign Key ke `users.id`
> 
> Tabel `rpp`:
> - `guru_id` → Foreign Key ke `gurus.id`
> 
> **Artinya:**
> - 1 User → 1 Guru (One-to-One)
> - 1 Guru → Banyak RPP (One-to-Many)
> 
> **Keuntungan:**
> - Tidak bisa insert guru tanpa user
> - Tidak bisa insert RPP tanpa guru
> - Jika guru dihapus, RPP-nya ikut terhapus (CASCADE)
> 
> **Constraint:**
> ```sql
> FOREIGN KEY (guru_id) REFERENCES gurus(id) ON DELETE CASCADE
> ```
> 
> Jadi Foreign Key menjaga konsistensi data."

---

## 5. PERTANYAAN KEAMANAN

### ❓ **"Bagaimana keamanan sistem?"**

**Jawaban:**
> "Pak/Bu, saya implementasi beberapa layer keamanan:
> 
> **1. Authentication (Siapa Anda?)**
> - Login dengan email & password
> - Password di-hash dengan bcrypt (tidak disimpan plain text)
> - Session management
> - Remember me token
> 
> **2. Authorization (Boleh Akses Apa?)**
> - Role-based access control (Guru/TU/Kepala Sekolah)
> - Middleware untuk proteksi route
> - Cek role di setiap request
> 
> **3. Input Validation**
> - Validasi semua input form
> - Sanitize data
> - Prevent SQL injection (Eloquent ORM)
> 
> **4. CSRF Protection**
> - Token CSRF di setiap form POST
> - Prevent Cross-Site Request Forgery
> 
> **5. XSS Protection**
> - Auto-escape output (Blade {{ }})
> - Prevent Cross-Site Scripting
> 
> **6. File Upload Security**
> - Validasi tipe file (image, pdf, doc)
> - Validasi ukuran file (max 2MB-5MB)
> - Simpan di storage terpisah
> 
> **7. HTTPS (Production)**
> - Enkripsi data saat transfer
> - SSL certificate
> 
> **Contoh Middleware:**
> ```php
> Route::middleware(['auth', 'role:guru'])->group(function () {
>     Route::get('/rpp', [RppController::class, 'index']);
> });
> ```
> 
> Jadi sistem cukup aman untuk production."

---

### ❓ **"Bagaimana cara hash password?"**

**Jawaban:**
> "Pak/Bu, saya pakai bcrypt untuk hash password:
> 
> **Kenapa Hash?**
> - Password tidak disimpan plain text
> - Jika database bocor, password tetap aman
> - Tidak bisa di-decrypt (one-way hash)
> 
> **Cara Kerja:**
> 
> **Saat Register/Create User:**
> ```php
> User::create([
>     'email' => 'guru@gmail.com',
>     'password' => Hash::make('password123'), // Hash
> ]);
> ```
> 
> **Di Database:**
> ```
> password: $2y$10$abcdefghijklmnopqrstuvwxyz...
> ```
> 
> **Saat Login:**
> ```php
> if (Hash::check($request->password, $user->password)) {
>     // Password benar
> }
> ```
> 
> **Keamanan:**
> - Bcrypt otomatis pakai salt (random string)
> - Setiap hash beda meski password sama
> - Butuh waktu lama untuk brute force
> 
> Jadi password user aman."

---

## 6. PERTANYAAN PENGEMBANGAN

### ❓ **"Berapa lama buat sistem ini?"**

**Jawaban:**
> "Pak/Bu, total development sekitar 2-3 bulan:
> 
> **Timeline:**
> 
> **Bulan 1: Planning & Design**
> - Analisis kebutuhan sekolah
> - Design database
> - Wireframe UI/UX
> - Setup environment
> 
> **Bulan 2: Development**
> - Backend (Laravel)
> - Frontend (Blade + Bootstrap)
> - Fitur Guru (RPP, Materi, Kuis)
> - Fitur TU (Manajemen Siswa/Guru)
> 
> **Bulan 3: Testing & Deployment**
> - Fitur Kepala Sekolah (Approval, Laporan)
> - Testing semua fitur
> - Bug fixing
> - Deployment dengan ngrok
> - Dokumentasi
> 
> **Tantangan:**
> - Multi-role system (3 role berbeda)
> - Approval workflow
> - File upload
> - Responsive design
> 
> Tapi alhamdulillah selesai tepat waktu."

---

### ❓ **"Apa kendala saat development?"**

**Jawaban:**
> "Pak/Bu, ada beberapa kendala:
> 
> **1. Multi-Role System**
> - **Masalah:** Setiap role punya hak akses berbeda
> - **Solusi:** Buat middleware CheckRole, cek role di setiap route
> 
> **2. Guru dengan 2 Mata Pelajaran**
> - **Masalah:** Satu guru bisa ngajar 2 mapel, data harus terpisah
> - **Solusi:** Dropdown switch mata pelajaran, filter data by mapel
> 
> **3. Approval Workflow**
> - **Masalah:** RPP harus di-approve Kepala Sekolah dulu
> - **Solusi:** Tambah field status_approval, buat controller khusus approval
> 
> **4. File Upload**
> - **Masalah:** Upload tanda tangan, foto, dokumen
> - **Solusi:** Laravel Storage, validasi tipe & ukuran file
> 
> **5. Responsive Design**
> - **Masalah:** Harus bisa diakses dari HP
> - **Solusi:** Bootstrap 5 (mobile-first framework)
> 
> **6. Data Guru Tidak Lengkap**
> - **Masalah:** User ada tapi data guru tidak ada
> - **Solusi:** Buat script fix untuk insert data guru
> 
> Semua kendala bisa diatasi dengan research dan trial-error."

---

### ❓ **"Fitur apa yang akan dikembangkan?"**

**Jawaban:**
> "Pak/Bu, ada beberapa fitur yang bisa dikembangkan:
> 
> **Short-term (1-3 bulan):**
> 1. **Notifikasi Real-time** - Pakai Pusher atau WebSocket
> 2. **Export RPP ke PDF** - Generate PDF dari RPP
> 3. **E-Learning** - Upload video pembelajaran
> 4. **Forum Diskusi** - Guru dan siswa bisa diskusi
> 5. **Mobile App** - Buat aplikasi Android/iOS
> 
> **Long-term (6-12 bulan):**
> 1. **AI Assistant** - Bantu guru buat RPP dengan AI
> 2. **Auto Grading** - Koreksi kuis otomatis
> 3. **Video Conference** - Integrasi Zoom/Google Meet
> 4. **Parent Portal** - Orang tua bisa lihat nilai anak
> 5. **Analytics Dashboard** - Prediksi nilai siswa dengan ML
> 
> **Integrasi:**
> - Google Classroom
> - WhatsApp API (notifikasi)
> - Payment Gateway (bayar SPP online)
> 
> Jadi sistem ini bisa terus berkembang sesuai kebutuhan."

---

## 7. TIPS MENJAWAB

### ✅ **DO (Lakukan)**

1. **Percaya Diri**
   - Bicara dengan jelas dan tegas
   - Tatap mata dosen
   - Jangan terburu-buru

2. **Pakai Analogi**
   - Restoran (MVC, Backend/Frontend)
   - Lemari arsip (Database)
   - Pelayan (Controller)

3. **Tunjukkan Kode**
   - Buka file panduan
   - Tunjukkan contoh kode singkat
   - Jelaskan setiap baris

4. **Demo Langsung**
   - Buka browser
   - Login sebagai guru/TU/Kepala Sekolah
   - Tunjukkan fitur bekerja

5. **Jujur**
   - Kalau tidak tahu, bilang "Belum saya pelajari, Pak/Bu"
   - Jangan ngasal jawab

### ❌ **DON'T (Jangan)**

1. **Jangan Gugup**
   - Tarik napas dalam
   - Ingat: Anda yang paling tahu sistem ini

2. **Jangan Terlalu Teknis**
   - Jangan langsung bahas algoritma kompleks
   - Mulai dari konsep sederhana

3. **Jangan Defensif**
   - Terima kritik dengan baik
   - Catat saran dosen untuk improvement

4. **Jangan Berbohong**
   - Jangan bilang "Sudah production" kalau belum
   - Jangan bilang "Sudah ada fitur X" kalau belum

---

## 🎯 **STRATEGI PRESENTASI**

### **Pembukaan (2 menit)**
```
"Assalamualaikum, Pak/Bu. Saya [Nama], NIM [NIM].

Hari ini saya akan presentasikan Tugas Akhir saya:
TMS NURANI - Teaching Management System untuk MTs Nurul Aiman.

Sistem ini membantu sekolah mengelola proses pembelajaran secara digital,
dengan 3 role: Guru, Tenaga Usaha, dan Kepala Sekolah.

Saya akan demo fitur-fitur utama dan menjelaskan teknologi yang digunakan."
```

### **Demo (10 menit)**
1. Login sebagai **Guru** → Buat RPP
2. Login sebagai **Kepala Sekolah** → Approve RPP
3. Login sebagai **TU** → Kelola siswa

### **Penjelasan Teknologi (5 menit)**
1. Tunjukkan **kode** (Model, Controller, View)
2. Jelaskan **database** (ERD, relasi)
3. Jelaskan **keamanan** (middleware, hash password)

### **Penutup (3 menit)**
```
"Demikian presentasi saya, Pak/Bu.

Sistem ini sudah berjalan dengan baik dan siap digunakan oleh sekolah.
Ke depan, saya berencana menambahkan fitur notifikasi real-time
dan export RPP ke PDF.

Terima kasih. Saya siap menjawab pertanyaan."
```

---

## 📚 **REFERENSI CEPAT**

**Saat Dosen Tanya, Buka File:**

| Pertanyaan | File |
|------------|------|
| "Teknologi apa?" | `RINGKASAN_TEKNOLOGI_TMS_NURANI.md` |
| "Fitur apa saja?" | `BUKU_PANDUAN_LENGKAP_SEMUA_FITUR.md` |
| "Bagaimana kode RPP?" | `PANDUAN_LENGKAP_GURU_USER_DAN_KODE.md` |
| "Bagaimana approval?" | `PANDUAN_LENGKAP_KEPALA_SEKOLAH_USER_DAN_KODE.md` |
| "Bagaimana kelola siswa?" | `PANDUAN_LENGKAP_TENAGA_USAHA_USER_DAN_KODE.md` |

---

## 🎓 **KESIMPULAN**

**Kunci Sukses Presentasi:**
1. ✅ **Pahami sistem Anda** (baca semua panduan)
2. ✅ **Latihan demo** (minimal 3x sebelum presentasi)
3. ✅ **Siapkan jawaban** (baca file ini berkali-kali)
4. ✅ **Percaya diri** (Anda yang buat sistem ini!)
5. ✅ **Jujur** (kalau tidak tahu, bilang tidak tahu)

**Ingat:**
> Dosen ingin tahu apakah Anda **paham** sistem yang Anda buat.
> Bukan apakah sistem Anda **sempurna**.

**Good luck!** 🚀

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0
