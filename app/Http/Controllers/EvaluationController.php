<?php

namespace App\Http\Controllers;

use App\Evaluate;
use App\Evaluation;
use App\Survey;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($survey, $user)
    {
        //
        $results = Evaluate::defaultEvalSurvey($survey,$user);
        $this->store($survey,$user,$results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($survey,$user,$result,$comments=NULL)
    {
        //
        $e = new Evaluation();
        $e->survey_id = $survey;
        $e->user_id = $user;
        $e->result = $result;
        $e->comments = $comments;
        $e->save();
        return response()->json(['msg'=>'Success'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        //
        return response()->json(['result'=>$evaluation->result,'comments'=>$evaluation->commments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        //
        $evaluation->delete();
    }
}
