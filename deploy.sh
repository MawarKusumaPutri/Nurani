#!/bin/bash

# Deploy script untuk Railway
# Script ini akan dijalankan otomatis setelah build selesai

echo "🚀 Starting deployment process..."

# Clear all caches
echo "🧹 Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Rebuild caches
echo "🔨 Rebuilding caches..."
php artisan route:cache
php artisan config:cache
php artisan view:cache

# Create storage link if not exists
echo "🔗 Creating storage link..."
php artisan storage:link

# Optimize application
echo "⚡ Optimizing application..."
php artisan optimize

echo "✅ Deployment completed successfully!"
