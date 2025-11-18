<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::table('settings')->insert([['name' => 'ADMIN_EMAIL', 'value' => 'crystal@gwgci.org'], ['name' => 'ADMIN_EMAIL2', 'value' => 'jeff@gwgci.org']]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('settings')->where('name', 'like', 'ADMIN_EMAIL%')->delete();
    }
};
