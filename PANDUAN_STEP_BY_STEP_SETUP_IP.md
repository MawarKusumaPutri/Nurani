# 📍 Panduan Step-by-Step: Bagian Mana yang Diklik?

## 🎯 LANGKAH DEMI LANGKAH (DENGAN GAMBAR MENTAL)

### ✅ LANGKAH 1: Buka Network Settings

**Cara Paling Mudah:**
1. Lihat **taskbar** (baris di bawah layar)
2. Cari ikon **WiFi** (biasanya di pojok kanan bawah, dekat jam)
3. **Klik kanan** pada ikon WiFi
4. Pilih **"Open Network & Internet settings"** atau **"Network & Internet settings"**

**Atau:**
1. Tekan **Windows + I** (tombol Windows + huruf I)
2. Di jendela Settings yang muncul, cari dan klik **"Network & internet"**

---

### ✅ LANGKAH 2: Buka Adapter Options

Setelah masuk ke halaman **"Network & internet"**:

1. Scroll ke bawah halaman
2. Cari bagian **"Advanced network settings"** atau **"Related settings"**
3. Di dalamnya, cari dan klik:
   - **"More network adapter options"** 
   - ATAU **"Change adapter options"**
   - ATAU **"Network and Sharing Center"** → **"Change adapter settings"**

**💡 TIP:** Jika tidak ketemu, coba:
- Klik **"Ethernet"** atau **"Wi-Fi"** di menu kiri
- Scroll ke bawah, cari **"Related settings"**
- Klik **"Change adapter options"**

---

### ✅ LANGKAH 3: Pilih WiFi/Ethernet

Setelah klik "Change adapter options", akan muncul jendela baru:

**Jendela "Network Connections"** akan muncul dengan daftar koneksi:
- **Wi-Fi** (dengan ikon sinyal WiFi)
- **Ethernet** (dengan ikon kabel)
- **Bluetooth Network Connection** (jika ada)

**Yang harus dilakukan:**
1. Cari **"Wi-Fi"** (jika pakai WiFi) atau **"Ethernet"** (jika pakai kabel)
2. **Klik kanan** pada **"Wi-Fi"** (atau Ethernet)
3. Pilih **"Properties"** (paling bawah)

---

### ✅ LANGKAH 4: Buka TCP/IPv4 Settings

Setelah klik "Properties", akan muncul jendela baru:

**Jendela "Wi-Fi Properties"** atau **"Ethernet Properties"** akan muncul dengan:
- Tab di atas: **"Networking"**, **"Sharing"**, dll
- Daftar item di tengah dengan checkbox

**Yang harus dilakukan:**
1. Di tab **"Networking"** (biasanya sudah terbuka)
2. Scroll ke bawah daftar item
3. Cari **"Internet Protocol Version 4 (TCP/IPv4)"**
   - Bukan "Internet Protocol Version 6 (TCP/IPv6)"
   - Harus yang "Version 4"
4. **Klik 2 kali** pada **"Internet Protocol Version 4 (TCP/IPv4)"**
   - ATAU klik 1 kali lalu klik tombol **"Properties"** di bawah

---

### ✅ LANGKAH 5: Set Static IP

Setelah klik 2x, akan muncul jendela baru:

**Jendela "Internet Protocol Version 4 (TCP/IPv4) Properties"** akan muncul dengan 2 opsi:
- ○ **Obtain an IP address automatically** (terpilih sekarang)
- ○ **Use the following IP address** (ini yang harus dipilih)

**Yang harus dilakukan:**
1. Klik pada **○ "Use the following IP address"** (pilih yang kedua)
2. Setelah dipilih, 3 kolom akan muncul dan bisa diisi:
   - **IP address:** (kosong, harus diisi)
   - **Subnet mask:** (kosong, harus diisi)
   - **Default gateway:** (kosong, harus diisi)

3. **Isi 3 kolom tersebut:**

   **IP address:**
   ```
   192.168.1.13
   ```
   (Ganti dengan IP address Anda)

   **Subnet mask:**
   ```
   255.255.255.0
   ```
   (Biasanya ini, atau ketik otomatis akan muncul)

   **Default gateway:**
   ```
   192.168.1.1
   ```
   (Ganti dengan Gateway Anda)

4. **Klik "OK"** (di bawah)
5. **Klik "OK"** lagi (di jendela Properties sebelumnya)

---

## 🎯 RINGKASAN LOKASI (BAGIAN MANA YANG DIKLIK)

