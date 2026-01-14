# 📊 SLIDE DECK OUTLINE: Sistem Guru TMS NURANI

## 🎯 Untuk PowerPoint Presentasi

---

## SLIDE 1: COVER
```
┌─────────────────────────────────────────┐
│                                         │
│   SISTEM MANAJEMEN GURU                 │
│   TMS NURANI - MTs Nurul Aiman          │
│                                         │
│   Multi-Role Authentication System      │
│   dengan Laravel Framework              │
│                                         │
│   Oleh: [Nama Anda]                     │
│   NIM: [NIM Anda]                       │
│                                         │
└─────────────────────────────────────────┘
```

---

## SLIDE 2: AGENDA
```
📋 AGENDA PRESENTASI

1. Latar Belakang & Tujuan
2. Konsep Multi-Role System
3. Database Architecture
4. Implementasi Authentication
5. Fitur-Fitur Guru
6. Demo Aplikasi
7. Kesimpulan & Q&A
```

---

## SLIDE 3: LATAR BELAKANG
```
🎯 LATAR BELAKANG

Masalah:
• Sekolah butuh sistem digital untuk kelola pembelajaran
• Guru, TU, dan Kepala Sekolah punya kebutuhan berbeda
• Butuh sistem yang aman dan terstruktur

Solusi:
• Sistem Multi-Role dengan Laravel
• Setiap role punya akses dan fitur berbeda
• Database terstruktur dan scalable
```

---

## SLIDE 4: KONSEP MULTI-ROLE
```
🔐 KONSEP MULTI-ROLE SYSTEM

┌─────────────┐
│   SISTEM    │
└──────┬──────┘
       │
   ┌───┴───┬───────┬──────────┐
   │       │       │          │
┌──▼──┐ ┌──▼──┐ ┌──▼──────┐
│GURU │ │ TU  │ │ KEPSEK  │
└─────┘ └─────┘ └─────────┘
   │       │         │
   ▼       ▼         ▼
 RPP    Siswa    Laporan
Materi  Jadwal   Evaluasi
 Kuis   Guru     Approval
```

---

## SLIDE 5: DATABASE ARCHITECTURE
```
📊 DATABASE STRUCTURE

┌──────────────┐         ┌──────────────┐
│    USERS     │         │    GURUS     │
├──────────────┤         ├──────────────┤
│ id (PK)      │◄────────│ user_id (FK) │
│ name         │   1:1   │ nip          │
│ email        │         │ mata_pelajaran│
│ password     │         │ foto         │
│ role         │         │ status       │
└──────────────┘         └──────────────┘

Kenapa Dipisah?
✓ Separation of Concerns
✓ Fleksibilitas
✓ Scalability
✓ Best Practice
```

---

## SLIDE 6: AUTHENTICATION FLOW
```
🔑 AUTHENTICATION FLOW

1. User Input
   ↓
   [Email, Password, Role]
   
2. Validation
   ↓
   Laravel Validator
   
3. Auth::attempt()
   ↓
   Check Credentials
   
4. Check Role
   ↓
   Guru? TU? Kepsek?
   
5. Redirect
   ↓
   Dashboard sesuai role
```

---

## SLIDE 7: CODE - MIGRATION
```php
// database/migrations/create_users_table.php

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['guru', 'tu', 'kepala_sekolah']);
    $table->timestamps();
});
```

**Poin Penting:**
• enum('role') → Batasi nilai
• unique() → Email tidak boleh duplikat
• timestamps() → Auto created_at & updated_at

---

## SLIDE 8: CODE - MODEL
```php
// app/Models/User.php

class User extends Authenticatable
{
    // Relasi ke Guru
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    // Helper method
    public function isGuru()
    {
        return $this->role === 'guru';
    }
}
```

**Poin Penting:**
• hasOne() → Relasi One-to-One
• isGuru() → Helper untuk cek role

---

## SLIDE 9: CODE - AUTHENTICATION
```php
// app/Http/Controllers/AuthController.php

public function login(Request $request)
{
    // 1. Validasi
    $request->validate([...]);
    
    // 2. Attempt login
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // 3. Redirect by role
        if ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        }
    }
    
    return back()->with('error', 'Login gagal');
}
```

---

## SLIDE 10: CODE - MIDDLEWARE
```php
// app/Http/Middleware/CheckRole.php

public function handle($request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    if (Auth::user()->role !== $role) {
        abort(403);
    }
    
    return $next($request);
}
```

**Middleware = Gatekeeper** 🚪

---

