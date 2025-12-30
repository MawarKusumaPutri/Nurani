# 📚 PANDUAN IMPORT DATA SISWA DENGAN EXCEL

## 🎯 Tujuan
Memudahkan Tenaga Usaha untuk memasukkan **banyak data siswa sekaligus** tanpa perlu input satu per satu.

---

## ✅ Langkah-Langkah Import Data Siswa

### **Step 1: Download Template Excel**

1. Buka halaman **Data Siswa** (`/tu/siswa`)
2. Klik button **"Import Excel"** (hijau)
3. Modal "Import Data Siswa dari Excel" akan muncul
4. Klik button **"Download Template Excel"**
5. File `template_data_siswa.csv` akan terdownload

---

### **Step 2: Isi Data Siswa di Excel**

Buka file template yang sudah didownload, lalu isi data siswa sesuai format:

| NIS    | Nama          | Kelas | Jenis Kelamin | Tempat Lahir | Tanggal Lahir | Alamat              | Status |
|--------|---------------|-------|---------------|--------------|---------------|---------------------|--------|
| 10120  | Ahmad Fauzi   | 7     | Laki-laki     | Jakarta      | 2010-05-15    | Jl. Merdeka No. 10  | aktif  |
| 10121  | Siti Nurhaliza| 7     | Perempuan     | Bandung      | 2010-06-20    | Jl. Sudirman No. 15 | aktif  |
| 10122  | Budi Santoso  | 8     | Laki-laki     | Surabaya     | 2009-03-12    | Jl. Pahlawan No. 5  | aktif  |

**⚠️ PENTING - Format yang Benar:**

- **NIS**: Angka unik, tidak boleh duplikat
- **Nama**: Nama lengkap siswa
- **Kelas**: Hanya `7`, `8`, atau `9`
- **Jenis Kelamin**: Hanya `Laki-laki` atau `Perempuan` (huruf besar di awal)
- **Tempat Lahir**: Nama kota
- **Tanggal Lahir**: Format `YYYY-MM-DD` (contoh: `2010-05-15`)
- **Alamat**: Alamat lengkap
- **Status**: Hanya `aktif`, `tidak_aktif`, atau `lulus`

---

### **Step 3: Upload File Excel**

1. Kembali ke modal "Import Data Siswa dari Excel"
2. Pilih tab **"Upload File"**
3. Klik **"Pilih File Excel"**
4. Pilih file Excel yang sudah diisi
5. File akan muncul di preview (nama file dan ukuran)
6. Klik button **"Import Data"** (hijau)

---

### **Step 4: Verifikasi Data**

Setelah import berhasil:

1. Akan muncul pesan sukses: **"Berhasil mengimport X data siswa"**
2. Data siswa otomatis muncul di card kelas masing-masing:
   - Kelas 7 → Card "Kelas 7"
   - Kelas 8 → Card "Kelas 8"
   - Kelas 9 → Card "Kelas 9"
3. Total siswa di footer card akan otomatis update

---

## 🚀 Alternatif: Import dengan Copy-Paste

Jika tidak bisa upload file, gunakan metode **Copy-Paste**:

### **Step 1: Siapkan Data di Excel**

Buat data di Excel dengan format yang sama seperti di atas.

### **Step 2: Copy Data**

1. Select semua data siswa di Excel (termasuk header)
2. Copy (`Ctrl+C`)

### **Step 3: Paste di Modal**

1. Buka modal "Import Data Siswa dari Excel"
2. Pilih tab **"Copy-Paste dari Excel"**
3. Paste data di textarea (`Ctrl+V`)
4. Klik button **"Import Data"**

---

## 📊 Contoh Data Excel untuk Import

### **Contoh 1: Import 5 Siswa Kelas 7**

