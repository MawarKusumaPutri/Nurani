# ✅ UPLOAD FOTO TANDA TANGAN DIGITAL SUDAH DITAMBAHKAN!

## 📸 **Perubahan yang Dilakukan**

### **File:** `resources/views/guru/rpp/create.blade.php`

**Ditambahkan:** Fitur **upload foto tanda tangan digital** untuk Kepala Sekolah dan Guru dengan preview real-time

---

## 🎯 **Fitur Baru**

### **1. Upload Tanda Tangan Kepala Sekolah**
- ✅ Input file untuk upload gambar
- ✅ Accept: Image files (JPG, PNG, etc.)
- ✅ Max size: 2MB
- ✅ Preview real-time setelah upload
- ✅ Label: "Upload Tanda Tangan & Stempel"

### **2. Upload Tanda Tangan Guru**
- ✅ Input file untuk upload gambar
- ✅ Accept: Image files (JPG, PNG, etc.)
- ✅ Max size: 2MB
- ✅ Preview real-time setelah upload
- ✅ Label: "Upload Tanda Tangan"

### **3. Preview Image**
- ✅ Preview muncul otomatis setelah pilih file
- ✅ Max width: 100%
- ✅ Max height: 150px
- ✅ Object-fit: contain (maintain aspect ratio)
- ✅ Success message dengan icon check

---

## 🎨 **Tampilan**

### **Sebelum Upload:**
```
┌──────────────────────────────────────┐
│ Upload Tanda Tangan & Stempel        │
│ [Choose File] No file chosen         │
│ Format: JPG, PNG (Max: 2MB)          │
│                                      │
│ ┌──────────────────────────────────┐ │
│ │  📷                              │ │
│ │  Preview Tanda Tangan & Stempel  │ │
│ │  Akan muncul setelah upload      │ │
│ └──────────────────────────────────┘ │
└──────────────────────────────────────┘
```

### **Setelah Upload:**
```
┌──────────────────────────────────────┐
│ Upload Tanda Tangan & Stempel        │
│ [Choose File] signature.png          │
│ Format: JPG, PNG (Max: 2MB)          │
│                                      │
│ ┌──────────────────────────────────┐ │
│ │  [PREVIEW IMAGE]                 │ │
│ │  ✅ Gambar berhasil dipilih      │ │
│ └──────────────────────────────────┘ │
└──────────────────────────────────────┘
```

---

## 💻 **Kode yang Ditambahkan**

### **1. Form Enctype:**
```blade
<form action="{{ route('guru.rpp.store') }}" method="POST" enctype="multipart/form-data">
```

### **2. Upload Input (Kepala Sekolah):**
```blade
<div class="mb-3">
    <label for="ttd_kepala_sekolah" class="form-label">
        Upload Tanda Tangan & Stempel
    </label>
    <input type="file" class="form-control" 
           id="ttd_kepala_sekolah" 
           name="ttd_kepala_sekolah" 
           accept="image/*" 
           onchange="previewSignature(this, 'preview_ttd_kepsek')">
    <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
</div>

<div class="border rounded p-3 text-center bg-light" 
     id="preview_ttd_kepsek" 
     style="min-height: 150px;">
    <i class="fas fa-image text-muted mb-2"></i>
    <p class="text-muted mb-0 small">Preview Tanda Tangan & Stempel</p>
    <p class="text-muted mb-0 small">Akan muncul setelah upload</p>
</div>
```

### **3. JavaScript Preview:**
```javascript
function previewSignature(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     alt="Preview Tanda Tangan" 
                     style="max-width: 100%; max-height: 150px; object-fit: contain;">
                <p class="text-success mb-0 small mt-2">
                    <i class="fas fa-check-circle me-1"></i>
                    Gambar berhasil dipilih
                </p>
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
```

---

## 📊 **Perubahan**

```
✅ 1 file changed
✅ +40 lines added
✅ -14 lines removed
✅ Net: +26 lines
```

**Yang Ditambahkan:**
- ✅ 2 file input untuk upload tanda tangan
- ✅ 2 preview area dengan ID unik
- ✅ JavaScript function untuk preview
- ✅ Form enctype multipart/form-data

**Yang Dihapus:**
- ❌ Static placeholder "Tempat Tanda Tangan"

---

## 🚀 **Status Deployment**

```bash
✅ git add resources/views/guru/rpp/create.blade.php
✅ git commit -m "Add: Upload foto tanda tangan digital..."
✅ git push
```

**Commit:** `5c3ab31` - Add digital signature upload with preview

**Railway akan:**
1. ⏰ Detect perubahan
2. 🔨 Build aplikasi
3. ✅ Deploy dengan fitur upload tanda tangan
4. ✅ Guru bisa upload tanda tangan digital

---

## 💡 **Cara Penggunaan**

### **Untuk Guru:**

1. **Buat RPP seperti biasa**
2. **Scroll ke bagian "Pengesahan"**
3. **Isi data Kepala Sekolah** (nama & NIP)
4. **Upload Tanda Tangan Kepala Sekolah:**
   - Klik "Choose File"
   - Pilih gambar tanda tangan & stempel
   - Lihat preview muncul otomatis
5. **Upload Tanda Tangan Guru:**
   - Klik "Choose File"
   - Pilih gambar tanda tangan
   - Lihat preview muncul otomatis
6. **Klik Simpan RPP**

---

## 📝 **Field Details**

### **Input Fields:**

