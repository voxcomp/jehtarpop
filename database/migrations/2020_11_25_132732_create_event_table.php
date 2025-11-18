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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('event_id')->default(0);
            $table->unsignedInteger('startdate');
            $table->string('name', 250);
            $table->string('contact', 250);
            $table->string('location', 350);
            $table->string('city', 100);
            $table->integer('minimum')->default(0);
            $table->integer('maximum')->default(100000);
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
        Schema::dropIfExists('events');
    }
};
