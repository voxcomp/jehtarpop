<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('settings')->insert([['name' => 'ADMIN_EMAIL', 'value' => 'crystal@gwgci.org'], ['name' => 'ADMIN_EMAIL2', 'value' => 'jeff@gwgci.org']]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('name', 'like', 'ADMIN_EMAIL%')->delete();
    }
};
