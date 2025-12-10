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
        Schema::create('materi_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->text('identitas_mata_pelajaran')->nullable();
            $table->text('profil_sejarah')->nullable();
            $table->text('relevansi')->nullable();
            $table->timestamps();
            
            $table->unique(['guru_id', 'mata_pelajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_pembelajaran');
    }
};
