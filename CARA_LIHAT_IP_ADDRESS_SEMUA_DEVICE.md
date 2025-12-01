# 📱 Cara Melihat IP Address di Semua Device

## 🎯 Tujuan
Panduan ini menjelaskan cara melihat IP address di berbagai device (Windows, Android, iOS, Mac, dll).

---

## 💻 WINDOWS (Laptop/PC)

### Cara 1: Command Prompt (Paling Mudah)

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan **Enter**
4. Di Command Prompt, ketik:
   ```
   ipconfig
   ```
5. Tekan **Enter**
6. Cari baris **"IPv4 Address"** di bagian **"Wireless LAN adapter Wi-Fi"** atau **"Ethernet adapter"**

**Contoh Output:**
```
Wireless LAN adapter Wi-Fi:
   IPv4 Address. . . . . . . . . . . : 192.168.1.13    ← INI IP ADDRESS ANDA
   Subnet Mask . . . . . . . . . . . : 255.255.255.0
   Default Gateway . . . . . . . . . : 192.168.1.1
```

### Cara 2: Settings (GUI)

1. Tekan **Windows + I** (buka Settings)
2. Klik **Network & Internet**
3. Klik **Wi-Fi** (jika pakai WiFi) atau **Ethernet** (jika pakai kabel)
4. Klik nama WiFi/koneksi Anda
5. Scroll ke bawah, cari **"IPv4 address"**

### Cara 3: Network Settings (Alternatif)

1. Klik kanan ikon **WiFi** di taskbar (pojok kanan bawah)
2. Pilih **"Open Network & Internet settings"**
3. Klik **"Properties"** di WiFi Anda
4. Scroll ke bawah, cari **"IPv4 address"**

---

## 📱 ANDROID (Smartphone/Tablet)

### Cara 1: Settings (Paling Mudah)

1. Buka **Settings** (Pengaturan)
2. Pilih **Wi-Fi** atau **Network & Internet**
3. Klik nama WiFi yang sedang terhubung
4. Scroll ke bawah, cari **"IP address"** atau **"Alamat IP"**

**Lokasi bisa berbeda tergantung versi Android:**
- Android 10+: Settings → Network & Internet → Wi-Fi → (nama WiFi) → Advanced → IP address
- Android 9: Settings → Wi-Fi → (nama WiFi) → IP address
- Samsung: Settings → Connections → Wi-Fi → (nama WiFi) → Advanced → IP address

### Cara 2: Aplikasi Network Info

1. Download aplikasi **"Network Info II"** atau **"Fing"** dari Play Store
2. Buka aplikasi
3. IP address akan langsung terlihat

### Cara 3: Developer Options (Advanced)

1. Buka **Settings**
2. Pilih **About phone**
3. Ketuk **Build number** 7 kali (untuk enable Developer Options)
4. Kembali ke Settings → **Developer options**
5. Scroll ke **"Network"** → IP address akan terlihat

---

## 🍎 iOS (iPhone/iPad)

### Cara 1: Settings (Paling Mudah)

1. Buka **Settings** (Pengaturan)
2. Pilih **Wi-Fi**
3. Klik ikon **"i"** (info) di sebelah nama WiFi yang terhubung
4. Scroll ke bawah, cari **"IP Address"**

**Contoh:**
```
Wi-Fi: Nama_WiFi
IP Address: 192.168.1.15    ← INI IP ADDRESS ANDA
Subnet Mask: 255.255.255.0
Router: 192.168.1.1
```

### Cara 2: Aplikasi Network Analyzer

1. Download aplikasi **"Network Analyzer"** dari App Store
2. Buka aplikasi
3. IP address akan langsung terlihat di halaman utama

---

## 🖥️ MAC (MacBook/iMac)

### Cara 1: System Preferences

1. Klik ikon **Apple** (pojok kiri atas)
2. Pilih **System Preferences** atau **System Settings**
3. Klik **Network**
4. Pilih **Wi-Fi** atau **Ethernet** (tergantung koneksi)
5. Klik **Advanced...**
6. Pilih tab **TCP/IP**
7. Lihat **IPv4 Address**

### Cara 2: Terminal

