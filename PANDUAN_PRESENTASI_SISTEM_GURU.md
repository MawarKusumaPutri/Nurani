# 🎤 PANDUAN PRESENTASI: Sistem Guru di TMS NURANI

## 📋 OUTLINE PRESENTASI

Ketika dosen bertanya: **"Bagaimana cara membuat fitur untuk Guru?"**

Jawab dengan struktur ini:
1. **Konsep Dasar** (2 menit)
2. **Database Structure** (3 menit)
3. **Implementasi Step-by-Step** (10 menit)
4. **Demo Fitur** (5 menit)

---

## 🎯 BAGIAN 1: KONSEP DASAR (Jawaban Pembuka)

### **Jawaban Anda:**

> "Pak/Bu, untuk membuat fitur Guru di sistem TMS NURANI, saya menggunakan **konsep Multi-Role Authentication** dengan Laravel. 
> 
> Sistemnya terdiri dari **3 komponen utama**:
> 1. **Database** - Menyimpan data user dan guru
> 2. **Authentication** - Untuk login berdasarkan role
> 3. **Authorization** - Untuk membatasi akses fitur
>
> Saya akan jelaskan step-by-step dari database sampai implementasi fitur."

---

## 🎯 BAGIAN 2: DATABASE STRUCTURE

### **Penjelasan Anda:**

> "Pertama, saya buat **2 tabel utama**:"

### **Tabel 1: `users` (Untuk Login)**

**Tampilkan di slide/whiteboard:**
```
┌─────────────────────────────────┐
│         TABEL USERS             │
├─────────────────────────────────┤
│ id          → Primary Key       │
│ name        → Nama lengkap      │
│ email       → Email (unique)    │
│ password    → Password (hashed) │
│ role        → guru/tu/kepsek    │
│ created_at  → Timestamp         │
│ updated_at  → Timestamp         │
└─────────────────────────────────┘
```

**Jelaskan:**
> "Tabel `users` ini untuk **authentication**. Setiap user punya role yang berbeda: guru, tenaga usaha, atau kepala sekolah."

### **Tabel 2: `gurus` (Data Detail Guru)**

```
┌─────────────────────────────────┐
│         TABEL GURUS             │
├─────────────────────────────────┤
│ id              → Primary Key   │
│ user_id         → Foreign Key   │
│ nip             → NIP Guru      │
│ mata_pelajaran  → Mapel         │
│ foto            → Path foto     │
│ status          → aktif/nonaktif│
└─────────────────────────────────┘
```

**Jelaskan:**
> "Tabel `gurus` untuk **data detail**. Kenapa dipisah? Karena tidak semua user adalah guru. Dengan begini, struktur database lebih **fleksibel** dan **scalable**."

### **Relasi Antar Tabel:**

```
┌──────────┐         ┌──────────┐
│  users   │ 1     1 │  gurus   │
│          │◄────────│          │
│ id (PK)  │         │ user_id  │
└──────────┘         └──────────┘
    One-to-One Relationship
```

**Jelaskan:**
> "Relasinya **One-to-One**. Satu user guru punya satu data detail di tabel gurus."

---

## 🎯 BAGIAN 3: IMPLEMENTASI STEP-BY-STEP

### **Step 1: Migration (Buat Tabel)**

**Jelaskan:**
> "Pertama, saya buat migration untuk membuat tabel di database."

**Tunjukkan code:**
```php
// database/migrations/xxxx_create_users_table.php

public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['guru', 'tu', 'kepala_sekolah']);
        $table->timestamps();
    });
}
```

**Poin penting:**
- `enum('role')` → Membatasi nilai hanya guru/tu/kepala_sekolah
- `unique()` → Email harus unik, tidak boleh duplikat

---

### **Step 2: Model (Representasi Tabel di Code)**

**Jelaskan:**
> "Kedua, saya buat Model untuk merepresentasikan tabel di code."

**Tunjukkan code:**
```php
// app/Models/User.php

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi ke Guru
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    // Helper method untuk cek role
    public function isGuru()
    {
        return $this->role === 'guru';
    }
}
```

**Poin penting:**
- `hasOne(Guru::class)` → Relasi One-to-One
- `isGuru()` → Helper method untuk cek role dengan mudah

---

### **Step 3: Authentication (Login)**

**Jelaskan:**
> "Ketiga, saya buat sistem login yang membedakan role."

