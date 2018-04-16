<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $hidden = ['user_id'];

    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function user(){
        return Profile::hasOne('App\User','user_id','user_id');
    }

    public function surveys(){
        return Profile::hasMany('App\UserSurveys','user_id','user_id');
    }
}
