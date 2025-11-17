<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsAddEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('settings')->insert(
        [
            [
                's_name'=>'fp_event',
                's_display'=>'Events',
                's_group'=>'editor',
                's_css_selector'=>null,
                's_css_property'=>null,
                's_value'=>'Upcoming events',
                's_type'=>'text',
                's_encrypt'=>0
            ],
            [
                's_name'=>'trainingconfirmation',
                's_display'=>'Training Confirmation',
                's_group'=>'editor',
                's_css_selector'=>null,
                's_css_property'=>null,
                's_value'=>'',
                's_type'=>'text',
                's_encrypt'=>0
            ],
            [
                's_name'=>'trainingregistration',
                's_display'=>'Training Registration',
                's_group'=>'status',
                's_css_selector'=>null,
                's_css_property'=>null,
                's_value'=>'true',
                's_type'=>'boolean',
                's_encrypt'=>0
            ],
            [
                's_name'=>'trainingmessage',
                's_display'=>'Training Message',
                's_group'=>'status',
                's_css_selector'=>null,
                's_css_property'=>null,
                's_value'=>'The training registration is currently closed.',
                's_type'=>'alpha_dash',
                's_encrypt'=>0
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('s_name','fp_events')->delete();
        \DB::table('settings')->where('s_name','trainingconfirmation')->delete();
        \DB::table('settings')->where('s_name','trainingregistration')->delete();
        \DB::table('settings')->where('s_name','trainingmessage')->delete();
    }
}