```csv
NIS,Nama,Kelas,Jenis Kelamin,Tempat Lahir,Tanggal Lahir,Alamat,Status
10201,Ahmad Fauzi,7,Laki-laki,Jakarta,2010-05-15,Jl. Merdeka No. 10,aktif
10202,Siti Nurhaliza,7,Perempuan,Bandung,2010-06-20,Jl. Sudirman No. 15,aktif
10203,Budi Santoso,7,Laki-laki,Surabaya,2010-03-12,Jl. Pahlawan No. 5,aktif
10204,Dewi Lestari,7,Perempuan,Yogyakarta,2010-08-25,Jl. Malioboro No. 20,aktif
10205,Eko Prasetyo,7,Laki-laki,Semarang,2010-11-30,Jl. Pemuda No. 8,aktif
```

### **Contoh 2: Import Siswa Campuran (Kelas 7, 8, 9)**

```csv
NIS,Nama,Kelas,Jenis Kelamin,Tempat Lahir,Tanggal Lahir,Alamat,Status
10301,Andi Wijaya,7,Laki-laki,Jakarta,2010-01-10,Jl. A No. 1,aktif
10302,Budi Setiawan,8,Laki-laki,Bandung,2009-02-15,Jl. B No. 2,aktif
10303,Citra Dewi,9,Perempuan,Surabaya,2008-03-20,Jl. C No. 3,aktif
10304,Dian Pratama,7,Laki-laki,Yogyakarta,2010-04-25,Jl. D No. 4,aktif
10305,Eka Putri,8,Perempuan,Semarang,2009-05-30,Jl. E No. 5,aktif
```

---

## ⚠️ Error yang Mungkin Terjadi

### **1. NIS Duplikat**

**Error**: `NIS '10120' sudah ada di database`

**Solusi**: Ganti NIS dengan nomor yang belum digunakan

### **2. Format Tanggal Salah**

**Error**: `Data tidak lengkap`

**Solusi**: Pastikan format tanggal `YYYY-MM-DD` (contoh: `2010-05-15`)

### **3. Jenis Kelamin Salah**

**Error**: `Data tidak lengkap`

**Solusi**: Gunakan `Laki-laki` atau `Perempuan` (huruf besar di awal)

### **4. Kelas Salah**

**Error**: `Data tidak lengkap`

**Solusi**: Gunakan hanya `7`, `8`, atau `9`

---

## 💡 Tips & Trik

### **1. Import Bertahap**

Jika data banyak (100+ siswa), import bertahap:
- Import kelas 7 dulu (30 siswa)
- Lalu kelas 8 (30 siswa)
- Terakhir kelas 9 (30 siswa)

### **2. Backup Data**

Sebelum import, backup file Excel Anda untuk jaga-jaga.

### **3. Cek Data Setelah Import**

Setelah import, cek:
- Total siswa di setiap kelas
- Data siswa sudah benar (nama, NIS, dll)
- Tidak ada data yang hilang

### **4. Gunakan Excel, Bukan Notepad**

Untuk hasil terbaik, gunakan:
- ✅ Microsoft Excel
- ✅ Google Sheets
- ✅ LibreOffice Calc
- ❌ Notepad (tidak disarankan)

---

## 📹 Video Tutorial (Jika Ada)

Jika ada video tutorial, link akan ditambahkan di sini.

---

## 🆘 Bantuan

Jika mengalami kesulitan:

1. **Cek format data** - Pastikan sesuai template
2. **Cek pesan error** - Baca pesan error dengan teliti
3. **Coba data sedikit dulu** - Import 1-2 siswa untuk test
4. **Hubungi admin** - Jika masih error

---

## ✅ Checklist Import Data Siswa

- [ ] Download template Excel
- [ ] Isi data siswa sesuai format
- [ ] Cek NIS tidak duplikat
- [ ] Cek format tanggal (YYYY-MM-DD)
- [ ] Cek jenis kelamin (Laki-laki/Perempuan)
- [ ] Cek kelas (7/8/9)
- [ ] Upload file Excel
- [ ] Klik "Import Data"
- [ ] Verifikasi data berhasil masuk
- [ ] Cek total siswa di setiap kelas

---

## 🎉 Selesai!

Dengan fitur **Import Excel**, Tenaga Usaha bisa memasukkan **puluhan bahkan ratusan data siswa sekaligus** dalam hitungan menit, tanpa perlu input satu per satu!

**Hemat waktu, hemat tenaga!** 🚀
