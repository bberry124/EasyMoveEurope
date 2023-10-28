<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase;    

class PurchaseController extends Controller
{
    /**
     * Display a listing of the index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$posts = Purchase::get();
        
        return view('purchase', compact('posts'));
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
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|min:10',
            'garage' => 'required',
            'seller_phone' => 'required|min:10',
            'date' => 'required',
            'location' => 'required',
            'prefer_time' => 'required',
            'inspection' => 'required',
            // 'flexCheckDefault' => 'accepted',
        ],
        [
            'reg_number.required' => 'Please input the registration number!',
            'name.required' => 'Please input the name!',
            'email.required' => 'Please input the email address!',
            'email.email' => 'Please input the email address exactly!',
            'phone_number.required' => 'Please input the phone number!',
            'phone_number.min' => 'Please input the phone number exactly!',
            'garage.required' => 'Please input the garage name!',
            'seller_phone.required' => 'Please input the seller phone number!',
            'seller_phone.min' => 'Please input the seller phone number exactly!',
            'date.required' => 'Please input the date!',
            'location.required' => 'Please select the location!',
            'prefer_time.required' => 'Please select the preferred time!',
            'inspection.required' => 'Please select the level of inspection!',
            // 'flexCheckDefault.accepted' => 'Please check the Terms of use and privacy Policy!',           
        ]
    );
  
        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }

        $result = Purchase::create([
            'reg_number' => $request->reg_number,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'garage' => $request->garage,
            'seller_phone' => $request->seller_phone,
            'date' => $request->date,
            'location' => $request->location,
            'prefer_time' => $request->prefer_time,
            'inspection' => $request->inspection,
        ]);

        if(!$result) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }  
        
        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
  
    }
}
