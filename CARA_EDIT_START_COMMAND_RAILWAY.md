# 🚀 Cara Edit Start Command di Railway (Untuk Jalankan Migrations)

## 📍 Lokasi: Tab "Settings" → Section "Deploy"

### Langkah-Langkah:

1. **Pastikan Anda di Service "web":**
   - Di sidebar kiri, klik service **"web"** (yang hijau)
   - Pastikan tab **"Settings"** sudah terpilih

2. **Scroll ke Section "Deploy":**
   - Di dalam tab "Settings", scroll ke bawah
   - Cari section **"Deploy"** atau **"Deploy Configuration"**

3. **Edit "Start Command":**
   - Cari field **"Start Command"**
   - Edit menjadi:
   ```bash
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```

4. **Save:**
   - Klik tombol **"Save"** atau **"Update"**
   - Railway akan otomatis restart service

5. **Tunggu Deploy:**
   - Railway akan rebuild dan restart
   - Migrations akan jalan otomatis saat start
   - Cek tab **"Deployments"** untuk lihat progress

---

## ⚠️ PENTING: Setelah Migrations Selesai

**Setelah migrations berhasil jalan, kembalikan Start Command ke:**

```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

**Kenapa?**
- Migrations hanya perlu jalan sekali (atau saat ada perubahan)
- Tidak perlu jalan setiap kali service restart
- Akan lebih cepat startup time

---

## ✅ Alternatif: Edit via railway.json (Sudah Saya Edit!)

Saya sudah edit file `railway.json` untuk Anda!

**Langkah selanjutnya:**

1. **Commit perubahan:**
   ```bash
   git add railway.json
   git commit -m "Add migrations to start command"
   git push
   ```

2. **Railway akan auto-deploy:**
   - Railway akan detect perubahan
   - Auto rebuild dan restart
   - Migrations akan jalan saat start

3. **Setelah migrations selesai, edit lagi:**
   - Edit `railway.json` kembali
   - Hapus `php artisan migrate --force &&` dari start command
   - Commit dan push lagi

---

## 🎯 Rekomendasi

**Gunakan cara edit `railway.json` (sudah saya edit):**
- ✅ Lebih mudah (tinggal commit & push)
- ✅ Perubahan tersimpan di Git
- ✅ Railway auto-deploy

**Atau edit langsung di Railway Settings:**
- ✅ Lebih cepat (tidak perlu commit)
- ❌ Perubahan tidak tersimpan di Git

---

**Pilih salah satu cara di atas! 🚀**

