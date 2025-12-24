#!/bin/bash

echo "🚀 Running post-deploy setup..."

# Install/update dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Fix event foto setup
echo "📸 Setting up event foto storage..."
php artisan fix:event-foto

# Clear and cache routes
echo "🔄 Optimizing application..."
php artisan route:cache
php artisan config:cache

echo "✅ Post-deploy setup completed!"
