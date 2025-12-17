# 📍 Cara Mendapatkan URL Aplikasi di Railway

## 🎯 Lokasi URL di Railway Dashboard

### Langkah-Langkah:

1. **Buka Railway Dashboard**
   - Login ke [railway.app](https://railway.app)
   - Pilih project **"TMS Nurani"**

2. **Klik Service "web"**
   - Di sidebar kiri, klik service **"web"** (yang hijau/online)

3. **Klik Tab "Settings"**
   - Di bagian atas, klik tab **"Settings"** (sudah terbuka sekarang)

4. **Scroll Ke Bawah**
   - **Scroll ke bawah** di panel kanan (area Settings)
   - Cari bagian yang bertuliskan **"Domains"** atau **"Networking"**

5. **Copy URL**
   - Di bagian "Domains", Anda akan melihat:
     - **Railway URL**: `https://web-production-50f9.up.railway.app`
     - Atau URL dengan format serupa
   - **Klik tombol copy** (ikon copy) di sebelah URL
   - Atau **highlight dan copy** URL tersebut

6. **Buka di Browser**
   - Paste URL di address bar browser
   - Tekan Enter
   - Aplikasi harus bisa diakses!

---

## 📸 Visual Guide

### Di Tab "Settings", scroll ke bawah untuk menemukan:

```
┌─────────────────────────────────────┐
│ Settings                            │
├─────────────────────────────────────┤
│ Source                              │
│   Repository: ...                   │
│   Branch: master                    │
│                                     │
│ Deploy                              │
│   Build Command: ...                │
│   Start Command: ...                │
│                                     │
│ [SCROLL KE BAWAH] ⬇️                │
│                                     │
│ Domains  ← INI YANG DICARI!        │
│   Railway URL:                      │
│   https://web-production-50f9...    │
│   [Copy] button                     │
│                                     │
│   Custom Domain (optional)          │
└─────────────────────────────────────┘
```

---

## 🔍 Alternatif: Cek di Tab "Details"

Jika tidak menemukan di Settings, coba:

1. Klik tab **"Details"** (bukan Settings)
2. Di bagian atas, biasanya ada **URL** atau **Domain** yang ditampilkan
3. Copy URL tersebut

---

## 🔍 Alternatif: Cek di Architecture View

1. Klik tab **"Architecture"** (di navigation bar atas)
2. Klik pada service **"web"** (box yang hijau)
3. Di popup atau detail, biasanya ada URL yang ditampilkan

---

## 💡 Tips

1. **Bagian "Domains" biasanya di bagian bawah Settings**
   - Scroll sampai ke bawah
   - Biasanya setelah bagian "Deploy" dan "Environment"

2. **URL Format:**
   - Biasanya: `https://web-production-xxxx.up.railway.app`
   - Atau: `https://your-app-name.up.railway.app`

3. **Jika tidak ada bagian "Domains":**
   - Cek di tab "Details"
   - Atau cek di Architecture view
   - Atau klik service "web" → lihat di header/title

---

## 🆘 Masih Tidak Ketemu?

Jika masih tidak menemukan URL:

1. **Cek di Activity Log:**
   - Di sidebar kanan, lihat Activity
   - Biasanya ada link ke deployment

2. **Cek di Deployments:**
   - Tab "Deployments" → klik deployment terbaru
   - Biasanya ada URL di sana

3. **Generate Domain Baru:**
   - Di Settings → Domains
   - Klik **"Generate Domain"** (jika ada)
   - Railway akan generate URL baru

---

**Setelah menemukan URL, copy dan buka di browser untuk test aplikasi! 🚀**

