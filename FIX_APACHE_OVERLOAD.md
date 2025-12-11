# 🔧 Fix: Apache Overload - Login Lambat

## ⚠️ MASALAH

Login lambat kemungkinan karena **Apache overload** atau konfigurasi yang tidak optimal.

## 🔍 DIAGNOSA

### Cek 1: Apache Error Log

**Buka XAMPP Control Panel:**
1. Klik **"Logs"** di sebelah Apache
2. Pilih **"error.log"**
3. Cek apakah ada error atau warning

**Jika ada banyak error:**
→ Apache mungkin overload

---

### Cek 2: Apache Access Log

**Buka XAMPP Control Panel:**
1. Klik **"Logs"** di sebelah Apache
2. Pilih **"access.log"**
3. Cek apakah ada banyak request yang menumpuk

**Jika ada banyak request:**
→ Apache mungkin overload

---

### Cek 3: PHP Error Log

**Buka:**
```
D:\Praktikum DWBI\xampp\php\logs\php_error_log
```

**Cek apakah ada error atau warning**

---

## ✅ SOLUSI: Optimasi Apache & PHP

### Solusi 1: Optimasi PHP Configuration

**Buka file:**
```
D:\Praktikum DWBI\xampp\php\php.ini
```

**Cari dan ubah:**

```ini
; Memory limit - TINGKATKAN
memory_limit = 256M

; Max execution time - TINGKATKAN
max_execution_time = 60
max_input_time = 60

; Post max size
post_max_size = 50M
upload_max_filesize = 50M

; Disable error display di production (untuk performa)
display_errors = Off
display_startup_errors = Off

; Enable OPcache untuk performa
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

**Setelah ubah, restart Apache!**

---

### Solusi 2: Optimasi Apache Configuration

**Buka file:**
```
D:\Praktikum DWBI\xampp\apache\conf\httpd.conf
```

**Cari dan ubah:**

```apache
# Timeout - TINGKATKAN
Timeout 300

# KeepAlive - ENABLE
KeepAlive On
MaxKeepAliveRequests 100
KeepAliveTimeout 5

# ServerLimit dan MaxRequestWorkers - TINGKATKAN
ServerLimit 16
MaxRequestWorkers 150
ThreadsPerChild 25

# Disable modules yang tidak perlu (untuk performa)
# LoadModule rewrite_module modules/mod_rewrite.so
# LoadModule deflate_module modules/mod_deflate.so
# LoadModule expires_module modules/mod_expires.so
```

**Setelah ubah, restart Apache!**

---

### Solusi 3: Optimasi MySQL Configuration

**Buka file:**
```
D:\Praktikum DWBI\xampp\mysql\bin\my.ini
```

**Cari dan ubah:**

```ini
[mysqld]
# Buffer pool size - TINGKATKAN
innodb_buffer_pool_size = 256M

# Query cache
query_cache_type = 1
query_cache_size = 32M

# Max connections
max_connections = 100

# Table cache
table_open_cache = 2000
```

**Setelah ubah, restart MySQL!**

---

### Solusi 4: Disable XAMPP Modules yang Tidak Perlu

**Di XAMPP Control Panel:**
- **FileZilla** - Stop (jika tidak digunakan)
- **Mercury** - Stop (jika tidak digunakan)
- **Tomcat** - Stop (jika tidak digunakan)

**Hanya jalankan Apache dan MySQL!**

---

### Solusi 5: Clear Laravel Cache (WAJIB!)

```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

### Solusi 6: Restart Apache & MySQL

1. **XAMPP Control Panel**
2. **Stop** Apache
3. **Stop** MySQL
4. **Tunggu 5 detik**
5. **Start** MySQL dulu
6. **Tunggu 3 detik**
7. **Start** Apache

---

## 🎯 SOLUSI CEPAT (RECOMMENDED)

**Lakukan langkah ini secara berurutan:**

### Step 1: Optimasi PHP (5 menit)

1. Buka: `D:\Praktikum DWBI\xampp\php\php.ini`
2. Cari: `memory_limit`
3. Ubah: `memory_limit = 256M`
4. Cari: `max_execution_time`
5. Ubah: `max_execution_time = 60`
6. Save file

### Step 2: Restart Apache

1. XAMPP Control Panel
2. Stop Apache
3. Start Apache

### Step 3: Clear Laravel Cache

```bash
cd D:\Praktikum DWBI\xampp\htdocs\nurani
php artisan optimize:clear
```

### Step 4: Test Login

Login harusnya lebih cepat!

---

## 📊 MONITORING

### Cek Apache Status

**Buka browser:**
```
http://localhost/server-status
```

**Atau via terminal:**
```bash
netstat -ano | findstr :80
```

**Cek apakah ada banyak connection**

---

### Cek PHP Memory Usage

**Buat file test:**
```php
<?php
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Memory Usage: " . memory_get_usage(true) . " bytes\n";
echo "Peak Memory: " . memory_get_peak_usage(true) . " bytes\n";
?>
```

**Akses via browser dan cek output**

---

## 🐛 TROUBLESHOOTING

### Masalah: Apache Tidak Start Setelah Ubah Config

**Solusi:**
1. Cek syntax error di `httpd.conf`
2. Buka XAMPP Control Panel → Apache → Logs
3. Cek error log untuk detail

### Masalah: PHP Error Setelah Ubah Config

**Solusi:**
1. Cek syntax error di `php.ini`
2. Buka: `D:\Praktikum DWBI\xampp\php\logs\php_error_log`
3. Cek error log untuk detail

### Masalah: MySQL Error Setelah Ubah Config

**Solusi:**
1. Cek syntax error di `my.ini`
2. Buka XAMPP Control Panel → MySQL → Logs
3. Cek error log untuk detail

---

## ✅ CHECKLIST

- [ ] Optimasi PHP (`php.ini`)
- [ ] Optimasi Apache (`httpd.conf`) - Opsional
- [ ] Optimasi MySQL (`my.ini`) - Opsional
- [ ] Disable modules yang tidak perlu
- [ ] Clear Laravel cache
- [ ] Restart Apache & MySQL
- [ ] Test login

---

## 📞 JIKA MASIH LAMBAT

**Setelah semua optimasi:**

1. **Cek apakah masalahnya di dashboard:**
   - Akses dashboard langsung: `http://localhost/nurani/public/guru/dashboard`
   - Jika lambat, berarti dashboard controller yang lambat

2. **Cek query database:**
   - Enable query logging
   - Cek apakah ada query yang lambat

3. **Cek browser console:**
   - F12 → Network tab
   - Lihat request mana yang lambat

---

**Selamat optimasi! 🚀**

