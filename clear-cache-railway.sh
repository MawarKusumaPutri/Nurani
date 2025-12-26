#!/bin/bash

# Script untuk clear cache di Railway setelah deployment
# Jalankan script ini di Railway console

echo "🧹 Clearing Laravel caches..."

# Clear route cache
echo "📍 Clearing route cache..."
php artisan route:clear
php artisan route:cache

# Clear config cache
echo "⚙️ Clearing config cache..."
php artisan config:clear
php artisan config:cache

# Clear view cache
echo "👁️ Clearing view cache..."
php artisan view:clear

# Clear all optimization cache
echo "🚀 Clearing optimization cache..."
php artisan optimize:clear

# Optimize application
echo "✨ Optimizing application..."
php artisan optimize

# Create storage link (jika belum ada)
echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ All caches cleared successfully!"
echo "🎉 Deployment complete!"
