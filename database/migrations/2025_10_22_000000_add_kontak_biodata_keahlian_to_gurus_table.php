<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (!Schema::hasColumn('gurus', 'kontak')) {
                $table->string('kontak')->nullable()->after('mata_pelajaran');
            }
            if (!Schema::hasColumn('gurus', 'biodata')) {
                $table->text('biodata')->nullable()->after('kontak');
            }
            if (!Schema::hasColumn('gurus', 'keahlian')) {
                $table->text('keahlian')->nullable()->after('biodata');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['kontak', 'biodata', 'keahlian']);
        });
    }
};

