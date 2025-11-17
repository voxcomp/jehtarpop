<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('donations');
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('fname',50)->default('');
            $table->string('lname',75)->default('');
            $table->string('title',75)->nullable()->default('');
            $table->string('company',200)->nullable()->default('');
            $table->string('email',150)->default('');
            $table->string('phone',20)->nullable()->default('');
            $table->string('address',200)->default('');
            $table->string('city',100)->default('');
            $table->string('state',20)->default('');
            $table->string('zip',20)->default('');
            $table->string('paytype',20)->nullable()->default('');
            $table->float('amount')->default(0);
            $table->float('paid')->default(0);
            $table->text('options')->nullable();
            $table->tinyInteger('sponsor')->default(0);
            $table->string('cardno',4)->nullable()->default('');
            $table->string('cardtype',20)->nullable()->default('');
            $table->string('clientip',20)->default('');
            $table->timestamps();
        });

        $statement = "ALTER TABLE donations AUTO_INCREMENT = 72673;";
        DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
