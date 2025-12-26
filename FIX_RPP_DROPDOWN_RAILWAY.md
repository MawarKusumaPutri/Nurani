# ⚠️ DROPDOWN RPP BELUM MUNCUL? INI SOLUSINYA!

## 🔍 Status Saat Ini

✅ **Kode sudah BENAR** di GitHub dengan 4 pilihan:
1. MTs Nurul Aiman
2. Google Drive
3. Kemdikbud
4. ChatGPT (Referensi)

✅ **Sudah di-PUSH** ke GitHub (commit: 853c143)

❌ **MASALAH**: Railway belum clear **VIEW CACHE**

---

## 🚀 SOLUSI CEPAT (5 MENIT)

### Step 1: Buka Railway Console
1. Buka: https://railway.app/dashboard
2. Klik project **"Nurani"**
3. Klik **service** yang aktif
4. Klik tab **"Settings"**
5. Scroll ke bawah
6. Klik **"Open Console"** atau **"Shell"**

### Step 2: Copy-Paste Command Ini

**COPY SEMUA BARIS INI** dan paste ke Railway Console:

```bash
php artisan view:clear && php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan optimize:clear && echo "✅ ALL CACHE CLEARED!"
```

Tekan **Enter** dan tunggu hingga muncul:
```
✅ ALL CACHE CLEARED!
```

### Step 3: Hard Refresh Browser

**Windows**: `Ctrl + Shift + F5`
**Mac**: `Cmd + Shift + R`

### Step 4: Test Dropdown RPP

1. Login sebagai **Guru**
2. Buka **Manajemen Materi**
3. Klik dropdown **"RPP"**
4. **Seharusnya muncul 4 pilihan** ✅

---

## 🔄 JIKA MASIH BELUM MUNCUL

### Opsi 1: Restart Service (2 menit)
1. Railway Dashboard → Service
2. Tab "Settings" → Scroll ke "Service"
3. Klik **"Restart"**
4. Tunggu restart selesai
5. **Hard refresh browser** lagi

### Opsi 2: Redeploy (5 menit)
1. Railway Dashboard → Service
2. Klik **"Redeploy"** (pojok kanan atas)
3. Tunggu deploy selesai (2-3 menit)
4. **Clear cache lagi** (Step 2)
5. **Hard refresh browser**

---

## 📋 VERIFIKASI FILE DI RAILWAY

Untuk memastikan file sudah ter-deploy dengan benar, jalankan di Railway Console:

```bash
cat resources/views/guru/materi/index.blade.php | grep -A 5 "Google Drive"
```

Seharusnya muncul:
```html
<a class="dropdown-item" href="https://drive.google.com" target="_blank">
    <i class="fab fa-google-drive me-2 text-success"></i>
    Google Drive
</a>
```

---

## ❓ KENAPA INI TERJADI?

Laravel **meng-cache** file Blade (`.blade.php`) untuk performa.

Ketika ada perubahan di file Blade:
1. ✅ File di GitHub sudah update
2. ✅ Railway sudah deploy file baru
3. ❌ **TAPI** Laravel masih pakai cache lama

**Solusi**: Clear view cache dengan `php artisan view:clear`

---

## 📝 CATATAN PENTING

- **Setiap kali** ada perubahan file `.blade.php`, **WAJIB** clear view cache
- **Hard refresh browser** juga penting untuk clear cache browser
- Jika masih tidak muncul, coba **restart service** atau **redeploy**

---

## ⏱️ ESTIMASI WAKTU

- Clear cache: **1 menit**
- Hard refresh: **10 detik**
- Restart service: **2 menit**
- Redeploy: **5 menit**

**Total maksimal**: ~10 menit

---

## ✅ CHECKLIST

- [ ] Buka Railway Console
- [ ] Run command clear cache
- [ ] Hard refresh browser (Ctrl + Shift + F5)
- [ ] Login sebagai Guru
- [ ] Buka Manajemen Materi
- [ ] Klik dropdown RPP
- [ ] Verifikasi 4 pilihan muncul

---

**Jika sudah ikuti semua langkah tapi masih belum muncul, screenshot error dan kirim ke saya!** 🙏