## SLIDE 11: CODE - ROUTING
```php
// routes/web.php

Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboard']);
        Route::get('/rpp', [RppController::class, 'index']);
        Route::get('/materi', [MateriController::class, 'index']);
        Route::get('/kuis', [KuisController::class, 'index']);
    });
```

**URL yang dihasilkan:**
• /guru/dashboard
• /guru/rpp
• /guru/materi

---

## SLIDE 12: FITUR-FITUR GURU
```
📚 FITUR GURU

1. Dashboard
   • Ringkasan materi, kuis, presensi
   • Switch mata pelajaran

2. RPP (Rencana Pelaksanaan Pembelajaran)
   • Buat RPP per pertemuan (1-16)
   • Edit & cetak RPP

3. Materi Pembelajaran
   • Upload materi (PDF, PPT, video)
   • Publish/unpublish

4. Kuis
   • Buat kuis (pilihan ganda, essay)
   • Set durasi & deadline
   • Lihat hasil siswa

5. Presensi
   • Isi presensi siswa
   • Rekap bulanan

6. Evaluasi
   • Input nilai siswa
   • Statistik nilai
```

---

## SLIDE 13: FITUR RPP - DETAIL
```
📝 FITUR RPP (Rencana Pelaksanaan Pembelajaran)

Flow:
1. Guru pilih mata pelajaran
2. Pilih pertemuan ke-1 sampai 16
3. Isi form RPP:
   • Identitas (judul, kelas, semester)
   • Kompetensi Inti (KI 1-4)
   • Kompetensi Dasar (KD)
   • Tujuan Pembelajaran
   • Materi Pembelajaran
   • Metode Pembelajaran
   • Kegiatan (Pendahuluan, Inti, Penutup)
   • Penilaian
   • Pengesahan (TTD Kepala Sekolah & Guru)
4. Simpan ke database
5. Cetak untuk ditandatangani
```

---

## SLIDE 14: CODE - RPP CONTROLLER
```php
public function store(Request $request)
{
    // 1. Ambil data guru
    $guru = Guru::where('user_id', Auth::id())->first();
    
    // 2. Validasi input
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'mata_pelajaran' => 'required',
        'pertemuan_ke' => 'required|integer|min:1',
        // ... field lainnya
    ]);
    
    // 3. Cek duplikasi
    $existing = Rpp::where('guru_id', $guru->id)
        ->where('mata_pelajaran', $validated['mata_pelajaran'])
        ->where('pertemuan_ke', $validated['pertemuan_ke'])
        ->first();
    
    if ($existing) {
        return back()->with('error', 'RPP sudah ada');
    }
    
    // 4. Simpan
    Rpp::create($validated);
    
    return redirect()->route('guru.dashboard')
        ->with('success', 'RPP berhasil dibuat!');
}
```

---

## SLIDE 15: SECURITY FEATURES
```
🔒 KEAMANAN SISTEM

1. Password Hashing
   • Pakai bcrypt (Laravel default)
   • Password tidak disimpan plain text

2. CSRF Protection
   • Token di setiap form
   • Cegah Cross-Site Request Forgery

3. Middleware Protection
   • Cek authentication
   • Cek authorization (role)

4. Input Validation
   • Validasi di backend
   • Sanitize input untuk cegah SQL Injection

5. Session Management
   • Session regenerate setelah login
   • Logout clear session
```

---

## SLIDE 16: DEMO APLIKASI
```
🎬 DEMO APLIKASI

Skenario:
1. Login sebagai Guru
   Email: desinurfalah24@gmail.com
   Password: desi123456

2. Lihat Dashboard
   • Tampilan ringkasan
   • Switch mata pelajaran

3. Buat RPP Baru
   • Pilih mata pelajaran
   • Isi form RPP
   • Simpan

4. Lihat Data di Database
   • Buka phpMyAdmin
   • Tunjukkan data tersimpan
```

---

## SLIDE 17: TEKNOLOGI YANG DIGUNAKAN
```
🛠️ TECH STACK

Backend:
• Laravel 11 (PHP Framework)
• MySQL (Database)
• PHP 8.2

Frontend:
• Blade Template Engine
• Bootstrap 5 (CSS Framework)
• JavaScript (Vanilla)

Tools:
• XAMPP (Local Server)
• Ngrok (Tunneling untuk akses remote)
• Git (Version Control)
• VS Code (Code Editor)
```

---

## SLIDE 18: CHALLENGES & SOLUTIONS
```
⚠️ TANTANGAN & SOLUSI

Challenge 1: Guru mengajar >1 mata pelajaran
Solution: Simpan sebagai string dengan separator koma,
          split jadi array di controller

Challenge 2: Validasi RPP tidak duplikat
Solution: Cek kombinasi guru_id + mata_pelajaran + pertemuan_ke

Challenge 3: Field name tidak match antara form & controller
Solution: Pastikan name attribute di HTML sama dengan
          validation rules di controller

Challenge 4: Ngrok terputus saat laptop sleep
Solution: Set laptop agar tidak sleep, atau deploy ke cloud
```

