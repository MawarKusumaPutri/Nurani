# Penjelasan Minggu 5 dan 6 di Tahap 2: Pengembangan Sistem

## Kenapa Minggu 5 dan 6 Masih Setup, Bukan Langsung Fitur?

Minggu 5 dan 6 adalah **fondasi (foundation)** yang **WAJIB** disiapkan sebelum mulai mengembangkan fitur-fitur spesifik untuk setiap role. Ini seperti membangun rumah - kita harus siapkan pondasi dulu sebelum membangun dinding dan atap.

---

## MINGGU 5: SETUP ENVIRONMENT DAN DATABASE

### Kenapa Perlu Minggu 5?

**Sebelum bisa develop fitur apapun, kita perlu:**
1. ✅ **Environment siap** - Laravel, database, tools sudah terinstall
2. ✅ **Database structure siap** - Semua tabel sudah dibuat
3. ✅ **Data dummy siap** - Untuk testing fitur nanti

**Tanpa ini, kita tidak bisa develop fitur apapun!**

---

### Apa yang Dilakukan di Minggu 5?

#### 1. Setup Development Environment
**Kenapa penting?**
- Laravel framework harus terinstall dulu
- Database connection harus berfungsi
- Package dependencies (Bootstrap, jQuery, dll) harus terinstall
- **Tanpa ini, kita tidak bisa coding apapun!**

**Aktivitas:**
- Install XAMPP (Apache, MySQL, PHP)
- Install Composer
- Install Laravel
- Setup project `nurani-tms`
- Install package dependencies (Bootstrap, jQuery, Chart.js, DomPDF)
- Setup Git untuk version control

**Hasil:**
- ✅ Kita bisa mulai coding
- ✅ Framework Laravel siap digunakan
- ✅ Semua tools sudah terinstall

---

#### 2. Setup Database dan Migration
**Kenapa penting?**
- Semua fitur nanti butuh database
- Dashboard butuh tabel `users`, `guru`, `siswa`
- Laporan butuh tabel `aktivitas_guru`
- Jadwal butuh tabel `jadwal_mengajar`
- Materi butuh tabel `materi`
- Kuis butuh tabel `kuis`
- **Tanpa tabel-tabel ini, fitur tidak bisa jalan!**

**Aktivitas:**
- Buat database `nurani_tms`
- Buat migration untuk semua tabel:
  - `users` (untuk login semua role)
  - `guru` (untuk data guru)
  - `siswa` (untuk data siswa)
  - `kelas` (untuk data kelas)
  - `mata_pelajaran` (untuk mata pelajaran)
  - `jadwal_mengajar` (untuk jadwal - fitur Guru)
  - `materi` (untuk materi - fitur Guru)
  - `kuis` (untuk kuis - fitur Guru)
  - `notifikasi` (untuk notifikasi semua role)
  - `aktivitas_guru` (untuk laporan - fitur Kepala Sekolah)
- Setup foreign keys (relasi antar tabel)
- Buat database seeder untuk data dummy

**Hasil:**
- ✅ Database structure lengkap
- ✅ Semua tabel sudah ada
- ✅ Data dummy untuk testing
- ✅ Relasi antar tabel sudah benar

**Contoh:**
- Kalau kita langsung develop fitur "Jadwal Mengajar" di minggu 7, tapi tabel `jadwal_mengajar` belum ada, **fitur tidak bisa jalan!**
- Kalau kita langsung develop fitur "Laporan" di minggu 7, tapi tabel `aktivitas_guru` belum ada, **fitur tidak bisa jalan!**

---

## MINGGU 6: AUTHENTICATION DAN AUTHORIZATION

### Kenapa Perlu Minggu 6?

**Sebelum bisa develop fitur per role, kita perlu:**
1. ✅ **Login system** - User harus bisa login dulu
2. ✅ **Role system** - Sistem harus tahu user itu Kepala Sekolah, Guru, atau Tenaga Usaha
3. ✅ **Authorization** - Setiap role hanya bisa akses fitur mereka
4. ✅ **Security** - Fitur harus protected, tidak bisa diakses sembarangan

**Tanpa ini, semua fitur tidak aman dan tidak bisa dibedakan per role!**

---

### Apa yang Dilakukan di Minggu 6?

#### 1. Implementasi Authentication
**Kenapa penting?**
- Semua fitur butuh user yang sudah login
- Dashboard Kepala Sekolah harus protected (hanya Kepala Sekolah yang bisa akses)
- Dashboard Guru harus protected (hanya Guru yang bisa akses)
- **Tanpa login, semua orang bisa akses semua fitur - TIDAK AMAN!**

**Aktivitas:**
- Setup Laravel Breeze untuk authentication
- Customize login page
- Implementasi login dengan email dan password
- Implementasi password reset
- Setup middleware untuk authentication

**Hasil:**
- ✅ User bisa login
- ✅ User bisa logout
- ✅ User bisa reset password
- ✅ Halaman-halaman protected (harus login dulu)

**Contoh:**
- Kalau kita langsung develop fitur "Dashboard Kepala Sekolah" di minggu 7, tapi login belum ada, **siapa saja bisa akses - TIDAK AMAN!**
- Kalau kita langsung develop fitur "Jadwal Mengajar" di minggu 8, tapi login belum ada, **siapa saja bisa lihat jadwal - TIDAK AMAN!**

