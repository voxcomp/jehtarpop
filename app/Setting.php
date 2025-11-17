<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
        's_name',
        's_display',
        's_group',
        's_css_selector',
        's_css_property',
        's_value',
        's_type',
        's_encrypt',
    ];

    public function getValueAttribute()
    {
        return $this->getSValueAttribute($this->s_value);
    }

    public function setValueAttribute($value)
    {
        $this->setSValueAttribute($value);
    }

    public function getSValueAttribute($value)
    {
        switch ($this->s_type) {
            case 'numeric':
                return (float) $value;
                break;
            case 'text':
                return html_entity_decode($value);
                break;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                break;
            default:
                return ($this->s_encrypt) ? \Crypt::decrypt($value) : $value;
        }
    }

    public function setSValueAttribute($value)
    {
        if ($this->s_type == 'text') {
            $this->attributes['s_value'] = htmlentities($value);
        } else {
            $this->attributes['s_value'] = ($this->s_encrypt) ? \Crypt::encrypt($value) : $value;
        }
    }
}
