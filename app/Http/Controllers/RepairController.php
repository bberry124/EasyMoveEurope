<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Repair;
use App\Models\Quote;
use Illuminate\Support\Facades\Route;

class RepairController extends Controller
{
    /**
     * Display a listing of the index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	// $posts = Repair::get();
        // return view('repair', compact('posts'));
        // return view('repair');
        
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
                'sel_location' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required|min:10',
                'array' => 'required|array|min:1'   
            ],
            [
                'first_name.required' => 'Please input the first name!',
                'last_name.required' => 'Please input the last name!',
                'email.required' => 'Please input the email address!',
                'email.email' => 'Please input the email address exactly!',
                'phone_number.required' => 'Please input the phone number!',
                'phone_number.min' => 'Please input the phone number exactly!',
                'array.required' => 'Please check one service item at least!'
            ]
        );
  
        if ($validator->fails()) {
            return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
        }
       
        $result_one = Repair::create([
            'reg_number' => $request->reg_number,
            'sel_location' => $request->sel_location,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        $repair_id = ($result_one->id);
        $service_id = $request->array;
        
        foreach ($service_id as $value) {
            $result_two = Quote::create([
                'repair_id' => $repair_id,
                'service_id' => $value,
            ]);
        }

        if(!$result_one && !$result_two) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }  
        
        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
    }
}