**Tunjukkan code:**
```php
// app/Http/Controllers/AuthController.php

public function login(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:guru,tu,kepala_sekolah',
    ]);

    // 2. Cek kredensial
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role,
    ];

    // 3. Attempt login
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // 4. Redirect berdasarkan role
        if ($user->isGuru()) {
            // Cek apakah data guru ada
            if (!$user->guru) {
                Auth::logout();
                return back()->with('error', 'Data guru tidak ditemukan');
            }
            return redirect()->route('guru.dashboard');
        }
        // ... role lainnya
    }

    return back()->with('error', 'Email atau password salah');
}
```

**Poin penting:**
- `Auth::attempt()` → Laravel otomatis cek email, password, dan hash
- Validasi role → Pastikan user login dengan role yang benar
- Cek relasi → Pastikan data guru ada sebelum redirect

---

### **Step 4: Middleware (Proteksi Akses)**

**Jelaskan:**
> "Keempat, saya buat middleware untuk **proteksi akses**. Hanya guru yang bisa akses fitur guru."

**Tunjukkan code:**
```php
// app/Http/Middleware/CheckRole.php

public function handle(Request $request, Closure $next, string $role)
{
    // Cek apakah user sudah login
    if (!Auth::check()) {
        return redirect()->route('login')
            ->with('error', 'Silakan login terlebih dahulu');
    }

    // Cek apakah role user sesuai
    if (Auth::user()->role !== $role) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini');
    }

    return $next($request);
}
```

**Poin penting:**
- Middleware = **gatekeeper** yang cek hak akses
- Jika role tidak sesuai → Error 403 Forbidden

---

### **Step 5: Routing (URL untuk Guru)**

**Jelaskan:**
> "Kelima, saya buat routing khusus untuk guru dengan middleware."

**Tunjukkan code:**
```php
// routes/web.php

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [GuruController::class, 'dashboard'])
            ->name('dashboard');
        
        // RPP
        Route::get('/rpp', [GuruController::class, 'rpp'])
            ->name('rpp');
        Route::get('/rpp/create', [RppController::class, 'create'])
            ->name('rpp.create');
        Route::post('/rpp', [RppController::class, 'store'])
            ->name('rpp.store');
        
        // Materi
        Route::get('/materi', [MateriController::class, 'index'])
            ->name('materi');
        
        // Kuis
        Route::get('/kuis', [KuisController::class, 'index'])
            ->name('kuis');
        
        // ... fitur lainnya
    });
```

**Poin penting:**
- `middleware(['auth', 'role:guru'])` → Harus login DAN role harus guru
- `prefix('guru')` → Semua URL dimulai dengan `/guru/`
- `name('guru.')` → Semua route name dimulai dengan `guru.`

**Contoh URL yang dihasilkan:**
- `/guru/dashboard` → Dashboard guru
- `/guru/rpp/create` → Buat RPP baru
- `/guru/materi` → Daftar materi

---

### **Step 6: Controller (Logic Fitur)**

**Jelaskan:**
> "Keenam, saya buat controller untuk handle logic setiap fitur."

**Contoh: Fitur Buat RPP**

**Tunjukkan code:**
```php
// app/Http/Controllers/RppController.php

public function create(Request $request)
{
    // 1. Ambil data guru yang sedang login
    $guru = Guru::where('user_id', Auth::id())->first();
    
    if (!$guru) {
        return redirect()->route('login')
            ->with('error', 'Data guru tidak ditemukan');
    }

    // 2. Ambil parameter dari URL
    $mataPelajaran = $request->query('mata_pelajaran');
    $pertemuanKe = $request->query('pertemuan_ke', 1);

    // 3. Tampilkan form create RPP
    return view('guru.rpp.create', [
        'guru' => $guru,
        'mataPelajaran' => $mataPelajaran,
        'pertemuanKe' => $pertemuanKe,
    ]);
}

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
        // ... field lainnya
    ]);

    // 3. Cek apakah RPP sudah ada
    $existingRpp = Rpp::where('guru_id', $guru->id)
        ->where('mata_pelajaran', $validated['mata_pelajaran'])
        ->where('pertemuan_ke', $validated['pertemuan_ke'])
        ->first();

    if ($existingRpp) {
        return redirect()->back()
            ->with('error', 'RPP untuk pertemuan ini sudah ada')
            ->withInput();
    }

    // 4. Simpan RPP
    $validated['guru_id'] = $guru->id;
    $rpp = Rpp::create($validated);

    // 5. Redirect dengan pesan sukses
    return redirect()->route('guru.dashboard')
        ->with('success', 'RPP berhasil dibuat!');
}
```

**Poin penting:**
- Selalu **cek data guru** ada atau tidak
- **Validasi input** untuk keamanan
- **Cek duplikasi** sebelum simpan
- **Redirect dengan message** untuk user feedback

---

### **Step 7: View (Tampilan)**

