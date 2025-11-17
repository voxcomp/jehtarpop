<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SupportTicket extends Model
{
    use Notifiable;

    protected $fillable = [
        'contactname', 'contactphone', 'contactemail', 'registration_id', 'title', 'description', 'transactionerror', 'status', 'email', 'visitor'
    ];

    public function routeNotificationForMail($notification)
    {
        if (!$this->email) {
            return null;
        }
        
        // Split by comma and trim whitespace
        return array_map('trim', explode(',', $this->email));
    }    

    public function getLightAttribute() {
        switch($this->status) {
            case "open":
                return '<img src="'.\URL::to('/').'/images/traffic-red.png" class="img-fluid pr-2" style="max-width:40px">';
            case "closed":
                return '<img src="'.\URL::to('/').'/images/traffic-green.png" class="img-fluid pr-2" style="max-width:40px">';
            case "working":
                return '<img src="'.\URL::to('/').'/images/traffic-yellow.png" class="img-fluid pr-2" style="max-width:40px">';
        }
    }

    public function getPersonAttribute() {
        switch($this->visitor) {
            case 0:
                return '<i class="fas fa-users-cog" style="font-size:30px;color:#000;"></i>';
            case 1:
                return '<i class="fas fa-user" style="font-size:30px;color:#000;"></i>';
        }
    }
    
    public function record() {
        return $this->belongsTo(Registration::class);
    } 

    public function notes() {
        return $this->hasMany(SupportTicketNote::class,'support_ticket_id','id');
    } 

    public function files() {
        return $this->hasMany(SupportTicketFile::class,'support_ticket_id','id');
    }
}
