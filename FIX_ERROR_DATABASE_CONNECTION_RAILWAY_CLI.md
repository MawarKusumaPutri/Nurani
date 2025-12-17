# 🔧 Fix Error: Database Connection di Railway CLI

## ❌ MASALAH

**Error yang muncul:**
```
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed : No such host is known.
```

**Artinya:**
- Database host `mysql.railway.internal` tidak bisa di-resolve
- Environment variables mungkin tidak ter-set dengan benar saat `railway run`
- Perlu cek dan fix environment variables di Railway Dashboard

---

## ✅ SOLUSI 1: Cek Environment Variables di Railway Dashboard

### Langkah 1: Buka Railway Dashboard

1. **Buka Railway Dashboard** → [railway.app](https://railway.app)
2. **Pilih project "TMS Nurani"**
3. **Klik service "web"** → tab **"Variables"**

### Langkah 2: Cek Database Variables

**Pastikan environment variables berikut ada dan benar:**

1. **DB_HOST:**
   - Harus: `${{MySQL.MYSQLHOST}}`
   - Bukan: `mysql.railway.internal` atau nilai lain

2. **DB_PORT:**
   - Harus: `${{MySQL.MYSQLPORT}}`

3. **DB_DATABASE:**
   - Harus: `${{MySQL.MYSQLDATABASE}}`

4. **DB_USERNAME:**
   - Harus: `${{MySQL.MYSQLUSER}}`

5. **DB_PASSWORD:**
   - Harus: `${{MySQL.MYSQLPASSWORD}}`

### Langkah 3: Fix Jika Salah

**Jika `DB_HOST` bukan `${{MySQL.MYSQLHOST}}`:**

1. **Klik variable `DB_HOST`**
2. **Edit value** menjadi: `${{MySQL.MYSQLHOST}}`
3. **Save**
4. **Ulangi untuk semua database variables** jika perlu

---

## ✅ SOLUSI 2: Gunakan Start Command (Alternatif)

**Jika Railway CLI masih error, gunakan cara ini:**

### Langkah 1: Tambahkan Migrations ke Start Command (Sementara)

**Edit `railway.json`:**

```json
{
  "deploy": {
    "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
  }
}
```

### Langkah 2: Commit & Push

```powershell
git add railway.json
git commit -m "Add migrations to start command"
git push
```

### Langkah 3: Tunggu Deploy

- Railway akan auto-deploy
- Migrations akan jalan saat service start
- Setelah migrations selesai, kembalikan start command

---

## ✅ SOLUSI 3: Gunakan Railway Shell (Jika Ada)

**Jika Railway Dashboard punya fitur Shell:**

1. **Railway Dashboard** → service "web"
2. **Cari tab "Shell"** atau "Terminal"
3. **Jalankan:**
   ```bash
   php artisan migrate --force
   ```

**Tapi fitur ini mungkin tidak ada di Railway web interface.**

---

## 📋 CHECKLIST

### ✅ Sudah Selesai:
- [x] Project sudah di-link (`railway link` berhasil)
- [x] Login Railway CLI berhasil

### ⏳ Langkah Ini:
- [ ] Cek environment variables di Railway Dashboard
- [ ] Pastikan `DB_HOST` = `${{MySQL.MYSQLHOST}}`
- [ ] Fix environment variables jika salah
- [ ] Coba `railway run php artisan migrate --force` lagi

### ⏳ Alternatif:
- [ ] Tambahkan migrations ke start command (sementara)
- [ ] Commit & push
- [ ] Tunggu deploy

---

## 💡 PENJELASAN

**Kenapa error ini terjadi?**

1. **`railway run`** menjalankan command di environment Railway
2. Tapi environment variables mungkin tidak ter-inject dengan benar
3. Atau `DB_HOST` menggunakan nilai yang salah
4. `mysql.railway.internal` adalah hostname internal yang mungkin tidak tersedia saat `railway run`

**Solusi terbaik:**
- Pastikan environment variables benar di Railway Dashboard
- Atau gunakan start command (lebih reliable)

---

## 🎯 REKOMENDASI

**Gunakan Solusi 2 (Start Command):**
- ✅ Lebih reliable
- ✅ Environment variables pasti ter-set dengan benar
- ✅ Tidak perlu Railway CLI

**Atau fix environment variables dulu (Solusi 1), lalu coba Railway CLI lagi.**

---

**Cek environment variables di Railway Dashboard dulu! Pastikan `DB_HOST` = `${{MySQL.MYSQLHOST}}`! 🚀**