---

## SLIDE 19: BEST PRACTICES
```
✅ BEST PRACTICES YANG DITERAPKAN

1. Separation of Concerns
   • Tabel users untuk auth
   • Tabel gurus untuk data detail

2. DRY (Don't Repeat Yourself)
   • Helper methods (isGuru(), isTU())
   • Reusable components

3. Security First
   • Hash password
   • Middleware protection
   • Input validation

4. Clean Code
   • Naming convention yang jelas
   • Komentar untuk code kompleks
   • Indentasi yang rapi

5. Scalability
   • Mudah tambah role baru
   • Mudah tambah fitur
```

---

## SLIDE 20: FUTURE IMPROVEMENTS
```
🚀 PENGEMBANGAN KE DEPAN

1. Fitur Notifikasi
   • Email notification untuk deadline kuis
   • Push notification untuk pengumuman

2. Mobile App
   • Responsive design → Native app
   • Akses lebih mudah untuk guru

3. AI Integration
   • Auto-generate RPP berdasarkan silabus
   • Analisis hasil kuis siswa

4. Cloud Deployment
   • Deploy ke Railway/Heroku
   • Akses 24/7 tanpa ngrok

5. Reporting & Analytics
   • Dashboard analytics untuk kepala sekolah
   • Export laporan ke PDF/Excel
```

---

## SLIDE 21: KESIMPULAN
```
🎓 KESIMPULAN

✓ Sistem Multi-Role berhasil diimplementasikan
✓ Guru, TU, dan Kepala Sekolah punya akses berbeda
✓ Database terstruktur dan scalable
✓ Keamanan terjaga dengan middleware & validation
✓ Fitur-fitur guru berfungsi dengan baik

Manfaat:
• Efisiensi kerja guru
• Data terpusat dan terorganisir
• Akses mudah dari mana saja
• Sistem yang aman dan reliable
```

---

## SLIDE 22: Q&A
```
❓ PERTANYAAN & JAWABAN

Silakan bertanya!

Contact:
Email: [email Anda]
GitHub: [GitHub Anda]
LinkedIn: [LinkedIn Anda]
```

---

## SLIDE 23: TERIMA KASIH
```
┌─────────────────────────────────────────┐
│                                         │
│         TERIMA KASIH                    │
│                                         │
│   TMS NURANI - MTs Nurul Aiman          │
│                                         │
│   "Digitalisasi Pendidikan untuk        │
│    Masa Depan yang Lebih Baik"          │
│                                         │
└─────────────────────────────────────────┘
```

---

## 📝 CATATAN UNTUK PRESENTER

### Slide yang Harus Dipahami Betul:
1. **Slide 5 (Database Architecture)** - Ini paling sering ditanya
2. **Slide 9 (Authentication)** - Konsep dasar yang penting
3. **Slide 10 (Middleware)** - Keamanan sistem
4. **Slide 14 (RPP Controller)** - Implementasi fitur utama

### Tips Presentasi per Slide:
- **Slide 1-4**: Santai, ini pembukaan (2 menit)
- **Slide 5-11**: Fokus, ini inti teknis (10 menit)
- **Slide 12-14**: Jelaskan fitur dengan antusias (5 menit)
- **Slide 15-16**: Demo langsung (5 menit)
- **Slide 17-21**: Penutup dan kesimpulan (3 menit)

### Backup Slides (Jika Ditanya):
- Slide tentang testing methodology
- Slide tentang error handling
- Slide tentang database normalization
- Slide tentang Laravel lifecycle

---

## 🎨 DESIGN TIPS

### Color Scheme:
- **Primary**: #2E7D32 (Hijau TMS NURANI)
- **Secondary**: #4CAF50 (Hijau Terang)
- **Accent**: #FFC107 (Kuning)
- **Text**: #212121 (Hitam)
- **Background**: #FFFFFF (Putih)

### Font:
- **Heading**: Montserrat Bold
- **Body**: Open Sans Regular
- **Code**: Fira Code

### Layout:
- Gunakan **grid system** untuk konsistensi
- **Whitespace** yang cukup, jangan terlalu padat
- **Icon** untuk visual appeal
- **Screenshot** untuk demo

---

**Dibuat oleh:** Antigravity AI Assistant  
**Untuk:** Presentasi TMS NURANI  
**Format:** PowerPoint Slide Deck Outline
