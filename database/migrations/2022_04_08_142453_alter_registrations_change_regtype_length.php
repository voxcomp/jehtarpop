<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        \DB::statement("ALTER TABLE registrations MODIFY regtype varchar(20) NULL default 'trade';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE registrations MODIFY regtype varchar(10) NULL default 'trade';");
    }
};
