# Setup CORS untuk Frontend Vercel

## 📝 Konfigurasi CORS di Laravel

### 1. Install Laravel CORS (jika belum ada)
```bash
composer require fruitcake/laravel-cors
```

### 2. Publish Config
```bash
php artisan vendor:publish --tag="cors"
```

### 3. Edit `config/cors.php`

```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://your-frontend.vercel.app',
        'http://localhost:3000', // untuk development
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
```

### 4. Edit `app/Http/Kernel.php`

Pastikan `HandleCors` middleware ada:

```php
protected $middleware = [
    // ...
    \Fruitcake\Cors\HandleCors::class,
];
```

### 5. Setup untuk API Routes

Di `routes/api.php`, pastikan menggunakan middleware yang tepat:

```php
Route::middleware(['cors', 'auth:sanctum'])->group(function () {
    // API routes
});
```

---

## 🔧 Environment Variables

Di Railway, tambahkan:

```env
FRONTEND_URL=https://your-frontend.vercel.app
```

Di `config/cors.php`, gunakan:

```php
'allowed_origins' => [
    env('FRONTEND_URL', 'http://localhost:3000'),
],
```

---

## ✅ Testing CORS

```bash
# Test dengan curl
curl -H "Origin: https://your-frontend.vercel.app" \
     -H "Access-Control-Request-Method: GET" \
     -H "Access-Control-Request-Headers: X-Requested-With" \
     -X OPTIONS \
     https://your-backend.railway.app/api/user
```

Seharusnya return:
```
Access-Control-Allow-Origin: https://your-frontend.vercel.app
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization
```

