# 🎯 PANDUAN SUPER MUDAH - TIDAK BINGUNG LAGI!

## 🚀 CARA PALING MUDAH (3 LANGKAH SAJA!)

### ✅ LANGKAH 1: Buka Jendela Network Connections

**Cara 1 (Paling Mudah):**
1. Tekan tombol **Windows** (ikon Windows di keyboard)
2. Tekan tombol **R** (sambil masih tekan Windows, atau lepas dulu)
3. Akan muncul kotak kecil di pojok kiri bawah
4. Ketik: `ncpa.cpl`
5. Tekan **Enter**
6. ✅ Jendela "Network Connections" akan terbuka!

**Cara 2 (Pakai Script):**
1. Double-click file: `BUKA_NETWORK_SETTINGS.bat`
2. ✅ Jendela "Network Connections" akan terbuka!

---

### ✅ LANGKAH 2: Klik Kanan pada "Wi-Fi"

**Setelah jendela "Network Connections" terbuka:**

1. **Lihat di jendela yang baru terbuka**
2. **Di bagian KIRI**, Anda akan melihat:
   - Ada ikon 📶 (ikon sinyal WiFi)
   - Ada tulisan **"Wi-Fi"**
   - Di bawahnya ada "marina345"
   - Di bawahnya lagi ada "Intel(...)"

3. **Yang harus dilakukan:**
   - **Klik KANAN** (tombol kanan mouse) pada bagian yang ada tulisan **"Wi-Fi"**
   - Bisa klik pada tulisan "Wi-Fi"
   - Bisa klik pada ikon 📶 di sebelah kiri
   - **PENTING:** Harus klik **KANAN**, bukan kiri!

4. **Setelah klik kanan:**
   - Akan muncul **menu kecil** dengan beberapa pilihan
   - Menu ini muncul di dekat tempat Anda klik

---

### ✅ LANGKAH 3: Pilih "Properties"

**Di menu kecil yang muncul:**

1. **Lihat menu kecil** yang muncul setelah klik kanan
2. **Cari tulisan "Properties"** di dalam menu
3. **Klik KIRI** (tombol kiri mouse) pada **"Properties"**
4. ✅ Jendela baru "Wi-Fi Properties" akan terbuka!

---

## 🎯 LANGKAH SELANJUTNYA (Setelah Jendela "Wi-Fi Properties" Terbuka)

### ✅ LANGKAH 4: Klik 2x pada "Internet Protocol Version 4"

**Di jendela "Wi-Fi Properties":**

1. **Lihat jendela "Wi-Fi Properties"** yang baru terbuka
2. **Di bagian atas**, ada beberapa **tab** (seperti kertas yang ditumpuk)
3. **Klik tab "Networking"** (biasanya sudah terbuka, jika tidak klik tab ini)
4. **Di dalam tab "Networking":**
   - Ada daftar item dengan checkbox ☑ di sebelah kiri
   - Scroll ke bawah (gulir mouse ke bawah)
   - Cari item yang bertuliskan:
     ```
     ☑ Internet Protocol Version 4 (TCP/IPv4)
     ```
   - **Bukan** "Internet Protocol Version 6"
   - **Harus** yang "Version 4"

5. **Klik 2 KALI** (double-click) pada item **"Internet Protocol Version 4 (TCP/IPv4)"**
   - Klik 2x cepat pada tulisan tersebut
   - ATAU klik 1x lalu klik tombol **"Properties"** di bawah
6. ✅ Jendela baru "Internet Protocol Version 4 Properties" akan terbuka!

---

### ✅ LANGKAH 5: Pilih "Use the following IP address"

**Di jendela "Internet Protocol Version 4 Properties":**

1. **Lihat jendela baru** yang terbuka
2. **Ada 2 pilihan** (radio button):
   - ○ **"Obtain an IP address automatically"** (ini yang terpilih sekarang)
   - ○ **"Use the following IP address"** ← **INI YANG HARUS DIPILIH!**

3. **Klik** pada **○ "Use the following IP address"**
4. **Setelah diklik:**
   - 3 kolom akan muncul dan bisa diisi
   - Kolom-kolom ini sebelumnya tidak bisa diisi, sekarang bisa!

---

### ✅ LANGKAH 6: Isi 3 Kolom

**Setelah pilih "Use the following IP address":**

1. **Kolom 1: IP address**
   - Klik di kolom ini
   - Ketik: `192.168.1.13`
   - (Ganti dengan IP address Anda, dari info sebelumnya)

2. **Kolom 2: Subnet mask**
   - Klik di kolom ini
   - Ketik: `255.255.255.0`
   - (Biasanya ini, atau ketik otomatis akan muncul)

3. **Kolom 3: Default gateway**
   - Klik di kolom ini
   - Ketik: `192.168.1.1`
   - (Biasanya ini, atau cek dengan `ipconfig`)

4. **Klik tombol "OK"** (di bawah)
5. **Klik tombol "OK"** lagi (di jendela "Wi-Fi Properties")
6. ✅ **SELESAI!** IP address Anda sekarang sudah static!

---

## 📋 RINGKASAN SEMUA LANGKAH

```
1. Windows + R → ketik: ncpa.cpl → Enter
   ↓
2. Klik KANAN pada "Wi-Fi" (di jendela Network Connections)
   ↓
3. Pilih "Properties" (di menu pop-up)
   ↓
4. Klik 2x "Internet Protocol Version 4 (TCP/IPv4)" (di jendela Wi-Fi Properties)
   ↓
5. Pilih "Use the following IP address" (di jendela Internet Protocol Version 4 Properties)
   ↓
6. Isi 3 kolom (IP, Subnet, Gateway) → OK → OK
   ↓
SELESAI! ✅
```

---

## 💡 TIPS PENTING

### Jika Masih Bingung:

1. **Langkah 1-3:** Fokus pada klik kanan "Wi-Fi" → Properties
2. **Langkah 4-6:** Fokus pada klik 2x "Internet Protocol Version 4" → pilih "Use the following IP address" → isi form

### Jika Menu Tidak Muncul:
- Pastikan klik **KANAN** (tombol kanan mouse), bukan kiri
- Klik pada bagian "Wi-Fi" atau ikon 📶

### Jika Kolom Tidak Bisa Diisi:
- Pastikan sudah pilih **"Use the following IP address"** dulu
- Setelah itu baru kolom-kolom bisa diisi

---

## 🎯 CONTOH VISUAL SEDERHANA

### Jendela "Network Connections":
```
[📶] Wi-Fi          ← KLIK KANAN DI SINI!
     marina345
     Intel(...)
```

### Menu Pop-up (setelah klik kanan):
```
Connect/Disconnect
Status
Properties    ← KLIK INI!
Diagnose
```

### Jendela "Wi-Fi Properties":
```
Tab: [Networking] [Sharing]

☑ Internet Protocol Version 4 (TCP/IPv4)  ← KLIK 2X INI!
☑ Internet Protocol Version 6 (TCP/IPv6)
```

### Jendela "Internet Protocol Version 4 Properties":
```
○ Obtain an IP address automatically
● Use the following IP address  ← PILIH INI!

IP address:      [192.168.1.13  ]  ← ISI INI
Subnet mask:     [255.255.255.0 ]  ← ISI INI
Default gateway: [192.168.1.1   ]  ← ISI INI

[OK] [Cancel]
```

---

**Sekarang sudah lebih mudah dipahami! Ikuti langkah 1-6 dengan urut!** 🎯

