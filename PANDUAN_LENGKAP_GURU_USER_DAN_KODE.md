# 📚 PANDUAN LENGKAP FITUR GURU (USER + KODE)
## TMS NURANI - MTs Nurul Aiman

> **Catatan:** File ini menggabungkan panduan pengguna dengan penjelasan kode teknis untuk setiap fitur

---

## 📖 DAFTAR ISI

1. [Fitur RPP](#fitur-rpp)
2. [Fitur Materi Pembelajaran](#fitur-materi-pembelajaran)
3. [Fitur Kuis](#fitur-kuis)
4. [Fitur Presensi](#fitur-presensi)
5. [Fitur Evaluasi](#fitur-evaluasi)

---

## 1. FITUR RPP

### 📱 CARA PAKAI (Untuk Guru)

**Langkah-langkah Membuat RPP:**
1. Klik menu "RPP" di sidebar
2. Klik tombol "Buat RPP Baru"
3. Pilih Mata Pelajaran dan Pertemuan Ke-
4. Isi semua field form (Identitas, KI, KD, Materi, dll)
5. Klik "Simpan RPP"
6. Tunggu loading, lalu redirect ke dashboard

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE rpps (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    guru_id BIGINT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    kelas VARCHAR(50) NOT NULL,
    semester VARCHAR(50) NOT NULL,
    pertemuan_ke INT NOT NULL,
    alokasi_waktu INT NOT NULL,
    -- Kompetensi Inti
    ki_1 TEXT,
    ki_2 TEXT,
    ki_3 TEXT,
    ki_4 TEXT,
    -- Kompetensi Dasar
    kd_pengetahuan TEXT,
    kd_keterampilan TEXT,
    -- Materi
    materi_pembelajaran TEXT,
    -- Kegiatan
    kegiatan_pendahuluan TEXT,
    kegiatan_inti TEXT,
    kegiatan_penutup TEXT,
    -- Penilaian
    teknik_penilaian TEXT,
    -- Pengesahan
    nama_kepala_sekolah VARCHAR(255),
    nip_kepala_sekolah VARCHAR(255),
    ttd_kepala_sekolah VARCHAR(255),
    ttd_guru VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES gurus(id)
);
```

**Penjelasan:**
- `guru_id` → ID guru yang membuat RPP (relasi ke tabel gurus)
- `pertemuan_ke` → Nomor pertemuan (1-16)
- `ki_1` sampai `ki_4` → Kompetensi Inti
- `ttd_kepala_sekolah` & `ttd_guru` → Path file tanda tangan

---

#### **B. Model Rpp**

**File:** `app/Models/Rpp.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpp extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'guru_id',
        'judul',
        'mata_pelajaran',
        'kelas',
        'semester',
        'pertemuan_ke',
        'alokasi_waktu',
        'ki_1', 'ki_2', 'ki_3', 'ki_4',
        'kd_pengetahuan',
        'kd_keterampilan',
        'materi_pembelajaran',
        'kegiatan_pendahuluan',
        'kegiatan_inti',
        'kegiatan_penutup',
        'teknik_penilaian',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'ttd_kepala_sekolah',
        'ttd_guru',
    ];

    /**
     * Relasi ke Guru
     * Satu RPP dimiliki oleh satu Guru
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
```

**Penjelasan:**
- `$fillable` → Daftar field yang boleh diisi via `Rpp::create()`
- `guru()` → Method untuk ambil data guru pemilik RPP
- `belongsTo` → Relasi Many-to-One (banyak RPP → satu Guru)

---

#### **C. Controller - Create RPP**

**File:** `app/Http/Controllers/RppController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Rpp;

class RppController extends Controller
{
    /**
     * Tampilkan form create RPP
     */
    public function create(Request $request)
    {
        // 1. Ambil data guru yang sedang login
        $guru = Guru::where('user_id', Auth::id())->first();
        
        // 2. Cek apakah data guru ada
        if (!$guru) {
            return redirect()->route('login')
                ->with('error', 'Data guru tidak ditemukan');
        }

        // 3. Ambil parameter dari URL
        $mataPelajaran = $request->query('mata_pelajaran');
        $pertemuanKe = $request->query('pertemuan_ke', 1);

        // 4. Return view dengan data
        return view('guru.rpp.create', [
            'guru' => $guru,
            'mataPelajaran' => $mataPelajaran,
            'pertemuanKe' => $pertemuanKe,
        ]);
    }
}
```

**Penjelasan:**
- `Auth::id()` → Ambil ID user yang sedang login
- `Guru::where('user_id', Auth::id())->first()` → Cari data guru berdasarkan user_id
- `$request->query('mata_pelajaran')` → Ambil parameter dari URL (contoh: `?mata_pelajaran=Matematika`)
- `return view()` → Tampilkan halaman form create RPP

---

#### **D. Controller - Store RPP**

```php
/**
 * Simpan RPP baru
 */
public function store(Request $request)
{
    // 1. Ambil data guru
    $guru = Guru::where('user_id', Auth::id())->first();
    
    if (!$guru) {
        return redirect()->route('login')
            ->with('error', 'Data guru tidak ditemukan');
    }

    // 2. Validasi input
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'mata_pelajaran' => 'required|string|max:255',
        'kelas' => 'required|string|max:50',
        'semester' => 'required|string|max:50',
        'pertemuan_ke' => 'required|integer|min:1',
        'alokasi_waktu' => 'required|integer|min:1',
        'ki_1' => 'nullable|string',
        'ki_2' => 'nullable|string',
        // ... field lainnya
        'nama_kepala_sekolah' => 'required|string|max:255',
        'nip_kepala_sekolah' => 'required|string|max:255',
        'ttd_kepala_sekolah' => 'nullable|image|max:2048',
        'ttd_guru' => 'nullable|image|max:2048',
    ]);

    // 3. Cek duplikasi
    $existingRpp = Rpp::where('guru_id', $guru->id)
        ->where('mata_pelajaran', $validated['mata_pelajaran'])
        ->where('pertemuan_ke', $validated['pertemuan_ke'])
        ->first();

    if ($existingRpp) {
        return redirect()->back()
            ->with('error', 'RPP untuk pertemuan ini sudah ada')
            ->withInput();
    }

    // 4. Tambahkan guru_id
    $validated['guru_id'] = $guru->id;

    // 5. Handle file upload
    if ($request->hasFile('ttd_kepala_sekolah')) {
        $validated['ttd_kepala_sekolah'] = $request->file('ttd_kepala_sekolah')
            ->store('signatures/kepala_sekolah', 'public');
    }

    if ($request->hasFile('ttd_guru')) {
        $validated['ttd_guru'] = $request->file('ttd_guru')
            ->store('signatures/guru', 'public');
    }

    // 6. Simpan RPP
    $rpp = Rpp::create($validated);

    // 7. Redirect dengan pesan sukses
    return redirect()->route('guru.dashboard', [
            'mata_pelajaran' => $validated['mata_pelajaran']
        ])
        ->with('success', 'RPP Pertemuan ' . $validated['pertemuan_ke'] . ' berhasil dibuat!');
}
```

**Penjelasan:**
- `$request->validate()` → Validasi semua input dari form
- `'required'` → Field harus diisi
- `'nullable'` → Field boleh kosong
- `'image|max:2048'` → File harus gambar, max 2MB
- `Rpp::where()->first()` → Cek apakah RPP sudah ada
- `$request->hasFile()` → Cek apakah ada file yang diupload
- `->store('signatures/kepala_sekolah', 'public')` → Simpan file ke `storage/app/public/signatures/kepala_sekolah/`
- `Rpp::create($validated)` → Simpan data ke database
- `->with('success', '...')` → Set flash message sukses

---

#### **E. View - Form Create RPP**

**File:** `resources/views/guru/rpp/create.blade.php`

```blade
<form action="{{ route('guru.rpp.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    {{-- Identitas --}}
    <div class="mb-3">
        <label class="form-label">Judul RPP <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="judul" 
               value="{{ old('judul', 'RPP ' . $mataPelajaran . ' Pertemuan ' . $pertemuanKe) }}" 
               required>
        @error('judul')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="mata_pelajaran" 
               value="{{ $mataPelajaran }}" readonly required>
    </div>

    <div class="mb-3">
        <label class="form-label">Kelas <span class="text-danger">*</span></label>
        <select class="form-control" name="kelas" required>
            <option value="">Pilih Kelas</option>
            <option value="VII">Kelas 7</option>
            <option value="VIII">Kelas 8</option>
            <option value="IX">Kelas 9</option>
        </select>
    </div>

    {{-- Upload TTD --}}
    <div class="mb-3">
        <label class="form-label">Upload TTD Kepala Sekolah</label>
        <input type="file" class="form-control" name="ttd_kepala_sekolah" 
               accept="image/*" onchange="previewSignature(this, 'preview_ttd_kepsek')">
        <div id="preview_ttd_kepsek" class="mt-2"></div>
    </div>

    <button type="submit" class="btn btn-primary" id="submitBtn">
        <i class="fas fa-save me-2"></i>Simpan RPP
    </button>
</form>

<script>
// Preview image sebelum upload
function previewSignature(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" 
                     style="max-width: 100%; max-height: 150px;">
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle form submission
document.querySelector('form').addEventListener('submit', function(e) {
    // Show loading
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
});
</script>
```

**Penjelasan:**
- `@csrf` → Token keamanan Laravel (wajib ada di setiap form POST)
- `action="{{ route('guru.rpp.store') }}"` → URL tujuan submit form
- `method="POST"` → Method HTTP untuk submit
- `enctype="multipart/form-data"` → Wajib ada jika ada file upload
- `name="judul"` → Nama field yang akan dikirim ke controller
- `value="{{ old('judul', '...') }}"` → Isi ulang form jika ada error
- `@error('judul')` → Tampilkan pesan error validasi
- `required` → Validasi HTML5 (field harus diisi)
- `onchange="previewSignature()"` → Jalankan fungsi JavaScript saat file dipilih
- `FileReader()` → JavaScript API untuk baca file
- `readAsDataURL()` → Convert file jadi base64 untuk preview

---

#### **F. Routing**

**File:** `routes/web.php`

```php
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        
        // RPP Routes
        Route::get('/rpp/create', [RppController::class, 'create'])
            ->name('rpp.create');
        Route::post('/rpp', [RppController::class, 'store'])
            ->name('rpp.store');
    });
