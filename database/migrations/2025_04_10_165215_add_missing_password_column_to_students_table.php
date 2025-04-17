<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'password')) {
                $table->string('password')->after('email');
            }
            
            if (!Schema::hasColumn('students', 'remember_token')) {
                $table->rememberToken()->after('course');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'password')) {
                $table->dropColumn('password');
            }
            
            if (Schema::hasColumn('students', 'remember_token')) {
                $table->dropRememberToken();
            }
        });
    }
};