| Field | Type | Accept | Max Size | Preview |
|-------|------|--------|----------|---------|
| **ttd_kepala_sekolah** | File | image/* | 2MB | ✅ Yes |
| **ttd_guru** | File | image/* | 2MB | ✅ Yes |

### **Preview IDs:**
- `preview_ttd_kepsek` - Preview Kepala Sekolah
- `preview_ttd_guru` - Preview Guru

---

## 🎯 **Keunggulan**

### **Dibanding Tanda Tangan Manual:**
1. ✅ **Digital** - Tidak perlu scan dokumen
2. ✅ **Cepat** - Upload langsung dari file
3. ✅ **Praktis** - Bisa upload dari HP/PC
4. ✅ **Preview** - Lihat hasil sebelum simpan
5. ✅ **Fleksibel** - Bisa ganti kapan saja

### **User Experience:**
- Guru bisa upload tanda tangan yang sudah di-scan
- Kepala Sekolah bisa upload tanda tangan + stempel
- Preview real-time untuk memastikan gambar benar
- Success message untuk konfirmasi

---

## 📸 **Cara Mendapatkan Tanda Tangan Digital**

### **Opsi 1: Scan Tanda Tangan Manual**
1. Tanda tangan di kertas putih
2. Scan menggunakan scanner/HP
3. Crop gambar agar hanya tanda tangan
4. Save sebagai JPG/PNG

### **Opsi 2: Tanda Tangan Digital**
1. Gunakan tablet/stylus
2. Tanda tangan di aplikasi drawing
3. Export sebagai image
4. Upload ke RPP

### **Opsi 3: Foto Tanda Tangan**
1. Tanda tangan di kertas putih
2. Foto dengan HP (cahaya terang)
3. Crop dan edit (brightness/contrast)
4. Save dan upload

---

## ⏰ **Langkah Selanjutnya**

### **1. Tunggu Railway Deploy (±3-5 menit)**
   - Buka: https://railway.app
   - Tab **Deployments**
   - Tunggu status **"Success"** ✅

### **2. Verifikasi di Railway**
   - Login sebagai Guru
   - Buka halaman **Buat RPP**
   - Scroll ke bagian **"Pengesahan"**
   - Lihat **2 upload inputs** muncul

### **3. Test Upload**
   - Siapkan gambar tanda tangan (JPG/PNG)
   - Klik "Choose File" untuk Kepala Sekolah
   - Pilih gambar
   - Lihat **preview muncul otomatis**
   - Klik "Choose File" untuk Guru
   - Pilih gambar
   - Lihat **preview muncul otomatis**

### **4. Test Simpan**
   - Isi semua field RPP
   - Upload kedua tanda tangan
   - Klik **Simpan RPP**
   - Cek apakah gambar tersimpan

---

## 🔧 **Backend Requirements (Next Step)**

**PENTING:** Fitur frontend sudah siap, tapi perlu update backend untuk menyimpan file!

### **Yang Perlu Ditambahkan di Controller:**

```php
// RppController.php - store method
public function store(Request $request) {
    // Validate
    $request->validate([
        'ttd_kepala_sekolah' => 'nullable|image|max:2048',
        'ttd_guru' => 'nullable|image|max:2048',
        // ... other fields
    ]);
    
    // Upload files
    $ttdKepsekPath = null;
    if ($request->hasFile('ttd_kepala_sekolah')) {
        $ttdKepsekPath = $request->file('ttd_kepala_sekolah')
            ->store('signatures/kepala_sekolah', 'public');
    }
    
    $ttdGuruPath = null;
    if ($request->hasFile('ttd_guru')) {
        $ttdGuruPath = $request->file('ttd_guru')
            ->store('signatures/guru', 'public');
    }
    
    // Save to database
    Rpp::create([
        'ttd_kepala_sekolah' => $ttdKepsekPath,
        'ttd_guru' => $ttdGuruPath,
        // ... other fields
    ]);
}
```

### **Database Migration:**
```php
Schema::table('rpps', function (Blueprint $table) {
    $table->string('ttd_kepala_sekolah')->nullable();
    $table->string('ttd_guru')->nullable();
});
```

---

## 📝 **Catatan Penting**

### **File Upload:**
- Format: JPG, PNG, GIF, WEBP
- Max size: 2MB
- Recommended: 500x200px (landscape)
- Background: Transparent atau putih

### **Preview:**
- Preview menggunakan FileReader API
- Tidak upload ke server sampai form di-submit
- Preview hanya di browser (client-side)

### **Storage:**
- File akan disimpan di `storage/app/public/signatures/`
- Perlu `php artisan storage:link` di server
- Path disimpan di database

---

## 🎉 **Kesimpulan**

**Upload foto tanda tangan digital sudah ditambahkan!**

- ✅ 2 upload inputs (Kepala Sekolah & Guru)
- ✅ Preview real-time dengan JavaScript
- ✅ Accept image files (JPG, PNG)
- ✅ Max size 2MB
- ✅ Success message setelah upload
- ✅ Form enctype multipart/form-data

**Tunggu Railway selesai deploy (±3-5 menit), lalu buka halaman Buat RPP untuk test upload tanda tangan!** 📸🚀

---

**Dibuat:** 2025-12-31 15:13  
**Status:** ✅ Complete (Frontend)  
**Commit:** `5c3ab31` - Add digital signature upload  
**Lines Changed:** +40, -14 (net +26)  
**Next:** Update backend controller untuk save files
