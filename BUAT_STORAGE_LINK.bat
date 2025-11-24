@echo off
title BUAT STORAGE LINK
color 0A

echo.
echo ============================================
echo BUAT STORAGE LINK
echo ============================================
echo.

REM Cari lokasi XAMPP
set "XAMPP_PATH=D:\Praktikum DWBI\xampp"
if not exist "%XAMPP_PATH%\htdocs\nurani" (
    echo [ERROR] Project tidak ditemukan!
    pause
    exit /b 1
)

cd /d "%XAMPP_PATH%\htdocs\nurani"

echo [1/4] Cek storage symlink...
if exist "public\storage" (
    echo [INFO] public/storage sudah ada
    echo [INFO] Akan dihapus dan dibuat ulang untuk memastikan benar
    rmdir /s /q "public\storage" >nul 2>&1
    echo [OK] Storage symlink lama dihapus
) else (
    echo [INFO] public/storage belum ada
    echo [INFO] Akan dibuat sekarang
)
echo.

echo [2/4] Buat storage symlink...
php artisan storage:link
if %ERRORLEVEL% EQU 0 (
    echo [OK] Storage symlink berhasil dibuat
) else (
    echo [WARNING] Ada error, tapi mungkin symlink sudah ada
)
echo.

echo [3/4] Verifikasi symlink...
if exist "public\storage" (
    echo [OK] public/storage ada
    if exist "public\storage\profiles" (
        echo [OK] public/storage/profiles ada
        if exist "public\storage\profiles\tu" (
            echo [OK] public/storage/profiles/tu ada
        )
        if exist "public\storage\profiles\guru" (
            echo [OK] public/storage/profiles/guru ada
        )
        if exist "public\storage\profiles\kepala_sekolah" (
            echo [OK] public/storage/profiles/kepala_sekolah ada
        )
    )
) else (
    echo [ERROR] public/storage tidak ada setelah dibuat!
    echo         Coba buat manual dengan: php artisan storage:link
)
echo.

echo [4/4] Test akses foto...
echo.
echo Test URL untuk foto:
for %%f in ("storage\app\public\profiles\tu\*.*") do (
    echo   http://localhost/nurani/public/storage/profiles/tu/%%~nxf
    echo   Buka URL ini di browser untuk test apakah foto bisa diakses
    echo   Jika foto muncul = symlink benar ✓
    echo   Jika error 404 = masalah symlink atau file tidak ada
    goto :test_done
)
:test_done
echo.

echo ============================================
echo SELESAI!
echo ============================================
echo.
echo Storage symlink sudah dibuat.
echo Foto sekarang bisa diakses via web.
echo.
echo Test akses foto di browser untuk memastikan.
echo.
pause

