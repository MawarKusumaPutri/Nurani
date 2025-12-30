#!/bin/bash

# Script untuk menjalankan migration di Railway
# Jalankan dengan: bash run-migration-railway.sh

echo "=========================================="
echo "MENJALANKAN MIGRATION DI RAILWAY"
echo "=========================================="
echo ""

# Pastikan Railway CLI sudah terinstall
if ! command -v railway &> /dev/null
then
    echo "❌ Railway CLI belum terinstall!"
    echo "Install dengan: npm install -g @railway/cli"
    exit 1
fi

echo "✅ Railway CLI ditemukan"
echo ""

# Login ke Railway (jika belum)
echo "🔐 Pastikan Anda sudah login ke Railway..."
echo "Jika belum, jalankan: railway login"
echo ""

# Link ke project (jika belum)
echo "🔗 Pastikan Anda sudah link ke project Railway..."
echo "Jika belum, jalankan: railway link"
echo ""

# Jalankan migration
echo "🚀 Menjalankan migration..."
railway run php artisan migrate --force

echo ""
echo "=========================================="
echo "✅ MIGRATION SELESAI!"
echo "=========================================="
echo ""
echo "Silakan refresh halaman dan coba lagi."
