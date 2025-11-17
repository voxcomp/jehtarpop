<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrespondenceCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correspondence_courses', function (Blueprint $table) {
            $table->id();
            $table->string('schoolyear', 15);
            $table->string('courseid', 200);
            $table->string('coursedesc', 200)->nullable()->default('');
            $table->string('trade', 200);
            $table->string('tradedesc', 200)->nullable()->default('');
            $table->string('location', 30)->nullable()->default('');
            $table->float('member', 8, 2);
            $table->float('nonmember', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correspondence_courses');
    }
}
