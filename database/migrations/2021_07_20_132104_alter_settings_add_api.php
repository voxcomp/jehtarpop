<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::table('settings')->insert([['name' => 'api_login', 'value' => ''], ['name' => 'transaction_key', 'value' => '']]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('settings')->where('name', 'api_login')->delete();
        \DB::table('settings')->where('name', 'transaction_key')->delete();
    }
};
