<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyLog;
use App\User;
use App\UserSurvey;
use App\Utilities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return response()->json(['msg'=>'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($survey_id)
    {
        //
        $data = [];
        // $u = Auth::user()->user_id;

        // Esto es para validar sin loguear.
        $u = 17;

        $user = User::with(['profile'])->find($u);
        $user_surveys = UserSurvey::where('user_id',$user->user_id)->get();
        $survey = Survey::find($survey_id);

        $user->profile->age = 35;

        $SLog = new SurveyLog();

        $action = 'Intento de acceso a encuesta';
        $log_msg = 'Usuario no logueado.';
        if(isset($user)) {
            $log_msg = 'Encuesta finalizada.';
            if(Carbon::parse($survey->expire_at) > Carbon::now()) {
                $log_msg = 'Usuario no cumple con la edad.';
                if (Utilities::between($user->profile->age, $survey->min_age, $survey->max_age)) {
                    $log_msg = 'Usuario ya completó la encuesta.';
                    $this_survey = NULL;

                    foreach ($user_surveys as $index => $u_survey) {
                        $this_survey = ($u_survey->survey_id == $survey->survey_id) ? $u_survey : NULL;
                    }
                    if ($this_survey->completed != 1) {
                        $action = 'Acceso a encuesta';
                        $log_msg = 'Usuario inicia la encuesta';

                        $data = [
                            'name' => $survey->survey_name,
                            'description' => $survey->survey_description,
                            'min_age' => $survey->min_age,
                            'max_age' => $survey->max_age,
                            'expiration_date' => Carbon::parse($survey->expiration_at)->format('Y-m-d'),
                            'expiration_time' => Carbon::parse($survey->expire_at)->format('H:i')
                        ];
                    }
                }
            }
        }

        $SLog->survey_id = $survey_id;
        $SLog->user_id = ($user->user_id) ? $user->user_id : 0;
        $SLog->action = $action;
        $SLog->description = $log_msg;
        $SLog->created_at = Carbon::now();
        $SLog->save();

        return response()->json([$data,$log_msg]);
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
