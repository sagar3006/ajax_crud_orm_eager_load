<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    protected $fillable = [
        'user_id', 'age', 'gender', 'profession'
    ];

    function user() {
    	return $this->belongsTo('App\User');
    }
}