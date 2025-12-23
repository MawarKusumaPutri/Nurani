# Panduan Import Jadwal Pelajaran dari Excel

## Fitur Baru: Import Jadwal Otomatis

Sekarang Anda dapat mengimport jadwal pelajaran secara otomatis dari file Excel! Fitur ini memungkinkan Anda untuk:
- Import banyak jadwal sekaligus
- Menghemat waktu input manual
- Mengurangi kesalahan input data

## Cara Menggunakan

### 1. Download Template Excel
1. Buka halaman **Jadwal Pelajaran** di dashboard TU
2. Klik tombol **"Import Excel"**
3. Di modal yang muncul, klik **"Download Template Excel"**
4. Simpan file template di komputer Anda

### 2. Isi Data Jadwal
Buka file template Excel dan isi data jadwal dengan format berikut:

| Mata Pelajaran | Nama Guru | Kelas | Hari | Waktu | Ruang | Keterangan |
|---|---|---|---|---|---|---|
| Matematika | Budi Santoso | 7A | Senin | 08:00 - 09:30 | Ruang 7A | Jadwal rutin |
| Bahasa Indonesia | Siti Aminah | 7A | Senin | 09:30 - 11:00 | Ruang 7A | |
| IPA | Ahmad Hidayat | 7A | Selasa | 08:00 - 09:30 | Laboratorium | Praktikum |

**Penting:**
- **Mata Pelajaran**: Gunakan nama mata pelajaran yang sesuai (Matematika, Bahasa Indonesia, Bahasa Inggris, IPA, IPS, dll)
- **Nama Guru**: Harus sesuai dengan nama guru yang sudah terdaftar di sistem
- **Kelas**: Format: 7A, 7B, 8A, 8B, 9A, 9B, dst
- **Hari**: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu
- **Waktu**: Format: HH:MM - HH:MM (contoh: 08:00 - 09:30)
- **Ruang**: Nama ruangan, atau "Laboratorium" untuk lab, "Lapangan" untuk lapangan
- **Keterangan**: Opsional, bisa dikosongkan

### 3. Upload File Excel
1. Kembali ke modal **Import Excel**
2. Pilih **Semester** dan **Tahun Ajaran**
3. Klik **"Choose File"** dan pilih file Excel yang sudah diisi
4. Klik **"Import Jadwal"**

### 4. Verifikasi Hasil Import
- Sistem akan menampilkan pesan sukses dengan jumlah jadwal yang berhasil diimport
- Jadwal yang diimport akan langsung muncul di tabel jadwal
- Guru akan langsung bisa melihat jadwal mereka di halaman **Jadwal Mengajar**

## Format Mata Pelajaran yang Didukung

Sistem akan otomatis mengenali berbagai format nama mata pelajaran:

- **Matematika**: Matematika, MTK
- **Bahasa Indonesia**: Bahasa Indonesia, B. Indonesia
- **Bahasa Inggris**: Bahasa Inggris, B. Inggris, English
- **IPA**: IPA, Sains
- **IPS**: IPS
- **Pendidikan Agama**: Pendidikan Agama, Agama, PAI
- **PKN**: Pendidikan Kewarganegaraan, PKN, PPKN
- **PJOK**: Pendidikan Jasmani, PJOK, Penjas
- **Seni Budaya**: Seni Budaya, Seni
- **TIK**: Teknologi Informasi, TIK, Informatika

## Tips & Trik

1. **Pastikan Nama Guru Benar**: Nama guru harus persis sama dengan yang ada di database
2. **Format Waktu**: Gunakan format 24 jam (08:00, 13:00, dst)
3. **Ruang Khusus**: 
   - Tulis "Laboratorium" atau "Lab" untuk pelajaran di lab
   - Tulis "Lapangan" untuk pelajaran olahraga
4. **Jadwal Berulang**: Semua jadwal yang diimport akan otomatis diset sebagai jadwal berulang setiap minggu

## Export Jadwal

Anda juga dapat mengexport jadwal yang sudah ada ke format CSV:
1. Klik tombol **"Export"** di halaman Jadwal Pelajaran
2. File CSV akan otomatis terdownload
3. Anda dapat membuka file ini di Excel untuk diedit atau dicetak

## Troubleshooting

**Q: Import gagal, muncul error "Guru not found"**
A: Pastikan nama guru di Excel persis sama dengan nama di database. Cek di menu Data Guru.

**Q: Waktu tidak terbaca dengan benar**
A: Pastikan format waktu adalah HH:MM - HH:MM dengan spasi sebelum dan sesudah tanda strip (-)

**Q: Mata pelajaran menjadi "Lainnya"**
A: Sistem tidak mengenali nama mata pelajaran. Gunakan nama standar seperti di daftar di atas.

## Contoh File Excel

Lihat file template yang sudah didownload untuk contoh format yang benar.

---

Jika ada pertanyaan atau masalah, hubungi administrator sistem.
