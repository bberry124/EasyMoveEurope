<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use Hash;

class CompanyProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comingValue = $this->getCount();
        $tmpArray = array();
        $tmpArray = explode('+', $comingValue);

        $upcomingCount = $tmpArray[0];
        $upcomingRepair = $tmpArray[1];
        $profiles = DB::table('users')->where('id',auth()->id())->get();

        return view('company.companyProfile',[
            'profiles'=> $profiles,
            'upcomingCount'=> $upcomingCount,
            'upcomingRepair'=> $upcomingRepair
        ]);

    }

    public function getCount(){
        $user_id = auth()->user()->id;
        $location = auth()->user()->location;
        $gname = auth()->user()->name;
        $pDates = DB::table('purchases')->select('date')->where('garage',$gname)->get();
        $pastCount = 0;
        $upcomingCount = 0;
        foreach ($pDates as $pDate) {
            if( date('Y-m-d', strtotime($pDate->date)) <= now()) {
                $pastCount++;
            } else {
                $upcomingCount++;
            }
        }


        $pastRepair = 0;
        $upcomingRepair = 0;
        $subDate = now()->subDays(7);
        $rDates = DB::table('repairs')->select('created_at')->where('sel_location',$location)->get();
        foreach ($rDates as $rDate) {
            if( date('Y-m-d H-i-s', strtotime($rDate->created_at)) <= $subDate) {
                $pastRepair++;
            } else {
                $upcomingRepair++;
            }
        }

        return $upcomingCount . "+" . $upcomingRepair;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required',
            'uphone' => 'required',
            'ucountry' => 'required',
            'uvat' => 'required',
            'ship_area' => 'required',
            'contact_name' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'email' => 'required:users,email,' . $request->uid,
        ],
        [
            'uname.required' => __('Please input the name!'),
            'uphone.required' => __('Please input the phone number!'),
            'ucountry.required' => __('Please input the country!'),
            'uvat.required' => __('Please input the Vat ID!'),
        ]
    );

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }

        $result = User::where('id', $request->uid)->first();

        $old_email = $result->email;

        $res =   $result->update([
            'name' => $request->contact_name,
            'phone' => $request->uphone,
            'company_country' => $request->ucountry,
            'vat_name' => $request->uvat,
            'email' => $request->email,
            'ship_area' => $request->ship_area,
            'company_name' => $request->uname,
            'location' => $request->location,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'valid_vat'=> $request->vvat,
            'invoice_type'=> $request->invoice_type,

        ]);

        if(!$res) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }

        if($old_email != $request->email){

            $result->email_verified_at = null;
            $result->save();
            event(new Registered($result));
        }


        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ],
        [
            'old_password.required' => 'Please input the old password!',
            'new_password.required' => 'Please input the new password!',
            'new_password.min' => 'Please input eight characters at least for new password!',
            'confirm_password.required' => 'Please input the confirm password!'
        ]
    );

        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json(array('status' => 5,'error' => "Old Password Doesn't match!"));
        }

        $result = User::where('id', $request->uid)
        ->update([
            'password' => Hash::make($request->new_password)
        ]);

        if(!$result) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }

        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
    }


    public function viewOrder($id)
    {

            $reqItems = DB::table('requests')->where('id',$id)->first();


        return view('company.view_order_invoice',[
            'reqItem'=> $reqItems
        ]);
    }


}

