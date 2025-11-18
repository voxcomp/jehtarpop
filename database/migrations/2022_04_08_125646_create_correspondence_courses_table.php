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
        Schema::create('correspondence_courses', function (Blueprint $table) {
            $table->id();
            $table->string('schoolyear', 15);
            $table->string('courseid', 200);
            $table->string('coursedesc', 200)->nullable()->default('');
            $table->string('trade', 200);
            $table->string('tradedesc', 200)->nullable()->default('');
            $table->string('location', 30)->nullable()->default('');
            $table->float('member', 8, 2);
            $table->float('nonmember', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondence_courses');
    }
};
