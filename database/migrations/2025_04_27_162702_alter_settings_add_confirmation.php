<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsAddConfirmation extends Migration
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
                    's_name'=>'tradeconfirmation',
                    's_display'=>'Trade Confirmation',
                    's_group'=>'editor',
                    's_css_selector'=>null,
                    's_css_property'=>null,
                    's_value'=>'',
                    's_type'=>'text',
                    's_encrypt'=>0
                ],
                [
                    's_name'=>'correspondenceconfirmation',
                    's_display'=>'Correspondence Confirmation',
                    's_group'=>'editor',
                    's_css_selector'=>null,
                    's_css_property'=>null,
                    's_value'=>'',
                    's_type'=>'text',
                    's_encrypt'=>0
                ],
                [
                    's_name'=>'eventconfirmation',
                    's_display'=>'Event Confirmation',
                    's_group'=>'editor',
                    's_css_selector'=>null,
                    's_css_property'=>null,
                    's_value'=>'',
                    's_type'=>'text',
                    's_encrypt'=>0
                ],
                [
                    's_name'=>'onlineconfirmation',
                    's_display'=>'Online Confirrmation',
                    's_group'=>'editor',
                    's_css_selector'=>null,
                    's_css_property'=>null,
                    's_value'=>'',
                    's_type'=>'text',
                    's_encrypt'=>0
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('settings')->where('s_name','tradeconfirmation')->delete();
        \DB::table('settings')->where('s_name','correspondenceconfirmation')->delete();
        \DB::table('settings')->where('s_name','eventconfirmation')->delete();
        \DB::table('settings')->where('s_name','onlineconfirmation')->delete();
    }
}
