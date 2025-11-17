<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFpContentSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('settings')->insert([
	        ['name'=>'fp_correspondence','value'=>''],
	        ['name'=>'fp_online','value'=>''],
	        ['name'=>'fp_trade','value'=>''],
	        ['name'=>'fp_training','value'=>'']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('name','like','fp_%')->delete();
    }
}
