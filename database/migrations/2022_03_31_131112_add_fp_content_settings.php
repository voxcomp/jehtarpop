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
            ['name' => 'fp_correspondence', 'value' => ''],
            ['name' => 'fp_online', 'value' => ''],
            ['name' => 'fp_trade', 'value' => ''],
            ['name' => 'fp_training', 'value' => ''],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('settings')->where('name', 'like', 'fp_%')->delete();
    }
};
