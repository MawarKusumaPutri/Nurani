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
        Schema::table('surats', function (Blueprint $table) {
            $table->enum('tipe_surat', ['masuk', 'keluar'])->default('keluar')->after('jenis_surat');
            $table->string('pengirim')->nullable()->after('penerima_lainnya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn(['tipe_surat', 'pengirim']);
        });
    }
};
