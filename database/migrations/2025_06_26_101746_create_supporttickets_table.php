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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('contactname', 100)->nullable()->default('');
            $table->string('contactphone', 20)->nullable()->default('');
            $table->string('contactemail', 200)->nullable()->default('');
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->string('title', 200)->nullable()->default('');
            $table->text('description');
            $table->text('transactionerror')->nullable();
            $table->string('status', 25)->default('open');
            $table->string('email', 300)->nullable();
            $table->tinyInteger('visitor')->default(1);
            $table->float('time')->default(0);
            $table->text('registration')->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
};
