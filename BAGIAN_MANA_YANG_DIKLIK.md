# 🎯 BAGIAN MANA YANG DIKLIK? (Dari Halaman yang Anda Lihat)

## ⚠️ PENTING: Halaman Ini BUKAN Tempat Setup Static IP!

Halaman yang sedang Anda lihat (**Network & internet > Wi-Fi > marina345**) adalah halaman **informasi WiFi**, bukan untuk setup static IP.

---

## ✅ CARA BENAR: Ke Tempat Setup Static IP

### Dari Halaman yang Anda Lihat Sekarang:

1. **Tutup pop-up** "marina345 Wireless Network Properties" (klik **Cancel** atau **X**)

2. **Kembali ke halaman sebelumnya:**
   - Klik tombol **←** (back/panah kiri) di pojok kiri atas
   - Atau klik **"Wi-Fi"** di breadcrumb (Network & internet > **Wi-Fi**)

3. **Di halaman "Network & internet > Wi-Fi":**
   - Scroll ke **bawah** halaman
   - Cari bagian **"Related settings"** atau **"Advanced network settings"**
   - Klik **"Hardware properties"** atau **"More network adapter options"**
   - ATAU cari **"Change adapter options"**

4. **Akan muncul jendela baru "Network Connections"**

5. **Di jendela "Network Connections":**
   - Klik **kanan** pada **"Wi-Fi"**
   - Pilih **"Properties"**

6. **Di jendela "Wi-Fi Properties":**
   - Tab **"Networking"** (biasanya sudah terbuka)
   - Scroll ke bawah daftar item
   - Cari **"Internet Protocol Version 4 (TCP/IPv4)"**
   - **Klik 2 kali** pada item tersebut

7. **Di jendela "Internet Protocol Version 4 Properties":**
   - Pilih **○ "Use the following IP address"**
   - Isi:
     - **IP address:** `192.168.1.13` (dari info yang Anda lihat)
     - **Subnet mask:** `255.255.255.0`
     - **Default gateway:** `192.168.1.1` (biasanya ini)
   - Klik **OK** → **OK**

---

## 🚀 CARA PALING MUDAH (Langsung ke Tempatnya)

### Opsi 1: Pakai Script
1. **Double-click:** `BUKA_NETWORK_SETTINGS.bat`
2. Jendela "Network Connections" langsung terbuka
3. Klik kanan **"Wi-Fi"** → **Properties**
4. Klik 2x **"Internet Protocol Version 4 (TCP/IPv4)"**
5. Pilih **"Use the following IP address"**
6. Isi form → OK → OK

### Opsi 2: Via Run Command
1. Tekan **Windows + R**
2. Ketik: `ncpa.cpl`
3. Tekan **Enter**
4. Jendela "Network Connections" langsung terbuka
5. Lanjutkan dari Langkah 3 di atas

---

## 📍 DARI HALAMAN YANG ANDA LIHAT SEKARANG

### Yang TIDAK Perlu Diklik:
- ❌ "View Wi-Fi security key" (untuk lihat password WiFi)
- ❌ "Advanced Wi-Fi network properties" (untuk edit WiFi settings)
- ❌ Pop-up "marina345 Wireless Network Properties" (untuk WiFi properties)

### Yang PERLU Diklik:
1. **Kembali** ke halaman "Network & internet > Wi-Fi" (klik ← atau "Wi-Fi")
2. **Scroll ke bawah**, cari **"Hardware properties"** atau **"Change adapter options"**
3. **Klik** bagian tersebut
4. Lanjutkan ke "Network Connections" → Properties → TCP/IPv4

---

## 🎯 RINGKASAN LOKASI

### Halaman yang Benar untuk Setup Static IP:
```
Network Connections (ncpa.cpl)
  → Klik kanan "Wi-Fi"
    → Properties
      → Internet Protocol Version 4 (TCP/IPv4)
        → Use the following IP address
```

### BUKAN di:
```
❌ Network & internet > Wi-Fi > marina345 (halaman yang Anda lihat sekarang)
❌ marina345 Wireless Network Properties (pop-up yang terbuka)
```

---

## 💡 INFO DARI HALAMAN YANG ANDA LIHAT

Dari halaman yang Anda lihat, saya bisa lihat:
- **IPv4 address:** `192.168.1.13` ← **INI YANG AKAN ANDA PAKAI**
- **IPv4 DNS servers:** 118.98.115.70, 118.98.115.77

**Catat IP address ini:** `192.168.1.13` (akan digunakan saat setup static IP)

---

## ✅ LANGKAH CEPAT

1. **Tutup pop-up** yang terbuka (Cancel atau X)
2. **Kembali** ke halaman "Wi-Fi" (klik ←)
3. **Scroll ke bawah**, klik **"Hardware properties"** atau **"Change adapter options"**
4. **Atau lebih mudah:** Tekan **Windows + R** → ketik `ncpa.cpl` → Enter
5. **Klik kanan "Wi-Fi"** → **Properties**
6. **Klik 2x "Internet Protocol Version 4 (TCP/IPv4)"**
7. **Pilih "Use the following IP address"**
8. **Isi:**
   - IP address: `192.168.1.13`
   - Subnet mask: `255.255.255.0`
   - Default gateway: `192.168.1.1`
9. **OK** → **OK**

---

**Intinya: Halaman yang Anda lihat sekarang BUKAN tempat setup static IP. Perlu ke "Network Connections" dulu!** 🎯

