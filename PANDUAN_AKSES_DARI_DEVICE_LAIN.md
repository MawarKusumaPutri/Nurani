# 📱 Panduan Mengakses Aplikasi dari Device Lain

## 🎯 Tujuan
Agar aplikasi Laravel yang berjalan di `http://localhost/nurani/public/` bisa diakses dari:
- ✅ Laptop lain dalam jaringan yang sama
- ✅ Smartphone dalam jaringan yang sama
- ✅ Tablet dalam jaringan yang sama

---

## 📋 Prasyarat

1. ✅ **Semua device harus dalam jaringan WiFi/LAN yang sama**
   - Laptop server dan device lain harus terhubung ke WiFi yang sama
   - Atau menggunakan kabel LAN yang sama

2. ✅ **XAMPP Apache harus berjalan**
   - Pastikan Apache **Running** di XAMPP Control Panel

3. ✅ **Firewall Windows harus mengizinkan koneksi**
   - Akan dijelaskan di langkah berikutnya

---

## 🔍 LANGKAH 1: Cari IP Address Komputer Anda

### Windows:

1. Tekan **Windows + R**
2. Ketik: `cmd` lalu tekan **Enter**
3. Di Command Prompt, ketik:
   ```cmd
   ipconfig
   ```
4. Cari baris **IPv4 Address** di bagian **Wireless LAN adapter Wi-Fi** atau **Ethernet adapter**
   - Contoh: `192.168.1.100` atau `192.168.0.50`
   - **Ini adalah IP address yang akan digunakan**

**Contoh Output:**
```
Wireless LAN adapter Wi-Fi:
   IPv4 Address. . . . . . . . . . . : 192.168.1.100
   Subnet Mask . . . . . . . . . . . : 255.255.255.0
   Default Gateway . . . . . . . . . : 192.168.1.1
```

**📝 Catat IP Address Anda:** `_________________` (contoh: 192.168.1.100)

---

## 🔥 LANGKAH 2: Konfigurasi Firewall Windows

### Opsi A: Mengizinkan Port 80 (HTTP) - Disarankan

1. Tekan **Windows + R**
2. Ketik: `wf.msc` lalu tekan **Enter** (Windows Firewall dengan Advanced Security)
3. Klik **Inbound Rules** di panel kiri
4. Klik **New Rule...** di panel kanan
5. Pilih **Port** → **Next**
6. Pilih **TCP** dan **Specific local ports**: ketik `80` → **Next**
7. Pilih **Allow the connection** → **Next**
8. Centang semua (Domain, Private, Public) → **Next**
9. Beri nama: `XAMPP Apache HTTP` → **Finish**

### Opsi B: Mengizinkan XAMPP Secara Langsung (Lebih Mudah)

1. Buka **Windows Defender Firewall** (cari di Start Menu)
2. Klik **Allow an app or feature through Windows Firewall**
3. Klik **Change settings** (butuh admin)
4. Cari **Apache HTTP Server** atau **XAMPP**
5. Centang **Private** dan **Public** untuk Apache
6. Klik **OK**

---

## 🌐 LANGKAH 3: Update Konfigurasi Laravel (Opsional tapi Disarankan)

### 3.1 Buka File .env

Buka file `.env` di folder project:
```
D:\Praktikum DWBI\xampp\htdocs\nurani\.env
```

### 3.2 Update APP_URL

**Cari baris:**
```env
APP_URL=http://localhost
```

**Ubah menjadi (gunakan IP address Anda):**
```env
APP_URL=http://192.168.1.100
```

**Contoh jika IP Anda adalah 192.168.1.100:**
```env
APP_URL=http://192.168.1.100
```

**⚠️ CATATAN:** 
- Ganti `192.168.1.100` dengan IP address yang Anda dapatkan di Langkah 1
- Jangan tambahkan `/nurani/public` di sini, cukup IP address saja

### 3.3 Clear Cache Laravel

Buka Command Prompt di folder project dan jalankan:

```cmd
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan config:clear
php artisan cache:clear
```

---

## 📱 LANGKAH 4: Akses dari Device Lain

### Dari Laptop Lain:

1. Buka browser (Chrome, Firefox, Edge, dll)
2. Ketik di address bar:
   ```
   http://192.168.1.100/nurani/public
   ```
   (Ganti `192.168.1.100` dengan IP address komputer server Anda)

3. Tekan **Enter**

### Dari Smartphone/Tablet:

