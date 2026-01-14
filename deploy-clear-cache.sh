#!/bin/bash

# Script untuk clear cache di Railway setelah deploy
# Jalankan script ini setelah deploy

echo "Clearing all caches..."
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Done! Cache cleared and optimized."
