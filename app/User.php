<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $rules_create = array(
        'name'          => 'required|max:50',
        'phone'         => 'required|unique:users|digits:11',
        'address'       => 'required|max:100',
        'age'           => 'nullable|integer|min:1|max:130',
        'profession'    => 'max:50'
    );

    function rules_update($id) {
        return $rules_update = array(
            'name'          => 'required|max:50',
            'phone'         => [
                'required',
                Rule::unique('users')->ignore($id),
                'digits:11'
            ],
            'address'       => 'required|max:100',
            'age'           => 'nullable|integer|min:1|max:130',
            'profession'    => 'max:50'
        );
    }

    function detail() {
        return $this->hasOne('App\User_detail');
    }
}