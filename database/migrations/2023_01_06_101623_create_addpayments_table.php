<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addpayments', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('address',200)->null()->default('');
            $table->string('city',200)->null()->default('');
            $table->string('state',50)->null()->default('');
            $table->string('zip',11)->null()->default('');
	        $table->string('transaction_id',50);
	        $table->float('amount', 10, 2);
	        $table->string('currency');
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
        Schema::dropIfExists('addpayments');
    }
}
