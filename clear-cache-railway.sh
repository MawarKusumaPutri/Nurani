#!/bin/bash

echo "🚀 Clearing all Laravel caches on Railway..."

# Clear route cache
echo "📍 Clearing route cache..."
php artisan route:clear
php artisan route:cache

# Clear config cache
echo "⚙️  Clearing config cache..."
php artisan config:clear
php artisan config:cache

# Clear view cache
echo "👁️  Clearing view cache..."
php artisan view:clear

# Clear application cache
echo "🗑️  Clearing application cache..."
php artisan cache:clear

# Optimize application
echo "⚡ Optimizing application..."
php artisan optimize:clear
php artisan optimize

# Create storage link if not exists
echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ All caches cleared successfully!"
echo ""
echo "🔍 Verifying siswa routes..."
php artisan route:list --name=siswa

echo ""
echo "✨ Done! Please refresh your browser."
