<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{
    protected $fillable = [
        'event_name','venue','description','event_from_time','event_to_time',
    ];
}
