# Panduan Clear Cache Railway untuk Dropdown RPP

## Masalah
Dropdown RPP di Railway hanya menampilkan "MTs Nurul Aiman", padahal di kode lokal sudah ada 4 pilihan:
1. MTs Nurul Aiman
2. Google Drive
3. Kemdikbud
4. ChatGPT (Referensi)

## Penyebab
- Perubahan sudah di-push ke GitHub
- Railway sudah auto-deploy
- **TAPI** view cache di Railway belum di-clear

## Solusi: Clear View Cache di Railway

### Langkah 1: Buka Railway Console
1. Buka https://railway.app/dashboard
2. Pilih project "Nurani"
3. Klik service yang aktif
4. Klik tab "Settings"
5. Scroll ke bawah ke bagian "Service"
6. Klik **"Open Console"** atau **"Shell"**

### Langkah 2: Clear View Cache
Jalankan command berikut di Railway Console:

```bash
php artisan view:clear
```

Tunggu hingga muncul pesan:
```
Compiled views cleared successfully.
```

### Langkah 3: Clear All Cache (Opsional tapi Direkomendasikan)
Untuk memastikan semua cache ter-clear, jalankan juga:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

### Langkah 4: Verify
Setelah clear cache selesai, buka browser dan:
1. **Hard refresh**: Ctrl + Shift + F5 (Windows) atau Cmd + Shift + R (Mac)
2. Login sebagai Guru
3. Buka halaman "Manajemen Materi"
4. Klik dropdown "RPP"
5. **Seharusnya muncul 4 pilihan** ✅

## Jika Masih Belum Muncul

### Opsi 1: Restart Service
1. Buka Railway Dashboard
2. Klik service
3. Klik tab "Settings"
4. Scroll ke "Service"
5. Klik **"Restart"**
6. Tunggu service restart selesai
7. Hard refresh browser

### Opsi 2: Redeploy
1. Buka Railway Dashboard
2. Klik service
3. Klik tombol **"Redeploy"** di pojok kanan atas
4. Tunggu deploy selesai
5. Clear cache lagi (Langkah 2)
6. Hard refresh browser

## Catatan Penting

- **View cache** adalah penyebab paling umum perubahan Blade tidak muncul di Railway
- Setiap kali ada perubahan di file `.blade.php`, **WAJIB** clear view cache
- Hard refresh browser juga penting untuk clear cache browser
- Jika masih tidak muncul setelah clear cache, coba restart service

## Verifikasi File Sudah Ter-Deploy

Untuk memastikan file sudah ter-deploy dengan benar, jalankan di Railway Console:

```bash
grep -A 20 "dropdown-menu" resources/views/guru/materi/index.blade.php | head -30
```

Seharusnya muncul 4 item dropdown:
- MTs Nurul Aiman
- Google Drive
- Kemdikbud
- ChatGPT (Referensi)

## Estimasi Waktu
- Clear cache: 1-2 menit
- Restart service: 2-3 menit
- Redeploy: 3-5 menit

---

**Total waktu maksimal**: ~10 menit untuk memastikan dropdown muncul dengan benar
