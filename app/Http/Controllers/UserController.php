<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::with('surveys')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(isset($request)) {
            $find = User::where('user_name','like',$request->username)
                ->orWhere('user_email','like',$request->email)
                ->first();
            if (!isset($find)){
                $user = new User();
                $user->user_name = $request->username;
                $user->user_pw = $request->password;
                $user->user_email = $request->email;
                $user->token = sha1(time());
                $user->save();
                $msg = 'Usuario registrado con exito';
            }else{
                $msg = 'Ya se encuentra un usuario registrado con ese alias o correo electrónico.';
            }
            return ['msg'=>$msg];
        }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        //
        $query = 'test5';//Auth::user()->user_name;
        if(isset($user)){
            $query = $user;
        }
        return User::where('user_name','like',$query)
            ->orWhere('user_email','like',$query)
            ->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