```

**Penjelasan:**
- `middleware(['auth', 'role:guru'])` → Harus login DAN role harus guru
- `prefix('guru')` → Semua URL dimulai dengan `/guru/`
- `name('guru.')` → Semua route name dimulai dengan `guru.`
- `Route::get()` → HTTP GET (untuk tampilkan halaman)
- `Route::post()` → HTTP POST (untuk submit form)
- URL yang dihasilkan:
  - GET `/guru/rpp/create` → Tampilkan form
  - POST `/guru/rpp` → Simpan data

---

### 🔄 FLOW LENGKAP FITUR RPP

```
1. User klik "Buat RPP" di browser
   ↓
2. Browser kirim request GET ke /guru/rpp/create
   ↓
3. Middleware cek: Sudah login? Role = guru?
   ↓
4. RppController@create dijalankan
   ↓
5. Ambil data guru dari database
   ↓
6. Tampilkan view form create.blade.php
   ↓
7. User isi form dan klik "Simpan"
   ↓
8. Browser kirim request POST ke /guru/rpp
   ↓
9. Middleware cek lagi
   ↓
10. RppController@store dijalankan
    ↓
11. Validasi input
    ↓
12. Cek duplikasi
    ↓
13. Upload file (jika ada)
    ↓
14. Simpan ke database
    ↓
