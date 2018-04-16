<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $u = (Auth::user()->user_id) ? Auth::user()->user_id : 17;
        $profile = Profile::find($u);
        return view('Profile\view',['profile'=>$profile]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Profile\edit', ['profile'=>[]]);
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
        $profile = new Profile();
        $profile->user_id = (Auth::user()->user_id) ? Auth::user()->user_id : 17;
        ($request->firstname) ? $profile->first_name = $request->firstname : Auth::user()->username;
        ($request->lastname) ? $profile->last_name = $request->lastname : NULL;
        ($request->address) ? $profile->address = $request->address : NULL;
        $profile->age = $request->age;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
        return redirect()->action($this->create());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        $profile = [
            'firstname' => $profile->first_name,
            'lastname' => $profile->last_name,
            'address' => $profile->address,
            'age' => $profile->age
        ];
        return response()->json(['profile'=>$profile],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
        ($request->firstname) ? $profile->first_name = $request->firstname : $profile->first_name;
        ($request->lastname) ? $profile->last_name = $request->lastname : $profile->last_name;
        ($request->address) ? $profile->address = $request->address : $profile->address;
        ($request->age) ? $profile->age = $request->age : $profile->age;
        $profile->save();
        return response()->json(['msg'=>'Success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
        $user = User::find($profile->user_id);
        $user->delete();
        $profile->delete();
    }
}