**Jelaskan:**
> "Ketujuh, saya buat view untuk tampilan form dan dashboard."

**Contoh: Form Create RPP**

**Tunjukkan code:**
```blade
{{-- resources/views/guru/rpp/create.blade.php --}}

<form action="{{ route('guru.rpp.store') }}" method="POST">
    @csrf
    
    {{-- Judul RPP --}}
    <label>Judul RPP <span class="text-danger">*</span></label>
    <input type="text" name="judul" 
           value="{{ old('judul', 'RPP ' . $mataPelajaran . ' Pertemuan ' . $pertemuanKe) }}" 
           required>
    @error('judul')
        <div class="error">{{ $message }}</div>
    @enderror

    {{-- Mata Pelajaran --}}
    <label>Mata Pelajaran <span class="text-danger">*</span></label>
    <input type="text" name="mata_pelajaran" 
           value="{{ $mataPelajaran }}" 
           readonly>

    {{-- Kelas --}}
    <label>Kelas <span class="text-danger">*</span></label>
    <select name="kelas" required>
        <option value="">Pilih Kelas</option>
        <option value="VII">Kelas 7</option>
        <option value="VIII">Kelas 8</option>
        <option value="IX">Kelas 9</option>
    </select>

    {{-- ... field lainnya --}}

    <button type="submit">Simpan RPP</button>
</form>
```

**Poin penting:**
- `@csrf` → Token untuk keamanan
- `old()` → Isi ulang form jika ada error
- `@error` → Tampilkan pesan error validasi
- `required` → Validasi di browser

---

## 🎯 BAGIAN 4: FITUR-FITUR GURU

### **Daftar Fitur yang Sudah Dibuat:**

**Jelaskan:**
> "Di sistem TMS NURANI, guru punya beberapa fitur utama:"

1. **Dashboard**
   - Lihat ringkasan materi, kuis, presensi
   - Switch antar mata pelajaran (jika guru mengajar >1 mapel)

2. **RPP (Rencana Pelaksanaan Pembelajaran)**
   - Buat RPP per pertemuan (1-16)
   - Edit RPP yang sudah ada
   - Cetak RPP untuk ditandatangani

3. **Materi Pembelajaran**
   - Upload materi (PDF, PPT, video)
   - Atur urutan materi
   - Publish/unpublish materi

4. **Kuis**
   - Buat kuis dengan berbagai jenis soal (pilihan ganda, essay)
   - Set durasi dan deadline
   - Lihat hasil kuis siswa

5. **Presensi**
   - Isi presensi siswa per pertemuan
   - Rekap presensi bulanan

6. **Evaluasi**
   - Input nilai siswa
   - Lihat statistik nilai

---

## 🎯 BAGIAN 5: DEMO FITUR (Jika Diminta)

### **Skenario Demo:**

**1. Login sebagai Guru**
```
Email: desinurfalah24@gmail.com
Password: desi123456
Role: Guru
```

**2. Tampilkan Dashboard**
- Tunjukkan data yang muncul
- Jelaskan setiap section

**3. Buat RPP Baru**
- Klik "Buat RPP"
- Isi form
- Klik "Simpan"
- Tunjukkan pesan sukses

**4. Lihat Data yang Tersimpan**
- Buka database (phpMyAdmin)
- Tunjukkan data di tabel `rpps`

---

## 🎯 PERTANYAAN YANG MUNGKIN DITANYA DOSEN

### **Q1: "Kenapa tabel users dan gurus dipisah?"**

**Jawaban:**
> "Pak/Bu, saya pisahkan karena:
> 1. **Separation of Concerns** - Tabel users untuk authentication, gurus untuk data detail
> 2. **Fleksibilitas** - Tidak semua user adalah guru (ada TU, kepala sekolah)
> 3. **Scalability** - Mudah menambah role baru tanpa ubah struktur users
> 4. **Best Practice** - Sesuai dengan prinsip database normalization"

---

### **Q2: "Bagaimana cara memastikan hanya guru yang bisa akses fitur guru?"**

**Jawaban:**
> "Pak/Bu, saya pakai **3 layer proteksi**:
> 
> 1. **Middleware di Route**
>    ```php
>    Route::middleware(['auth', 'role:guru'])
>    ```
>    Ini cek apakah user login DAN role-nya guru
> 
> 2. **Cek di Controller**
>    ```php
>    if (!Auth::user()->isGuru()) {
>        abort(403);
>    }
>    ```
>    Double check di controller
> 
> 3. **Cek di Blade**
>    ```blade
>    @if(Auth::user()->isGuru())
>        {{-- Tampilkan konten --}}
>    @endif
>    ```
>    Sembunyikan konten jika bukan guru"

