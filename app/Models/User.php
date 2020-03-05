<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that are guarded from mass assignment
     *
     * @var array
     */
    protected $guarded = [
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

    /**
     * Returns boolean to check if the user is a admin
     *
     * @return mixed
     */
    public function isAdmin () {
        return $this->is_admin;
    }


    /**
     * Made to search some specific field on the user Model
     *
     * @param String $value
     *
     * @return mixed
     */
    public static function search(String $value){
        return self::where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }
}
