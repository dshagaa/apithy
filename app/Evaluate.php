<?php
/**
 * Created by PhpStorm.
 * User: Dshagaa
 * Date: 16/04/2018
 * Time: 03:41 PM
 */

namespace App;


use Illuminate\Http\Request;

class Evaluate
{
    public function defaultEvalSurvey(Survey $s, User $u){
        $questions = Question::where('survey_id',$s->survey_id)->get();
        $epsilon = 0;

        foreach ($questions as $index => $q){
            // (NUM_PREGUNTAS / (SUMATORIA RESPUESTAS)) * 100
            $u_answer = Answer::where('question_id',$q->id)->where('user_id',$u->user_id)->first();
            $epsilon = $epsilon + $u_answer->value;
        }
        $delta = $questions->length()/$epsilon;
        $result = ($delta)*100;
        return response()->json(['result'=>$result]);
    }

    public function newEvalMethod(Request $request) {
        $EMethod = new EvaluationMethod();
        $EMethod->method_name = $request->name;
        $EMethod->method->formule = $request->formule;
        $EMethod->save();
        return response()->json(['msg'=>'Success'],200);
    }

    public function evalBy(EvaluationMethod $method){
        return response()->json(['msg'=>'not yet.']);
    }
}