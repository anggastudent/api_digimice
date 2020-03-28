<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class EventAgenda extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = "event_agenda";

    protected $fillable = [
        'participant_event_id','event_agenda_id','barcode','status'
    ];

    public function session(){
    	return $this->belongsTo('App\EventSession','event_session_id','id');
    }
   
}