1. Pastikan smartphone terhubung ke **WiFi yang sama** dengan laptop server
2. Buka browser (Chrome, Safari, dll)
3. Ketik di address bar:
   ```
   http://192.168.1.100/nurani/public
   ```
   (Ganti `192.168.1.100` dengan IP address komputer server Anda)

4. Tekan **Enter**

---

## ✅ LANGKAH 5: Verifikasi

### Checklist:

- [ ] IP address sudah ditemukan
- [ ] Firewall sudah dikonfigurasi
- [ ] APP_URL di .env sudah diupdate (opsional)
- [ ] Cache Laravel sudah dibersihkan
- [ ] Apache XAMPP berjalan
- [ ] Device lain terhubung ke WiFi yang sama
- [ ] Bisa akses dari device lain

---

## 🔧 TROUBLESHOOTING

### ❌ Error: "This site can't be reached" atau "ERR_CONNECTION_REFUSED"

**Penyebab:** 
- IP address salah
- Firewall memblokir koneksi
- Apache tidak berjalan
- Device tidak dalam jaringan yang sama

**Solusi:**
1. Pastikan IP address benar (cek lagi dengan `ipconfig`)
2. Pastikan Apache **Running** di XAMPP
3. Pastikan firewall sudah dikonfigurasi (Langkah 2)
4. Pastikan semua device dalam WiFi yang sama
5. Coba akses dari komputer server sendiri dulu: `http://192.168.1.100/nurani/public`

---

### ❌ Error: "403 Forbidden" atau "Access Denied"

**Penyebab:** 
- Permission folder atau konfigurasi Apache

**Solusi:**
1. Pastikan folder `nurani` bisa diakses
2. Cek file `.htaccess` di folder `public`
3. Restart Apache di XAMPP

---

### ❌ Error: "Connection timeout"

**Penyebab:**
- Firewall memblokir koneksi
- IP address berubah (dynamic IP)

**Solusi:**
1. Pastikan firewall sudah dikonfigurasi (Langkah 2)
2. Cek IP address lagi dengan `ipconfig` (mungkin berubah)
3. Update APP_URL di .env jika IP berubah

---

### ❌ IP Address Berubah Setiap Hari

**Penyebab:**
- Router menggunakan DHCP (dynamic IP)

**Solusi:**
1. **Set Static IP di Windows** (disarankan):
   - Buka **Network Settings**
   - Pilih WiFi/LAN adapter
   - Klik **Properties** → **Internet Protocol Version 4 (TCP/IPv4)**
   - Pilih **Use the following IP address**
   - Masukkan IP address yang sama setiap kali

2. **Atau set Static IP di Router** (lebih permanen):
   - Login ke router (biasanya `192.168.1.1` atau `192.168.0.1`)
   - Cari menu **DHCP Reservation** atau **Static IP**
   - Set IP address untuk MAC address komputer Anda

---

## 📝 CATATAN PENTING

### 1. IP Address Bisa Berubah
Jika router menggunakan DHCP, IP address bisa berubah setiap kali komputer restart atau reconnect WiFi. Solusinya:
- Set static IP (lihat troubleshooting di atas)
- Atau cek IP address setiap kali dengan `ipconfig`

### 2. Keamanan
- ⚠️ **Jangan expose ke internet** tanpa proteksi
- ⚠️ Hanya untuk **development/testing** dalam jaringan lokal
- ⚠️ Untuk production, gunakan server yang proper dengan HTTPS

### 3. Port Alternatif
Jika port 80 sudah digunakan, bisa menggunakan port lain:
- Edit file `httpd.conf` di XAMPP
- Ubah `Listen 80` menjadi `Listen 8080`
- Akses dengan: `http://192.168.1.100:8080/nurani/public`

---

## 🚀 QUICK START (Ringkasan)

1. **Cari IP address:** `ipconfig` → catat IPv4 Address
2. **Konfigurasi firewall:** Izinkan port 80 atau Apache
3. **Update .env:** `APP_URL=http://IP_ADDRESS_ANDA`
4. **Clear cache:** `php artisan config:clear`
5. **Akses dari device lain:** `http://IP_ADDRESS_ANDA/nurani/public`

---

## 💡 TIPS

- ✅ Gunakan **bookmark** di browser untuk memudahkan akses
- ✅ Simpan IP address di notes/phone
- ✅ Set static IP untuk menghindari perubahan IP
- ✅ Gunakan aplikasi **Fing** atau **Network Scanner** di smartphone untuk scan IP address di jaringan

---

**Selamat! Aplikasi Anda sekarang bisa diakses dari device lain! 🎉**

