<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{


//     Client ID: 1
// Client secret: sZoScYSWCrQ3mK1rEBNOSP9RZhVy8txTTlhdrQHe
// Password grant client created successfully.
// Client ID: 2
// Client secret: AzD4yF00A782G3dola4w7YtrP4eY5yA0C8SrZVre

    use Notifiable,HasApiTokens;

    public $keyType="string";
    public $primaryKey='kd_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kd_user', 
        'nama', 
        'username', 
        'password',
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
}