1. Buka **Terminal** (Applications → Utilities → Terminal)
2. Ketik:
   ```
   ifconfig | grep "inet "
   ```
3. Tekan **Enter**
4. Cari IP address yang dimulai dengan `192.168.` atau `10.0.`

**Contoh Output:**
```
inet 192.168.1.20 netmask 0xffffff00 broadcast 192.168.1.255
```

---

## 🔍 CARA MELIHAT IP ADDRESS KOMPUTER SERVER DARI DEVICE LAIN

### Opsi 1: Lihat dari Komputer Server Itu Sendiri

**Ini yang paling penting!** IP address yang digunakan untuk akses adalah IP address **komputer server** (yang jalanin XAMPP), bukan IP address device lain.

1. Di komputer server, buka Command Prompt
2. Ketik: `ipconfig`
3. Catat IPv4 Address
4. Gunakan IP address ini di device lain

### Opsi 2: Scan Network (Dari Device Lain)

#### Android:
1. Download aplikasi **"Fing"** atau **"Network Scanner"** dari Play Store
2. Buka aplikasi
3. Klik **"Scan"** atau **"Refresh"**
4. Aplikasi akan menampilkan semua device di jaringan
5. Cari device yang menjalankan server (biasanya ada info "Apache" atau "HTTP")

#### iOS:
1. Download aplikasi **"Fing"** atau **"Network Analyzer"** dari App Store
2. Buka aplikasi
3. Scan network
4. Cari device server

#### Windows:
1. Download aplikasi **"Advanced IP Scanner"** atau **"Angry IP Scanner"**
2. Install dan buka
3. Klik **Scan**
4. Cari device server

---

## 🎯 YANG MANA IP ADDRESS YANG DIGUNAKAN?

### ⚠️ PENTING: IP Address Komputer SERVER

**IP address yang digunakan untuk akses adalah IP address komputer SERVER** (yang menjalankan XAMPP), bukan IP address device lain!

**Contoh:**
- Komputer Server (laptop Anda): `192.168.1.13` ← **INI YANG DIGUNAKAN**
- Smartphone: `192.168.1.15` ← Tidak digunakan
- Laptop Lain: `192.168.1.20` ← Tidak digunakan

**URL yang digunakan:**
```
http://192.168.1.13/nurani/public
```
(Gunakan IP address komputer SERVER, yaitu `192.168.1.13`)

---

## 📋 RINGKASAN CEPAT

### Untuk Melihat IP Address Komputer Server (Windows):
```
1. Windows + R
2. Ketik: cmd
3. Ketik: ipconfig
4. Cari "IPv4 Address"
```

### Untuk Melihat IP Address Smartphone (Android):
```
Settings → Wi-Fi → (nama WiFi) → IP address
```

### Untuk Melihat IP Address iPhone/iPad:
```
Settings → Wi-Fi → (i) → IP Address
```

### Untuk Melihat IP Address Mac:
```
System Preferences → Network → Wi-Fi → Advanced → TCP/IP → IPv4 Address
```

---

## 🔧 TIPS

### 1. IP Address Bisa Berubah
- Setiap kali reconnect WiFi, IP address bisa berubah
- Solusi: Set static IP (lihat panduan lain)

### 2. Gunakan Aplikasi Scanner
- Aplikasi seperti **Fing** sangat membantu untuk scan semua device di jaringan
- Bisa melihat IP address semua device sekaligus

### 3. Catat IP Address Server
- Setelah dapat IP address komputer server, **catat di notes/phone**
- Akan berguna untuk akses dari device lain

---

## 💡 CONTOH REAL-WORLD

### Skenario:
- Laptop Server: IP `192.168.1.13`
- Smartphone: IP `192.168.1.15`
- Laptop Lain: IP `192.168.1.20`

### Yang Digunakan:
- **URL:** `http://192.168.1.13/nurani/public`
- **Menggunakan IP laptop server** (`192.168.1.13`), bukan IP smartphone atau laptop lain

### Dari Smartphone:
1. Buka browser
2. Ketik: `http://192.168.1.13/nurani/public`
3. Selesai!

---

**Intinya: Lihat IP address komputer SERVER (yang jalanin XAMPP), lalu gunakan IP itu di semua device lain!** 🎯

