#!/bin/bash

echo "🔧 Fixing Event Foto Upload Issue"
echo "=================================="
echo ""

# 1. Run migrations
echo "1️⃣ Running migrations..."
php artisan migrate --force

# 2. Check if foto column exists
echo ""
echo "2️⃣ Checking if 'foto' column exists in events table..."
php artisan tinker --execute="
\$table = DB::select('DESCRIBE events');
\$columns = array_column(\$table, 'Field');
if (in_array('foto', \$columns)) {
    echo '✅ Column foto EXISTS\n';
} else {
    echo '❌ Column foto NOT FOUND!\n';
    echo 'Running migration manually...\n';
}
"

# 3. Create storage directory
echo ""
echo "3️⃣ Creating storage directory..."
mkdir -p storage/app/public/events
chmod -R 775 storage/app/public/events
echo "✅ Directory created"

# 4. Create storage link
echo ""
echo "4️⃣ Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"

# 5. Clear all caches
echo ""
echo "5️⃣ Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
echo "✅ Caches cleared"

# 6. Test event
echo ""
echo "6️⃣ Testing event ID 4..."
php artisan tinker --execute="
\$event = App\Models\Event::find(4);
if (\$event) {
    echo 'Event: ' . \$event->judul_event . '\n';
    echo 'Foto: ' . (\$event->foto ?? 'NULL') . '\n';
} else {
    echo '❌ Event not found\n';
}
"

echo ""
echo "✅ Done! Now try uploading foto again."
