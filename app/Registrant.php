<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    protected $fillable = [
        'registration_id', 'firstname', 'lastname', 'mobile', 'mobilecarrier', 'dob', 'address', 'city', 'state', 'zip', 'email', 'program', 'location', 'course', 'fee', 'companypaid', 'event_id', 'event', 'ticket_id', 'ticket', 'das', 'map', 'indid', 'schoolyear'
    ];

	public function registration() {
	    return $this->belongsTo('App\Registration');
	}
	
	public function myticket() {
		return $this->hasOne('App\Ticket','ticket_id','id');
	}
}
