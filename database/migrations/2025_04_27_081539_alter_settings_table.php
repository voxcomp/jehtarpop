<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('s_name', 150)->nullable();
            $table->string('s_display', 150)->nullable()->default('');
            $table->string('s_group', 150)->default('general');
            $table->string('s_css_selector', 150)->nullable();
            $table->string('s_css_property', 150)->nullable();
            $table->longText('s_value');
            $table->text('s_type')->nullable(false);
            $table->boolean('s_encrypt')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('s_name');
            $table->dropColumn('s_display');
            $table->dropColumn('s_group');
            $table->dropColumn('s_css_selector');
            $table->dropColumn('s_css_property');
            $table->dropColumn('s_value');
            $table->dropColumn('s_type');
            $table->dropColumn('s_encrypt');
        });
    }
}
