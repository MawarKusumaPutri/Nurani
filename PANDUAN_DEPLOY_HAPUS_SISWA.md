# Panduan Deploy Fitur Hapus Siswa ke Railway

## ✅ Status Perubahan
Perubahan sudah di-commit dan di-push ke GitHub:
- ✅ Controller: Menambahkan method `siswaDestroy()`
- ✅ Routes: Menambahkan route DELETE untuk siswa
- ✅ View: Menambahkan form delete dengan konfirmasi
- ✅ Alert: Menambahkan notifikasi sukses/error

## 🚀 Langkah Deploy ke Railway

### Opsi 1: Tunggu Auto-Deploy (Recommended)
Railway akan otomatis deploy perubahan dari GitHub dalam 2-5 menit.

1. **Cek status deploy di Railway Dashboard**
   - Buka: https://railway.app/dashboard
   - Pilih project "Nurani"
   - Lihat tab "Deployments"
   - Tunggu hingga status menjadi "Success" ✅

2. **Clear Cache setelah deploy selesai**
   
   Buka Railway Console (klik project → klik service → tab "Settings" → scroll ke "Service" → klik "Open Console")
   
   Jalankan command berikut satu per satu:
   ```bash
   php artisan route:clear
   php artisan route:cache
   php artisan config:clear
   php artisan view:clear
   php artisan optimize:clear
   ```

3. **Verifikasi route sudah terdaftar**
   ```bash
   php artisan route:list --name=siswa
   ```
   
   Pastikan ada route: `tu.siswa.destroy`

### Opsi 2: Manual Redeploy
Jika auto-deploy tidak berjalan:

1. Buka Railway Dashboard
2. Pilih project "Nurani"
3. Klik service yang aktif
4. Klik tombol "Redeploy" di pojok kanan atas
5. Tunggu hingga deploy selesai
6. Lakukan clear cache seperti Opsi 1 step 2

## 🧪 Testing Fitur Hapus

Setelah deploy dan clear cache selesai:

1. **Refresh browser** (Ctrl + F5 untuk hard refresh)
2. **Login ke TU Dashboard**
3. **Buka halaman Data Siswa**
4. **Klik tombol Hapus (🗑️)** pada salah satu siswa
5. **Konfirmasi dialog** akan muncul dengan nama siswa
6. **Klik OK** untuk menghapus
7. **Pesan sukses** akan muncul: "Data siswa [Nama] berhasil dihapus"

## ⚠️ Troubleshooting

### Jika tombol hapus masih tidak berfungsi:

1. **Hard refresh browser**: Ctrl + Shift + R (Chrome) atau Ctrl + F5
2. **Clear browser cache**: 
   - Chrome: Settings → Privacy → Clear browsing data
   - Pilih "Cached images and files"
3. **Cek Railway logs**:
   - Buka Railway Dashboard
   - Klik project → service → tab "Logs"
   - Cari error message
4. **Verifikasi route di Railway console**:
   ```bash
   php artisan route:list | grep siswa.destroy
   ```
   Harus muncul: `DELETE tu/siswa/{id} ... tu.siswa.destroy`

### Jika muncul error 404 atau 405:

Jalankan di Railway console:
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

Kemudian restart service:
- Railway Dashboard → Service → Settings → Restart

## 📝 Catatan Penting

- ✅ Perubahan sudah di-push ke GitHub
- ✅ Railway akan auto-deploy dalam beberapa menit
- ⚠️ **WAJIB** clear cache setelah deploy
- ⚠️ **WAJIB** hard refresh browser
- 🔒 Fitur hapus dilengkapi dengan:
  - Konfirmasi dialog sebelum hapus
  - Hapus cascade (presensi siswa ikut terhapus)
  - Error handling
  - Notifikasi sukses/error

## 🎯 Hasil Akhir

Setelah semua langkah selesai, tombol hapus akan:
1. ✅ Bisa diklik
2. ✅ Menampilkan konfirmasi dengan nama siswa
3. ✅ Menghapus data siswa dari database
4. ✅ Menampilkan pesan sukses
5. ✅ Refresh halaman otomatis

---

**Waktu estimasi**: 5-10 menit (termasuk deploy dan clear cache)
