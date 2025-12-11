# 🔧 Fix Error: Database Connection di Railway

## ❌ Error yang Terjadi

```
php_network_getaddresses: getaddrinfo for ${MYSQLHOST} failed: Name or service not known
```

**Penyebab:** Environment variable `DB_HOST` menggunakan format yang salah untuk reference variable Railway.

---

## ✅ Solusi: Perbaiki Environment Variables di Railway

### Langkah 1: Buka Railway Dashboard

1. Login ke [railway.app](https://railway.app)
2. Pilih project Anda
3. Klik pada service **"web"** (yang error)
4. Buka tab **"Variables"**

### Langkah 2: Cek Nama Service Database

1. Di sidebar kiri, lihat nama service database Anda
   - Contoh: **"MySQL"**, **"Postgres"**, **"MySQL Database"**, dll
2. **Catat nama service ini** (akan digunakan di langkah berikutnya)

### Langkah 3: Perbaiki Environment Variables

**HAPUS** variable yang salah (jika ada):
- ❌ `DB_HOST=${MYSQLHOST}` (format salah)
- ❌ `DB_HOST=${{MYSQLHOST}}` (format salah)

**TAMBAHKAN/EDIT** variable dengan format yang benar:

#### Variable 1: DB_HOST
```
Name: DB_HOST
Value: ${{MySQL.MYSQLHOST}}
```
**⚠️ PENTING:** Ganti `MySQL` dengan nama service database Anda yang sebenarnya!

#### Variable 2: DB_PORT
```
Name: DB_PORT
Value: ${{MySQL.MYSQLPORT}}
```

#### Variable 3: DB_DATABASE
```
Name: DB_DATABASE
Value: ${{MySQL.MYSQLDATABASE}}
```

#### Variable 4: DB_USERNAME
```
Name: DB_USERNAME
Value: ${{MySQL.MYSQLUSER}}
```

#### Variable 5: DB_PASSWORD
```
Name: DB_PASSWORD
Value: ${{MySQL.MYSQLPASSWORD}}
```

#### Variable 6: DB_CONNECTION
```
Name: DB_CONNECTION
Value: mysql
```

---

## 📝 Contoh Berdasarkan Nama Service

### Jika nama service database adalah "MySQL":
```
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

### Jika nama service database adalah "Postgres":
```
DB_HOST=${{Postgres.MYSQLHOST}}
DB_PORT=${{Postgres.MYSQLPORT}}
DB_DATABASE=${{Postgres.MYSQLDATABASE}}
DB_USERNAME=${{Postgres.MYSQLUSER}}
DB_PASSWORD=${{Postgres.MYSQLPASSWORD}}
```

### Jika nama service database adalah "MySQL Database":
```
DB_HOST=${{MySQL Database.MYSQLHOST}}
DB_PORT=${{MySQL Database.MYSQLPORT}}
DB_DATABASE=${{MySQL Database.MYSQLDATABASE}}
DB_USERNAME=${{MySQL Database.MYSQLUSER}}
DB_PASSWORD=${{MySQL Database.MYSQLPASSWORD}}
```

---

## 🔍 Cara Cek Nama Service yang Benar

1. Di Railway dashboard, klik pada **service database** (bukan service web)
2. Buka tab **"Variables"**
3. Scroll ke bawah, ada bagian **"Reference Variable"**
4. Copy format reference yang ditampilkan di sana
5. Gunakan format yang sama untuk service web

**Contoh Reference Variable yang ditampilkan:**
```
${{MySQL.MYSQLHOST}}
${{MySQL.MYSQLPORT}}
```

---

## ✅ Setelah Memperbaiki

1. **Save** semua environment variables
2. Railway akan **otomatis redeploy** service web
3. Tunggu beberapa menit
4. Cek **Deploy Logs** untuk memastikan tidak ada error lagi

---

## 🎯 Format yang Benar vs Salah

| ❌ SALAH | ✅ BENAR |
|---------|---------|
| `${MYSQLHOST}` | `${{MySQL.MYSQLHOST}}` |
| `${{MYSQLHOST}}` | `${{MySQL.MYSQLHOST}}` |
| `MYSQLHOST` | `${{MySQL.MYSQLHOST}}` |

**Kunci perbedaan:**
- ✅ Double curly braces: `{{ }}`
- ✅ Nama service: `MySQL` (atau nama service Anda)
- ✅ Titik pemisah: `.`
- ✅ Nama variable: `MYSQLHOST`

---

## 🆘 Masih Error?

### 1. Cek Service Database Online
- Pastikan service database berstatus **"Online"** (ada titik hijau)
- Jika offline, klik tombol **"Deploy"** pada service database

### 2. Cek Nama Service
- Pastikan nama service di reference variable **SAMA PERSIS** dengan nama service di dashboard
- Case sensitive! `MySQL` ≠ `mysql`

### 3. Cek Environment Variables Lainnya
Pastikan juga sudah set:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (generate dengan: php artisan key:generate)
DB_CONNECTION=mysql
```

### 4. Clear Cache (jika perlu)
Setelah fix, bisa juga clear cache di Railway dengan menambahkan command di build:
```bash
php artisan config:clear && php artisan cache:clear
```

---

## 📚 Referensi

- [Railway Documentation - Environment Variables](https://docs.railway.app/develop/variables)
- [Railway Documentation - Service References](https://docs.railway.app/develop/variables#reference-variables)
