<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase;    

class TransportController extends Controller
{
    /**
     * Display a listing of the index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = DB::table('costs')->select('cost')->get()->first();
        // return view('transport');
        return view('transport',[
            'costs'=> $costs
        ]);
    }
     
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reg_number' => 'required',
            'username' => 'required',
            'useremail' => 'required|email',
            'phone_number' => 'required|min:10',
            'date' => 'required',
            'pickup_location' => 'required',
            'destination_location' => 'required',
            'distance_value' => 'required',
            'duration_value' => 'required',
            'estimation_value' => 'required',
            'cost_value' => 'required',
            'loading_purpose' => 'required',
            'note' => 'required',
        ],
        [
            'reg_number.required' => 'Please input the registration number!',
            'username.required' => 'Please input the name!',
            'useremail.required' => 'Please input the email address!',
            'useremail.email' => 'Please input the email address exactly!',
            'phone_number.required' => 'Please input the phone number!',
            'phone_number.min' => 'Please input the phone number exactly!',
            'date.required' => 'Please input the date!',
            'pickup_location.required' => 'Please input the pickup location!',
            'destination_location.required' => 'Please input the destination location exactly!',
            'distance_value.required' => 'Empty distance value!',
            'duration_value.required' => 'Empty the duration value!',
            'estimation_value.required' => 'Empty the estimation value!',
            'cost_value.required' => 'Empty the level of inspection!',
            'loading_purpose.required' => 'Please input the loading purpose!',           
            'note.required' => 'Please input your note!',     
        ]
    );
  
        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }

        // $result = Purchase::create([
        //     'reg_number' => $request->reg_number,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone_number' => $request->phone_number,
        //     'garage' => $request->garage,
        //     'seller_phone' => $request->seller_phone,
        //     'date' => $request->date,
        //     'location' => $request->location,
        //     'prefer_time' => $request->prefer_time,
        //     'inspection' => $request->inspection,
        // ]);

        // if(!$result) {
        //     return response()->json(array('status' => 1,'error' => "Database Error"));
        // }  
        
        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
  
    }
}
