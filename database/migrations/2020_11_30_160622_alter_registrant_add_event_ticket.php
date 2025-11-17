<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrantAddEventTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->bigInteger('event_id')->default('0');
            $table->string('event', 200)->default('');
            $table->bigInteger('ticket_id')->default('0');
            $table->string('ticket', 100)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn('event_id');
            $table->dropColumn('event');
            $table->dropColumn('ticket_id');
            $table->dropColumn('ticket');
        });
    }
}
