<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ComRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth/comsignup');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'work_phone' => ['required', 'min:9'],
            'password' => ['required', 'string', 'min:8'],
            'company_name' => ['required', 'string'],
            'company_country' => ['required', 'string'],
            'contact_name' => ['required', 'string'],
            'vat_id' => 'required',
            'street' => 'required',
            'zipcode' => 'required',
            'city' => 'required'
        ],
            [
                'email.required' => 'Please input the email address!',
                'email.email' => 'Please input the email address exactly!',
                'work_phone.required' => 'Please input your phone number!',
                'password.required' => 'Please input the password!',
                'password.min' => 'Please input the password of 8 letters at least!',
                'company_name.required' => 'Please input the company name!',
                'contact_name.required' => 'Please input the contact name!',
                'company_country.required' => 'Please input the company country!',
                'vat_id.required' => 'Your VAT number (eg. PL1234567890)',
            ]
        );



        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->all()
            ]);
        }

        $strpos = strlen($data['vat_id']);
        $country_code  = substr($data['vat_id'],0,2);
        $vat_number =  substr($data['vat_id'],2,$strpos);

        $is_valid_vat=  checkValidVat($vat_number, strtoupper($country_code));

        if (!isset($data['tonumber']) && !isset($data['ship_area'])) {
            $result = User::create([
                'name' => $data['contact_name'],
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone' => $data['work_phone'],
                'location' => $data['street'],
                'zipcode' => $data['zipcode'],
                'city' => $data['city'],
                'company_country' => $data['company_country'],
             /*   'api_status' => $data['api_status'],
                'vat_id' => $data['vat_id'],
                'vat_valid' => $data['vat_valid'],*/
                'vat_name' => $data['vat_id'],
                'valid_vat' => $is_valid_vat,
                'vat_address' => $data['vat_address'],
                'password' => Hash::make($data['password']),
                'type' => '2',
            ]);
        } else if (!isset($data['tonumber'])) {



            $result = User::create([
                'name' => $data['contact_name'],
                'valid_vat' => $is_valid_vat,
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone' => $data['work_phone'],
                'location' => $data['street'],
                'zipcode' => $data['zipcode'],
                'city' => $data['city'],
                'company_country' => $data['company_country'],
                /*'api_status' => $data['api_status'],
                'vat_id' => $data['vat_id'],
                'vat_valid' => $data['vat_valid'],*/
                'vat_name' => $data['vat_id'],
                'vat_address' => $data['vat_address'],
                /*'ship_area' => $data['ship_area'],*/
                'password' => Hash::make($data['password']),
                'type' => '2',
            ]);
        } else if (!isset($data['ship_area'])) {
            $result = User::create([
                'name' => $data['contact_name'],
                'valid_vat' => $is_valid_vat,
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone' => $data['work_phone'],
                'location' => $data['street'],
                'zipcode' => $data['zipcode'],
                'city' => $data['city'],
                'company_country' => $data['company_country'],
                /*'api_status' => $data['api_status'],
                'vat_id' => $data['vat_id'],
                'vat_valid' => $data['vat_valid'],*/
                'vat_name' => $data['vat_id'],
                'vat_address' => $data['vat_address'],
                /*'ship_count' => $data['tonumber'],*/
                'password' => Hash::make($data['password']),
                'type' => '2',
            ]);
        } else {

            $result = User::create([
                'name' => $data['contact_name'],
                'company_name' => $data['company_name'],
                'valid_vat' => $is_valid_vat,
                'email' => $data['email'],
                'phone' => $data['work_phone'],
                'location' => $data['street'],
                'zipcode' => $data['zipcode'],
                'city' => $data['city'],
                'company_country' => $data['company_country'],
             /*   'api_status' => $data['api_status'],
                'vat_id' => $data['vat_id'],
                'vat_valid' => $data['vat_valid'],*/
                'vat_name' => $data['vat_id'],
//                'vat_address' => $data['vat_address'],
                /*'ship_count' => $data['tonumber'],*/
                'ship_area' => $data['ship_area'],
                'password' => Hash::make($data['password']),
                'type' => '2',
            ]);
        }


        if (!$result) {
            return response()->json(array('status' => 1, 'error' => "Database Error"));
        }
        event(new Registered($result));

        auth()->login($result);

        return response()->json(array('status' => 2, 'msg' => "Successfully Submitted"));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param string $data
     * @return JsonResponse
     */


    public function checkValidVat(string $data)
    {

        $strpos = strlen($data);
        $country_code  = substr($data,0,2);
        $vat_number =  substr($data,2,$strpos);

        return checkValidVat($vat_number, strtoupper($country_code)) ? response()->json(['success'=>true]) : response()->json(['success' => false]);
    }
}
