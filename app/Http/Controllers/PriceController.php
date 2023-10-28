<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;
use App\Models\Quote;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Mail;
use Log;
//use App\Models\User;
//use Hash;

class PriceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {

        if (url()->previous() != url('invoice')) {
            session()->forget('price_page');

        }

        $user_id = auth()->check() ? auth()->id() : "";
        $deferred = "no";

        if($user_id != ""){
            $user = User::find($user_id);
            if($user->credit_balance > 0){
                $deferred = "yes";
            }
        }

        $pickup_country = $request->pickup_country;

        $destination_country = $request->destination_country;
        session()->put('pickup_country', $request->pickup_country);
        session()->put('destination_country', $request->destination_country);

        if (!session()->has('price_page')) {

            session()->put('price_page', []);


        }


        $pickup_prices = DB::table('countries')->where('country', $pickup_country)->get();
        $destination_prices = DB::table('countries')->where('country', $destination_country)->get();


        $set = true;
        if ($pickup_prices->isEmpty() && $destination_prices->isEmpty()) {
            $set = false;
            $pickup_prices = DB::table('countries')->where('abbreviation', $pickup_country)->get();


            $destination_prices = DB::table('countries')->where('abbreviation', $destination_country)->get();

            $destination_country = $destination_prices[0]->abbreviation;
            $pickup_country = $pickup_prices[0]->abbreviation;

        } elseif ($set == false) {

            $destination_country = $destination_prices[0]->abbreviation;
            $pickup_country = $pickup_prices[0]->abbreviation;
        } else {


            $destination_country = $destination_prices[0]->abbreviation;
            $pickup_country = $pickup_prices[0]->abbreviation;

        }




        return view('price', [
            'pickup_country' => $pickup_country,
            'destination_country' => $destination_country,
            'pickup_prices' => $pickup_prices,
            'destination_prices' => $destination_prices,
            'deferred' =>$deferred,
            'id' => $request->id ?? null
        ]);
    }

  /*  public function change_pw($id){
        $result = User::where('id', $id)
            ->update([
                'password' => Hash::make("Easy@075987")
            ]);

            echo "Updated";
    }*/

    /**
     * Create country based price calculation
     */

     public function calculate_average_price(Request $request)
     {
        $pickup = $request->pickup;
        $destination = $request->destination;
        $pickup_country_code =  $request->pickup_code;
        $destination_country_code =  $request->destination_code;

        $distanceKm =0;
        $company_price=0;
        $personal_price=0;
        $maxlength_price = 0;
        $shortlength_price = 0;
        $destination_price =0;

        

            $pickup_info = DB::table('countries')->where('abbreviation', $pickup_country_code)->get();
            $destination_info = DB::table('countries')->where('abbreviation', $destination_country_code)->get();


            $p_country = urlencode($pickup_info[0]->country);
            $d_country = urlencode($destination_info[0]->country);

          //  return response()->json(array('company_price' => $p_country, 'private_price' => $d_country));

            if(isset($p_country) && isset($d_country))
            {
                        $destination_price = $destination_info[0]-> box_min;
                        $destination_sprice = $destination_info[0]-> short_price;
                        $destination_lprice = $destination_info[0]-> long_price;
                        
                    if($pickup != $destination)
                    {
                        $key = 'AIzaSyDcUccmFJ_K2m8gV048ha6eoHtfx1XMZPc';// env('GOOGLE_API_KEY');
                        $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$p_country.'&destinations='.$d_country.'&key='. $key);
                        $distance_arr = json_decode($distance_data);

                        $elements = $distance_arr->rows[0]->elements;
                        $distanceX = $elements[0]->distance->value;

                        $distanceKm = round($distanceX/1000);
                
                        


                if($distanceKm > 1000){
                            $maxlength_price = round(($distanceKm - 1000) * $destination_lprice);
                            $shortlength_price = round(500 * $destination_sprice);
                        }
                        else{
                            if($distanceKm > 500){
                                $shortlength_price = round(($distanceKm - 500) * $destination_sprice);
                            }
                            else{
                                $shortlength_price = $destination_sprice;
                            }
                        }
                    }

                    if($pickup != $destination)
                    {
                        $company_price = round((($maxlength_price + $shortlength_price) + $destination_price));
                        $personal_price= round(((($maxlength_price + $shortlength_price) + $destination_price)) * 1.19);
                    }
                    else{
                        $company_price = round(($destination_price) + 110);
                        $personal_price= round((($destination_price) + 110) * 1.19);
                    }


                    return response()->json(array('company_price' => number_format($company_price), 'private_price' => number_format($personal_price)));
                }
                else{
                    return response()->json(array('company_price' => '0', 'private_price' => '0'));
                }
 
     }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
