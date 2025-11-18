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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('coid', 8);
            $table->string('indid', 8);
            $table->string('first', 200);
            $table->string('last', 200);
            $table->string('phone', 20)->null()->default('');
            $table->string('mobile', 20)->null()->default('');
            $table->string('mobilecarrier', 50)->null()->default('');
            $table->string('email', 200)->null()->default('');
            $table->string('address', 200)->null()->default('');
            $table->string('city', 200)->null()->default('');
            $table->string('state', 50)->null()->default('');
            $table->string('zip', 11)->null()->default('');
            $table->float('balance', 8, 2)->nullable()->default(0);
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
        Schema::dropIfExists('students');
    }
};
