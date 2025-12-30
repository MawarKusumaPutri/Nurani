# 📚 CARA INSTALL PHPSPREADSHEET DI RAILWAY

## 🎯 Tujuan
Agar aplikasi bisa import file Excel (.xlsx/.xls) langsung tanpa perlu convert ke CSV.

---

## ✅ Langkah-Langkah

### **Opsi 1: Otomatis saat Deploy (RECOMMENDED)**

Railway akan otomatis install PhpSpreadsheet saat deployment jika sudah ditambahkan ke `composer.json`.

**Langkah:**
1. Tambahkan PhpSpreadsheet ke `composer.json`
2. Push ke GitHub
3. Railway auto-deploy dan install dependencies

---

### **Opsi 2: Manual dengan Railway CLI**

Jika Opsi 1 tidak berhasil, install manual:

```bash
# 1. Login ke Railway
railway login

# 2. Link ke project
railway link

# 3. Install PhpSpreadsheet
railway run composer require phpoffice/phpspreadsheet

# 4. Redeploy
railway up
```

---

### **Opsi 3: Tambah ke composer.json Manual**

1. Buka file `composer.json`
2. Tambahkan di bagian `require`:

```json
{
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0",
        "phpoffice/phpspreadsheet": "^1.29"
    }
}
```

3. Commit dan push:

```bash
git add composer.json
git commit -m "Add: PhpSpreadsheet dependency"
git push origin master
```

4. Railway akan auto-install saat deployment

---

## 🔍 Verifikasi Installation

Setelah deployment selesai, cek apakah PhpSpreadsheet sudah terinstall:

```bash
railway run composer show phpoffice/phpspreadsheet
```

Jika berhasil, akan muncul info package PhpSpreadsheet.

---

## 🚀 Test Import Excel

Setelah PhpSpreadsheet terinstall:

1. Buka halaman Data Siswa
2. Klik "Import Excel"
3. Download template (sekarang format `.xlsx`)
4. Isi data siswa
5. Upload file `.xlsx`
6. Klik "Import Data"
7. **Berhasil!** Tidak ada error lagi!

---

## ⚠️ Troubleshooting

### **Error: Class 'PhpOffice\PhpSpreadsheet\Spreadsheet' not found**

**Penyebab**: PhpSpreadsheet belum terinstall

**Solusi**:
```bash
railway run composer require phpoffice/phpspreadsheet
railway up
```

### **Error: Memory limit exceeded**

**Penyebab**: File Excel terlalu besar

**Solusi**: 
- Upload file lebih kecil (max 50-100 siswa per file)
- Atau tingkatkan memory limit di Railway settings

---

## 💡 Catatan

- **PhpSpreadsheet** adalah library PHP untuk membaca/menulis file Excel
- **Ukuran**: ~10MB (tidak terlalu besar)
- **Kompatibel**: Excel 2007+ (.xlsx), Excel 97-2003 (.xls), CSV
- **Gratis**: Open source, tidak perlu lisensi

---

## ✅ Checklist

- [ ] PhpSpreadsheet ditambahkan ke composer.json
- [ ] Code di-push ke GitHub
- [ ] Railway auto-deploy
- [ ] PhpSpreadsheet terinstall
- [ ] Test download template (.xlsx)
- [ ] Test upload file Excel (.xlsx)
- [ ] Import berhasil tanpa error

---

## 🎉 Selesai!

Setelah PhpSpreadsheet terinstall, Anda bisa:
- ✅ Download template Excel (.xlsx)
- ✅ Upload file Excel (.xlsx/.xls) langsung
- ✅ Tidak perlu convert ke CSV lagi!

**Lebih mudah dan user-friendly!** 🚀
