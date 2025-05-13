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
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->unique();
            $table->string('course');
            $table->integer('year_level');
            $table->decimal('grade', 5, 2)->nullable();
            $table->string('id_photo')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'student_id',
                'course',
                'year_level',
                'grade',
                'id_photo',
                'is_admin'
            ]);
        });
    }
};
