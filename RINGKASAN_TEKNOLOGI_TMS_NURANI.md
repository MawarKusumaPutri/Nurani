# 📖 RINGKASAN: TEKNOLOGI TMS NURANI
## Panduan Singkat & Mudah Dipahami

---

## 🎯 **APA ITU TMS NURANI?**

**TMS NURANI** adalah sistem manajemen sekolah berbasis web untuk **MTs Nurul Aiman**.

**Fungsi Utama:**
- 👨‍🏫 Guru bisa buat RPP, materi, kuis
- 👨‍💼 TU bisa kelola data siswa dan guru
- 👨‍💼 Kepala Sekolah bisa monitoring dan approve RPP

---

## 🛠️ **TEKNOLOGI YANG DIGUNAKAN**

### **1. Backend: Laravel 11 (PHP)**

**Apa itu Backend?**
> Backend = Dapur restoran (tidak terlihat customer, tapi di situ makanan dimasak)

**Apa itu Laravel?**
> Laravel = Framework PHP yang memudahkan bikin website

**Kenapa Pakai Laravel?**
- ✅ **Lebih mudah** daripada PHP biasa
- ✅ **Lebih aman** (auto-proteksi dari hacker)
- ✅ **Lebih cepat** development-nya

**Contoh Perbedaan:**

**PHP Biasa (Ribet):**
```php
$conn = mysqli_connect("localhost", "root", "", "nurani");
$query = "SELECT * FROM siswas WHERE kelas = 'VII'";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)) {
    echo $row['nama_lengkap'];
}
```

**Laravel (Mudah):**
```php
$siswas = Siswa::where('kelas', 'VII')->get();
foreach($siswas as $siswa) {
    echo $siswa->nama_lengkap;
}
```

---

### **2. Frontend: Blade + HTML + CSS + JavaScript**

**Apa itu Frontend?**
> Frontend = Ruang makan restoran (yang dilihat customer)

**Teknologi Frontend:**

#### **A. Blade (Template Engine)**
- Buat tampilan HTML lebih mudah
- Bisa pakai variabel PHP di HTML
- Bisa extends layout (tidak perlu copy-paste)

**Contoh:**
```blade
<h1>Selamat Datang, {{ $guru->user->name }}!</h1>

@if($rpps->count() > 0)
    <p>Anda punya {{ $rpps->count() }} RPP</p>
@else
    <p>Belum ada RPP</p>
@endif
```

#### **B. HTML5**
- Struktur halaman web
- Form, tabel, button, dll

#### **C. CSS (Bootstrap 5)**
- Styling/tampilan
- Bootstrap = Framework CSS yang sudah jadi

**Tanpa Bootstrap (Ribet):**
```css
.button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
}
```

**Dengan Bootstrap (Mudah):**
```html
<button class="btn btn-primary">Simpan</button>
```

#### **D. JavaScript**
- Interaksi di browser
- Preview image, loading button, dll

**Contoh:**
```javascript
// Disable button saat submit
document.querySelector('form').addEventListener('submit', function() {
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Menyimpan...';
});
```

---

### **3. Database: MySQL**

**Apa itu Database?**
> Database = Lemari arsip yang terorganisir

**Kenapa MySQL?**
- ✅ Gratis
- ✅ Cepat
- ✅ Reliable (handal)

**Struktur Database:**
```
Database: nurani
├── users (Data login)
├── gurus (Data guru)
├── siswas (Data siswa)
├── rpp (Data RPP)
├── jadwal (Jadwal pelajaran)
└── events (Kalender akademik)
```

**Relasi Tabel:**
```
users → gurus → rpps
  1        1       N
(One-to-One) (One-to-Many)
```

---

### **4. Arsitektur: MVC**

**Apa itu MVC?**
> MVC = Cara mengorganisir kode jadi 3 bagian

```
┌─────────────────────────────────────┐
│  Model (Data & Database)            │
│  • Representasi tabel database      │
│  • Query data                       │
├─────────────────────────────────────┤
│  View (Tampilan)                    │
│  • HTML yang dilihat user           │
│  • Form, tabel, button              │
├─────────────────────────────────────┤
│  Controller (Logic)                 │
│  • Otak sistem                      │
│  • Proses data                      │
│  • Hubungkan Model & View           │
└─────────────────────────────────────┘
```

**Keuntungan MVC:**
- ✅ Kode lebih rapi
- ✅ Mudah maintenance
- ✅ Mudah dikembangkan

---

## 🔄 **CARA KERJA SISTEM**

### **Flow Sederhana:**

```
1. User buka browser
   ↓
2. Ketik URL: /guru/rpp
   ↓
3. Laravel routing cek URL
   ↓
4. Middleware cek: Sudah login? Role = guru?
   ↓
5. RppController dijalankan
   ↓
6. Controller ambil data dari Model (Rpp)
   ↓
7. Model query database MySQL
   ↓
8. Database return data
   ↓
9. Controller kirim data ke View (Blade)
   ↓
10. Blade render HTML
    ↓
11. HTML + CSS + JS dikirim ke Browser
    ↓
12. Browser tampilkan halaman
```

---

## 📊 **TEKNOLOGI PER LAYER**

| Layer | Teknologi | Fungsi |
|-------|-----------|--------|
| **Browser** | HTML + CSS + JavaScript | Tampilan yang dilihat user |
| **Web Server** | Apache (XAMPP) | Terima request, kirim response |
| **Framework** | Laravel 11 (PHP) | Proses logic, atur data |
| **Database** | MySQL | Simpan data |

