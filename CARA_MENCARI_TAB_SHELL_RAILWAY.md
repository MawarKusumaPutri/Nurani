# 📍 Cara Mencari Tab "Shell" di Railway

## 🎯 Lokasi Tab "Shell"

### Di Railway Dashboard:

1. **Klik service "web"** (yang hijau/online di sidebar kiri)

2. **Lihat tab-tab di bagian atas** (di bawah nama service "web")

3. **Tab "Shell" biasanya ada di baris yang sama dengan:**
   - Deployments
   - Variables
   - Metrics
   - Settings
   - **Shell** ← INI YANG DICARI!

---

## 🔍 Jika Tab "Shell" Tidak Terlihat

### Kemungkinan 1: Tab Tersembunyi (Perlu Scroll)
- **Scroll horizontal** ke kanan di baris tab
- Tab "Shell" mungkin ada di ujung kanan

### Kemungkinan 2: Tab Ada di Menu Lain
- Cek di tab **"Settings"**
- Scroll ke bawah di Settings
- Mungkin ada section "Shell" atau "Terminal"

### Kemungkinan 3: Tab Ada di Navigation Bar Atas
- Cek navigation bar di paling atas (Architecture, Observability, Logs, Settings)
- Tab "Shell" mungkin ada di sana

---

## 🔍 Alternatif: Cek di Tab "Details"

1. **Klik tab "Details"** (jika ada)
2. Scroll ke bawah
3. Mungkin ada tombol **"Open Shell"** atau **"Terminal"**

---

## 🔍 Alternatif: Via URL Langsung

Jika tab Shell tidak terlihat, coba akses langsung:

1. **Copy URL** dari browser saat di Railway Dashboard
2. **Tambahkan** `/shell` di akhir URL
3. Atau cari tombol **"Shell"** atau **"Terminal"** di interface

---

## 📸 Visual Guide

### Tab biasanya terlihat seperti ini:

```
┌─────────────────────────────────────────┐
│ web (service name)                      │
├─────────────────────────────────────────┤
│ [Deployments] [Variables] [Metrics]    │
│ [Settings] [Shell] ← INI!              │
└─────────────────────────────────────────┘
```

Atau mungkin:

```
┌─────────────────────────────────────────┐
│ web                                      │
├─────────────────────────────────────────┤
│ Deployments | Variables | Metrics |     │
│ Settings | Shell ← INI!                 │
└─────────────────────────────────────────┘
```

---

## 💡 Tips

1. **Scroll horizontal** jika tab tidak terlihat
2. **Cek semua tab** yang ada
3. **Cek di Settings** - mungkin ada tombol "Open Shell"
4. **Refresh halaman** - mungkin UI belum load sempurna

---

## 🆘 Jika Masih Tidak Ketemu

Jika masih tidak menemukan tab "Shell":

1. **Cek Railway Documentation** - mungkin UI berubah
2. **Coba klik kanan** pada service "web" - mungkin ada menu context
3. **Cek di tab "Settings"** - scroll ke bawah, mungkin ada section Shell

---

**Tab "Shell" biasanya ada di baris yang sama dengan tab "Deployments", "Variables", "Metrics", dan "Settings"! Coba scroll horizontal jika tidak terlihat! 🔍**