//            'who_type' => ['required'],
            'pickup_country' => ['required', 'string'],
            'sender_city' => ['required', 'string'],
            'sender' => ['required', 'min:3'],
            'sender_phone' => ['required', 'min:8'],
            'desti_country' => ['required', 'string'],
            'receiver_city' => ['required', 'string'],
            'receiver' => ['required', 'string', 'min:3'],
            'receiver_phone' => ['required', 'min:8'],
            'van_type' => ['required'],
            'cargo_info' => ['required', 'string'],
            'cargo_val' => ['required', 'string'],
            'collection_day' => ['required'],
            'contact_name' => ['required', 'min:3'],
            'contact_email' => ['required', 'string', 'email', 'max:255'],
            'contact_phone' => ['required', 'min:8'],
            'term_agree' => ['required'],
            'price' => ['required'],
        ],
            [
                'term_agree.required' => 'Please read and accept the Terms and Conditions of Easy Move Europe!',
                'price.required' => 'Please get a price before continuance!',
            ]
        );
        session()->forget('price_page');

        $new_page['price_page'] = [];
        foreach ($data as $key => $validate) {
            $new_page['price_page'][$key] = $validate;


        }

        session()->put($new_page, $validate);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->all()
            ]);
        }

        $user_id = auth()->check() ? auth()->id() : "";

        if($user_id != ""){
            $user = User::find($user_id);
        }

        $new_order_id=0;
        $pickup_dayx = Carbon::createFromFormat("d/m/Y", $data['collection_day'])->format("Y-m-d");
        $weekDay = date('w', strtotime($pickup_dayx));
        $weekEndPickup = "false";
        if($weekDay == 0 || $weekDay == 6){
            $weekEndPickup = "true";
        }

        $same_country = "false";

        if($data['pickup_country'] == $data['desti_country']){
            $same_country = "true";
        }

        $same_day = "false";

        if(date('Y-m-d', strtotime($pickup_dayx)) == date('Y-m-d')){
            $same_day = "true";
        }

        $result = Price::updateOrCreate(['id' => $request->id], [
            'who_type' => getWhoType(),
            'pickup_country' => $data['pickup_country'],
            'sender_city' => $data['sender_city'],
            'sender' => $data['sender'],
            'user_id' => auth()->check() ? auth()->id() : "",
            'sender_phone' => $data['sender_phone'],
            'sender_full_phone' => $data['sender_full_phone'],
            'desti_country' => $data['desti_country'],
            'receiver_city' => $data['receiver_city'],
            'receiver' => $data['receiver'],
            'receiver_phone' => $data['receiver_phone'],
            'receiver_full_phone' => $data['receiver_full_phone'],
            'van_type' => $data['van_type'],
            'help_loading' => $data['help_loading'],
            'help_unloading' => $data['help_unloading'],
            'distance' => $data['distance_is'],
            'duration' => $data['duration_is'],
            'tail_lift' => $data['tail_lift'],
            'pickup_weekend' => $weekEndPickup,
            'pickup_same_day' => $same_day,
            'pickup_delelivery_same_country' => $same_country,
            'cargo_info' => $data['cargo_info'],
            'cargo_val' => $data['cargo_val'],
            'collection_day' => Carbon::createFromFormat("d/m/Y", $data['collection_day'])->format("Y-m-d"),
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'user_email' => $data['user_email'] ?? null,
            'user_vat' => $data['user_vat'] ?? null,
            'contact_phone' => $data['contact_phone'],
            'contact_full_phone' => $data['contact_full_phone'],
            'contact_note' => $data['contact_note'],
            'price' => $data['price'],
            'total_price' => $data['price'],
            'order_number' => generateOrderNumber(),
            'invoice_id' => 0,
        ]);

        $new_order_id = $result->id;
        $new_order_no = $result->order_number;
        $amount = $result->price;
        $url_id =  base64_encode($result->order_number);

        if ($new_order_id == 0 || $new_order_id == "") {
            return response()->json(array('status' => 1, 'error' => "Database Error"));
        }
        else{
            /*$html = '<p>Hello,</p><p> More one order was placed, please check it out.</p><p>Order number: ' . $result->order_number;
            Mail::html($html, function($message){
                $message-> from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                $message-> to('info@easymoveeurope.com');
                $message-> subject('Great news – More one order was placed!');
            });  */
        }

        return response()->json(array('status' => 2, 'msg' => "Successfully Submitted", 'id' => $new_order_id, 'order_number' => $new_order_no, 'amount'=>$amount, 'url_id'=>$url_id));
    }


    public function calculate_price(Request $request)
    {

        preg_match_all('!\d+(?:\.\d+)?!', str_replace(',', '', $request->duration), $matches);

        $total_seconds = $matches[0][0] * 60;
        $hours = floor($total_seconds / 3600);
        $minutes = floor(($total_seconds / 60) % 60);


        $result = "";

        if ($hours > 0) {

            $result .= "{$hours} hours ";
        }

        if ($minutes > 0) {

            $result .= "$minutes mins";
        }


        return response()->json($result);


    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $price_find = Price::find($id);

        $validator = Validator::make($data, [
//            'who_type' => ['required'],
            'pickup_country' => ['required', 'string'],
            'sender_city' => ['required', 'string'],
            'sender' => ['required', 'min:3'],
            'sender_phone' => ['required', 'min:8'],
            'desti_country' => ['required', 'string'],
            'receiver_city' => ['required', 'string'],
            'receiver' => ['required', 'string', 'min:3'],
            'receiver_phone' => ['required', 'min:8'],
            'van_type' => ['required'],
            'cargo_info' => ['required', 'string'],
            'cargo_val' => ['required', 'string'],
            'collection_day' => ['required'],
            'contact_name' => ['required', 'min:3'],
            'contact_email' => ['required', 'string', 'email', 'max:255'],
            'contact_phone' => ['required', 'min:8'],
            'term_agree' => ['required'],
            'price' => ['required'],
        ],
            [

                'price.required' => 'Please get a price before continuance!',
            ]
        );

        session()->forget('price_page');

        $new_page['price_page'] = [];
        foreach ($data as $key => $v) {
            $new_page['price_page'][$key] = $v;


        }

        session()->put($new_page, $validator);


        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->all()
            ]);
        }


        $result = $price_find->update([
            'who_type' => getWhoType(),
            'pickup_country' => $data['pickup_country'],
            'sender_city' => $data['sender_city'],
            'sender' => $data['sender'],
            'sender_phone' => $data['sender_phone'],
            'sender_full_phone' => $data['sender_phone'],
            'desti_country' => $data['desti_country'],
            'receiver_city' => $data['receiver_city'],
            'receiver' => $data['receiver'],
            'receiver_phone' => $data['receiver_phone'],
            'receiver_full_phone' => $data['receiver_phone'],
            'van_type' => $data['van_type'],
            'help_loading' => $data['help_loading'],
            'help_unloading' => $data['help_unloading'],
            'tail_lift' => $data['tail_lift'],
            'cargo_info' => $data['cargo_info'],
            'cargo_val' => $data['cargo_val'],
            'collection_day' => Carbon::createFromFormat("Y-m-d", $data['collection_day'])->format("Y-m-d"),
            'contact_name' => $data['contact_name'],
            'contact_email' => $data['contact_email'],
            'user_email' => $data['user_email'] ?? null,
            'user_vat' => $data['user_vat'] ?? null,
            'contact_phone' => $data['contact_phone'],
            'contact_full_phone' => $data['contact_phone'],
            'contact_note' => $data['contact_note'],
            'price' => $data['price'],
            'total_price' => $data['price'],
            'order_number' => generateOrderNumber()
        ]);


        if (!$result) {
            return response()->json(array('status' => 1, 'error' => "Database Error"));
        }

        return response()->json(array('status' => 2, 'msg' => "Successfully Submitted"));
    }

    
}

