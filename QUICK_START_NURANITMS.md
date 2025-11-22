# ⚡ QUICK START - Setup nuraniTMS.test dengan HTTPS

Panduan cepat untuk mengubah domain menjadi `nuraniTMS.test` dengan HTTPS yang berfungsi.

---

## 🚀 LANGKAH CEPAT (10 Menit)

### 1️⃣ Update Konfigurasi Laravel

**Double-click:** `UPDATE_SEMUA_KE_NURANITMS.bat`

Script ini akan:
- Update `.env` ke `https://nuraniTMS.test`
- Clear cache Laravel
- Memberikan instruksi untuk langkah selanjutnya

---

### 2️⃣ Buat Certificate SSL

**Double-click:** `SCRIPT_BUAT_CERTIFICATE_NURANITMS.bat`

**Saat diminta informasi:**
- Country: `ID`
- State: `Jakarta`
- City: `Jakarta`
- Organization: `MTs Nurul Aiman`
- Common Name: `nuraniTMS.test` ← **PENTING!**
- Email: `admin@nuraniTMS.test`

**Untuk "A challenge password" dan "An optional company name", tekan Enter saja.**

---

### 3️⃣ Aktifkan mod_ssl

1. **Buka:** `C:\xampp\apache\conf\httpd.conf`
2. **Cari:** `#LoadModule ssl_module modules/mod_ssl.so`
3. **Hapus tanda `#`:**
   ```apache
   LoadModule ssl_module modules/mod_ssl.so
   ```
4. **Cari:** `#Include conf/extra/httpd-ssl.conf`
5. **Hapus tanda `#`:**
   ```apache
   Include conf/extra/httpd-ssl.conf
   ```
6. **Simpan:** Ctrl + S

---

### 4️⃣ Update VirtualHost

1. **Buka:** `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. **Hapus VirtualHost lama** (jika ada)
3. **Copy-paste dari:** `KONFIGURASI_VIRTUALHOST_HTTPS_NURANITMS.txt`
4. **Simpan:** Ctrl + S

---

### 5️⃣ Update File Hosts

1. **Tekan Windows + R** → ketik `notepad` → **Ctrl + Shift + Enter** (run as admin)
2. **File → Open** → `C:\Windows\System32\drivers\etc\hosts`
3. **Hapus baris lama** (jika ada):
   ```
   127.0.0.1    nurani.test
   ```
4. **Tambahkan di akhir:**
   ```
   127.0.0.1    nuraniTMS.test
   127.0.0.1    www.nuraniTMS.test
   ```
5. **Simpan:** Ctrl + S
6. **Flush DNS:** Buka CMD sebagai admin → `ipconfig /flushdns`

---

### 6️⃣ Restart Apache

1. **XAMPP Control Panel**
2. **Stop Apache**
3. **Tunggu 3 detik**
4. **Start Apache**
5. **Pastikan Running** (hijau)

---

### 7️⃣ Test

1. **Tutup semua tab browser**
2. **Buka browser baru** (atau Incognito mode)
3. **Ketik:** `https://nuraniTMS.test`
4. **Tekan Enter**

**Peringatan keamanan akan muncul (normal):**
- Klik **"Advanced"**
- Klik **"Proceed to nuraniTMS.test (unsafe)"**

---

## ✅ Checklist

- [ ] Certificate sudah dibuat (`nuraniTMS.crt` dan `nuraniTMS.key`)
- [ ] mod_ssl aktif
- [ ] VirtualHost HTTPS sudah dibuat
- [ ] File hosts sudah diupdate
- [ ] DNS sudah di-flush
- [ ] APP_URL sudah `https://nuraniTMS.test`
- [ ] Cache sudah di-clear
- [ ] Apache sudah di-restart

---

## 🔧 Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Can't reach | Cek Apache running, file hosts, flush DNS |
| SSL error | Cek certificate sudah dibuat, path benar |
| Domain tidak dikenali | Update file hosts, flush DNS |
| HTTP tidak redirect | Cek mod_rewrite aktif, VirtualHost benar |

---

## 📖 Panduan Lengkap

Lihat: **SOLUSI_LENGKAP_NURANITMS.md**

---

**Selamat! Domain Anda sekarang `nuraniTMS.test` dengan HTTPS! 🔒**

