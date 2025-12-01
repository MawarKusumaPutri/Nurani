# 📋 Cara Tambahkan /nurani/public ke URL Ngrok

## ❓ PERTANYAAN ANDA

**"Yang harus ditambahkan di forwarding itu untuk tambahkan /nurani/public itu taruh di sebelah mana?"**

---

## ✅ JAWABAN

**Tambahkan `/nurani/public` di AKHIR URL ngrok (setelah URL ngrok)!**

---

## 📋 LANGKAH LENGKAP

### Langkah 1: Copy URL dari Baris "Forwarding"

**Di jendela ngrok console, cari baris "Forwarding":**

```
Forwarding    https://abc-def-123.ngrok-free.app -> http://localhost:80
```

**Copy bagian KIRI (sebelum tanda `->`):**

```
https://abc-def-123.ngrok-free.app
```

**Ini adalah URL ngrok yang Anda copy!**

---

### Langkah 2: Tambahkan /nurani/public di AKHIR URL

**Setelah copy URL ngrok, tambahkan `/nurani/public` di AKHIR:**

**URL ngrok yang di-copy:**
```
https://abc-def-123.ngrok-free.app
```

**Tambahkan `/nurani/public` di AKHIR:**
```
https://abc-def-123.ngrok-free.app/nurani/public
                                    ↑
                          TAMBAHKAN DI SINI!
```

**Hasil akhir:**
```
https://abc-def-123.ngrok-free.app/nurani/public
```

---

## 🎯 CONTOH LENGKAP

### Contoh 1: Format Standar

**Di jendela ngrok console:**
```
Forwarding    https://abc-def-123.ngrok-free.app -> http://localhost:80
```

**Langkah 1: Copy URL ngrok (bagian kiri)**
```
https://abc-def-123.ngrok-free.app
```

**Langkah 2: Tambahkan /nurani/public di AKHIR**
```
https://abc-def-123.ngrok-free.app/nurani/public
                                    ↑
                          TAMBAHKAN DI SINI!
```

**URL lengkap untuk akses:**
```
https://abc-def-123.ngrok-free.app/nurani/public
```

---

### Contoh 2: Format Lain

**Di jendela ngrok console:**
```
Forwarding    https://xyz-789-456.ngrok.io -> http://localhost:80
```

**Langkah 1: Copy URL ngrok (bagian kiri)**
```
https://xyz-789-456.ngrok.io
```

**Langkah 2: Tambahkan /nurani/public di AKHIR**
```
https://xyz-789-456.ngrok.io/nurani/public
                              ↑
                    TAMBAHKAN DI SINI!
```

**URL lengkap untuk akses:**
```
https://xyz-789-456.ngrok.io/nurani/public
```

---

## 📸 CONTOH VISUAL

### Di Jendela Ngrok Console:

```
Forwarding    https://abc-def-123.ngrok-free.app -> http://localhost:80
              └─────────────────────────────────┘
                    COPY INI (bagian kiri)
```

---

### Setelah Copy, Tambahkan /nurani/public:

```
https://abc-def-123.ngrok-free.app/nurani/public
└──────────────────────────────┘ └───────────┘
     URL ngrok yang di-copy          TAMBAHKAN INI!
```

---

## ⚠️ CATATAN PENTING

### 1. Jangan Tambahkan di Tengah URL

**❌ SALAH:**
```
https://abc-def-123.ngrok-free.app/nurani/public -> http://localhost:80
```

**✅ BENAR:**
```
https://abc-def-123.ngrok-free.app/nurani/public
```

---

### 2. Jangan Copy Seluruh Baris

**❌ SALAH:**
```
Forwarding    https://abc-def-123.ngrok-free.app -> http://localhost:80
```

**✅ BENAR:**
```
https://abc-def-123.ngrok-free.app
```

**Lalu tambahkan `/nurani/public`:**
```
https://abc-def-123.ngrok-free.app/nurani/public
```

---

### 3. Pastikan Ada Tanda Slash (/) di Depan

**✅ BENAR:**
```
https://abc-def-123.ngrok-free.app/nurani/public
                                    ↑
                          Ada tanda / di sini!
```

**❌ SALAH:**
```
https://abc-def-123.ngrok-free.appnurani/public
                                    ↑
                          Tidak ada tanda /!
```

---

## 📋 LANGKAH STEP BY STEP

### Langkah 1: Copy URL dari Baris "Forwarding"

**Di jendela ngrok console:**
1. Cari baris "Forwarding"
2. Copy bagian KIRI (sebelum tanda `->`)
3. Contoh: `https://abc-def-123.ngrok-free.app`

---

### Langkah 2: Paste di Browser atau Notepad

**Paste URL yang sudah di-copy:**
```
https://abc-def-123.ngrok-free.app
```

---

### Langkah 3: Tambahkan /nurani/public di AKHIR

**Tambahkan `/nurani/public` di AKHIR URL:**

**Sebelum:**
```
https://abc-def-123.ngrok-free.app
```

**Sesudah:**
```
https://abc-def-123.ngrok-free.app/nurani/public
                                    ↑
                          TAMBAHKAN DI SINI!
```

---

### Langkah 4: Test di Browser

**Buka browser:**
1. Ketik URL lengkap di address bar:
   ```
   https://abc-def-123.ngrok-free.app/nurani/public
   ```
2. Tekan Enter
3. Website muncul? ✅

---

## 🎯 RINGKASAN

**Pertanyaan:** "Yang harus ditambahkan di forwarding itu untuk tambahkan /nurani/public itu taruh di sebelah mana?"

**Jawaban:**
- ✅ **Tambahkan `/nurani/public` di AKHIR URL ngrok!**
- ✅ **Setelah URL ngrok yang di-copy dari baris "Forwarding"**

**Langkah:**
1. Copy URL ngrok dari baris "Forwarding" (bagian kiri)
   - Contoh: `https://abc-def-123.ngrok-free.app`
2. Tambahkan `/nurani/public` di AKHIR
   - Menjadi: `https://abc-def-123.ngrok-free.app/nurani/public`
3. Test di browser

**Selesai!** ✅

---

**Intinya: Tambahkan `/nurani/public` di AKHIR URL ngrok, setelah URL yang di-copy dari baris "Forwarding"!** 🎯

