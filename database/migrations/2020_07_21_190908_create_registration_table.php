<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('coid',8);
            $table->string('name',200);
            $table->string('phone',20)->null()->default('');
            $table->string('address',200)->null()->default('');
            $table->string('city',200)->null()->default('');
            $table->string('state',50)->null()->default('');
            $table->string('zip',11)->null()->default('');
            $table->string('contact',200)->null()->default('');
            $table->string('cphone',20)->null()->default('');
            $table->string('cemail',200)->null()->default('');
            $table->integer('registrantcount')->default(0);
            $table->string('member',5)->default('true');
            $table->string('paytype',10)->default('credit');
            $table->float('total',10,2);
            $table->float('paid',10,2);
            $table->float('due',10,2);
            $table->float('balance',10,2);
            $table->timestamps();
        });
        
        DB::statement("ALTER TABLE registrations AUTO_INCREMENT = 10472;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
