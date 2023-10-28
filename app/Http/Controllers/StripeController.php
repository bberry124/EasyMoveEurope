<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaceMail;
use App\Mail\InvoiceMail;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\ExtraCharges;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe;
use Session;

class StripeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $reqItems = DB::table('requests')->latest()->take(1)->get();
        $decoded = $request->get('price');

        $defferd_allow = "No";

        if($reqItems[0]->user_id > 0 && $reqItems[0]->who_type == "Company")
        {
            $user_info = User::find($reqItems[0]->user_id);
            if($user_info->credit_balance > 0){
                $defferd_allow = "Yes";
            }
        }

        if ($decoded == false) {
            return back();
        }
        return view('payment', [
            'reqItems' => $reqItems,
            'defferd_allow'=>$defferd_allow
        ]);
    }

    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {

       Stripe\Stripe::setApiKey(config('stripe.stripe_secret_live'));
       Stripe\Charge::create([
            "amount" =>  ($request->price * 100),
//            "amount" => 1 * 100,
            "currency" => "EUR",
            "source" => $request->stripeToken,
            "description" => "Payment Made"
        ]);

        $user_id = 0;
        $order_id = 0;
        if (auth()->check()){
            $reqItems = DB::table('requests')->where('user_id', auth()->id())->latest()->take(1)->first();

            $order_id = $reqItems->id;
            $user_id = $reqItems->user_id;
        }
        else
        {
            $reqItems = DB::table('requests')->latest()->take(1)->first();
            $order_id = $reqItems->id;
            $user_id = $reqItems->user_id;
        }

        Price::where('id', $order_id)->update(['status' => Price::$status['PAID']]);
        Price::where('id', $order_id)->update(['payment_method' => 'Credit Card']);
        Price::where('id', $order_id)->update(['admin_email_sent' => 'no']);
        Price::where('id', $order_id)->update(['order_email_sent' => 'yes']);
        
        $invoice_type = "Per Order";
        if($user_id > 0){
            $user_info = User::find($user_id);

            if($user_info->invoice_type != null){
                $invoice_type = $user_info->invoice_type;
            }
            else{
                $invoice_type = "Per Order";
            }
        }

        $order =  Price::find($reqItems->id);
        if($user_id == 0 || $invoice_type == "Per Order")
        {
            $struid = Str::uuid();

            $invoice =  new Invoice();
            $invoice->uuid = str_replace("-", "e", $struid);
            $invoice->invoice_type = 'Invoice';
            $invoice->order_id= $reqItems->id;
            $invoice->extra_charge_id= 0;
            $invoice->invoice_date = date('Y-m-d');
            $invoice->invoice_amount = $reqItems->total_price;
            $invoice->status = 'Paid';
            $invoice->paid_date = date('Y-m-d');
            $invoice->payment_method = 'Credit Card';
            $invoice->save();

            $invoice_id=$invoice->id;
            $order->invoice_id = $invoice_id;
            $order->save();
        }
        else{
            $invoice_id=$order->invoice_id;
            $invoice =  Invoice::find($invoice_id);
            $invoice->status = 'Paid';
            $invoice->save();
        }

        Session::flash('success', 'Payment has been successfully processed.');



        Mail::to($request->email)->send(new OrderPlaceMail($request->order_number, 'stripe'));

        return view('stripe_payment', ['order_number' => $request->order_number]);
    }

