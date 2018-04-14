<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $primaryKey = 'survey_id';

    public function questions() {
       return  Survey::hasMany('App\Question','survey_id','survey_id');
    }
}
