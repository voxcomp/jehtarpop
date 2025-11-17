<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsoritemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsoritems', function (Blueprint $table) {
            $table->id();
            $table->string('parent',50)->default('');
            $table->string('name',50)->default('');
            $table->integer('qty')->default(0);
            $table->integer('sold')->default(0);
            $table->float('price')->default(0);
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
        Schema::dropIfExists('sponsoritems');
    }
}
