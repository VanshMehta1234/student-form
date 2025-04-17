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
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'course_id')) {
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('quizzes', 'title')) {
                $table->string('title');
            }
            
            if (!Schema::hasColumn('quizzes', 'description')) {
                $table->text('description')->nullable();
            }
            
            if (!Schema::hasColumn('quizzes', 'time_limit')) {
                $table->integer('time_limit')->nullable();
            }
            
            if (!Schema::hasColumn('quizzes', 'passing_score')) {
                $table->integer('passing_score')->default(70);
            }
            
            if (!Schema::hasColumn('quizzes', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('time_limit');
            $table->dropColumn('passing_score');
            $table->dropColumn('is_active');
        });
    }
}; 