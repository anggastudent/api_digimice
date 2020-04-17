<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class EventPresensi extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = "event_presensie";

    protected $fillable = [
        'participant_user_id','event_agenda_event_session_id','barcode','status',
        'event_agenda_event_session_event_id','event_agenda_event_session_event_event_id'
    ];

   
}
