# Script untuk install PhpSpreadsheet
# Jalankan dengan: bash install-phpspreadsheet.sh

echo "=========================================="
echo "INSTALL PHPSPREADSHEET"
echo "=========================================="
echo ""

echo "📦 Installing PhpSpreadsheet..."
composer require phpoffice/phpspreadsheet

echo ""
echo "=========================================="
echo "✅ INSTALLATION SELESAI!"
echo "=========================================="
echo ""
echo "PhpSpreadsheet berhasil diinstall!"
echo "Sekarang aplikasi sudah bisa import file Excel (.xlsx/.xls)"
