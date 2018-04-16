<?php

namespace App\Http\Controllers;

use App\Answer;
use App\AnswerOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $answer = new Answer();
        $answer->user_id = Auth::user()->user_id;
        $answer->question_id = $request->question_id;
        $answer->value = $request->value;

        $answer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
        return response()->json(['answer'=>$answer],200);
    }
}