---

### **Q3: "Bagaimana cara handle jika guru mengajar lebih dari 1 mata pelajaran?"**

**Jawaban:**
> "Pak/Bu, di database saya simpan mata pelajaran sebagai **string dengan separator koma**:
> 
> ```
> mata_pelajaran: 'Matematika, IPA, Bahasa Indonesia'
> ```
> 
> Lalu di controller, saya **split** jadi array:
> ```php
> $mataPelajaranList = explode(',', $guru->mata_pelajaran);
> ```
> 
> Di dashboard, guru bisa **switch** antar mata pelajaran dengan dropdown."

---

### **Q4: "Bagaimana cara validasi agar RPP tidak duplikat?"**

**Jawaban:**
> "Pak/Bu, sebelum simpan RPP, saya cek dulu di database:
> 
> ```php
> $existingRpp = Rpp::where('guru_id', $guru->id)
>     ->where('mata_pelajaran', $mataPelajaran)
>     ->where('pertemuan_ke', $pertemuanKe)
>     ->first();
> 
> if ($existingRpp) {
>     return back()->with('error', 'RPP sudah ada');
> }
> ```
> 
> Jadi **kombinasi** guru_id + mata_pelajaran + pertemuan_ke harus **unik**."

---

### **Q5: "Bagaimana cara testing fitur ini?"**

**Jawaban:**
> "Pak/Bu, saya testing dengan **3 cara**:
> 
> 1. **Manual Testing**
>    - Login sebagai guru
>    - Coba semua fitur satu per satu
>    - Cek apakah data tersimpan di database
> 
> 2. **Browser Testing**
>    - Buka Developer Console (F12)
>    - Cek Network tab untuk request/response
>    - Cek Console tab untuk JavaScript error
> 
> 3. **Database Testing**
>    - Buka phpMyAdmin
>    - Cek data yang tersimpan
>    - Cek relasi antar tabel"

---

## 🎯 TIPS PRESENTASI

### **DO's (Yang Harus Dilakukan):**

✅ **Jelaskan dengan struktur yang jelas**
   - Mulai dari konsep → database → implementasi → demo

✅ **Gunakan analogi sederhana**
   - "Middleware itu seperti satpam yang cek kartu identitas"
   - "Relasi One-to-One seperti KTP dan orang, 1 orang = 1 KTP"

✅ **Tunjukkan code yang penting**
   - Jangan tunjukkan semua code
   - Fokus ke logic utama

✅ **Siapkan demo yang berfungsi**
   - Test dulu sebelum presentasi
   - Siapkan data dummy yang bagus

✅ **Jawab dengan percaya diri**
   - Jika tidak tahu, bilang "Saya belum explore itu, tapi saya akan pelajari"

---

### **DON'Ts (Yang Harus Dihindari):**

❌ **Jangan langsung ke code tanpa konsep**
   - Dosen ingin tahu Anda paham konsep, bukan cuma copy-paste

❌ **Jangan pakai istilah yang terlalu teknis**
   - Jelaskan dengan bahasa yang mudah dipahami

❌ **Jangan demo fitur yang error**
   - Test dulu sebelum presentasi

❌ **Jangan bilang "Saya tidak tahu" tanpa elaborasi**
   - Lebih baik: "Saya belum explore itu, tapi menurut saya bisa pakai cara X"

---

## 📝 CHECKLIST SEBELUM PRESENTASI

- [ ] Pastikan ngrok running
- [ ] Pastikan bisa login sebagai guru
- [ ] Pastikan semua fitur berfungsi
- [ ] Siapkan data dummy yang bagus (RPP, materi, kuis)
- [ ] Buka phpMyAdmin untuk tunjukkan database
- [ ] Buka code editor untuk tunjukkan code
- [ ] Latihan presentasi minimal 2x

---

## 🎓 PENUTUP

**Kesimpulan yang bisa Anda sampaikan:**

> "Jadi Pak/Bu, untuk membuat fitur Guru di TMS NURANI, saya menggunakan **konsep Multi-Role Authentication** dengan Laravel.
> 
> Prosesnya dimulai dari **database design** yang terstruktur, lalu **authentication** untuk login, **middleware** untuk proteksi akses, **routing** untuk URL management, **controller** untuk business logic, dan **view** untuk tampilan.
> 
> Dengan struktur ini, sistem menjadi **secure**, **scalable**, dan **maintainable**. Terima kasih."

---

**Dibuat oleh:** Antigravity AI Assistant  
**Untuk:** Presentasi TMS NURANI  
**Tanggal:** 14 Januari 2026

**Good luck dengan presentasinya!** 🚀🎓
