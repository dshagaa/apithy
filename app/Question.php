<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AnswerOption;

class Question extends Model
{
    //
    protected $primaryKey = 'question_id';
    public $timestamps = false;

    protected $hidden = ['survey_id'];

    public function type() {
        return Question::hasOne('App\QuestionType','type_id','question_type');
    }
    public function options() {
        return Question::hasMany('App\AnswerOption','question_id','question_id');
    }
}
