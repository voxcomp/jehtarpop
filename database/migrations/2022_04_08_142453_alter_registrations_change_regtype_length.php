<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement("ALTER TABLE registrations MODIFY regtype varchar(20) NULL default 'trade';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("ALTER TABLE registrations MODIFY regtype varchar(10) NULL default 'trade';");
    }
};
