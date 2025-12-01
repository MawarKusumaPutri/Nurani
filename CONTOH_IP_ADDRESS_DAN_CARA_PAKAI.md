# 📱 Contoh IP Address dan Cara Pakai

## 🎯 Apa Itu IP Address?

IP Address adalah **alamat unik** komputer Anda di dalam jaringan WiFi/LAN. Seperti nomor rumah, setiap komputer punya IP address yang berbeda.

---

## 📋 CONTOH IP ADDRESS

### Format IP Address:
IP Address biasanya berbentuk seperti ini:

```
192.168.1.100
192.168.0.50
10.0.0.25
172.16.0.10
```

**Struktur:**
- Terdiri dari **4 angka** yang dipisahkan titik
- Setiap angka bisa **0-255**
- Contoh paling umum: `192.168.x.x` atau `192.168.0.x`

### Contoh IP Address yang Mungkin Anda Dapatkan:

```
✅ 192.168.1.100
✅ 192.168.1.101
✅ 192.168.0.50
✅ 192.168.0.25
✅ 10.0.0.5
```

---

## 🔍 CARA MENCARI IP ADDRESS ANDA

### Langkah 1: Buka Command Prompt

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan **Enter**

### Langkah 2: Ketik Perintah

Di Command Prompt, ketik:
```
ipconfig
```

Tekan **Enter**

### Langkah 3: Cari IPv4 Address

Cari baris yang bertuliskan **"IPv4 Address"** atau **"IPv4 Address . . . . . . . . . . . :"**

**Contoh Output:**
```
Wireless LAN adapter Wi-Fi:

   Connection-specific DNS Suffix  . :
   IPv4 Address. . . . . . . . . . . : 192.168.1.100    ← INI IP ADDRESS ANDA
   Subnet Mask . . . . . . . . . . . : 255.255.255.0
   Default Gateway . . . . . . . . . : 192.168.1.1
```

**IP Address Anda adalah:** `192.168.1.100`

---

## 🌐 CARA MENGGUNAKAN IP ADDRESS UNTUK AKSES

### Penjelasan Format URL:

Ketika saya bilang:
```
http://[IP_ADDRESS]/nurani/public
```

**Maksudnya:**
- `[IP_ADDRESS]` = **GANTI** dengan IP address yang Anda dapatkan
- Jangan ketik `[IP_ADDRESS]` secara literal!

### Contoh Konkret:

#### ❌ SALAH:
```
http://[IP_ADDRESS]/nurani/public
```
(Ini salah, jangan ketik seperti ini!)

#### ✅ BENAR:

**Jika IP address Anda adalah `192.168.1.100`, maka ketik:**
```
http://192.168.1.100/nurani/public
```

**Jika IP address Anda adalah `192.168.0.50`, maka ketik:**
```
http://192.168.0.50/nurani/public
```

**Jika IP address Anda adalah `10.0.0.5`, maka ketik:**
```
http://10.0.0.5/nurani/public
```

---

## 📱 CONTOH LENGKAP: Dari Smartphone

### Skenario:
- IP address laptop server Anda: `192.168.1.100`
- Smartphone terhubung ke WiFi yang sama

### Langkah-langkah:

1. **Buka browser di smartphone** (Chrome, Safari, dll)

2. **Ketik di address bar:**
   ```
   http://192.168.1.100/nurani/public
   ```
   (Ganti `192.168.1.100` dengan IP address Anda sendiri!)

3. **Tekan Enter atau Go**

4. **Website akan muncul!** 🎉

---

## 💻 CONTOH LENGKAP: Dari Laptop Lain

### Skenario:
- IP address laptop server Anda: `192.168.0.50`
- Laptop lain terhubung ke WiFi yang sama

### Langkah-langkah:

1. **Buka browser di laptop lain** (Chrome, Firefox, Edge)

2. **Ketik di address bar:**
   ```
   http://192.168.0.50/nurani/public
   ```
   (Ganti `192.168.0.50` dengan IP address Anda sendiri!)

3. **Tekan Enter**

4. **Website akan muncul!** 🎉

---

## 🎯 RINGKASAN SIMPEL

### 1. Cari IP Address:
```
ipconfig → cari "IPv4 Address" → contoh: 192.168.1.100
```

### 2. Gunakan di Browser:
```
http://192.168.1.100/nurani/public
```
(Ganti `192.168.1.100` dengan IP address Anda!)

### 3. Akses dari Device Lain:
- Pastikan WiFi sama
- Ketik URL di browser
- Selesai!

---

## ⚠️ CATATAN PENTING

### 1. IP Address Bisa Berbeda
- Setiap komputer punya IP address berbeda
- IP address Anda mungkin: `192.168.1.100`
- Teman Anda mungkin: `192.168.1.101`
- **Gunakan IP address komputer SERVER (yang jalanin XAMPP)**

### 2. Jangan Lupa `/nurani/public`
- URL lengkap: `http://192.168.1.100/nurani/public`
- Bukan: `http://192.168.1.100` (akan error 404)

### 3. Pastikan WiFi Sama
- Laptop server dan smartphone harus **WiFi yang sama**
- Kalau beda WiFi, tidak akan bisa akses

---

## 🔧 TROUBLESHOOTING

### ❌ Tidak Bisa Akses?

1. **Cek IP address lagi:**
   ```
   ipconfig
   ```
   (Mungkin IP address berubah)

2. **Cek WiFi:**
   - Pastikan semua device dalam WiFi yang sama

3. **Cek Apache:**
   - Pastikan Apache **Running** di XAMPP

4. **Cek Firewall:**
   - Pastikan firewall mengizinkan port 80

---

## 📝 CONTOH REAL-WORLD

### Contoh 1:
- **IP Address:** `192.168.1.100`
- **URL di smartphone:** `http://192.168.1.100/nurani/public`

### Contoh 2:
- **IP Address:** `192.168.0.25`
- **URL di laptop lain:** `http://192.168.0.25/nurani/public`

### Contoh 3:
- **IP Address:** `10.0.0.5`
- **URL di tablet:** `http://10.0.0.5/nurani/public`

---

**Intinya: Ganti `[IP_ADDRESS]` dengan angka IP address yang Anda dapatkan dari `ipconfig`!** 🎯

