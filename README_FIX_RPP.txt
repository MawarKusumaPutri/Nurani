========================================
CARA FIX ERROR TABEL RPP
========================================

ERROR: Table 'nurani.rpp' doesn't exist

========================================
SOLUSI TERMUDAH (PILIH SALAH SATU):
========================================

1. DOUBLE-CLICK FILE INI:
   → JALANKAN_INI_UNTUK_FIX_RPP.bat
   
   Script akan otomatis membuat tabel RPP.
   Tunggu sampai muncul pesan "SUKSES!"
   Lalu refresh halaman RPP di browser (Ctrl+F5)

2. VIA PHPMYADMIN (Manual):
   → Buka http://localhost/phpmyadmin
   → Pilih database "nurani"
   → Klik tab "SQL"
   → Copy-paste isi file CREATE_RPP_TABLE.sql
   → Klik "Go"
   → Refresh halaman RPP

3. VIA COMMAND LINE:
   → Buka Command Prompt di folder ini
   → Ketik: php fix_rpp_simple.php
   → Refresh halaman RPP

========================================
FILE YANG TERSEDIA:
========================================

- JALANKAN_INI_UNTUK_FIX_RPP.bat  ← PALING MUDAH!
- CREATE_RPP_TABLE.sql             ← Untuk phpMyAdmin
- fix_rpp_simple.php               ← Script PHP
- CARA_FIX_ERROR_RPP_LENGKAP.md    ← Dokumentasi lengkap

========================================
SETELAH FIX:
========================================

1. Refresh halaman RPP di browser (Ctrl+F5)
2. Atau tutup dan buka kembali browser
3. Coba akses fitur RPP lagi

========================================
