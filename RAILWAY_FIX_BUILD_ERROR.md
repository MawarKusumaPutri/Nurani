# 🔧 Fix Railway Build Error - `undefined variable 'composer'`

## ❌ Error:
```
error: undefined variable 'composer'
at /app/.nixpacks/nixpkgs-*.nix:19:9
```

## ✅ Solusi yang Sudah Diterapkan:

### 1. Update `nixpacks.toml`
- Install Composer secara manual (bukan dari nixPkgs)
- Gunakan curl untuk download Composer
- Install ke `/usr/local/bin/composer`

### 2. Format yang Benar:
```toml
[phases.setup]
nixPkgs = ["php82", "nodejs-18_x"]

[phases.install]
cmds = [
    "curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer",
    "composer install --no-dev --optimize-autoloader",
    "npm install",
]

[phases.build]
cmds = [
    "php artisan key:generate --force",
    "php artisan storage:link",
    "npm run build",
]

[start]
cmd = "php artisan serve --host=0.0.0.0 --port=$PORT"
```

## 🚀 Langkah Selanjutnya:

### 1. Tunggu Auto-Redeploy
- Railway akan otomatis detect perubahan
- Tunggu 1-2 menit
- Refresh Railway Dashboard

### 2. Atau Trigger Manual Deploy
1. Di Railway Dashboard
2. Klik service "Nurani"
3. Klik tab "Settings"
4. Scroll ke bagian "Deploy"
5. Klik **"Redeploy"** atau **"Deploy"**

### 3. Monitor Build
1. Klik tab "Deployments"
2. Lihat deployment baru
3. Klik "View Logs"
4. Monitor progress

## 📋 Jika Masih Error:

### Option 1: Hapus nixpacks.toml
Jika masih error, coba hapus `nixpacks.toml` dan biarkan Railway auto-detect:
```bash
git rm nixpacks.toml
git commit -m "Remove nixpacks.toml - use auto-detect"
git push
```

### Option 2: Gunakan Build Command Manual
Di Railway Settings → Deploy → Build Command:
```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan key:generate --force && php artisan storage:link
```

### Option 3: Disable Nixpacks
1. Di Railway Settings
2. Pilih **"Dockerfile"** sebagai builder
3. Buat Dockerfile (saya sudah buat template di file sebelumnya)

## 🎯 Yang Perlu Dilakukan Sekarang:

1. ✅ **Tunggu 1-2 menit** - Railway auto-redeploy
2. ✅ **Refresh Railway Dashboard**
3. ✅ **Cek deployment baru**
4. ✅ **Monitor build logs**
5. ✅ **Jika masih error** - Coba Option 1, 2, atau 3 di atas

---

**Tunggu Railway auto-redeploy dengan konfigurasi baru!** 🚀

