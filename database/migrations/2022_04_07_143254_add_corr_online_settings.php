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
        \DB::table('settings')->insert([
            ['name' => 'onlineregistration', 'value' => 'true'],
            ['name' => 'onlinemessage', 'value' => 'The class registration is currently closed.'],
            ['name' => 'correspondenceregistration', 'value' => 'true'],
            ['name' => 'correspondencemessage', 'value' => 'The class registration is currently closed.'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('name', 'like', 'online%')->delete();
        \DB::table('settings')->where('name', 'like', 'correspondence%')->delete();
    }
};
