# 🌐 Cara Test Website di Railway

## 🎯 LANGKAH-LANGKAH TEST WEBSITE

### Langkah 1: Buka URL Website di Browser

**URL Website Anda:**
```
web-production-50f9.up.railway.app
```

**Cara:**
1. **Buka browser** (Chrome, Firefox, Edge, dll)
2. **Copy URL di atas** atau ketik langsung di address bar
3. **Tekan Enter**

**Atau dari Railway Dashboard:**
1. Railway Dashboard → service "web"
2. **Copy URL** yang muncul di card (contoh: `web-production-50f9.up.railway.app`)
3. **Paste di browser** dan tekan Enter

---

### Langkah 2: Cek Homepage

**Yang harus muncul:**
- ✅ Header dengan logo "TMS NURANI" dan "MTs Nurul Aiman"
- ✅ Navigation: "BERANDA", "TENTANG", "LOGIN"
- ✅ Hero section dengan background image
- ✅ Teks: "Madrasah Tsanawiyah Unggulan"
- ✅ Teks: "MENCIPTAKAN MASA DEPAN"
- ✅ Teks: "BERKONTRIBUSI UNTUK DUNIA"
- ✅ Tombol-tombol fitur (MTs Nurul Aiman, PENDIDIKAN BERKUALITAS, UNGGUL)

**Jika muncul seperti di localhost** = Homepage berhasil! ✅

---

### Langkah 3: Test Login

1. **Klik tombol "LOGIN"** di header (pojok kanan atas)
2. **Akan muncul halaman login**
3. **Masukkan:**
   - **Email:** (email yang sudah terdaftar)
   - **Password:** (password yang benar)
   - **Role:** Pilih salah satu (guru, kepala_sekolah, atau tu)
4. **Klik tombol "Login"**

**Jika login berhasil:**
- ✅ Akan redirect ke dashboard sesuai role
- ✅ Tidak ada error "Column 'role' not found"
- ✅ Bisa akses fitur-fitur aplikasi

**Jika login gagal:**
- ❌ Cek error message yang muncul
- ❌ Cek HTTP Logs di Railway Dashboard

---

### Langkah 4: Test Fitur-Fitur Lain

**Setelah login berhasil, test fitur-fitur:**
- ✅ Dashboard sesuai role
- ✅ Menu-menu yang tersedia
- ✅ Fitur-fitur yang ada di aplikasi

---

## 📋 CHECKLIST TEST

### ✅ Test Homepage:
- [ ] Buka URL di browser
- [ ] Homepage muncul dengan benar
- [ ] Header dan navigation terlihat
- [ ] Hero section dengan background image
- [ ] Tombol-tombol fitur terlihat

### ✅ Test Login:
- [ ] Klik tombol "LOGIN"
- [ ] Halaman login muncul
- [ ] Masukkan email, password, dan role
- [ ] Klik "Login"
- [ ] Login berhasil (redirect ke dashboard)
- [ ] Tidak ada error

### ✅ Test Fitur:
- [ ] Dashboard bisa diakses
- [ ] Menu-menu berfungsi
- [ ] Fitur-fitur aplikasi bekerja

---

## 🆘 JIKA ADA MASALAH

### Masalah: Homepage tidak muncul / Error 502
**Solusi:**
1. Cek service "web" status "Online" (hijau) di Railway Dashboard
2. Tunggu beberapa saat (service mungkin masih starting)
3. Refresh browser (F5)
4. Cek HTTP Logs di Railway Dashboard untuk error detail

### Masalah: Login error "Column 'role' not found"
**Solusi:**
1. Cek Deploy Logs - pastikan migrations sudah jalan
2. Pastikan migration `2025_10_17_150326_add_role_to_users_table` sudah jalan
3. Jika belum, tunggu deploy selesai atau jalankan migrations manual

### Masalah: Website lambat / loading lama
**Solusi:**
- Normal untuk pertama kali (cold start)
- Tunggu beberapa saat
- Refresh browser

---

## 💡 TIPS

1. **Gunakan browser yang sama** seperti saat test di localhost
2. **Clear cache browser** jika ada masalah (Ctrl+Shift+Delete)
3. **Gunakan incognito/private mode** untuk test yang lebih bersih
4. **Cek console browser** (F12) untuk error JavaScript jika ada

---

## 🎯 URL UNTUK TEST

**URL Website:**
```
https://web-production-50f9.up.railway.app
```

**Atau tanpa https:**
```
http://web-production-50f9.up.railway.app
```

---

**Buka URL di browser dan test website! 🚀**

