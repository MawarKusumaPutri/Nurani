---
description: Deploy dan Clear Cache di Railway
---

# Deploy dan Clear Cache di Railway

Ikuti langkah-langkah berikut untuk memastikan perubahan route dan fitur baru ter-deploy dengan benar di Railway:

## 1. Clear Route Cache
Jalankan command berikut di Railway console atau tambahkan ke build script:
```bash
php artisan route:clear
php artisan route:cache
```

## 2. Clear Config Cache
```bash
php artisan config:clear
php artisan config:cache
```

## 3. Clear View Cache
```bash
php artisan view:clear
```

## 4. Create Storage Link
Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

## 5. Optimize Application
```bash
php artisan optimize:clear
php artisan optimize
```

## 6. Verify Routes
Cek apakah route sudah terdaftar:
```bash
php artisan route:list --name=foto.download
```

## Catatan Penting
- Setiap kali ada perubahan route, **WAJIB** clear route cache
- Setiap kali ada perubahan config, **WAJIB** clear config cache
- Pastikan file `.env` di Railway sudah benar
- Pastikan `APP_ENV=production` di Railway
