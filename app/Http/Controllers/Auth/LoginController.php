<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Please input the email address!',
                'email.email' => 'Please input the email address exactly!',
                'password.required' => 'Please input the password!'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }

        // $user_email = $request->email;
        // $enusers = DB::table('users')->where(['email'=>$user_email,'type'=>'0'])->get();

        // foreach ($enusers as $enuser) {
        //     if( $enuser->approve == '0') {
        //         return response()->json(array('status' => 1,'error' => "no approve"));
        //     }
        // }

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->type == 'admin') {
                return response()->json(array('status' => 3,'success' => "admin"));
            }else if (auth()->user()->type == 'company') {
                return response()->json(array('status' => 2,'success' => "company"));
            }else if (auth()->user()->type == 'user') {
                return response()->json(array('status' => 9,'success' => "approved"));
            }
        }else{
            return response()->json(array('status' => 5,'error' => "Email-Address And Password Are Wrong."));
        }


    }
}
