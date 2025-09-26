<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up (): void
    {
        Schema::create('enrollment', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('student_id') -> index();
            $table -> foreignId('courses_id') -> index();
        });
    }

    public function down (): void
    {
        Schema::dropIfExists('enrollment');
    }
};