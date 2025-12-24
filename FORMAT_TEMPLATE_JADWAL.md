# Template Import Jadwal Pelajaran

## Format Excel yang Harus Diikuti:

### Kolom yang Diperlukan (Header di Baris 1):
1. **mata_pelajaran** - Nama mata pelajaran (contoh: Matematika, Bahasa Indonesia)
2. **guru** - Nama guru (harus sesuai dengan nama di database)
3. **kelas** - Kelas (contoh: 7, 8, 9)
4. **hari** - Hari (senin, selasa, rabu, kamis, jumat, sabtu)
5. **jam_mulai** - Jam mulai (format: HH:MM atau HH:MM:SS, contoh: 07:00 atau 07:00:00)
6. **jam_selesai** - Jam selesai (format: HH:MM atau HH:MM:SS, contoh: 07:40 atau 07:40:00)
7. **ruang** - Ruang kelas (opsional, contoh: Ruang 7)

### Contoh Data:

| mata_pelajaran | guru | kelas | hari | jam_mulai | jam_selesai | ruang |
|---|---|---|---|---|---|---|
| Bahasa Arab | Fadli | 7 | Jumat | 08:15 | 11:30 | Ruang 7 |
| Matematika | Nurhadi, S.Pd | 7 | Selasa | 07:00 | 07:45 | Ruang 7 |
| Bahasa Indonesia | Maman Suparman, A.K.S | 8 | Senin | 07:00 | 07:40 | Ruang 8 |

### Catatan Penting:
- Nama guru harus **PERSIS SAMA** dengan nama di database
- Hari harus huruf kecil semua (senin, selasa, rabu, kamis, jumat, sabtu)
- Format waktu bisa HH:MM atau HH:MM:SS
- Ruang bersifat opsional, jika kosong akan otomatis "Ruang [kelas]"
- Semester dan Tahun Ajaran diisi di form import, bukan di Excel

### Download Template:
Klik tombol "Download Template Excel" di modal import untuk mendapatkan template yang sudah siap diisi.