/**
     * handling payment with POST
     */
    public function handleInvoicePost(Request $request)
    {

        Stripe\Stripe::setApiKey(config('stripe.stripe_secret_live'));
        Stripe\Charge::create([
            "amount" => ($request->price * 100),
            "currency" => "EUR",
            "source" => $request->stripeToken,
            "description" => "Payment Made"
        ]);

        $invoice = Invoice::find($request->invoice_id);
        $extra_id = $invoice->extra_charge_id;

        $invoice->status = 'Paid';
        $invoice->paid_date = date('Y-m-d');
        $invoice->payment_method = 'Credit Card';
        $invoice->save();

        if($extra_id > 0){
            $extra = ExtraCharges::find($extra_id);
            $extra->status = 'Paid';
            $extra->save();
        }

        Session::flash('success', 'Payment has been successfully processed.');

        $order = Price::find($invoice->order_id);

        Mail::to($request->email)->send(new InvoiceMail($request->invoice_id, 'stripe'));

        return view('invoice_payment_done', ['invoice_id' => $invoice->uuid]);

    }

    public function handleInvoiceGet($id){
        $reqItems = DB::table('invoice')->where('uuid', $id)->take(1)->get();
        $decoded = $request->get('invoice_amount');
        if ($decoded == false) {
            return back();
        }
        return view('invoice_payment_done', [
            'reqItems' => $reqItems
        ]);
    }


    public function bankDetail($id)
    {

        if (isset($id) && $id != "" && $p = Price::where('order_number', base64_decode($id))->where('status', null)->first())
        {
            $p->status = $p::$status['WAITING PAYMENT'];

            Mail::to($p->contact_email)->send(new OrderPlaceMail(base64_decode($id)));
            Price::where('order_number', base64_decode($id))->update(['status' => Price::$status['WAITING PAYMENT']]);
            Price::where('order_number', base64_decode($id))->update(['payment_method' => 'Bank Transfer']);
            Price::where('order_number', base64_decode($id))->update(['admin_email_sent' => 'no']);
            Price::where('order_number', base64_decode($id))->update(['order_email_sent' => 'yes']);

            $order =  Price::where('order_number', base64_decode($id))->first();

            $user_id = $order->user_id;
            $invoice_type = "Per Order";
            if($user_id > 0){
                $user_info = User::find($user_id);

                if($user_info->invoice_type != null){
                    $invoice_type = $user_info->invoice_type;
                }
                else{
                    $invoice_type = "Per Order";
                }
            }

           /* if($user_id == 0 || $invoice_type == "Per Order")
            {
                $struid = Str::uuid();
                $invoice =  new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Invoice';
                $invoice->order_id= $order->id;
                $invoice->extra_charge_id= 0;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $order->price;
                $invoice->status = 'Waiting Payment';
                $invoice->payment_method = 'Bank Transfer';
                $invoice->save();

                $invoice_id=$invoice->id;
                $order->invoice_id = $invoice_id;
                $order->save();
            }*/

            session()->forget('price_page');
            return view('bank_payment', ['order' => base64_decode($id)]);

        }


        return redirect('/');
    }


    public function invoice_bank_payment($id)
    {

        if (isset($id) && $id != "")
        {
            $invoice =  Invoice::where('uuid',$id)->first();
            $invoice->payment_method = 'Bank Transfer';
            $invoice->save();
            $order =  Price::find($invoice->order_id);

            Mail::to($order->contact_email)->send(new InvoiceMail($id));

            $user_id = $order->user_id;

            return view('invoice_bank_payment', ['invoice_id' => $id, 'order'=>$order]);

        }


        return redirect('/');
    }


    public function defferd_payment($id)
    {
        if (isset($id) && $id != "" && $p = Price::where('order_number', base64_decode($id))->where('status', null)->first())
        {
            $p->status = $p::$status['DEFERRED PAYMENT'];

            Mail::to($p->contact_email)->send(new InvoiceMail(base64_decode($id),'defferd'));
            
            Price::where('order_number', base64_decode($id))->update(['status' => Price::$status['DEFERRED PAYMENT']]);
            Price::where('order_number', base64_decode($id))->update(['payment_method' => 'Deferred Payment']);
            Price::where('order_number', base64_decode($id))->update(['admin_email_sent' => 'no']);
            Price::where('order_number', base64_decode($id))->update(['order_email_sent' => 'yes']);

            $order =  Price::where('order_number', base64_decode($id))->first();

            $user_id = $order->user_id;
            $invoice_type = "Per Order";
            if($user_id > 0){
                $user_info = User::find($user_id);

                if($user_info->invoice_type != null){
                    $invoice_type = $user_info->invoice_type;
                }
                else{
                    $invoice_type = "Per Order";
                }
            }

            if($invoice_type == "Per Order")
            {
                $struid = Str::uuid();
                $invoice =  new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Invoice';
                $invoice->order_id= $order->id;
                $invoice->extra_charge_id= 0;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $order->price;
                $invoice->status = 'Deferred Payment';
                $invoice->payment_method = 'Deferred';
                $invoice->save();

                $invoice_id=$invoice->id;
                $order->invoice_id = $invoice_id;
                $order->save();
            }

            session()->forget('price_page');
            return view('deferred_payment', ['order' => base64_decode($id)]);
        }

        return redirect('/');
    }
}
