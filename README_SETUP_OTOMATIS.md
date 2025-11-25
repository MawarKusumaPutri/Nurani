# 🚀 SETUP OTOMATIS - TANPA SETTING MANUAL

Panduan untuk menjalankan website `nuranitms.test` dengan HTTPS **TANPA PERLU SETTING MANUAL**.

---

## ⚡ CARA MENGGUNAKAN (SUPER MUDAH!)

### Langkah 1: Jalankan Script Otomatis

**Double-click:** `SETUP_OTOMATIS_LENGKAP.bat`

**Script ini akan melakukan SEMUA konfigurasi otomatis:**
- ✅ Membuat certificate SSL otomatis
- ✅ Mengaktifkan mod_ssl otomatis
- ✅ Mengaktifkan mod_rewrite otomatis
- ✅ Membuat VirtualHost HTTPS otomatis
- ✅ Update file hosts Windows otomatis
- ✅ Update .env otomatis
- ✅ Clear cache otomatis
- ✅ Flush DNS otomatis

**TIDAK PERLU SETTING MANUAL APAPUN!**

---

### Langkah 2: Restart Apache

**Setelah script selesai:**

1. **Buka XAMPP Control Panel**
2. **Klik STOP pada Apache**
3. **Tunggu 5 detik**
4. **Klik START pada Apache**
5. **Pastikan status Running** (hijau)

**Itu saja! Tidak perlu setting apapun lagi!**

---

### Langkah 3: Test Website

1. **Buka browser**
2. **Ketik:** `https://nuranitms.test`
3. **Tekan Enter**

**Peringatan keamanan akan muncul** (normal untuk self-signed certificate):
- Klik **"Advanced"** atau **"Advanced settings"**
- Klik **"Proceed to nuranitms.test (unsafe)"** atau **"Continue to nuranitms.test"**

**Website TMS NURANI akan muncul!**

---

## ✅ YANG DILAKUKAN OTOMATIS

Script `SETUP_OTOMATIS_LENGKAP.bat` akan:

1. ✅ **Membuat folder ssl** (jika belum ada)
2. ✅ **Membuat certificate SSL** otomatis tanpa input manual
3. ✅ **Mengaktifkan mod_ssl** di httpd.conf
4. ✅ **Mengaktifkan httpd-ssl.conf** di httpd.conf
5. ✅ **Mengaktifkan mod_rewrite** di httpd.conf
6. ✅ **Membuat VirtualHost HTTPS** dengan semua variasi domain
7. ✅ **Update file hosts Windows** dengan semua variasi domain
8. ✅ **Flush DNS cache** otomatis
9. ✅ **Update .env** ke `https://nuraniTMS.test`
10. ✅ **Clear cache Laravel** otomatis

**SEMUA OTOMATIS! TIDAK PERLU SETTING MANUAL!**

---

## 🎯 HASIL AKHIR

Setelah menjalankan script dan restart Apache:

✅ `https://nuranitms.test` bisa diakses  
✅ `https://nuraniTMS.test` bisa diakses  
✅ Website TMS NURANI muncul lengkap  
✅ Header hijau dengan logo  
✅ Background gambar gedung sekolah  
✅ Tombol LOGIN di kanan atas  
✅ Semua fitur bekerja normal  

---

## 🔧 TROUBLESHOOTING

### Masalah: Script error saat membuat certificate

**Solusi:**
- Pastikan OpenSSL tersedia (biasanya sudah ada di XAMPP)
- Jalankan script sebagai Administrator

### Masalah: File hosts tidak bisa diupdate

**Solusi:**
- Jalankan script sebagai Administrator
- Atau update manual: `C:\Windows\System32\drivers\etc\hosts`

### Masalah: Apache tidak bisa restart

**Solusi:**
- Pastikan XAMPP Control Panel dibuka sebagai Administrator
- Atau restart manual di XAMPP Control Panel

### Masalah: Website masih tidak muncul

**Solusi:**
1. **RESTART KOMPUTER** (sering menyelesaikan masalah)
2. Pastikan Apache **Running** di XAMPP
3. Test dengan browser lain (Chrome, Firefox, Edge)
4. Gunakan **Incognito mode** untuk test

---

## 📝 CATATAN PENTING

1. **Script harus dijalankan di root folder Laravel** (folder yang ada file `artisan`)
2. **Script akan mengubah file konfigurasi** (backup otomatis dibuat)
3. **Setelah script selesai, WAJIB restart Apache**
4. **Browser akan menampilkan peringatan keamanan** (normal untuk self-signed certificate)

---

## 🆘 MASIH ERROR?

Jika masih error setelah semua langkah:

1. **RESTART KOMPUTER** (sering menyelesaikan masalah)
2. **Cek error log:** `C:\xampp\apache\logs\error.log`
3. **Pastikan Apache running** di XAMPP Control Panel
4. **Test dengan browser lain**

---

**SELESAI! Website Anda sekarang berfungsi dengan baik! 🎉**

