<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['user_id','password','token','remember_token','created_at','updated_at','deleted_at'];
    protected $primaryKey = 'user_id';

    public function profile() {
        return User::hasOne('App\Profile','user_id','user_id');
    }

    public function surveys() {
        return User::hasMany('App\UserSurvey','user_id','user_id');
    }

}