15. Redirect ke dashboard dengan pesan sukses
```

---

## 2. FITUR MATERI PEMBELAJARAN

### 📱 CARA PAKAI (Untuk Guru)

**Langkah-langkah Edit Materi:**
1. Klik menu "Dashboard"
2. Scroll ke section "Materi Pembelajaran"
3. Klik tombol "Edit Materi"
4. Isi/Edit 8 section (Identitas, KI, Unit, dll)
5. Klik "Simpan Materi"

---

### 💻 PENJELASAN KODE

#### **A. Database Structure**

```sql
CREATE TABLE materi_pembelajaran (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    guru_id BIGINT NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    identitas_sekolah_program TEXT,
    kompetensi_inti_capaian TEXT,
    unit_pembelajaran TEXT,
    pendekatan_pembelajaran TEXT,
    model_pembelajaran TEXT,
    kegiatan_pembelajaran TEXT,
    penilaian TEXT,
    sarana_prasarana TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES gurus(id)
);
```

---

#### **B. Model MateriPembelajaran**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran',
        'identitas_sekolah_program',
        'kompetensi_inti_capaian',
        'unit_pembelajaran',
        'pendekatan_pembelajaran',
        'model_pembelajaran',
        'kegiatan_pembelajaran',
        'penilaian',
        'sarana_prasarana',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
```

---

#### **C. Controller - Update Materi**

```php
public function update(Request $request)
{
    $guru = Guru::where('user_id', Auth::id())->first();
    
    $validated = $request->validate([
        'mata_pelajaran' => 'required|string|max:255',
        'identitas_sekolah_program' => 'nullable|string',
        'kompetensi_inti_capaian' => 'nullable|string',
        'unit_pembelajaran' => 'nullable|string',
        'pendekatan_pembelajaran' => 'nullable|string',
        'model_pembelajaran' => 'nullable|string',
        'kegiatan_pembelajaran' => 'nullable|string',
        'penilaian' => 'nullable|string',
        'sarana_prasarana' => 'nullable|string',
    ]);

    // Update or Create
    $materi = MateriPembelajaran::updateOrCreate(
        [
            'guru_id' => $guru->id,
            'mata_pelajaran' => $validated['mata_pelajaran'],
        ],
        $validated
    );

    return redirect()->route('guru.dashboard')
        ->with('success', 'Materi berhasil disimpan!');
}
```

**Penjelasan:**
- `updateOrCreate()` → Jika data sudah ada, update. Jika belum, create baru.
- Parameter pertama → Kondisi untuk cari data
- Parameter kedua → Data yang akan disimpan

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0

---

> **Catatan:** File ini fokus ke fitur-fitur utama Guru dengan penjelasan kode. Untuk fitur lainnya (Kuis, Presensi, Evaluasi), polanya sama dengan RPP dan Materi.
