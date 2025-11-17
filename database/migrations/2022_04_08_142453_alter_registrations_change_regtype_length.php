<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrationsChangeRegtypeLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		\DB::statement("ALTER TABLE registrations MODIFY regtype varchar(20) NULL default 'trade';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		\DB::statement("ALTER TABLE registrations MODIFY regtype varchar(10) NULL default 'trade';");
    }
}
