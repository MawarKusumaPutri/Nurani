# Update: Input Tanggal Lahir Manual

## Deskripsi
Mengubah input tanggal lahir dari date picker menjadi text input agar TU dapat mengetik tanggal secara manual dengan format DD/MM/YYYY.

## Perubahan yang Dilakukan

### 1. Form Tambah Siswa (`resources/views/tu/siswa/create.blade.php`)
- **Sebelum**: `<input type="date">`
- **Sesudah**: `<input type="text" placeholder="04/01/2015">`
- **Tambahan**: Label format "Format: DD/MM/YYYY"

### 2. Form Edit Siswa (`resources/views/tu/siswa/edit.blade.php`)
- **Sebelum**: `<input type="date">` dengan value format Y-m-d
- **Sesudah**: `<input type="text" placeholder="04/01/2015">` dengan value format d/m/Y
- **Tambahan**: Label format "Format: DD/MM/YYYY"

### 3. Controller (`app/Http/Controllers/TuController.php`)

#### Method `siswaStore()`
- Mengubah validasi dari `'tanggal_lahir' => 'required|date'` menjadi `'tanggal_lahir' => 'required|string'`
- Menambahkan konversi format tanggal dari DD/MM/YYYY ke Y-m-d sebelum menyimpan:
```php
$data = $request->all();
if (isset($data['tanggal_lahir'])) {
    $data['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $data['tanggal_lahir'])->format('Y-m-d');
}
Siswa::create($data);
```

#### Method `siswaUpdate()`
- Mengubah validasi dari `'tanggal_lahir' => 'required|date'` menjadi `'tanggal_lahir' => 'required|string'`
- Menambahkan konversi format tanggal dari DD/MM/YYYY ke Y-m-d sebelum update:
```php
$data = $request->all();
if (isset($data['tanggal_lahir'])) {
    $data['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $data['tanggal_lahir'])->format('Y-m-d');
}
$siswa->update($data);
```

## Format Tanggal

### Input (User)
- **Format**: DD/MM/YYYY
- **Contoh**: 04/01/2015

### Database
- **Format**: Y-m-d (tetap sama)
- **Contoh**: 2015-01-04

### Display (Edit Form)
- **Format**: DD/MM/YYYY
- **Contoh**: 04/01/2015

## Cara Menggunakan

### Tambah Siswa Baru
1. Buka menu "Data Siswa" → "Tambah Siswa Baru"
2. Di kolom "Tanggal Lahir", ketik manual dengan format: **DD/MM/YYYY**
   - Contoh: `04/01/2015`
3. Klik "Simpan"

### Edit Data Siswa
1. Buka menu "Data Siswa" → Klik "Edit" pada siswa yang ingin diubah
2. Tanggal lahir akan ditampilkan dalam format **DD/MM/YYYY**
3. Ubah tanggal jika diperlukan dengan format yang sama
4. Klik "Update"

## Validasi

⚠️ **Penting**: Pastikan format tanggal yang diinput benar (DD/MM/YYYY)
- ✅ Benar: `04/01/2015`, `25/12/2010`
- ❌ Salah: `2015-01-04`, `01-04-2015`, `4/1/2015`

Jika format salah, sistem akan menampilkan error saat menyimpan.

## Catatan Teknis

- Menggunakan `Carbon::createFromFormat()` untuk parsing tanggal
- Database tetap menyimpan dalam format Y-m-d (standar MySQL)
- Tidak ada perubahan pada struktur database
- Backward compatible dengan data yang sudah ada

---
**Dibuat**: 2026-01-04  
**Versi**: 1.0  
**Developer**: Antigravity AI
