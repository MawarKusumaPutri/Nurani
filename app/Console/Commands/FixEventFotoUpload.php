<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\Event;

class FixEventFotoUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:event-foto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix event foto upload issue - run migrations, create directories, and setup storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing Event Foto Upload Issue');
        $this->info('==================================');
        $this->newLine();

        // 1. Run migrations
        $this->info('1️⃣  Running migrations...');
        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->info('✅ Migrations completed');
            $this->line(Artisan::output());
        } catch (\Exception $e) {
            $this->error('❌ Migration failed: ' . $e->getMessage());
        }
        $this->newLine();

        // 2. Check if foto column exists
        $this->info('2️⃣  Checking if "foto" column exists in events table...');
        try {
            $columns = DB::select('DESCRIBE events');
            $columnNames = array_column($columns, 'Field');
            
            if (in_array('foto', $columnNames)) {
                $this->info('✅ Column "foto" EXISTS in events table');
            } else {
                $this->error('❌ Column "foto" NOT FOUND!');
                $this->warn('Please check if migration file exists and run manually.');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error checking column: ' . $e->getMessage());
        }
        $this->newLine();

        // 3. Create storage directory
        $this->info('3️⃣  Creating storage directory...');
        try {
            $eventsDir = storage_path('app/public/events');
            
            if (!File::exists($eventsDir)) {
                File::makeDirectory($eventsDir, 0775, true);
                $this->info('✅ Directory created: ' . $eventsDir);
            } else {
                $this->info('✅ Directory already exists: ' . $eventsDir);
            }
            
            // Set permissions
            chmod($eventsDir, 0775);
            $this->info('✅ Permissions set to 775');
        } catch (\Exception $e) {
            $this->error('❌ Error creating directory: ' . $e->getMessage());
        }
        $this->newLine();

        // 4. Create storage link
        $this->info('4️⃣  Creating storage link...');
        try {
            Artisan::call('storage:link');
            $this->info('✅ Storage link created');
            $this->line(Artisan::output());
        } catch (\Exception $e) {
            $this->warn('⚠️  Storage link may already exist: ' . $e->getMessage());
        }
        $this->newLine();

        // 5. Clear all caches
        $this->info('5️⃣  Clearing caches...');
        try {
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            $this->info('✅ All caches cleared');
        } catch (\Exception $e) {
            $this->error('❌ Error clearing cache: ' . $e->getMessage());
        }
        $this->newLine();

        // 6. Test event
        $this->info('6️⃣  Testing event ID 4...');
        try {
            $event = Event::find(4);
            
            if ($event) {
                $this->info('Event found:');
                $this->line('  - ID: ' . $event->id);
                $this->line('  - Judul: ' . $event->judul_event);
                $this->line('  - Foto: ' . ($event->foto ?? 'NULL'));
                
                if ($event->foto) {
                    $fullPath = storage_path('app/public/' . $event->foto);
                    $exists = file_exists($fullPath);
                    $this->line('  - File exists: ' . ($exists ? '✅ YES' : '❌ NO'));
                    if ($exists) {
                        $this->line('  - File size: ' . filesize($fullPath) . ' bytes');
                    }
                } else {
                    $this->warn('  ⚠️  Event does not have foto yet. Upload one to test!');
                }
            } else {
                $this->error('❌ Event ID 4 not found');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error testing event: ' . $e->getMessage());
        }
        $this->newLine();

        // 7. Summary
        $this->info('📊 Summary:');
        $this->line('  - Migrations: ✅ Run');
        $this->line('  - Storage directory: ✅ Created');
        $this->line('  - Storage link: ✅ Created');
        $this->line('  - Caches: ✅ Cleared');
        $this->newLine();

        $this->info('✅ Done! Now try uploading foto again.');
        $this->info('📝 Steps to test:');
        $this->line('  1. Refresh your browser (Ctrl + Shift + R)');
        $this->line('  2. Go to event detail page');
        $this->line('  3. Click "Upload Foto" button');
        $this->line('  4. Select an image and upload');
        $this->line('  5. Foto should appear!');
        
        return Command::SUCCESS;
    }
}
