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
    public function up(): void
    {
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->foreign('registration_id')->references('id')->on('registrations');
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->bigInteger('dob')->null()->default(0);
            $table->string('address', 200)->null()->default('');
            $table->string('city', 200)->null()->default('');
            $table->string('state', 50)->null()->default('');
            $table->string('zip', 11)->null()->default('');
            $table->string('mobile', 20)->null()->default('');
            $table->string('mobilecarrier', 50)->null()->default('');
            $table->string('email', 200)->null()->default('');
            $table->string('program', 100)->default('');
            $table->string('location', 100)->default('');
            $table->string('course', 100)->default('');
            $table->float('fee', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('registrants');
    }
};
