# Fitur Grafik Lingkaran Presensi Siswa

## Deskripsi
Fitur ini menambahkan visualisasi grafik lingkaran (pie chart) untuk monitoring aktivitas siswa di setiap kelas (7, 8, 9). Guru dapat dengan mudah melihat perbandingan siswa yang aktif, tidak aktif, dan belum diisi presensinya.

## Perubahan yang Dilakukan

### 1. Controller (`app/Http/Controllers/Guru/PresensiSiswaController.php`)
- **Method**: `index()`
- **Penambahan**: Menghitung statistik presensi untuk setiap kelas (7, 8, 9) berdasarkan data 30 hari terakhir
- **Data yang dihitung**:
  - Total siswa per kelas
  - Jumlah siswa aktif di kelas
  - Jumlah siswa tidak aktif di kelas
  - Jumlah presensi yang belum diisi aktivitasnya
  - Total presensi yang tercatat

### 2. View (`resources/views/guru/presensi-siswa/index.blade.php`)

#### a. Penambahan Library
- **Chart.js v4.4.0**: Library untuk membuat grafik interaktif
- Ditambahkan di bagian `<head>` section

#### b. Section Grafik Lingkaran
- **Lokasi**: Setelah filter section, sebelum form presensi
- **Fitur**:
  - 3 grafik lingkaran untuk kelas 7, 8, dan 9
  - Warna yang jelas:
    - 🟢 Hijau (#28a745) untuk "Aktif di Kelas"
    - 🔴 Merah (#dc3545) untuk "Tidak Aktif di Kelas"
    - 🟡 Kuning (#ffc107) untuk "Belum Diisi"
  - Informasi detail di bawah setiap grafik
  - Animasi smooth saat grafik muncul
  - Hover effect pada container grafik

#### c. JavaScript Initialization
- **Chart Configuration**:
  - Type: Pie chart
  - Responsive design
  - Tooltip dengan persentase
  - Animasi rotasi dan scale (1.5 detik)
  - Hover offset untuk interaktivitas
- **Fallback**: Jika tidak ada data, menampilkan pesan "Belum ada data presensi"

## Cara Menggunakan

1. **Akses Halaman**: Login sebagai Guru → Menu "Presensi Siswa"
2. **Lihat Grafik**: Scroll ke bawah setelah filter section
3. **Interpretasi**:
   - Grafik menampilkan data 30 hari terakhir
   - Hover pada grafik untuk melihat detail jumlah dan persentase
   - Gunakan data ini untuk memantau keterlibatan siswa

## Manfaat

✅ **Visual yang Jelas**: Guru dapat langsung melihat perbandingan aktivitas siswa  
✅ **Monitoring Mudah**: Identifikasi kelas yang membutuhkan perhatian lebih  
✅ **Data Real-time**: Otomatis update berdasarkan presensi yang diinput  
✅ **User-Friendly**: Desain modern dengan animasi yang smooth  

## Screenshot Fitur
Grafik akan menampilkan 3 pie chart berdampingan untuk kelas 7, 8, dan 9 dengan informasi:
- Total siswa di kelas tersebut
- Breakdown jumlah siswa aktif, tidak aktif, dan belum diisi
- Persentase masing-masing kategori saat hover

## Testing
Untuk menguji fitur:
1. Pastikan ada data presensi siswa yang sudah diinput
2. Pastikan field "Aktivitas Siswa" sudah diisi (aktif/tidak aktif)
3. Refresh halaman Presensi Siswa
4. Grafik akan muncul otomatis dengan data 30 hari terakhir

---
**Dibuat**: 2026-01-04  
**Versi**: 1.0  
**Developer**: Antigravity AI
