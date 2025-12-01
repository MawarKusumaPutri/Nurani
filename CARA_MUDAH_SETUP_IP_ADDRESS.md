# 🎯 Cara MUDAH Setup IP Address - Tidak Bingung Lagi!

## 🚀 CARA PALING MUDAH (OTOMATIS)

### Opsi 1: Pakai Script Otomatis (DISARANKAN!)

1. **Double-click file:** `SETUP_STATIC_IP_MUDAH.bat`
2. **Ikuti instruksi di layar:**
   - Masukkan IP address saat ini
   - Masukkan Subnet Mask (biasanya `255.255.255.0`)
   - Masukkan Gateway (biasanya `192.168.1.1`)
   - Masukkan nama adapter (biasanya `Wi-Fi` atau `Ethernet`)
3. **Konfirmasi** → Selesai!

**✅ IP address Anda sekarang TIDAK akan berubah lagi!**

---

## 📋 CARA MANUAL (Step-by-Step dengan Gambar)

### Langkah 1: Cari IP Address Saat Ini

1. Tekan **Windows + R**
2. Ketik: `cmd`
3. Tekan **Enter**
4. Ketik: `ipconfig`
5. **Catat 3 informasi ini:**
   - **IPv4 Address:** `192.168.1.13` (contoh)
   - **Subnet Mask:** `255.255.255.0` (biasanya ini)
   - **Default Gateway:** `192.168.1.1` (contoh)

**Contoh Output:**
```
IPv4 Address. . . . . . . . . . . : 192.168.1.13    ← CATAT INI
Subnet Mask . . . . . . . . . . . : 255.255.255.0   ← CATAT INI
Default Gateway . . . . . . . . . : 192.168.1.1     ← CATAT INI
```

---

### Langkah 2: Buka Network Settings

**Cara 1 (Paling Mudah):**
1. Klik kanan ikon **WiFi** di taskbar (pojok kanan bawah)
2. Pilih **"Open Network & Internet settings"**

**Cara 2:**
1. Tekan **Windows + I** (buka Settings)
2. Klik **Network & Internet**

---

### Langkah 3: Buka Adapter Options

1. Di halaman Network settings, scroll ke bawah
2. Klik **"Change adapter options"**
   - Atau cari **"Advanced network settings"** → **"More network adapter options"**

---

### Langkah 4: Pilih WiFi/Ethernet

1. Akan muncul jendela **Network Connections**
2. Cari **"Wi-Fi"** atau **"Ethernet"** (tergantung koneksi Anda)
3. **Klik kanan** pada WiFi/Ethernet
4. Pilih **"Properties"**

---

### Langkah 5: Buka TCP/IPv4 Settings

1. Di jendela Properties, scroll ke bawah
2. Cari **"Internet Protocol Version 4 (TCP/IPv4)"**
3. **Klik 2 kali** atau pilih lalu klik **"Properties"**

---

### Langkah 6: Set Static IP

1. Pilih **"Use the following IP address"** (bukan "Obtain automatically")
2. **Isi 3 kolom ini:**

   **IP address:**
   ```
   192.168.1.13
   ```
   (Ganti dengan IP address Anda yang dicatat di Langkah 1)

   **Subnet mask:**
   ```
   255.255.255.0
   ```
   (Biasanya ini, atau gunakan yang dicatat di Langkah 1)

   **Default gateway:**
   ```
   192.168.1.1
   ```
   (Ganti dengan Gateway yang dicatat di Langkah 1)

3. **Klik "OK"**
4. **Klik "OK"** lagi di jendela Properties

---

### Langkah 7: Selesai!

✅ **IP address Anda sekarang sudah static (tidak akan berubah)!**

---

## 🎯 CONTOH LENGKAP

### Skenario:
- IP Address saat ini: `192.168.1.13`
- Subnet Mask: `255.255.255.0`
- Gateway: `192.168.1.1`

### Yang Diisi:
```
IP address:      192.168.1.13
Subnet mask:     255.255.255.0
Default gateway: 192.168.1.1
```

### Hasil:
- IP address akan selalu `192.168.1.13`
- Tidak akan berubah meski reconnect WiFi
- URL tetap: `http://192.168.1.13/nurani/public`

---

## ⚠️ TIPS PENTING

### 1. Pilih IP yang Tidak Konflik
- Jangan pilih IP yang sudah dipakai device lain
- Biasanya router menggunakan `192.168.1.1` atau `192.168.0.1`
- Hindari IP yang terlalu kecil (1-10) atau terlalu besar (250-254)

### 2. Jika Tidak Bisa Connect WiFi Setelah Setup
- Kembalikan ke **"Obtain an IP address automatically"**
- Atau coba IP address yang berbeda (misalnya `192.168.1.50`)

### 3. Catat Konfigurasi
- Simpan IP address, Subnet Mask, dan Gateway di notes
- Akan berguna jika perlu reset

---

## 🔄 KEMBALI KE AUTO IP (Jika Perlu)

Jika ingin kembali ke IP otomatis (dynamic):

1. Buka **Network Connections** (Langkah 3)
2. Klik kanan **WiFi/Ethernet** → **Properties**
3. **Internet Protocol Version 4 (TCP/IPv4)** → **Properties**
4. Pilih **"Obtain an IP address automatically"**
5. **OK** → **OK**

---

## 📝 CHECKLIST

Sebelum setup, pastikan Anda punya:
- [ ] IPv4 Address (dari `ipconfig`)
- [ ] Subnet Mask (biasanya `255.255.255.0`)
- [ ] Default Gateway (biasanya `192.168.1.1` atau `192.168.0.1`)
- [ ] Nama adapter (Wi-Fi atau Ethernet)

---

## 🚀 QUICK START

**Cara Paling Cepat:**
1. Double-click: `SETUP_STATIC_IP_MUDAH.bat`
2. Ikuti instruksi
3. Selesai!

**Atau Manual:**
1. `ipconfig` → catat IP, Subnet, Gateway
2. Settings → Network → Change adapter options
3. WiFi → Properties → TCP/IPv4 → Use following IP
4. Isi → OK → OK

---

## 💡 MENGAPA PERLU STATIC IP?

### Dengan Dynamic IP (Default):
- ❌ IP berubah setiap reconnect WiFi
- ❌ Harus cek IP lagi setiap kali
- ❌ URL harus diupdate lagi

### Dengan Static IP:
- ✅ IP selalu sama
- ✅ Tidak perlu cek IP lagi
- ✅ URL tetap sama selamanya
- ✅ Lebih mudah untuk akses dari device lain

---

**Sekarang setup IP address jadi MUDAH dan TIDAK BINGUNG lagi!** 🎉

