<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(Request $request){

    }
    public function login(Request $request) {
        // Default
        $log = new UserLog();
        $log->user_id = 0;
        $log->action = 'Login request';
        $msg = 'Fail to login';
        $status = 'error';

        $result = User::where('user_name',$request->username)
            ->where('user_pw',$request->password)
            ->first(['user_id','user_name','token']);
        if(isset($result)) {
            $log->user_id = $result->user_id;
            $msg = 'Success to login';
            $status = 'ok';
        }
        $log->description = "{$msg} with the user: {$request->username}";
        $log->created_at = Carbon::now();
        $log->save();
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
}
