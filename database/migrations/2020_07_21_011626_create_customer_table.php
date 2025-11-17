<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('coid', 8);
            $table->string('name', 200);
            $table->string('phone', 20)->null()->default('');
            $table->string('address', 200)->null()->default('');
            $table->string('city', 200)->null()->default('');
            $table->string('state', 50)->null()->default('');
            $table->string('zip', 11)->null()->default('');
            $table->string('member', 8)->null()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
