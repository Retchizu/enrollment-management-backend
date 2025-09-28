<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('enrollment', function (Blueprint $table) {
            $table->dropForeign(['courses_id']);
            $table->renameColumn('courses_id', 'course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete(`cascade`);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('enrollment', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->renameColumn('course_id', 'courses_id');
            $table->foreign('courses_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
};
