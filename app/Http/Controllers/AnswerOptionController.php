<?php

namespace App\Http\Controllers;

use App\AnswerOption;
use App\Question;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class AnswerOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($survey_id,$question_id)
    {
        //
        $AOption = AnswerOption::where('question_id',$question_id)->get();
        return $AOption;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('AnswerOption/new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        foreach ($request->options as $index => $option) {
            $AOption = new AnswerOption();
            $AOption->question_id = $request->question_id;
            $AOption->option_description = $option['option_string'];
            $AOption->option_value = $option['option_value'];
            $AOption->save();
            return response()->json(['msg'=>'Success'],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function show($survey_id,$question_id,$answerOption)
    {
        //
        return AnswerOption::find($answerOption)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerOption $answerOption)
    {
        //
        return view('AnswerOption/edit',['option'=>$answerOption]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$Survey_id,$question_id,$answerOption)
    {
        //
        $answerOption = AnswerOption::find($answerOption);
        (isset($request->option_string)) ? $answerOption->option_description = $request->option_string : NULL;
        (isset($request->option_value)) ? $answerOption->option_value = $request->option_value : NULL;
        $answerOption->save();
        return response()->json(['msg'=>'Success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerOption $answerOption)
    {
        //
        $answerOption->delete();
    }
}
