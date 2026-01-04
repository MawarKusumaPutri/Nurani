# Fitur Statistik Presensi Siswa

## Deskripsi
Fitur ini menampilkan grafik lingkaran (pie chart) untuk memantau aktivitas siswa di kelas berdasarkan data presensi. Guru dapat melihat statistik untuk setiap kelas (7, 8, dan 9) secara visual dan interaktif.

## Fitur Utama

### 1. Grafik Lingkaran Per Kelas
- **Kelas 7**: Badge ungu dengan gradien
- **Kelas 8**: Badge pink dengan gradien
- **Kelas 9**: Badge biru dengan gradien

Setiap grafik menampilkan:
- 🟢 **Aktif di Kelas** (hijau)
- 🔴 **Tidak Aktif di Kelas** (merah)
- ⚪ **Belum Diisi** (abu-abu)

### 2. Filter Tanggal
Guru dapat memfilter data berdasarkan rentang tanggal:
- Tanggal Mulai
- Tanggal Akhir
- Default: Bulan berjalan

### 3. Statistik Detail Per Kelas
Untuk setiap kelas, ditampilkan:
- Total Siswa
- Total Presensi
- Jumlah Siswa Aktif di Kelas
- Jumlah Siswa Tidak Aktif di Kelas
- Jumlah Data Belum Diisi

### 4. Ringkasan Status Presensi
Menampilkan breakdown status presensi:
- ✅ Hadir (hijau)
- 🤒 Sakit (kuning)
- 📝 Izin (biru)
- ❌ Alfa (merah)

## Cara Menggunakan

### Untuk Guru:
1. Login ke sistem sebagai Guru
2. Buka menu **Presensi Siswa**
3. Klik tombol **"Lihat Statistik"** di pojok kanan atas
4. Pilih rentang tanggal yang diinginkan
5. Klik tombol **"Filter Data"**
6. Lihat grafik dan statistik untuk setiap kelas

### URL Akses:
```
/guru/presensi-siswa/statistik
```

## Teknologi yang Digunakan

### Backend:
- **Laravel Controller**: `PresensiSiswaController@statistik`
- **Model**: `PresensiSiswa`, `Siswa`, `Guru`
- **Query**: Eloquent ORM dengan relationship

### Frontend:
- **Chart.js 4.4.0**: Library untuk grafik lingkaran
- **Bootstrap 5.3**: Framework CSS
- **Font Awesome 6.0**: Icon library
- **Google Fonts**: Inter font family

### Fitur Visualisasi:
- Doughnut chart dengan cutout 65%
- Animasi smooth saat loading
- Hover effect dengan tooltip informatif
- Responsive design untuk mobile dan desktop

## File yang Dibuat/Dimodifikasi

### 1. Controller
```
app/Http/Controllers/Guru/PresensiSiswaController.php
```
- Method baru: `statistik()`

### 2. View
```
resources/views/guru/presensi-siswa/statistik.blade.php
```
- Halaman baru untuk menampilkan grafik

### 3. Routes
```
routes/web.php
```
- Route baru: `GET /guru/presensi-siswa/statistik`

### 4. Index View
```
resources/views/guru/presensi-siswa/index.blade.php
```
- Tombol navigasi ke halaman statistik

## Data yang Ditampilkan

### Aktivitas Siswa:
- **Aktif di Kelas**: Siswa yang berpartisipasi aktif dalam pembelajaran
- **Tidak Aktif di Kelas**: Siswa yang kurang berpartisipasi
- **Belum Diisi**: Data aktivitas yang belum diinput oleh guru

### Status Presensi:
- **Hadir**: Siswa hadir di kelas
- **Sakit**: Siswa tidak hadir karena sakit
- **Izin**: Siswa tidak hadir dengan izin
- **Alfa**: Siswa tidak hadir tanpa keterangan

## Manfaat

1. **Monitoring Real-time**: Guru dapat memantau aktivitas siswa secara visual
2. **Identifikasi Cepat**: Mudah mengidentifikasi siswa yang tidak aktif
3. **Laporan Visual**: Data disajikan dalam bentuk grafik yang mudah dipahami
4. **Filter Fleksibel**: Dapat melihat data berdasarkan periode tertentu
5. **Perbandingan Antar Kelas**: Melihat performa aktivitas siswa di berbagai kelas

## Catatan Pengembangan

- Grafik menggunakan Chart.js dengan konfigurasi doughnut chart
- Warna konsisten dengan tema aplikasi (hijau untuk sukses, merah untuk warning)
- Responsive design yang optimal untuk desktop dan mobile
- Animasi smooth untuk meningkatkan user experience
- Data diambil berdasarkan guru yang login dan rentang tanggal yang dipilih

## Screenshot
![Preview Statistik Presensi](../../../public/images/statistik-preview.png)

---
**Dibuat**: 4 Januari 2026
**Developer**: Antigravity AI Assistant
**Versi**: 1.0
