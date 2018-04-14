<?php

namespace App\Http\Controllers;

use App\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Survey::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        $survey = new Survey();

        $survey->survey_name = $request->name;
        $survey->survey_description = $request->description;
        $survey->min_age = $request->min_age;
        $survey->max_age = $request->max_age;
        $survey->expire_at = Carbon::parse("{$request->expiration_date}{$request->expiration_time}");

        $survey->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
        $data = [
            'name' => $survey->survey_name,
            'description' => $survey->survey_description,
            'min_age' => $survey->min_age,
            'max_age' => $survey->max_age,
            'expiration_date' => Carbon::parse($survey->expiration_at)->format('Y-m-d'),
            'expiration_time' => Carbon::parse($survey->expire_at)->format('H:i')
        ];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
        $data = [
            'name' => $survey->survey_name,
            'description' => $survey->survey_description,
            'min_age' => $survey->min_age,
            'max_age' => $survey->max_age,
            'expiration_date' => Carbon::parse($survey->expiration_at)->format('Y-m-d'),
            'expiration_time' => Carbon::parse($survey->expire_at)->format('H:i')
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        // Solo se puede actualizar la fecha de expiración y la descripción.
        $survey->survey_description = $request->description;
        $survey->expire_at = Carbon::parse("{$request->expiration_date}{$request->expiration_time}");
        $survey->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
        $survey->delete();
    }
}
