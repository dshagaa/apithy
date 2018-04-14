<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $primaryKey = 'question_id';
    public $timestamps = false;
    public function getTypes() {
        return Question::hasOne('App\QuestionType','type_id','question_type');
    }
}
