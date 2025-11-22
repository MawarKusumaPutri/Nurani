@echo off
echo ============================================
echo PERBAIKAN URGEN: DNS_PROBE_FINISHED_NXDOMAIN
echo ============================================
echo.
echo Script ini akan membantu memperbaiki error DNS.
echo.
pause

echo.
echo [1/5] Flushing DNS cache...
ipconfig /flushdns
if %errorlevel% neq 0 (
    echo ERROR: Gagal flush DNS cache!
    echo Pastikan Command Prompt dibuka sebagai Administrator.
    pause
    exit /b 1
)
echo SUKSES: DNS cache sudah di-flush.
echo.

echo [2/5] Menampilkan isi file hosts saat ini...
echo.
type C:\Windows\System32\drivers\etc\hosts
echo.
echo ============================================
echo CEK DI ATAS: Apakah ada "nurani.test"?
echo ============================================
echo.
pause

echo.
echo [3/5] Membuka file hosts untuk diedit...
echo.
echo INSTRUKSI:
echo 1. File hosts akan terbuka di Notepad
echo 2. Pastikan Notepad dibuka sebagai Administrator
echo 3. Tambahkan di akhir file:
echo    127.0.0.1    nurani.test
echo    127.0.0.1    www.nurani.test
echo 4. Simpan (Ctrl + S)
echo 5. Tutup Notepad
echo.
pause

start notepad C:\Windows\System32\drivers\etc\hosts

echo.
echo [4/5] Menunggu Anda menyimpan file hosts...
echo.
pause

echo.
echo [5/5] Flushing DNS cache lagi...
ipconfig /flushdns
echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Pastikan Apache running di XAMPP
echo 2. Restart browser atau gunakan Incognito mode
echo 3. Buka: http://nurani.test
echo.
pause

