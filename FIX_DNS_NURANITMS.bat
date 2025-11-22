@echo off
echo ============================================
echo PERBAIKAN DNS untuk nuranitms.test
echo ============================================
echo.

echo [1/4] Flushing DNS cache...
ipconfig /flushdns
if %errorlevel% neq 0 (
    echo ERROR: Gagal flush DNS cache!
    echo Pastikan Command Prompt dibuka sebagai Administrator.
    pause
    exit /b 1
)
echo [OK] DNS cache sudah di-flush.
echo.

echo [2/4] Menampilkan isi file hosts saat ini...
echo.
type C:\Windows\System32\drivers\etc\hosts | findstr /i "nurani"
echo.
echo ============================================
echo CEK DI ATAS: Apakah ada "nuraniTMS.test" atau "nuranitms.test"?
echo ============================================
echo.
pause

echo.
echo [3/4] Membuka file hosts untuk diedit...
echo.
echo ============================================
echo INSTRUKSI UPDATE FILE HOSTS:
echo ============================================
echo.
echo 1. File hosts akan terbuka di Notepad
echo 2. Pastikan Notepad dibuka sebagai Administrator
echo 3. Hapus semua baris yang terkait nurani (jika ada)
echo 4. Tambahkan di akhir file:
echo    127.0.0.1    nuraniTMS.test
echo    127.0.0.1    www.nuraniTMS.test
echo    127.0.0.1    nuranitms.test
echo    127.0.0.1    www.nuranitms.test
echo 5. Simpan (Ctrl + S)
echo 6. Tutup Notepad
echo.
pause

start notepad C:\Windows\System32\drivers\etc\hosts

echo.
echo [4/4] Menunggu Anda menyimpan file hosts...
echo.
pause

echo.
echo Flushing DNS cache lagi...
ipconfig /flushdns
echo.
echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Langkah selanjutnya:
echo 1. Pastikan VirtualHost sudah diupdate dengan ServerAlias
echo 2. Pastikan Apache running di XAMPP
echo 3. Restart Apache
echo 4. Restart browser atau gunakan Incognito mode
echo 5. Test: https://nuranitms.test
echo.
echo Jika masih error, RESTART KOMPUTER!
echo.
pause

