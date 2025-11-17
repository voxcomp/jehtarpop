<?php

use Illuminate\Database\Migrations\Migration;

class AlterSettingsAddApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('settings')->insert([['name' => 'api_login', 'value' => ''], ['name' => 'transaction_key', 'value' => '']]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('name', 'api_login')->delete();
        \DB::table('settings')->where('name', 'transaction_key')->delete();
    }
}
