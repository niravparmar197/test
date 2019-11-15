<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestRemark extends Model
{
    //
    public function createUser()
    {
    	return $this->belongsTo(User::class,"created_by");
    }
}
