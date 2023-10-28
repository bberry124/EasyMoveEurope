<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\ExtraCharges;
use Illuminate\Support\Str;
use Mail;
use Log;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index($id)
    {
        $reqItems = DB::table('requests')->where('id', $id)->get();

//        dd($reqItems);
        return view('invoice',[
            'reqItems'=> $reqItems
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function create(Request $request)
    {
        $data = $request->all();

        $result = Price::where('id', $request->req_id)
        ->update([
            'total_price' => $request->total_price,
        ]);

        if(!$result) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }

        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));

    }

    public function customer_invoice($id)
    {
        $invoice = Invoice::where('uuid',$id)->first();
        $order = Price::find($invoice->order_id);
        
        $valid_vat = "yes";
        $vat_text = "VAT 0%";
        if($order->user_id == 0){
            $valid_vat = "no";
            $vat_text = "VAT 19%";
        }
        else{
            $user = User::find($order->user_id);

            if($user->valid_vat == 0){
                $valid_vat = "no";
                $vat_text = "VAT 19%";
            }
        }
        
       
        $country1 = DB::table('countries')->where('country', $order->pickup_country)->get();
        $country2 = DB::table('countries')->where('country', $order->desti_country)->get();

        $code1 = $country1[0]->abbreviation;
        $code2 = $country2[0]->abbreviation;

        $info = "Order " . $order->order_number . " – Shipping service  " . $code1 . " - " . $code2;
        if($invoice->extra_charge_id > 0){
            $extra = ExtraCharges::find($invoice->extra_charge_id);
            $info = "Order " . $order->order_number . " Extra charges (" . $extra->requester . ")";
        }

        $vat_amount = 0;
            if($valid_vat == "no")
            {
                $vat_amount = ($invoice->invoice_amount - ($invoice->invoice_amount/1.19));
            }
        

        return view('customer_invoice',[
            'invoice'=> $invoice, 'order' => $order, 'info' => $info, 'vat_text'=>$vat_text, 'vat_amount' => $vat_amount
        ]);
    }


    /*
    public function weekly_invoice(){
        $customers = DB::table('users')->where('invoice_type', 'Per Week')->get();

       
        foreach($customers as $customer)
        {
            $orders = DB::table('requests')->whereNull('invoice_id')->orwhere('invoice_id',0)->where('user_id', $customer->id)->get();
    
            $record_id = 0;
            $html="";
            $vat = "0%";
            $vat_amount = "0.00";
            $to_email = $customer->email;

            $html .= "<p>Dears,</p><p>We would like to confirm the following invoice(s) is pending.</p>";
            
            foreach($orders as $order)
            {
                $struid = Str::uuid();
                $invoice = new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Invoice';
                $invoice->order_id= $order->id;
                $invoice->extra_charge_id= 0;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $order->price??0;
                $invoice->status = 'Waiting Payment';
                $invoice->save();

                $invoice_id = $invoice->id;

                $cur_order = Price::find($order->id);
                $cur_order->invoice_id = $invoice_id;
                $cur_order->save();

                if($customer->valid_vat == 0){
                    $vat = "19%";
                    $vat_amount = number_format(($order->price - ($order->price/1.19)), 2 , ".");
                }
                
                $str_invoice_no = $invoice_id;

                if($invoice_id < 10){
                    $str_invoice_no = "0000" . $invoice_id;
                }
                if($invoice_id >= 10 && $invoice_id < 100){
                    $str_invoice_no = "000" . $invoice_id;
                }
                if($invoice_id >= 100 && $invoice_id < 1000){
                    $str_invoice_no = "00" . $invoice_id;
                }
                if($invoice_id >= 1000 && $invoice_id < 10000){
                    $str_invoice_no = "0" . $invoice_id;
                }

                $html .= '<div style="width: 100%; padding:5%;">
                <div style="max-width: 720px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="/img/invoice_logo.png" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">Strada Feleacu 3</td>
                                <td style="width:55%; padding:4px; font-weight:600;">' . $customer->company_name . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">077190 Bucharest</td>
                                <td style="width:55%; padding:4px;">' . $customer->location . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">Romania</td>
                                <td style="width:55%; padding:4px;">' . $customer->city . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">VAT: RO47795949</td>
                                <td style="width:55%; padding:4px;">' . $customer->company_country . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;"></td>
                                <td style="width:55%; padding:4px;">' . $customer->vat_name . '</td>
                            </tr>
                        </table>
                        
                        <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:50px;">
                            <tr>
                                <td style="padding:4px; background-color:#000;"></td>
                                <td colspan="5" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">INV-'. $str_invoice_no .'</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Invoice/Bill Date:</td>
                                <td style="padding:4px;">Due Date:</td>
                                <td colspan="2" style="padding:4px;">Service date:</td>
                                <td colspan="2" style="padding:4px;">Payment type:</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td colspan="2" style="padding:4px;">'. date("d/m/Y", strtotime($order->collection_day)) .'</td>
                                <td colspan="2" style="padding:4px;">Deferred payment</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service ' . $order->pickup_country . ' - ' . $order->desti_country . '</td>
                                <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . $order->price . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $order->price . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; border-bottom:1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">Sub Total</td>
                                <td style="padding:4px; text-align:right;">' . $order->price . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; background-color:#000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-7000 / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';

            $record_id++;
        }
               if($record_id > 0)
                {
                    Mail::html($html, function($message) use($to_email){
                        $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                        $message->to($to_email);
                        $message->subject('Easymoveeurope - Invoice');
                    });
                }

        }

        echo "Done..";
    }


    public function monthly_invoice(){
        $customers = DB::table('users')->where('invoice_type', 'Per Month')->get();

       
        foreach($customers as $customer)
        {
            $orders = DB::table('requests')->whereNull('invoice_id')->orwhere('invoice_id',0)->where('user_id', $customer->id)->get();
    
            $record_id = 0;
            $html="";
            $vat = "0%";
            $vat_amount = "0.00";
            $to_email = $customer->email;

            $html .= "<p>Dears,</p><p>We would like to confirm the following invoice(s) is pending.</p>";
            
            foreach($orders as $order)
            {
                $struid = Str::uuid();
                $invoice = new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Invoice';
                $invoice->order_id= $order->id;
                $invoice->extra_charge_id= 0;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $order->price??0;
                $invoice->status = 'Waiting Payment';
                $invoice->save();

                $invoice_id = $invoice->id;

                $cur_order = Price::find($order->id);
                $cur_order->invoice_id = $invoice_id;
                $cur_order->save();

                if($customer->valid_vat == 0){
                    $vat = "19%";
                    $vat_amount = number_format(($order->price - ($order->price/1.19)), 2 , ".");
                }
                
                $str_invoice_no = $invoice_id;

                if($invoice_id < 10){
                    $str_invoice_no = "0000" . $invoice_id;
                }
                if($invoice_id >= 10 && $invoice_id < 100){
                    $str_invoice_no = "000" . $invoice_id;
                }
                if($invoice_id >= 100 && $invoice_id < 1000){
                    $str_invoice_no = "00" . $invoice_id;
                }
                if($invoice_id >= 1000 && $invoice_id < 10000){
                    $str_invoice_no = "0" . $invoice_id;
                }

                $html .= '<div style="width: 100%; padding:5%;">
                <div style="max-width: 720px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="/img/invoice_logo.png" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">Strada Feleacu 3</td>
                                <td style="width:55%; padding:4px; font-weight:600;">' . $customer->company_name . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">077190 Bucharest</td>
                                <td style="width:55%; padding:4px;">' . $customer->location . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">Romania</td>
                                <td style="width:55%; padding:4px;">' . $customer->city . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">VAT: RO47795949</td>
                                <td style="width:55%; padding:4px;">' . $customer->company_country . '</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;"></td>
                                <td style="width:55%; padding:4px;">' . $customer->vat_name . '</td>
                            </tr>
                        </table>
                        
                        <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:50px;">
                            <tr>
                                <td style="padding:4px; background-color:#000;"></td>
                                <td colspan="5" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">INV-'. $str_invoice_no .'</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">Invoice/Bill Date:</td>
                                <td style="padding:4px;">Due Date:</td>
                                <td colspan="2" style="padding:4px;">Service date:</td>
                                <td colspan="2" style="padding:4px;">Payment type:</td>
                            </tr>
                            <tr>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td style="padding:4px;">'. date("d/m/Y") .'</td>
                                <td colspan="2" style="padding:4px;">'. date("d/m/Y", strtotime($order->collection_day)) .'</td>
                                <td colspan="2" style="padding:4px;">Deferred payment</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service ' . $order->pickup_country . ' - ' . $order->desti_country . '</td>
                                <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . $order->price . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $order->price . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                                <td style="padding:4px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; border-bottom:1px solid #000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">Sub Total</td>
                                <td style="padding:4px; text-align:right;">' . $order->price . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="4" style="padding:4px; background-color:#000;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-7000 / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';

            $record_id++;
        }
               if($record_id > 0)
                {
                    Mail::html($html, function($message) use($to_email){
                        $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                        $message->to($to_email);
                        $message->subject('Easymoveeurope - Invoice');
                    });
                }

        }

        echo "Done..";
    }*/



}
