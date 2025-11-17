<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTradedescCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
		    $table->string('tradedesc',200)->nullable()->default('');
		    $table->string('coursedesc',200)->nullable()->default('');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
	        $table->dropColumn('tradedesc');
	        $table->dropColumn('coursedesc');
        });
    }
}