---

## 💡 **ANALOGI SEDERHANA**

**Bayangkan TMS NURANI seperti Restoran:**

```
┌─────────────────────────────────────┐
│  CUSTOMER (User)                    │
│  • Lihat menu (Frontend)            │
│  • Pesan makanan (Input data)       │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  PELAYAN (Laravel)                  │
│  • Terima pesanan (Routing)         │
│  • Cek customer (Middleware)        │
│  • Proses pesanan (Controller)      │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  DAPUR (Backend)                    │
│  • Masak makanan (Process data)     │
│  • Ambil bahan (Query database)     │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  GUDANG (Database)                  │
│  • Simpan bahan (Data)              │
└─────────────────────────────────────┘
```

---

## 🎯 **KENAPA PAKAI TEKNOLOGI INI?**

### **1. Laravel (Backend)**
- ✅ **Mudah** - Kode lebih sedikit
- ✅ **Aman** - Built-in security
- ✅ **Cepat** - Development lebih cepat

### **2. Blade (Template)**
- ✅ **Reusable** - Layout tidak perlu copy-paste
- ✅ **Clean** - Kode lebih rapi
- ✅ **Safe** - Auto-escape XSS

### **3. Bootstrap (CSS)**
- ✅ **Responsive** - Otomatis mobile-friendly
- ✅ **Konsisten** - Tampilan seragam
- ✅ **Cepat** - Tinggal pakai class

### **4. MySQL (Database)**
- ✅ **Gratis** - Open source
- ✅ **Reliable** - Sudah terbukti
- ✅ **Compatible** - Cocok dengan Laravel

### **5. MVC (Arsitektur)**
- ✅ **Terstruktur** - Kode terorganisir
- ✅ **Maintainable** - Mudah di-maintain
- ✅ **Scalable** - Bisa dikembangkan

---

## 📝 **CONTOH NYATA DI TMS NURANI**

### **Fitur: Tambah Siswa**

**1. Model (Data)**
```php
class Siswa extends Model
{
    protected $fillable = ['nisn', 'nama_lengkap', 'kelas'];
}
```

**2. Controller (Logic)**
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'nisn' => 'required|unique:siswas',
        'nama_lengkap' => 'required',
    ]);
    
    Siswa::create($validated);
    
    return redirect()->back()->with('success', 'Siswa berhasil ditambahkan!');
}
```

**3. View (Tampilan)**
```blade
<form action="{{ route('tu.siswa.store') }}" method="POST">
    @csrf
    <input type="text" name="nisn" required>
    <input type="text" name="nama_lengkap" required>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
```

**4. JavaScript (Interaksi)**
```javascript
document.querySelector('form').addEventListener('submit', function() {
    submitBtn.innerHTML = 'Menyimpan...';
});
```

---

## 🚀 **KESIMPULAN**

**TMS NURANI dibangun dengan:**

| Komponen | Teknologi | Seperti |
|----------|-----------|---------|
| **Backend** | Laravel 11 | Dapur restoran |
| **Frontend** | Blade + HTML + CSS + JS | Ruang makan |
| **Database** | MySQL | Gudang bahan |
| **Arsitektur** | MVC | Cara kerja restoran |

**Semua teknologi ini bekerja sama untuk:**
- ✅ **Aman** - Proteksi dari hacker
- ✅ **Cepat** - Load halaman cepat
- ✅ **Mudah** - Mudah dikembangkan
- ✅ **Reliable** - Jarang error

---

## 📚 **UNTUK BELAJAR LEBIH LANJUT**

**Baca file lengkap:**
- 📘 `BUKU_PANDUAN_TEKNOLOGI_TMS_NURANI.md` (Penjelasan detail dengan banyak contoh kode)

**Baca panduan fitur:**
- 📗 `PANDUAN_LENGKAP_GURU_USER_DAN_KODE.md`
- 📙 `PANDUAN_LENGKAP_TENAGA_USAHA_USER_DAN_KODE.md`
- 📕 `PANDUAN_LENGKAP_KEPALA_SEKOLAH_USER_DAN_KODE.md`

---

## 🎓 **UNTUK PRESENTASI**

**Saat dosen tanya: "Teknologi apa yang dipakai?"**

**Jawaban singkat:**
> "Pak/Bu, sistem TMS NURANI menggunakan:
> 
> 1. **Laravel 11** untuk backend (PHP framework yang modern)
> 2. **Blade + Bootstrap** untuk frontend (tampilan yang responsive)
> 3. **MySQL** untuk database (penyimpanan data)
> 4. **MVC Architecture** untuk struktur kode yang rapi
> 
> Semua teknologi ini dipilih karena mudah, aman, dan cepat untuk development."

**Saat dosen tanya: "Kenapa pakai Laravel?"**

**Jawaban singkat:**
> "Pak/Bu, Laravel lebih mudah daripada PHP biasa. Contohnya:
> 
> **PHP biasa:** Perlu 10 baris kode untuk query database
> **Laravel:** Cukup 1 baris: `Siswa::where('kelas', 'VII')->get()`
> 
> Plus Laravel sudah punya built-in security, validation, dan authentication."

---

**Dibuat oleh:** TMS NURANI Development Team  
**Tanggal:** 14 Januari 2026  
**Versi:** 1.0 (Ringkasan)

---

> **💡 TIP:** File ini adalah ringkasan. Untuk penjelasan lengkap dengan banyak contoh kode, baca `BUKU_PANDUAN_TEKNOLOGI_TMS_NURANI.md`