---

#### 2. Implementasi Authorization (Role-based)
**Kenapa penting?**
- Kepala Sekolah hanya bisa akses fitur Kepala Sekolah
- Guru hanya bisa akses fitur Guru
- Tenaga Usaha hanya bisa akses fitur Tenaga Usaha
- **Tanpa ini, semua role bisa akses semua fitur - TIDAK AMAN!**

**Aktivitas:**
- Setup role system di database (`kepala_sekolah`, `guru`, `tenaga_usaha`)
- Implementasi middleware untuk role-based access
- Setup permission untuk setiap role
- Implementasi route protection berdasarkan role
- Implementasi view protection berdasarkan role

**Hasil:**
- ✅ Setiap role hanya bisa akses fitur mereka
- ✅ Kepala Sekolah tidak bisa akses fitur Guru
- ✅ Guru tidak bisa akses fitur Kepala Sekolah
- ✅ Security terjaga

**Contoh:**
- Kalau kita langsung develop fitur "Dashboard Kepala Sekolah" di minggu 7, tapi authorization belum ada, **Guru juga bisa akses - TIDAK AMAN!**
- Kalau kita langsung develop fitur "Manajemen Data Guru" di minggu 10, tapi authorization belum ada, **Guru juga bisa edit data guru - TIDAK AMAN!**

---

## Alur Pengembangan yang Benar:

```
MINGGU 5: Setup Foundation
├── Environment siap ✅
├── Database structure siap ✅
└── Data dummy siap ✅
    ↓
MINGGU 6: Setup Security
├── Login system siap ✅
├── Role system siap ✅
└── Authorization siap ✅
    ↓
MINGGU 7-12: Develop Fitur Per Role
├── Minggu 7: Fitur Kepala Sekolah (Dashboard, Laporan)
│   └── Bisa pakai database dari minggu 5 ✅
│   └── Bisa pakai authorization dari minggu 6 ✅
├── Minggu 8: Fitur Kepala Sekolah (Data) + Fitur Guru (Dashboard, Jadwal)
│   └── Bisa pakai database dari minggu 5 ✅
│   └── Bisa pakai authorization dari minggu 6 ✅
├── Minggu 9: Fitur Guru (Materi, Kuis)
│   └── Bisa pakai database dari minggu 5 ✅
│   └── Bisa pakai authorization dari minggu 6 ✅
├── Minggu 10: Fitur Tenaga Usaha
│   └── Bisa pakai database dari minggu 5 ✅
│   └── Bisa pakai authorization dari minggu 6 ✅
└── Minggu 11-12: Fitur Umum + Finalisasi
    └── Bisa pakai semua yang sudah dibuat ✅
```

---

## Analogi Sederhana:

### Membangun Rumah:

**Minggu 5 = Siapkan Lahan dan Bahan:**
- ✅ Lahan sudah dibersihkan
- ✅ Semen, bata, kayu sudah tersedia
- ✅ Alat-alat sudah siap

**Minggu 6 = Buat Pondasi:**
- ✅ Pondasi sudah dibuat
- ✅ Struktur dasar sudah ada
- ✅ Keamanan dasar sudah ada

**Minggu 7-12 = Bangun Rumah:**
- ✅ Kamar Kepala Sekolah (fitur Kepala Sekolah)
- ✅ Kamar Guru (fitur Guru)
- ✅ Kamar Tenaga Usaha (fitur Tenaga Usaha)
- ✅ Semua pakai pondasi yang sudah dibuat

**Kalau langsung bangun kamar tanpa pondasi, rumah akan roboh!**

---

## Kesimpulan:

### Minggu 5 dan 6 BUKAN "ngapain", tapi "WAJIB":

1. **Minggu 5: Setup Foundation**
   - Environment, database, tools
   - **Tanpa ini, tidak bisa coding apapun**

2. **Minggu 6: Setup Security**
   - Login, role, authorization
   - **Tanpa ini, fitur tidak aman dan tidak bisa dibedakan per role**

3. **Minggu 7-12: Develop Fitur**
   - Baru mulai develop fitur per role
   - **Pakai semua yang sudah disiapkan di minggu 5-6**

---

## Timeline yang Benar:

| Minggu | Aktivitas | Kenapa Penting |
|--------|-----------|----------------|
| **5** | Setup Environment & Database | **Fondasi** - Tanpa ini tidak bisa coding |
| **6** | Authentication & Authorization | **Security** - Tanpa ini tidak aman |
| **7** | Fitur Kepala Sekolah | Pakai fondasi dari minggu 5-6 |
| **8** | Fitur Kepala Sekolah + Guru | Pakai fondasi dari minggu 5-6 |
| **9** | Fitur Guru | Pakai fondasi dari minggu 5-6 |
| **10** | Fitur Tenaga Usaha | Pakai fondasi dari minggu 5-6 |
| **11-12** | Fitur Umum + Finalisasi | Pakai semua yang sudah dibuat |

---

**Jadi, minggu 5 dan 6 adalah "persiapan wajib" sebelum mulai develop fitur. Tanpa ini, fitur tidak bisa dikembangkan dengan benar dan aman!**

---

*Penjelasan ini untuk menjawab pertanyaan: "trs minggu 5 sama 6 nya ngapain di tahap 2"*

