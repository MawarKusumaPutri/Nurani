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
        Schema::table('jadwal', function (Blueprint $table) {
<<<<<<< HEAD
            //
=======
            $table->boolean('is_lapangan')->default(false)->after('is_lab');
>>>>>>> bd1c07c5fea862aa0b0a3105a6b0f728d080abb5
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
<<<<<<< HEAD
            //
        });
    }
};
=======
            $table->dropColumn('is_lapangan');
        });
    }
};

>>>>>>> bd1c07c5fea862aa0b0a3105a6b0f728d080abb5
