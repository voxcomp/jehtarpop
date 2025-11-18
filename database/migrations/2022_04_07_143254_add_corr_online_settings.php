<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
     */
    public function down(): void
    {
        \DB::table('settings')->where('name', 'like', 'online%')->delete();
        \DB::table('settings')->where('name', 'like', 'correspondence%')->delete();
    }
};
