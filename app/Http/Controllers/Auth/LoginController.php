<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Default
        $status = 'error';
        $msg = 'Usuario o Email ya registrados';
        $username = ($request->username) ? $request->username : NULL;
        $password = ($request->password) ? $request->password : NULL;
        $email = ($request->email) ? $request->email : NULL;

        if(!isset($username) || !isset($password) || !isset($email)) {
            $msg = 'Debe completar todos los campos.';
            return response()->json(['status'=>$status,'msg'=>$msg]);
        }

        $check = User::where('user_name','LIKE',$username)
            ->orWhere('user_email','LIKE',$email)
            ->first();
        if(!isset($check)) {
            $user = new User();
            $user->username = $username;
            $user->password = bcrypt($password);
            $user->email = $email;
            $user->token = sha1(Carbon::now());
            $user->save();
            $status = 'ok';
            $msg = 'Registro completo.';
        }
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }
    public function login(Request $request) {
        // Default
        $log = new UserLog();
        $log->user_id = 0;
        $log->action = 'Login request';
        $msg = 'Fail to login';
        $status = 'error';
        $data = ['status'=>$status,'msg'=>$msg];

        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password],true)) {
            $log->user_id = Auth::user()->user_id;
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
            $msg = 'Success to login';
            $status = 'ok';
            $data = ['status'=>$status,'msg'=>$msg,'token'=>Auth::user()->getRememberToken()];
        }
        $log->description = "{$msg} with the user: {$request->username}";
        $log->created_at = Carbon::now();
        $log->save();
        return response()->json($data);
    }
    public function logout(Request $request) {}
}
