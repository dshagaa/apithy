<?php

namespace App\Http\Controllers;

use App\Question;
use App\Survey;
use App\SurveyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($survey_id)
    {
        //
        $survey = Survey::with(['questions'])->findOrFail($survey_id);
        return response()->json($survey);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Question/new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        //
        $q = new Question();
        $q->survey_id = $survey->survey_id;
        $q->question_description = $request->question;
        $q->question_instruction = ($request->instruction) ? $request->instruction : NULL;
        $q->question_type = $request->type;
        $q->save();
        return response()->json(['msg'=>'Success'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey,Question $question)
    {
        //
        $question = Question::with(['type','options'])->findOrFail($question->question_id);
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        return view('Question/edit',['question'=>$question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $survey_id, $question_id)
    {
        //
        $question = Question::find($question_id);
        (isset($request->question)) ? $question->question_description = $request->question : NULL;
        (isset($request->instruction)) ? $question->question_instruction = $request->instruction : NULL;
        (isset($request->type)) ? $question->question_type = $request->type : NULL;
        $question->save();
        return response()->json(['msg'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        $question->delete();
    }
}
