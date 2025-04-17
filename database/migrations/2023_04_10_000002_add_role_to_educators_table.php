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
        Schema::table('educators', function (Blueprint $table) {
            if (!Schema::hasColumn('educators', 'role')) {
                $table->string('role')->default('educator')->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('educators', function (Blueprint $table) {
            if (Schema::hasColumn('educators', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
}; 