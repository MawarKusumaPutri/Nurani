# 🚀 CARA MEMBUAT LINK NGROK JADI PENDEK

## ❌ **Masalah Sekarang:**

Link panjang dan ribet:
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/nurani/public/tu/siswa
```

Setelah hapus/edit siswa → Error 404 Not Found

---

## ✅ **Solusi: Setup Apache Virtual Host**

Setelah setup, link jadi pendek:
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/tu/siswa
```

Dan semua halaman (hapus, edit, dll) berfungsi normal!

---

## 📋 **Langkah-langkah Setup:**

### **Step 1: Edit File Apache**

1. **Buka file ini:**
   ```
   D:\Praktikum DWBI\xampp\apache\conf\extra\httpd-vhosts.conf
   ```
   
2. **Scroll ke paling bawah**

3. **Copy semua isi file `SETUP_APACHE_VHOST.conf`** (file yang baru saya buat)

4. **Paste di paling bawah file `httpd-vhosts.conf`**

5. **Save file** (Ctrl + S)

### **Step 2: Restart Apache**

1. Buka **XAMPP Control Panel**
2. Klik **Stop** di baris Apache
3. Tunggu sampai stop
4. Klik **Start** di baris Apache
5. Pastikan Apache running (hijau)

### **Step 3: Update Laravel .env**

Jalankan command ini:
```bash
php artisan config:clear
php artisan cache:clear
```

### **Step 4: Restart Ngrok**

1. **Stop ngrok** yang sedang running (Ctrl+C di PowerShell)
2. **Jalankan ngrok lagi:**
   ```bash
   ngrok http 80 --host-header="localhost"
   ```
3. **Copy link ngrok baru** (kemungkinan masih sama)

### **Step 5: Test!**

Akses link ini:
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/
```

Seharusnya langsung muncul halaman welcome Laravel!

Lalu login dan coba:
```
https://dorothy-fuzziest-goggly.ngrok-free.dev/tu/siswa
```

---

## 🎉 **Hasil Akhir:**

| Sebelum | Sesudah |
|---------|---------|
| `https://...ngrok.../nurani/public/tu/siswa` | `https://...ngrok.../tu/siswa` |
| Error 404 setelah hapus/edit | ✅ Berfungsi normal |
| Harus ketik path panjang | ✅ Path pendek |

---

## ⚠️ **Catatan Penting:**

Setelah setup ini, **semua project lain di htdocs tidak bisa diakses** karena Apache sekarang langsung point ke `/nurani/public/`.

Jika Anda punya project lain di htdocs yang masih perlu diakses, beri tahu saya dan saya akan buatkan konfigurasi yang berbeda.

---

## 🆘 **Jika Ada Masalah:**

1. **Apache tidak mau start:**
   - Cek syntax error di `httpd-vhosts.conf`
   - Pastikan path `D:/Praktikum DWBI/xampp/htdocs/nurani/public` benar

2. **Link masih panjang:**
   - Pastikan Apache sudah di-restart
   - Pastikan ngrok sudah di-restart
   - Clear browser cache (Ctrl + Shift + R)

3. **Error 500:**
   - Jalankan: `php artisan config:clear`
   - Jalankan: `php artisan cache:clear`

---

**Silakan ikuti langkah-langkah di atas!** Setelah selesai, link Anda akan jadi pendek dan semua fitur berfungsi normal. 🚀
