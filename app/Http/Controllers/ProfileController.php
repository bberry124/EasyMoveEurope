<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;

class ProfileController extends Controller
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
        $user_email = auth()->user()->email;
        $upcomingCount = $tmpArray[0];
        $upcomingRepair = $tmpArray[1];
        $profiles = DB::table('users')->where('email', $user_email)->get();
        return view('profile', [
            'profiles' => $profiles,
            'upcomingCount' => $upcomingCount,
            'upcomingRepair' => $upcomingRepair
        ]);
    }

    public function getCount()
    {
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $username = auth()->user()->name;
        $pDates = DB::table('purchases')->select('date')->where('email', $user_email)->get();
        $pastCount = 0;
        $upcomingCount = 0;
        foreach ($pDates as $pDate) {
            if (date('Y-m-d', strtotime($pDate->date)) <= now()) {
                $pastCount++;
            } else {
                $upcomingCount++;
            }
        }


        $pastRepair = 0;
        $upcomingRepair = 0;
        $subDate = now()->subDays(7);
        $rDates = DB::table('repairs')->select('created_at')->where('email', $user_email)->get();
        foreach ($rDates as $rDate) {
            if (date('Y-m-d H-i-s', strtotime($rDate->created_at)) <= $subDate) {
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
            'country' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'email' => 'required|unique:users,email,' . $request->uid,

        ],
            [
                'uname.required' => 'Please input the name!',
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

        $result->name = $request->uname;
        $result->email = $request->email;
        $result->phone = $request->phone;
        $result->company_country = $request->country;
        $result->location = $request->location;
        $result->zipcode = $request->zipcode;
        $result->city = $request->city;
        $result->vat_name = $request->vat_name;

        $save =  $result->save();


        if (!$save) {
            return response()->json(array('status' => 1, 'error' => "Database Error"));
        }
        if ($old_email != $request->email) {

            $result->email_verified_at = null;
            $result->save();
            event(new Registered($result));

        }

        return response()->json(array('status' => 2, 'msg' => "Successfully Submitted"));
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

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json(array('status' => 5, 'error' => "Old Password Doesn't match!"));
        }

        $result = User::where('id', $request->uid)
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        if (!$result) {
            return response()->json(array('status' => 1, 'error' => "Database Error"));
        }

        return response()->json(array('status' => 2, 'msg' => "Successfully Submitted"));
    }

    
    public function create_order()
    {

        if (url()->previous() != url('invoice_company')) {
            session()->forget('price_page');
        }

        return view('created_order', ['dont_show_container' => true]);
    }

    public function getReceiverDetails($sender, $receiver)
    {
        $pickup_country = $sender;
        $destination_country = $receiver;


        $pickup_prices = DB::table('countries')->where('country', $pickup_country)->first();
        $destination_prices = DB::table('countries')->where('country', $destination_country)->first();


        if ($pickup_prices == null && $destination_prices == null) {
            $pickup_prices = DB::table('countries')->where('abbreviation', $pickup_country)->first();

            $destination_prices = DB::table('countries')->where('abbreviation', $destination_country)->first();

        } else {

            $destination_country = $pickup_prices->abbreviation;
            $pickup_country = $destination_prices->abbreviation;
        }


        $data = ['pickup_prices' => $pickup_prices, 'destination_prices' => $destination_prices, 'destination_country' => $destination_country, 'pickup_country' => $pickup_country];

        return response()->json($data);
    }

    public function invoice()
    {
        if (auth()->check())
            $reqItems = DB::table('requests')->where('user_id', auth()->id())->latest()->take(1)->get();
        else
            $reqItems = DB::table('requests')->latest()->take(1)->get();



        return view('created_order_invoice', [
            'reqItems' => $reqItems
        ]);
    }

    public function viewOrder($id)
    {

        $reqItems = DB::table('requests')->where('id', $id)->first();


        return view('view_order_invoice', [
            'reqItem' => $reqItems
        ]);
    }
}
