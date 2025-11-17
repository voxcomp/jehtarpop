<?php

/**
 * Collection of site-wide settings
 */

namespace App\Http\Repositories;

use App\Setting;

class Settings
{
    protected $table = 'settings';

    public function __construct() {}

    /**
     * Get setting from DB.  Return setting value.
     *
     * @param  $s_name  string
     * @return string
     */
    public static function get($s_name, $group = 'general', $default = null)
    {
        $setting = Setting::where('s_name', '=', $s_name)->where('s_group', '=', $group)->first();
        if ($setting) {
            return $setting->s_value; // ($setting->s_encrypt)?\Crypt::decrypt($setting->s_value):$setting->s_value;
        } else {
            return $default;
        }
    }

    /**
     * Get setting type from DB..
     *
     * @param  $s_name  string
     * @return string
     */
    public function gettype($s_name)
    {
        $setting = Setting::where('s_name', '=', $s_name)->first();

        if ($setting) {
            return $setting->s_type;
        } else {
            return false;
        }
    }

    /**
     * Get setting encryption from DB..
     *
     * @param  $s_name  string
     * @return string
     */
    public function getencrypt($s_name)
    {
        $setting = Setting::where('s_name', '=', $s_name)->first();

        if ($setting) {
            return $setting->s_encrypt;
        } else {
            return false;
        }
    }

    /**
     * Set setting to DB.  Return false if not saved.
     *
     * @param  $s_name  string
     * @param  $s_value  string
     * @return bool
     */
    public static function set($display, $name, $value, $group = 'general', $s_css_selector = '', $s_css_property = '', $type = 'alpha_dash', $encrypt = false)
    {
        $get = Setting::where('s_name', '=', $name)->where('s_group', '=', $group)->first();
        if (! $get) {
            $setting = new Setting;
            $setting->s_display = $display;
            $setting->s_name = $name;
            // if($type=='text') {
            //     $setting->s_value=htmlentities($value);
            // } else {
            //     $setting->s_value = ($encrypt)?\Crypt::encrypt($value):$value;
            // }
            $setting->s_value = $value;
            $setting->s_group = $group;
            $setting->s_css_selector = $s_css_selector;
            $setting->s_css_property = $s_css_property;
            $setting->s_type = $type;
            $setting->s_encrypt = $encrypt;
            $setting->save();
            if ($setting->id) {
                return true;
            }
        } else {
            // $get->update(['s_value'=>($get->s_encrypt)?\Crypt::encrypt($value):$value]);
            $get->update(['s_value' => $value]);

            return true;
        }

        return false;
    }

    /**
     * Update setting in DB.  Return false if not found.
     *
     * @param  $s_name  string
     * @param  $s_group  string
     * @param  $s_value  mixed
     */
    public function update($s_name, $s_group, $s_value)
    {
        $setting = Setting::where('s_name', '=', $s_name)->where('s_group', '=', $s_group)->first();
        if (! empty($setting)) {
            $setting->update(['s_value' => $s_value]);

            // if($setting->s_type=='text') {
            //     $setting->s_value=htmlentities($s_value);
            // } else {
            //     $setting->s_value = ($setting->s_encrypt)?\Crypt::encrypt($value):$value;
            // }
        }
        //	    Setting::where('s_name','=',$s_name)->where('s_group','=',$s_group)->update(['s_value'=>$s_value]);
    }

    /**
     * Delete setting from DB.  Return false if not found.
     *
     * @param  $s_name  string
     * @return bool
     */
    public function delete($s_name, $s_group = 'general')
    {
        $setting = Setting::where('s_name', '=', $s_name)->where('s_group', '=', $s_group)->delete();
    }

    /**
     * Return a Collection of all settings.
     *
     * @return Collection
     */
    public function all()
    {
        return Setting::all();
    }

    /**
     * Return a Collection of grouped settings.
     *
     * @return Collection
     */
    public function getGroup($s_group = 'general')
    {
        return Setting::where('s_group', '=', $s_group)->orderBy('s_css_selector')->get();
    }
}
