# 🔄 Panduan Sinkronisasi Jadwal TU dan Guru

## ✅ Status: Sudah Tersinkron Otomatis!

Jadwal yang dibuat oleh **Tenaga Usaha (TU)** akan **otomatis muncul** di halaman jadwal guru tanpa perlu refresh manual atau tindakan tambahan.

## 🔗 Cara Kerja Sinkronisasi

### 1. Database yang Sama
- ✅ TU dan Guru menggunakan **database yang sama**
- ✅ Jadwal disimpan di tabel `jadwal` dengan `guru_id` sebagai foreign key
- ✅ Semua jadwal untuk guru tertentu menggunakan `guru_id` yang sama

### 2. Query Otomatis
- ✅ Halaman jadwal guru menggunakan query: `Jadwal::where('guru_id', $guru->id)`
- ✅ Query ini **otomatis mengambil semua jadwal** yang dibuat oleh TU untuk guru tersebut
- ✅ Tidak perlu refresh manual - jadwal langsung muncul

### 3. Filter Status
- ✅ Hanya menampilkan jadwal dengan status **"aktif"**
- ✅ Jadwal dengan status "nonaktif" atau "sementara" tidak ditampilkan

## 📋 Alur Sinkronisasi

```
1. TU membuat jadwal baru
   ↓
2. Jadwal disimpan ke database dengan guru_id
   ↓
3. Guru membuka halaman "Jadwal Mengajar"
   ↓
4. Query otomatis mengambil jadwal berdasarkan guru_id
   ↓
5. Jadwal langsung muncul di halaman guru
```

## ✅ Fitur yang Sudah Tersinkron

### 1. Halaman Jadwal Mengajar Guru
- ✅ Menampilkan semua jadwal yang dibuat TU untuk guru tersebut
- ✅ Urut berdasarkan hari (Senin → Minggu)
- ✅ Urut berdasarkan jam mulai
- ✅ Menampilkan informasi lengkap: hari, mata pelajaran, kelas, jam, ruang, semester, status

### 2. Dashboard Guru
- ✅ **Jadwal Hari Ini**: Menampilkan jadwal hari ini (termasuk jadwal berulang)
- ✅ **Jadwal Minggu Ini**: Menampilkan jadwal minggu ini
- ✅ **Statistik**: Menampilkan jumlah jadwal hari ini

### 3. Informasi Jadwal
- ✅ Badge "Lab" jika menggunakan laboratorium
- ✅ Badge "Lapangan" jika menggunakan lapangan
- ✅ Badge "Berulang" jika jadwal berulang setiap minggu
- ✅ Status jadwal (Aktif/Nonaktif)

## 🔧 Troubleshooting

### Masalah: Jadwal tidak muncul di halaman guru

**Penyebab:**
1. Status jadwal bukan "aktif"
2. `guru_id` tidak sesuai
3. Cache belum dibersihkan

**Solusi:**
1. Pastikan status jadwal adalah "aktif" di halaman TU
2. Pastikan TU memilih guru yang benar saat membuat jadwal
3. Clear cache:
   ```cmd
   php artisan config:clear
   php artisan view:clear
   ```
4. Refresh browser dengan hard refresh (Ctrl+F5)

### Masalah: Jadwal muncul tapi tidak sesuai

**Penyebab:**
- `guru_id` salah saat membuat jadwal

**Solusi:**
1. Edit jadwal di halaman TU
2. Pastikan memilih guru yang benar
3. Simpan perubahan
4. Jadwal akan otomatis terupdate di halaman guru

## 📌 Catatan Penting

1. **Tidak Perlu Refresh Manual**
   - Jadwal otomatis tersinkron karena menggunakan database yang sama
   - Cukup refresh browser untuk melihat jadwal terbaru

2. **Real-time Update**
   - Ketika TU membuat/edit/hapus jadwal, perubahan langsung tersimpan ke database
   - Guru akan melihat perubahan saat refresh halaman

3. **Filter Otomatis**
   - Hanya jadwal dengan status "aktif" yang ditampilkan
   - Jadwal yang dihapus atau dinonaktifkan tidak akan muncul

## ✅ Kesimpulan

**Sinkronisasi sudah otomatis dan berfungsi dengan baik!**

- ✅ TU membuat jadwal → Otomatis muncul di halaman guru
- ✅ TU edit jadwal → Otomatis terupdate di halaman guru
- ✅ TU hapus/nonaktifkan jadwal → Otomatis hilang dari halaman guru
- ✅ Tidak perlu tindakan tambahan
- ✅ Menggunakan database yang sama
- ✅ Query otomatis berdasarkan `guru_id`

