<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    //
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    protected $hidden = ['question_id'];
}