### Dari Taskbar:
```
Ikon WiFi (pojok kanan bawah) 
  → Klik kanan 
    → "Open Network & Internet settings"
```

### Dari Settings:
```
Settings (Windows + I)
  → "Network & internet" (menu kiri)
    → Scroll ke bawah
      → "Change adapter options" (di Related settings)
        → Klik kanan "Wi-Fi"
          → "Properties"
            → "Internet Protocol Version 4 (TCP/IPv4)" (klik 2x)
              → "Use the following IP address"
                → Isi IP, Subnet, Gateway
                  → OK → OK
```

---

## 📸 URUTAN JENDELA YANG AKAN MUNCUL

1. **Settings** → Network & internet
2. **Network Connections** (setelah klik "Change adapter options")
3. **Wi-Fi Properties** (setelah klik kanan → Properties)
4. **Internet Protocol Version 4 Properties** (setelah klik 2x TCP/IPv4)
5. **Isi form** → OK → OK

---

## ⚠️ JIKA TIDAK KETEMU "CHANGE ADAPTER OPTIONS"

### Alternatif 1: Via Control Panel
1. Tekan **Windows + R**
2. Ketik: `ncpa.cpl`
3. Tekan **Enter**
4. Langsung muncul jendela "Network Connections"
5. Lanjut ke Langkah 3 (Klik kanan Wi-Fi → Properties)

### Alternatif 2: Via Run
1. Tekan **Windows + R**
2. Ketik: `control netconnections`
3. Tekan **Enter**
4. Langsung muncul jendela "Network Connections"

---

## 💡 TIPS

### Jika Bingung Tab Mana:
- Tab yang dicari adalah **"Networking"** (biasanya tab pertama)
- Bukan tab "Sharing" atau tab lain

### Jika Bingung Item Mana:
- Item yang dicari adalah **"Internet Protocol Version 4 (TCP/IPv4)"**
- Bukan "Internet Protocol Version 6"
- Bukan "File and Printer Sharing"
- Bukan item lain

### Jika Form Tidak Bisa Diisi:
- Pastikan sudah klik **○ "Use the following IP address"** dulu
- Setelah itu baru kolom-kolom bisa diisi

---

## 🎯 CONTOH VISUAL (TEXT-BASED)

```
┌─────────────────────────────────────┐
│  Settings                           │
├─────────────────────────────────────┤
│  Network & internet  ← KLIK INI    │
│  System                             │
│  Bluetooth & devices                │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│  Network & internet                 │
├─────────────────────────────────────┤
│  Wi-Fi: On                          │
│  marina345: Connected               │
│                                     │
│  [Scroll ke bawah]                  │
│                                     │
│  Related settings:                  │
│  Change adapter options  ← KLIK INI │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│  Network Connections                │
├─────────────────────────────────────┤
│  Wi-Fi              ← KLIK KANAN   │
│  Ethernet                           │
│                                     │
│  (Klik kanan → Properties)          │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│  Wi-Fi Properties                   │
├─────────────────────────────────────┤
│  [Tab: Networking]                  │
│                                     │
│  ☑ Client for Microsoft Networks    │
│  ☑ File and Printer Sharing         │
│  ☑ Internet Protocol Version 4      │
│     (TCP/IPv4)        ← KLIK 2X INI│
│  ☑ Internet Protocol Version 6      │
└─────────────────────────────────────┘
           ↓
┌─────────────────────────────────────┐
│  Internet Protocol Version 4 Props  │
├─────────────────────────────────────┤
│  ○ Obtain an IP address automatically│
│  ● Use the following IP address    │ ← PILIH INI
│                                     │
│  IP address:      [192.168.1.13  ]  │ ← ISI INI
│  Subnet mask:     [255.255.255.0 ]  │ ← ISI INI
│  Default gateway: [192.168.1.1   ]  │ ← ISI INI
│                                     │
│  [OK] [Cancel]                      │
└─────────────────────────────────────┘
```

---

## ✅ CHECKLIST (Tandai Setelah Selesai)

- [ ] Buka Settings (Windows + I)
- [ ] Klik "Network & internet"
- [ ] Scroll ke bawah, klik "Change adapter options"
- [ ] Klik kanan "Wi-Fi" → "Properties"
- [ ] Klik 2x "Internet Protocol Version 4 (TCP/IPv4)"
- [ ] Pilih "Use the following IP address"
- [ ] Isi IP address
- [ ] Isi Subnet mask
- [ ] Isi Default gateway
- [ ] Klik OK → OK

---

**Sekarang sudah jelas bagian mana yang harus diklik!** 🎯

