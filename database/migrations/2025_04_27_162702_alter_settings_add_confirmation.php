<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::table('settings')->insert(
            [
                [
                    's_name' => 'tradeconfirmation',
                    's_display' => 'Trade Confirmation',
                    's_group' => 'editor',
                    's_css_selector' => null,
                    's_css_property' => null,
                    's_value' => '',
                    's_type' => 'text',
                    's_encrypt' => 0,
                ],
                [
                    's_name' => 'correspondenceconfirmation',
                    's_display' => 'Correspondence Confirmation',
                    's_group' => 'editor',
                    's_css_selector' => null,
                    's_css_property' => null,
                    's_value' => '',
                    's_type' => 'text',
                    's_encrypt' => 0,
                ],
                [
                    's_name' => 'eventconfirmation',
                    's_display' => 'Event Confirmation',
                    's_group' => 'editor',
                    's_css_selector' => null,
                    's_css_property' => null,
                    's_value' => '',
                    's_type' => 'text',
                    's_encrypt' => 0,
                ],
                [
                    's_name' => 'onlineconfirmation',
                    's_display' => 'Online Confirrmation',
                    's_group' => 'editor',
                    's_css_selector' => null,
                    's_css_property' => null,
                    's_value' => '',
                    's_type' => 'text',
                    's_encrypt' => 0,
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('settings')->where('s_name', 'tradeconfirmation')->delete();
        \DB::table('settings')->where('s_name', 'correspondenceconfirmation')->delete();
        \DB::table('settings')->where('s_name', 'eventconfirmation')->delete();
        \DB::table('settings')->where('s_name', 'onlineconfirmation')->delete();
    }
};
