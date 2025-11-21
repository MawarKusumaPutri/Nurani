# ⚡ Panduan Cepat Setup Sinkronisasi Gmail

## 🎯 Untuk Email: mawarkusuma694@gmail.com

### Langkah 1: Buat Gmail App Password (5 menit)

1. Buka: https://myaccount.google.com/
2. Login dengan: `mawarkusuma694@gmail.com`
3. Security → **2-Step Verification** (aktifkan dulu jika belum)
4. Scroll ke bawah → **App passwords**
5. Pilih:
   - **App:** Mail
   - **Device:** Other (Custom name)
   - **Name:** "MTs Nurul Aiman System"
6. Klik **Generate**
7. **Copy password 16 karakter** (contoh: `abcd efgh ijkl mnop`)

### Langkah 2: Setup Otomatis (1 menit)

Jalankan di terminal:

```bash
php artisan gmail:setup mawarkusuma694@gmail.com "abcd efgh ijkl mnop"
```

**Ganti `abcd efgh ijkl mnop` dengan App Password yang sudah dibuat!**

### Langkah 3: Test (30 detik)

```bash
php artisan email:test mawarkusuma694@gmail.com
```

### Langkah 4: Login dan Cek Gmail

1. **Login ke sistem:**
   - Email: `mawarkusuma694@gmail.com`
   - Password: `Mawar2024!`
   - Role: `guru`

2. **Buka Gmail:** https://mail.google.com
3. **Cek Inbox** - Email notifikasi akan muncul!

## 🛡️ Jika Email Masih Masuk ke Spam

### Solusi Cepat (30 detik):

1. Buka Gmail → Folder **Spam**
2. Klik email notifikasi → Klik **"Bukan spam"**
3. Selesai!

### Solusi Permanen (2 menit):

1. Gmail → **Settings** (⚙️) → **"Lihat semua pengaturan"**
2. **"Filter dan Alamat yang Diblokir"** → **"Buat filter baru"**
3. **From:** `mawarkusuma694@gmail.com`
4. **"Buat filter"** → Centang:
   - ✅ "Jangan pernah mengirim ke Spam"
   - ✅ "Selalu tandai sebagai penting"
5. **"Buat filter"**

**Hasil:** Email akan selalu masuk ke Inbox!

## ✅ Checklist

- [ ] Gmail App Password sudah dibuat
- [ ] Command `gmail:setup` sudah dijalankan
- [ ] Test email berhasil
- [ ] Login ke sistem berhasil
- [ ] Email masuk ke Gmail Inbox (atau sudah ditandai "Bukan spam")
- [ ] Filter Gmail sudah dibuat (opsional)

## 🆘 Masalah?

**Email tidak terkirim?**
- Cek: `php artisan email:test mawarkusuma694@gmail.com`
- Cek log: `storage/logs/laravel.log`

**Email masuk ke Spam?**
- Tandai "Bukan spam" → Buat filter Gmail (lihat di atas)

**Butuh bantuan lebih?**
- Lihat: `SETUP_SINKRONISASI_GMAIL.md`
- Lihat: `CARA_HINDARI_SPAM.md`

---

**Waktu Setup:** ~10 menit  
**Status:** ✅ Siap Digunakan

