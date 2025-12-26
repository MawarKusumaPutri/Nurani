#!/bin/bash

# Script untuk clear cache di Railway setelah deploy
# Jalankan script ini di Railway Console

echo "========================================="
echo "🚀 CLEARING ALL LARAVEL CACHES"
echo "========================================="
echo ""

# 1. Clear View Cache (PALING PENTING untuk perubahan Blade)
echo "📄 Clearing View Cache..."
php artisan view:clear
if [ $? -eq 0 ]; then
    echo "✅ View cache cleared successfully"
else
    echo "❌ Failed to clear view cache"
fi
echo ""

# 2. Clear Application Cache
echo "🗑️  Clearing Application Cache..."
php artisan cache:clear
if [ $? -eq 0 ]; then
    echo "✅ Application cache cleared successfully"
else
    echo "❌ Failed to clear application cache"
fi
echo ""

# 3. Clear Config Cache
echo "⚙️  Clearing Config Cache..."
php artisan config:clear
if [ $? -eq 0 ]; then
    echo "✅ Config cache cleared successfully"
else
    echo "❌ Failed to clear config cache"
fi
echo ""

# 4. Clear Route Cache
echo "🛣️  Clearing Route Cache..."
php artisan route:clear
if [ $? -eq 0 ]; then
    echo "✅ Route cache cleared successfully"
else
    echo "❌ Failed to clear route cache"
fi
echo ""

# 5. Clear All Optimizations
echo "⚡ Clearing All Optimizations..."
php artisan optimize:clear
if [ $? -eq 0 ]; then
    echo "✅ Optimizations cleared successfully"
else
    echo "❌ Failed to clear optimizations"
fi
echo ""

echo "========================================="
echo "✨ ALL CACHES CLEARED SUCCESSFULLY!"
echo "========================================="
echo ""
echo "📋 Next Steps:"
echo "1. Hard refresh your browser (Ctrl + Shift + F5)"
echo "2. Login as Guru"
echo "3. Go to 'Manajemen Materi'"
echo "4. Click 'RPP' dropdown"
echo "5. You should see 4 options:"
echo "   - MTs Nurul Aiman"
echo "   - Google Drive"
echo "   - Kemdikbud"
echo "   - ChatGPT (Referensi)"
echo ""
echo "========================================="
