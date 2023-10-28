<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\User;
use App\Models\Carrier;
use App\Models\OrderAddress;
use App\Models\AdditionalPrice;
use App\Models\ExtraCharges;
use App\Models\Invoice;
use App\Models\Refund;
use App\Models\CreditNote;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mail;
use File;
use App;
use PDF;
use Log;

class AdminRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {


            $data = Price::latest()->whereIn('who_type', ['person', 'private'])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url = route('adminRequest.index') .'/' . $row->id .'/edit';
                    $btn = '<a href="'.$url.'" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->editColumn('created_at', function($row){

                    return Carbon::create($row->created_at)->format("d.m.Y");
                })
                ->editColumn('collection_day', function($row){

                    return Carbon::create($row->collection_day)->format("d.m.Y");
                })
                ->editColumn('id', function($row){

                    return  $row->order_number;
                })
                ->editColumn('price', function($row){

                    return number_format($row->total_price ?? $row->price, 2, ".", ","). " " . euroSymbol();
                })
                ->editColumn('status', function($row){

                    return is_null($row->status) ? $row::$status['WAITING PAYMENT'] : $row->status;
                })
                ->editColumn('who_type', function($row){
                    return $row->who_type == null || $row->who_type == "" ? __('Guest') : $row->who_type;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.adminRequest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Price::updateOrCreate(['id' => $request->repair_id],
            [
                'reg_number' => $request->reg_number,
                'email' => $request->email
            ]);

        return response()->json(['success' => 'Saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Repair $repair
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repair = Price::find($id);

        $pickup = DB::table('countries')->where('country', $repair->pickup_country)->first();
        if ($pickup) {

            $repair['pickup_country'] = $pickup->abbreviation;
        }


        $desti = DB::table('countries')->where('country', $repair->desti_country)->first();

        if ($desti) {
            $repair['desti_country'] = $desti->abbreviation;
        }

        $prices  = $repair['reqItem'] =  Price::find($id);




        $repair['pickup_prices'] = DB::table('countries')->where('country', $prices->pickup_country)->get();
        $repair['destination_prices'] = DB::table('countries')->where('country', $prices->desti_country)->get();

       // $repair['id'] = $repair->id;
        $user = User::find($repair->user_id);
        $carrier = Carrier::all();
        $additional = AdditionalPrice::all();
        $extra = ExtraCharges::where('order_id', $repair->id)->get();
        $invoices = Invoice::where('order_id', $repair->id)->get();
        $cur_invoice = Invoice::where('order_id', $repair->id)->where('invoice_type', 'Invoice')->first();
        $credit_notes = CreditNote::where('order_id', $repair->id)->get();
        $refunds = Refund::where('order_id', $repair->id)->get();

        $pickup_address = OrderAddress::where('address_type','Pickup')->where('order_id', $repair->id)->get();
        $delivery_address = OrderAddress::where('address_type','Delivery')->where('order_id', $repair->id)->get();
       // $repair['user_data'] =  $user;
       // $repair['carrier_data'] =  $carrier;
       $cur_payment_method = "Credit Card";

       if($repair->payment_method != null && $repair->payment_method != "")
       {
         $cur_payment_method = $repair->payment_method;
       }
       else{
        if($repair->user_id > 0){
                if($user->invoice_type != 'Per Order'){
                    $cur_payment_method = "Deferred";
                }
        }
        
    }

    if($repair->user_id > 0){
        $repair->user_id = $repair->user_id;
        }
        else{
            $repair->user_id=0;
        }

       //  return  view('admin.orders.form', $repair);
       $cur_order_status = ucwords(strtolower($repair->status));

       if($cur_invoice != null && $cur_invoice != ""){
            $cur_order_status = $cur_invoice->status;
       }

       $extra_van = 0;
       if(count($extra) > 0){
            $extra2 = ExtraCharges::where('order_id', $repair->id)->where('requester','Curtain side van')->first();

            if($extra2 != null && $extra2 != ""){
                $extra_van = $extra2->amount;
            }
       }
             

       return  view('admin.orders.form', ['reqItem'=>$repair, 'user'=>$user, 'carrier'=>$carrier, 'additional'=>$additional, 'extra'=>$extra, 'extra_van'=>$extra_van, 'invoices'=>$invoices, 'cur_invoice'=>$cur_invoice, 'cur_order_status'=>$cur_order_status, 'cur_payment_method'=>$cur_payment_method, 'credit_notes'=>$credit_notes, 'refunds'=>$refunds, 'pickup_address'=>$pickup_address, 'delivery_address'=>$delivery_address]);
    }


    public function add_order_address(Request $request)
    {

        if($request->type == "New")
        {
            OrderAddress::create(
                $request->validate([
                    'order_id' => 'required',
                    'address_type' => 'required',
                    'contact_name' => 'required',
                    'contact_address' => 'required',
                    'contact_phone' => 'required'
                ]),
            [
                'order_id' => $request->order_id, 
                'address_type' => $request->address_type,
                'contact_name' => $request->contact_name,
                'contact_address' => $request->contact_address,
                'contact_phone' => $request->contact_phone,
            ]
            );
        }

        if($request->type == "Edit"){
            $info = OrderAddress::find($request->id);
            $info->contact_name = $request->order_address_name;
            $info->contact_address = $request->order_address_address;
            $info->contact_phone = $request->order_address_phone;
            $info->save();
        }

        if($request->type == "Delete"){
            $info = OrderAddress::find($request->id);
            $info->delete();
        }
        
        
        return response()->json(['success' => 'Saved successfully.']);
    }

    public function edit_order_info(Request $request){
        $order = Price::find($request->id);
        $current_user_id = 0;
        $cur_payment_method = "Per Order";
        $old_status = $order->status;
        
        if($order->user_id > 0){
            $user = User::find($order->user_id);
            $current_user_id = $order->user_id;
            
                if($user->invoice_type != 'Per Order'){
                    $cur_payment_method = "Deferred";
                }
        }

       if($request->type == "Pickup"){
            $order->sender = $request->pickup_name;
            $order->sender_address = $request->pickup_address;
            $order->sender_phone = $request->pickup_phone;
            $order->sender_full_phone = $request->pickup_phone;
            $order->save();
       }

       if($request->type == "Delivery"){
            $order->receiver = $request->deliver_name;
            $order->receiver_address = $request->deliver_address;
            $order->receiver_phone = $request->deliver_phone;
            $order->receiver_full_phone = $request->deliver_phone;
            $order->save();
       }

    if($request->type == "customer_note"){
        $order->contact_note = $request->customer_note;
        $order->save();
     }

     if($request->type == "internal_note"){
        $order->intenal_note = $request->internal_note;
        $order->save();
     }

     if($request->type == "ContactAddress"){
        $order->contact_name = $request->contact_name;
        $order->contact_email = $request->contact_email;
        $order->contact_phone = $request->contact_phone;
        $order->contact_full_phone = $request->contact_phone;
        $order->save();
   }

     if($request->type == "update")
     {
       

        $invoice_count = Invoice::where('invoice_type', 'Invoice')->where('order_id',$request->id)->count();

        if($request->status == 'Cancelled After Payment' || $request->status == 'Cancelled Before Payment'){
            if($request->status == 'Cancelled Before Payment')
            {
                $order->status = 'CANCELLED BEFORE PAYMENT';
                $order->save();
            }

            if($request->status == 'Cancelled After Payment')
            {
                $order->status = 'CANCELLED AFTER PAYMENT';
                $order->save();
            }

            if($invoice_count > 0 && $order->invoice_id > 0){
                $invoiceX = Invoice::find($order->invoice_id);
                $invoiceX->status = $request->status;
                $invoiceX->save();

            /*    if($request->status == 'Cancelled after payment')
                {
                    $struid = Str::uuid();
                    $credit = new CreditNote();
                    $credit->uuid = str_replace("-", "c", $struid);
                    $credit->order_id = $order->id;
                    $credit->invoice_id = $order->invoice_id;
                    $credit->amount = $invoiceX->invoice_amount;
                    $credit->save();
                }*/
            }
        }

        $collection_day_arr = explode("/", $request->pickup_date);
        $dtx1 = $collection_day_arr[2] . "-" . $collection_day_arr[1] . "-" . $collection_day_arr[0];
        $order->payment_method = $request->payment_method;
        $order->collection_day = date('Y-m-d', strtotime($dtx1));
        $order->price = $request->tot_price;
        $order->total_price = $request->tot_price;
        $order->status = strtoupper($request->status);
        $order->carrier_id = $request->carrier_id;
        $order->carrier_price = $request->carrier_price;
        $order->save();

        if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
            if($invoice_count == 0){
                if($cur_payment_method == "Per Order")
                {
                    if($request->status != 'Cancelled Before Payment' && $request->status != 'Cancelled After Payment')
                    {
                        $struid = Str::uuid();
                        $invoice =  new Invoice();
                        $invoice->uuid = str_replace("-", "e", $struid);
                        $invoice->invoice_type = 'Invoice';
                        $invoice->order_id= $order->id;
                        $invoice->extra_charge_id= 0;
                        $invoice->invoice_date = date('Y-m-d');
                        $invoice->invoice_amount = $order->price;
                        $invoice->status = $request->status;
                        $invoice->paid_date = date('Y-m-d');
                        $invoice->payment_method = $request->payment_method;
                        $invoice->save();

                        $cur_invoice_id = $invoice->id;

                        $order->invoice_id = $cur_invoice_id;
                        $order->save();

                        $link_extra = ExtraCharges::where('order_id', $request->id)->where('charge_type','Include Order')->get();

                        if(count($link_extra) > 0){
                            foreach($link_extra as $exitem){
                                $exitemx = ExtraCharges::find($exitem->id);
                                $exitemx->invoice_id = $cur_invoice_id;
                                $exitemx->status = $request->status;
                                $exitemx->save();
                            }
                        }

                        if($old_status != strtoupper("Paid") && $old_status != strtoupper("Confirmed") && ($request->status == 'Paid' ||  $request->status == 'Confirmed')){
                            $this->sendInvoiceEmailToCustomer($cur_invoice_id);
                        }
                    }
                }
            }
            else{
                if($cur_payment_method == "Per Order"){
                $invoice = Invoice::where('invoice_type', 'Invoice')->where('order_id',$request->id)->first();
                $paid_dt = $invoice->paid_date;
                $invoice->invoice_amount = $request->tot_price;
                $invoice->status = $request->status;
                if($paid_dt == "" || $paid_dt == null){
                $invoice->paid_date = date('Y-m-d');
                $invoice->payment_method = $request->payment_method;
                }
                $invoice->save();

                $link_extra = ExtraCharges::where('order_id', $request->id)->where('charge_type','Include Order')->get();

                if(count($link_extra) > 0){
                    foreach($link_extra as $exitem){
                        $exitemx = ExtraCharges::find($exitem->id);
                        $exitemx->invoice_id = $invoice->id;
                        $exitemx->status = $request->status;
                        $exitemx->save();
                    }
                }

                if($old_status != strtoupper("Paid") && $old_status != strtoupper("Confirmed") && ($request->status == 'Paid' ||  $request->status == 'Confirmed')){
                    $this->sendInvoiceEmailToCustomer($invoice->id);
                }
            }
        }
        }
        else{
            if($invoice_count > 0)
            {
                $invoice = Invoice::where('invoice_type', 'Invoice')->where('order_id',$request->id)->first();
                if($invoice != null){
                $invoice->invoice_amount = $request->tot_price;
                $invoice->payment_method = $request->payment_method;
                $invoice->status = $request->status;
                $invoice->save();
                }
            }
        }
     }

     if($request->type == "extra")
     {
       // if($order->status == "Waiting Payment" && $order->status == "Deferred Payment")
       // {
            $order->van_type = $request->van_type;
            $order->price = $request->tot_price;
            $order->total_price = $request->tot_price;
            $order->help_loading = $request->charge1;
            $order->help_unloading = $request->charge2;
            $order->tail_lift = $request->charge3;
            $order->pickup_weekend = $request->charge4;
            $order->pickup_same_day = $request->charge5;
            $order->pickup_delelivery_same_country = $request->charge6;
            $order->save();

            $order_invoice_id = $order->invoice_id;
            if($order_invoice_id > 0){
                $order_inv = Invoice::find($order_invoice_id);
                $order_inv->invoice_amount = $request->tot_price;
                $order_inv->save();
            }
       // }

        $current_charges = $request->currentCharges;
        $new_charges = $request->newCharges;
        $remove_charges = $request->removeCharges;
        $charge_amounts = $request->allcharges;

        if($remove_charges != ""){
            $removeArr = explode(",", $remove_charges);

            if(in_array("0",$removeArr)){
                $order->help_loading = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Help to load')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("1",$removeArr)){
                $order->help_unloading = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Help to unload')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("2",$removeArr)){
                $order->tail_lift = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','tail lift')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("3",$removeArr)){
                $order->pickup_weekend = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Pickup on the Weekend')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("4",$removeArr)){
                $order->pickup_same_day = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Pickup Same-day')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("5",$removeArr)){
                $order->pickup_delelivery_same_country = "false";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Pickup - Delivery Same Country')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }
            if(in_array("6",$removeArr)){
                $order->van_type = "box";
                $ex0 = ExtraCharges::where('order_id', $request->id)->where('requester','Curtain side van')->first();
                if($ex0 != null){
                    $ex0->delete();
                }
            }

            $order->save();
        }

        if($new_charges != ""){
            $newArr = explode(",", $new_charges);
            $allchargesArr = explode(",", $charge_amounts);

            if(in_array("0",$newArr)){
                $ex0 = new ExtraCharges();
                $ex0->user_id = $order->user_id??0; 
                $ex0->order_id = $request->id;
                $ex0->requester = 'Help to load';
                $ex0->amount = $allchargesArr[0];
                $ex0->status = 'Waiting Payment';
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex0->invoice_id = 0;
                    $ex0->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex0->invoice_id = $order->invoice_id;
                    $ex0->charge_type = 'Include Order';
                }
                $ex0->save();
            }
            if(in_array("1",$newArr)){
                $ex1 = new ExtraCharges();
                $ex1->user_id = $order->user_id??0; 
                $ex1->order_id =$request->id;
                $ex1->requester = 'Help to unload';
                $ex1->amount = $allchargesArr[1];
                $ex1->status = 'Waiting Payment';                
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex1->invoice_id = 0;
                    $ex1->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex1->invoice_id = $order->invoice_id;
                    $ex1->charge_type = 'Include Order';
                }
                $ex1->save();
            }
            if(in_array("2",$newArr)){
                $ex2 = new ExtraCharges();
                $ex2->user_id = $order->user_id??0; 
                $ex2->order_id = $request->id;
                $ex2->requester = 'tail lift';
                $ex2->amount = $allchargesArr[2];
                $ex2->status = 'Waiting Payment';                
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex2->invoice_id = 0;
                    $ex2->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex2->invoice_id = $order->invoice_id;
                    $ex2->charge_type = 'Include Order';
                }
                $ex2->save();
            }
            if(in_array("3",$newArr)){
                $ex3 = new ExtraCharges();
                $ex3->user_id = $order->user_id??0; 
                $ex3->order_id = $request->id;
                $ex3->requester = 'Pickup on the Weekend';
                $ex3->amount = $allchargesArr[3];
                $ex3->status = 'Waiting Payment';                
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex3->invoice_id = 0;
                    $ex3->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex3->invoice_id = $order->invoice_id;
                    $ex3->charge_type = 'Include Order';
                }
                $ex3->save();
            }
            if(in_array("4",$newArr)){
                $ex4 = new ExtraCharges();
                $ex4->user_id = $order->user_id??0; 
                $ex4->order_id = $request->id;
                $ex4->requester = 'Pickup Same-day';
                $ex4->amount = $allchargesArr[4];
                $ex4->status = 'Waiting Payment';                
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex4->invoice_id = 0;
                    $ex4->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex4->invoice_id = $order->invoice_id;
                    $ex4->charge_type = 'Include Order';
                }
                $ex4->save();
            }
            if(in_array("5",$newArr)){
                $ex5 = new ExtraCharges();
                $ex5->user_id = $order->user_id??0; 
                $ex5->order_id = $request->id;
                $ex5->requester = 'Pickup - Delivery Same Country';
                $ex5->amount = $allchargesArr[5];
                $ex5->status = 'Waiting Payment';                
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex5->invoice_id = 0;
                    $ex5->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex5->invoice_id = $order->invoice_id;
                    $ex5->charge_type = 'Include Order';
                }
                $ex5->save();
            }
            if(in_array("6",$newArr))
            {
                $ex6 = new ExtraCharges();
                $ex6->user_id = $order->user_id??0; 
                $ex6->order_id = $request->id;
                $ex6->requester = 'Curtain side van';
                $ex6->amount = $allchargesArr[6];
                $ex6->status = 'Waiting Payment';
                if($order->status != strtoupper('Waiting Payment') && $order->status != strtoupper('Deferred Payment')){
                    $ex6->invoice_id = 0;
                    $ex6->charge_type = 'Exclude Order';
                }
                else
                {
                    $ex6->invoice_id = $order->invoice_id;
                    $ex6->charge_type = 'Include Order';
                }
                $ex6->save();                
            }
        }
     }

       

        return response()->json(['success' => 'Saved successfully.']);
    }

    public function manage_additional_charges(Request $request)
    {
        if($request->type == "New")
        {
            ExtraCharges::create(
                $request->validate([
                    'user_id' => 'required',
                    'order_id' => 'required',
                    'requester' => 'required',
                    'amount' => 'required',
                    'status' => 'required',
                ]),
            [
                'user_id' => $request->user_id, 
                'order_id' => $request->order_id,
                'requester' => $request->requester,
                'amount' => $request->amount,
                'status' => $request->status,
                'invoice_id' => 0,
                'charge_type' => 'Exclude Order',
            ]
            );
            return response()->json(['success' => 'Saved successfully.']);
        }
        if($request->type == "Edit")
        {
            $additional = ExtraCharges::find($request->id);
            $invoice_id = $additional->invoice_id;
            $additional->requester = $request->requester;
            $additional->amount = $request->amount;
            $additional->status = $request->status;
            $additional->save();

            if($request->status == 'Paid'){
                if($additional->invoice_id > 0){
                    $invoice = Invoice::find($invoice_id);
                    $old_status = $invoice->status;
                    $paid_dt = $invoice->paid_date;
                    $invoice->status = 'Paid';
                    if($paid_dt == "" || $paid_dt == null){
                        $invoice->paid_date = date('Y-m-d');
                        $invoice->payment_method = $request->payment_method;
                    }
                    $invoice->save();

                    if($old_status != "Paid"){
                        $this->sendExtraChrageRequestEmail($request->id);
                    }
                }
                else{
                    $struid = Str::uuid();
                    $invoice =  new Invoice();
                    $invoice->uuid = str_replace("-", "e", $struid);
                    $invoice->invoice_type = 'Extra Charge';
                    $invoice->order_id= $additional->order_id;
                    $invoice->extra_charge_id= $additional->id;
                    $invoice->invoice_date = date('Y-m-d');
                    $invoice->invoice_amount = $additional->amount;
                    $invoice->status = 'Paid';
                    $invoice->payment_method = $request->payment_method;
                    $invoice->paid_date = date('Y-m-d');
                    $invoice->save();
        
                    $invoice_Id = $invoice->id;
                    $additional->invoice_id = $invoice_Id;
                    $additional->save();

                    $this->sendExtraChrageRequestEmail($request->id);
                }

            }

            return response()->json(['success' => 'Updated successfully.']);
        }
        if($request->type == "Delete")
        {
            ExtraCharges::find($request->id)->delete();
            return response()->json(['success' => 'Deleted successfully.']);
        }

        return response()->json(['success' => 'Saved successfully.']);
    }

    public function request_additional_charges(Request $request){
        $order_id = $request->order_id;
        $extra = ExtraCharges::where('order_id', $order_id)->whereNull('invoice_id')->orwhere('invoice_id',0)->get();
        foreach($extra as $extra_item){
            if($extra_item->charge_type == "Exclude Order")
            {
                $struid = Str::uuid();
                $invoice =  new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = 'Extra Charge';
                $invoice->order_id= $extra_item->order_id;
                $invoice->extra_charge_id= $extra_item->id;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = $extra_item->amount;
                if($request->status == 'Paid'){
                    $invoice->status = 'Paid';
                    $invoice->payment_method = $request->payment_method;
                    $invoice->paid_date = date('Y-m-d');
                }
                else{
                    $invoice->status = 'Waiting Payment';
                }
                $invoice->save();
    
                $invoice_Id = $invoice->id;
                $extra_record = ExtraCharges::find($extra_item->id);
                $extra_record->invoice_id = $invoice_Id;
                $extra_record->save();

                $this->sendExtraChrageRequestEmail($extra_record->id);
            }
        }

        return response()->json(['success' => 'Invoice Sent.']);
    }


    public function new_invoice_gen(Request $request)
    {
        $order_id = $request->order_id;
        $order = Price::find($order_id);
        $struid = Str::uuid();

        $invoice =  new Invoice();
        $invoice->uuid = str_replace("-", "e", $struid);
        $invoice->invoice_type = 'Invoice';
        $invoice->order_id= $order->id;
        $invoice->extra_charge_id= 0;
        $invoice->invoice_date = date('Y-m-d');
        $invoice->invoice_amount = $order->total_price;
        $invoice->status = 'Waiting Payment';
        $invoice->save();

            $invoice_id=$invoice->id;
            $order->invoice_id = $invoice_id;
            $order->save();

            return response()->json(['success' => 'Invoice Created.']);
    }

    public function manage_refund(Request $request)
    {
        if($request->id == 0){
        $invoice_id = $request->invoice_id;
        $order_id = $request->order_id;
        $refund_amout = $request->amount;
        $refund_status = $request->status;
        $invoice = Invoice::find($invoice_id);
        $invoice_amout = $invoice->invoice_amount;

            $refund = new Refund();
            $refund->order_id = $order_id;
            $refund->invoice_id = $invoice_id;
            $refund->invoice_amount = $invoice_amout;
            $refund->refund_amout = $refund_amout;
            $refund->credit_note_id = 0;
            $refund->status = $refund_status;

            $refund->save();
        }
        else{
            $refund_status = $request->status;

            $refund= Refund::find($request->id);
            $refund->status = $refund_status;
            $refund->save();
        }
        
        return response()->json(['success' => 'Refund record created.']);
    }

    public function create_credit_note(Request $request)
    {
        $order_id = $request->order_id;
        $refund = Refund::where('order_id',$order_id)->where('credit_note_id',0)->get();

        foreach($refund as $ritem)
        {
            $rId = $ritem->id;
            $refund_row = Refund::find($rId);
            $struid = Str::uuid();
            
            $credit = new CreditNote();
            $credit->uuid = str_replace("-", "c", $struid);
            $credit->order_id = $ritem->order_id;
            $credit->invoice_id = $ritem->invoice_id;
            $credit->amount = $ritem->invoice_amount;
            $credit->save();
            $credit_id = $credit->id;

            $refund_row->credit_note_id = $credit_id;
            $refund_row->save();

            $old_invoice = Invoice::find($ritem->invoice_id);
            $old_status = $old_invoice->status;
            $old_type = $old_invoice->invoice_type;
            $old_extra_charge_id = $old_invoice->extra_charge_id;

            if($old_status == "Paid"){
                $old_invoice->status = 'Cancelled After Payment';
            }
            else{
                If($old_status != "Cancelled Before Payment" && $old_status != "Cancelled After Payment")
                {
                    $old_invoice->status = 'Cancelled Before Payment';
                }
            }
            $old_invoice->save();

            if($ritem->invoice_amount != $ritem->refund_amout){
                $struid = Str::uuid();
                $invoice = new Invoice();
                $invoice->uuid = str_replace("-", "e", $struid);
                $invoice->invoice_type = $old_type;
                $invoice->order_id = $ritem->order_id;
                $invoice->extra_charge_id = $old_extra_charge_id;
                $invoice->invoice_date = date('Y-m-d');
                $invoice->invoice_amount = ($ritem->invoice_amount - $ritem->refund_amout);
                $invoice->status = $old_status;
                $invoice->save();
            }

        }

        return response()->json(['success' => 'Successfully saved.']);
    }


    public function sendExtraChrageRequestEmail($id)
    {
        $extra = ExtraCharges::find($id);
        $invoice_id = $extra->invoice_id;
        $invoice = Invoice::find($extra->invoice_id);
        $order = Price::find($invoice->order_id);
       

        $vat = "0%";
        $vat_amount = "0.00";

        if($order->user_id > 0){
            $customer = User::find($order->user_id);
    
            if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($extra->amount - ($extra->amount/1.19)), 2 , ".");
            }
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

                $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));

        $link = "https://easymoveeurope.com/customer_invoice/" . $invoice->uuid;

        $html = "<table style='width:90%;'>";
        $html .= "<tr>";
        $html .= "<td style='padding:4px;'><img src='" . $logoimage . "' style='width:250px;' /> </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px; font-weight:600;'>Extra charges invoice</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Requester: " . $extra->requester . " </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Total Amount: " . $extra->amount . " &euro;</td>";
        $html .= "</tr>";
        if($extra->status != "Paid")
        {
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Go to following link and see more info </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Link: " . $link . " </td>";
        $html .= "</tr>";
        }
        $html .= "<tr>";
        $html .= "<td style='padding:15px 5px;'>If you have any questions or need to make any changes, do not hesitate to contact us.</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:15px 5px;'>Phone: +40 317 801 214 || <a href='mailto:info@easymoveeurope.com'>info@easymoveeurope.com</a></td>";
        $html .= "</tr>";
        $html .= "</table>";

       

        if($extra->status == "Paid")
        {
          $file_name = 'invoice_' . $str_invoice_no . '.pdf';
          $path = storage_path('invoices/') . $file_name;
  
          $invoice_html =  $this->invoice_data_html($invoice_id);
         
          $pdf = App::make('dompdf.wrapper');
          $pdf->loadHTML($invoice_html);
  
              if (File::exists($path)) {
                  File::delete($path);
              }
  
              $pdf->save($path);
    
  
          $fileContents = base64_encode(File::get($path));

          $to_email = $order->contact_email;
                    Mail::html($html, function($message) use($to_email, $fileContents, $file_name){
                        $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                        $message->to($to_email);
                        $message->subject('Extra charge Invoices');
                        $message->attachData(base64_decode($fileContents), $file_name);
                    });
        }
        else
           { 
            $order_email = $order->contact_email;

            Mail::html($html, function($message) use($order_email){
                $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                $message->to($order_email);
                $message->subject('Extra charge request');
            });
        }

            return true;
    }


    public function send_carrier_email(Request $request){
        $order_id = $request->order_id;
        $carrier_id = $request->carrier_id;

        $order = Price::find($order_id);
        $carrier = Carrier::find($carrier_id);

        $pickup_address = '1. ' . $order->sender . "<br />" .  $order->sender_city . "<br />" .  $order->sender_full_phone;
        $receiver_address =  '1. ' . $order->receiver . "<br />" .  $order->receiver_city . "<br />" .  $order->receiver_full_phone;

        $pickup_address_count = OrderAddress::where('order_id', $order_id)->where('address_type', 'Pickup')->count();
        $delivery_address_count = OrderAddress::where('order_id', $order_id)->where('address_type', 'Delivery')->count();

        if($pickup_address_count == 0){
            $pickup_address = $order->sender . "<br />" .  $order->sender_city . "<br />" .  $order->sender_full_phone;
        }

        if($delivery_address_count == 0){
            $receiver_address =  $order->receiver . "<br />" .  $order->receiver_city . "<br />" .  $order->receiver_full_phone;
        }

        $prow = 1;
        $drow = 1;

       if($pickup_address_count > 0){
            $pickup_address_info = OrderAddress::where('order_id', $order_id)->where('address_type', 'Pickup')->get();
            foreach($pickup_address_info as $paddress)
            {
                $prow++;
                $pickup_address .= '<br /><br />' . $prow .'. ' . $paddress->contact_name . "<br />" . $paddress->contact_address . "<br />" . $paddress->contact_phone;
            }
        }

        if($delivery_address_count > 0){
            $delivery_address_info = OrderAddress::where('order_id', $order_id)->where('address_type', 'Delivery')->get();
            
            foreach($delivery_address_info as $daddress)
            {
                $drow++;
                $receiver_address .= '<br /><br />' . $drow .'. ' . $daddress->contact_name . "<br />" . $daddress->contact_address . "<br />" . $daddress->contact_phone;
            }
        }

        $to_email = $carrier->carrier_email;

        $order_no = $order->order_number;

        $html ='<p style="font-size:14px; text-align:right; padding-right:100px;">Order: ' . $order->order_number . '</p>';
        $html .='<p style="font-size:14px;">Dears,</p>';
        $html .='<p style="font-size:14px;">We would like to confirm the transport with the data below:</p>';
        $html .='<p style="font-size:14px;"><strong>Van type: ' . $order->van_type . '</strong></p>';
        $html .='<p style="font-size:14px;"><strong>Collection day: ' . date('d-m-Y', strtotime($order->collection_day)) . '</strong></p>';
        $html .='<p></p>';
        $html .='<p style="font-size:14px;"><strong>Extras:</strong></p>';
        if($order->help_loading=='true'){
            $html .='<p style="font-size:14px;">Help to load</p>';
        }
        if($order->help_unloading=='true'){
        $html .='<p style="font-size:14px;">Help to unload</p>';
        }
        if($order->tail_lift=='true'){
        $html .='<p style="font-size:14px;">Tail Lift</p>';
        }
        $html .='<p></p>';
        $html .='<p style="font-size:14px;"><strong>Special notes:</strong></p>';
        $html .='<p></p>';
        $html .='<p style="font-size:14px;"><strong>Pick-up address:</strong><br />' . $pickup_address . '</p>';
        $html .='<p></p>';
        $html .='<p style="font-size:14px;"><strong>Delivery address:</strong><br />' . $receiver_address . '</p>';
        $html .='<p></p>';
        $html .='<p style="font-size:14px;"><strong>Agreed price:</strong><br />' . $order->carrier_price . '</p>';
        $html .='<p></p>';
        $html .='<p  style="font-size:14px;">Waiting for your confirmation.</p>';
        $html .='<p></p>';
        $html .='<p style="font-size:12px;">Note: If not agreed in advance, by default the van must have a capacity of at least 13m³ if box van or 19m³ if Curtain side van, with
        weight load capacity of at least 1000 kg</p>';

        $html .='<p></p>';
        $html .='<p></p>';
        $html .='<p style="font-size:20px; font-style: italic; text-align:center; margin-top:60px;">EASY MOVE EUROPE SRL</p>';
        $html .='<p style="font-size:16px; text-align:center;">www.easymoveeurope.com || +40 317 801 214 || VAT: RO47795949 || info@easymoveeurope.com</p>';

        $subject = 'Easy Move transport confirmation – Order ' . $order_no;
    try{
        Mail::html($html, function($message) use($to_email, $subject){
            $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
            $message->to($to_email);
            $message->cc('admin@easymoveeurope.com');
            $message->subject($subject);
        });

        return response()->json(['success' => 'Email successfully sent.']);
    }
    catch(Exception $e){
        return response()->json(['errors' => $e->getMessage()]);
    }

    }


    public function payment_link_email(Request $request)
    {
        $id = $request->id;
        $order = Price::find($id);
        $invoice_id = 0;
       if($order->invoice_id=="" || $order->invoice_id==null || $order->invoice_id=="0")
       {
            $struid = Str::uuid();
            $invoice = new Invoice();
            $invoice->uuid = str_replace("-", "e", $struid);
            $invoice->invoice_type = 'Invoice';
            $invoice->order_id = $id;
            $invoice->extra_charge_id = 0;
            $invoice->invoice_date = date('Y-m-d');
            $invoice->invoice_amount = $order->price;
            $invoice->status = ucwords($order->status);
            $invoice->save();

            $invoice_id = $invoice->id;
       }
       else{
            $invoice_id = $order->invoice_id;
       }
       
        $invoice = Invoice::find($invoice_id);

        $exChargesx = ExtraCharges::where('order_id',$id)->where('charge_type','Include Order')->get();
        foreach($exChargesx as $exitem){
            $exchargeItem = ExtraCharges::find($exitem->id);
            $exchargeItem->invoice_id = $invoice_id;
            $exchargeItem->save();
        }

       

        $vat_no="";
        $vat = "19%";
        $vat_amount = "0.00";
        $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");

        if($order->user_id > 0){
            $customer = User::find($order->user_id);
    
            if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");
            }
            else{
                $vat = "0%";
                $vat_amount = "0.00";
            }
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

                $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));

        $link = "https://easymoveeurope.com/customer_invoice/" . $invoice->uuid;

        $html = "<table style='width:90%;'>";
        $html .= "<tr>";
        $html .= "<td style='padding:4px;'><img src='" . $logoimage . "' style='width:250px;' /> </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px; font-weight:600;'>It is almost done!</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>You can pay now via credit card or bank transfer, so we can start the preparation for your transport.</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Your order number is: " . $order->order_no . " </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Total Amount: " . $invoice->invoice_amount . " &euro;</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Go to following link and see more info: </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:5px;'>Link: " . $link . " </td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:15px 5px;'>If you have any questions or need to make any changes, do not hesitate to contact us.</td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<td style='padding:15px 5px;'>Phone: +40 317 801 214 || <a href='mailto:info@easymoveeurope.com'>info@easymoveeurope.com</a></td>";
        $html .= "</tr>";
        $html .= "</table>";

      /*  if($order->user_id > 0  && ($invoice->status=="Paid" || $invoice->status=="Confirmed")){
        $html .= '<div style="width: 100%; padding:5%;">
                <div style="max-width: 720px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="https://easymoveeurope.com/img/invoice_logo.png" style="width:250px;" />
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
                                <td colspan="2" style="padding:4px;">'. $invoice->payment_method .'</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service. ' . $order->pickup_country .  ' - ' . $order->desti_country . '</td>
                                <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $invoice->invoice_amount . ' &euro;</td>
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
                                <td style="padding:4px; text-align:right;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                                <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                                <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">' .$invoice->invoice_amount .' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-' . $str_invoice_no.' / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';
        }*/
            
        $order_email = $order->contact_email;

            Mail::html($html, function($message) use($order_email){
                $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                $message->to($order_email);
                $message->subject('New payment link');
            });

            return true;
    }


    public function invoice_view(Request $request){
        $invoice = Invoice::find($request->id);
        $order = Price::find($invoice->order_id);

        $vat_no="";
        $vat = "19%";
        $vat_amount = "0.00";
        $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");

       
        $customer_name=$order->sender;
        $customer_address=$order->sender_city . "<br />" . $order->pickup_country;

        if($order->user_id > 0){
            $customer = User::find($order->user_id);

            if($customer->type == 2){
                $customer_name=$customer->company_name;
            }
            else{
                $customer_name=$customer->name;
            }
                $customer_address=$customer->location . "<br />" . $customer->city . "<br />" . $customer->company_country;
    
           if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");
                $vat_no=$customer->vat_name;
            }
            else{
                $vat = "0%";
                $vat_amount = "0.00";
                $vat_no=$customer->vat_name;
            }
        }

        $invoice_id= $request->id;
        $str_invoice_no = $request->id;

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

                $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));


                $html = '<div style="width: 100%; padding:5%;">
                <div style="max-width: 720px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="' . $logoimage . '" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">
                                Strada Feleacu 3,<br />
                                077190 Bucharest,<br />
                                Romania.<br />
                                VAT: RO47795949<br />
                                </td>
                                <td style="width:55%; padding:4px;"><span style=" font-weight:600;">' . $customer_name . '</span><br />' . $customer_address . '<br />' . $vat_no . '</td>
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
                                <td colspan="2" style="padding:4px;">'. date("d/m/Y",strtotime($order->collection_day)) .'</td>
                                <td colspan="2" style="padding:4px;">'. $invoice->payment_method .'</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>';

                        if($invoice->invoice_type =='Invoice')
                        {
                            $html .= '<td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service. ' . $order->pickup_country .  ' - ' . $order->desti_country . '</td>';
                        }
                        if($invoice->invoice_type == 'Extra Charge')
                        {
                            $extra = ExtraCharges::where('invoice_id',$invoice->id)->first();
                            $html .= '<td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Additional charges. (' . $extra->requester . ')</td>';
                        }
                        $html .= '<td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:center;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $invoice->invoice_amount . ' &euro;</td>
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
                                <td style="padding:4px; text-align:right;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                                <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                                <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">' .$invoice->invoice_amount .' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-'.$str_invoice_no.' / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';            
            
            return response()->json(['data'=>$html]);

    }


    public function invoice_data_html($id){
        $invoice = Invoice::find($id);
        $order = Price::find($invoice->order_id);

        $vat_no="";
        $vat = "19%";
        $vat_amount = "0.00";
        $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");

       
        $customer_name=$order->sender;
        $customer_address=$order->sender_city . "<br />" . $order->pickup_country;

        if($order->user_id > 0){
            $customer = User::find($order->user_id);

            if($customer->type == 2){
                $customer_name=$customer->company_name;
            }
            else{
                $customer_name=$customer->name;
            }
                $customer_address=$customer->location . "<br />" . $customer->city . "<br />" . $customer->company_country;
    
           if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");
                $vat_no=$customer->vat_name;
            }
            else{
                $vat = "0%";
                $vat_amount = "0.00";
                $vat_no=$customer->vat_name;
            }
        }

        $invoice_id= $id;
        $str_invoice_no = $id;

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

                $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));


                $html = '<div style="width: 100%;">
                <div style="max-width: 630px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
                    <div style="width: 100%; margin: 0 auto; padding: 0;">
                        <img src="' . $logoimage . '" style="width:250px;" />
                    </div>
                    
                    <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                                <td style="width:55%; padding:4px;">Invoice to:</td>
                            </tr>
                            <tr>
                                <td style="width:65%; padding:4px;">
                                Strada Feleacu 3,<br />
                                077190 Bucharest,<br />
                                Romania.<br />
                                VAT: RO47795949<br />
                                </td>
                                <td style="width:55%; padding:4px;"><span style=" font-weight:600;">' . $customer_name . '</span><br />' . $customer_address . '<br />' . $vat_no . '</td>
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
                                <td colspan="2" style="padding:4px;">'. date("d/m/Y",strtotime($order->collection_day)) .'</td>
                                <td colspan="2" style="padding:4px;">'. $invoice->payment_method .'</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                                <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                            </tr>
                            <tr>';

                        if($invoice->invoice_type =='Invoice')
                        {
                            $html .= '<td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service. ' . $order->pickup_country .  ' - ' . $order->desti_country . '</td>';
                        }
                        if($invoice->invoice_type == 'Extra Charge')
                        {
                            $extra = ExtraCharges::where('invoice_id',$invoice->id)->first();
                            $html .= '<td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Additional charges. (' . $extra->requester . ')</td>';
                        }
                        $html .= '<td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                                <td style="padding:4px; background-color:#e7e7e7;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:center;">' . $vat . '</td>
                                <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $invoice->invoice_amount . ' &euro;</td>
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
                                <td style="padding:4px; text-align:right;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px;">&nbsp;</td>
                                <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                                <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                                <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                                <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">' .$invoice->invoice_amount .' &euro;</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: INV-'.$str_invoice_no.' / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                            </tr>
                            <tr>
                                <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                            </tr>
                        </table>
                    
                    </div>
                </div>
            </div>';            
            
            return $html;

    }


    public function invoice_pdf_view($id){
        $invoice = Invoice::find($id);
        $order = Price::find($invoice->order_id);

        $extra = "";
        if($invoice->invoice_type == 'Extra Charge'){
            $extra = ExtraCharges::where('invoice_id',$invoice->id)->first();
        }

        $vat_no="";
        $vat = "19%";
        $vat_amount = "0.00";
        $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");

        if($order->user_id > 0){
            $customer = User::find($order->user_id);
    
            if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");
                $vat_no=$customer->vat_name;
            }
            else{
                $vat = "0%";
                $vat_amount = "0.00";
                $vat_no=$customer->vat_name;
            }
        }


        $invoice_id= $id;
        $str_invoice_no = $id;

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

        $invoice_amount = $invoice->invoice_amount;

        $invoice_amount = $invoice->invoice_amount;
        $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));

        $data = [
            'str_invoice_no' => $str_invoice_no,
            'invoice' => $invoice,
            'order' => $order,
            'vat_no' => $vat_no,
            'vat' => $vat,
            'vat_amount' => $vat_amount,
            'invoice_amount' => $invoice_amount,
            'service_date' => date('d/m/Y', strtotime($order->collection_day)),
            'payment_method' => $invoice->payment_method,
            'logo_img' => $logoimage,
            'extra' => $extra,
        ];
        $pdf = PDF::loadView('invoice_view', $data);
        $file_name = 'invoice_' . $str_invoice_no . '.pdf';

        $path = storage_path('invoices/') . $file_name;

        if (File::exists($path)) {
            File::delete($path);
        }
       
        $pdf->save($path);
       // $invoice_data = $pdf->stream('invoice_' . $str_invoice_no . '.pdf');
       /* $fileContents = base64_encode(File::get($path));
        $html = "<p>see attached</p>";
        $order_email ="kapilapgg1976@gmail.com";
        Mail::html($html, function($message) use($order_email, $fileContents, $file_name){
            $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
            $message->to($order_email);
            $message->subject('New Invoice');
            $message->attachData(base64_decode($fileContents), $file_name);
        });*/

       // return $file_name;

        return response()->json(['data' => $file_name]);
      //  return response()->file(storage_path('invoices/' . $file_name),['content-type'=>'application/pdf']);    
         //   return response()->json(['data'=>$html]);
       //  return  view('invoice_view',['str_invoice_no'=>$str_invoice_no, 'invoice'=>'$invoice', 'order'=>$order, 'vat_no'=>$vat_no, 'vat'=>$vat, 'vat_amount'=>$vat_amount, 'invoice_amount'=>$invoice_amount ]);

    }

    public function sendInvoiceEmailToCustomer($id)
    {
        $invoice = Invoice::find($id);
        $order = Price::find($invoice->order_id);
        $this->invoice_pdf_view($id);

        $invoice_id=$id;
        $str_invoice_no = $id;

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

        $file_name = 'invoice_' . $str_invoice_no . '.pdf';
        $path = storage_path('invoices/') . $file_name;
        if($invoice->invoice_type == "Extra Charge"){

            $invoice_html = $this->invoice_data_html($id);
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($invoice_html);

            if (File::exists($path)) {
                File::delete($path);
            }

            $pdf->save($path);
        }        

        $fileContents = base64_encode(File::get($path));

                    $html2 = "<p>Dears, </p><p>Your Invoice attached with this email</p>";
                    $html2 .= "<p>Order number: " . $order->order_number . "</p>";
                    $html2 .= "<p>Total Amount: " . $invoice->invoice_amount  . "</p>";
                    $html2 .= "<p>Payment Method: " . $invoice->payment_method  . "</p>";
                    $html2 .= "<p>Paid Date: " . date('d/M/Y', strtotime($invoice->paid_date))  . "</p>";
                    $html2 .= "<p style='padding:15px 5px; margin-top:20px;'>If you have any questions or need to make any changes, do not hesitate to contact us.</p>";
                    $html2 .= "<p style='padding:15px 5px;'>Phone: +40 317 801 214 || <a href='mailto:info@easymoveeurope.com'>info@easymoveeurope.com</a></p>";

                    $to_email = $order->contact_email;
                    Mail::html($html2, function($message) use($to_email, $fileContents, $file_name){
                        $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
                        $message->to($to_email);
                        $message->subject('Invoice');
                        $message->attachData(base64_decode($fileContents), $file_name);
                    });

    }


    public function credit_note_pdf($id){
        $credit_note = CreditNote::find($id);
        $invoice = Invoice::find($credit_note->invoice_id);
        $order = Price::find($credit_note->order_id);

        $vat_no="";
        $vat = "19%";
        $vat_amount = "0.00";
        $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");

        $customer_name=$order->sender;
        $customer_address=$order->sender_city . "<br />" . $order->pickup_country;

        if($order->user_id > 0){
            $customer = User::find($order->user_id);
            $customer_name=$customer->company_name??$customer->name;
            $customer_address= $customer->location . ",<br />" . $customer->city . ",<br />" . $customer->zipcode . ",<br />" . $customer->company_country;
            

            if($customer->valid_vat == 0){
                $vat = "19%";
                $vat_amount = number_format(($invoice->invoice_amount - ($invoice->invoice_amount/1.19)), 2 , ".");
                $vat_no=$customer->vat_name;
            }
            else{
                $vat = "0%";
                $vat_amount = "0.00";
                $vat_no=$customer->vat_name;
            }

           
        }

        $note_id= $id;
        $str_no = $id;

                if($note_id < 10){
                    $str_no = "0000" . $note_id;
                }
                if($note_id >= 10 && $note_id < 100){
                    $str_no = "000" . $note_id;
                }
                if($note_id >= 100 && $note_id < 1000){
                    $str_no = "00" . $note_id;
                }
                if($note_id >= 1000 && $note_id < 10000){
                    $str_no = "0" . $note_id;
                }

                $invoice_id= $invoice->id;
                $str_invoice_no = $invoice->id;
        
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

        $amount = $credit_note->amount;

        $imagePath = public_path("img/invoice_logo.png");

        $logoimage = "data:image/png;base64,".base64_encode(file_get_contents($imagePath));


        $html = '<div style="width: 100%;">
        <div style="max-width: 630px; background-color: white; width: 100%;padding:15px 5%; border:1px solid #000;">
            <div style="width: 100%; margin: 0 auto; padding: 0;">
                <img src="' . $logoimage . '" style="width:250px;" />
            </div>
            
            <div style="margin: 10px auto; min-height: 250px; width: 100%; border-top: 1px solid #000;">
                <table style="width:100%;">
                    <tr>
                        <td style="width:65%; padding:4px; font-weight:600;">EASY MOVE EUROPE SRL</td>
                        <td style="width:55%; padding:4px;">Invoice to:</td>
                    </tr>
                    <tr>
                        <td style="width:65%; padding:4px;">
                        Strada Feleacu 3,<br />
                        077190 Bucharest,<br />
                        Romania.<br />
                        VAT: RO47795949<br />
                        </td>
                        <td style="width:55%; padding:4px;"><span style=" font-weight:600;">' . $customer_name . '</span><br />' . $customer_address . '<br />' . $vat_no . '</td>
                    </tr>                            
                </table>
                
                <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:50px;">
                    <tr>
                        <td style="padding:4px; background-color:#000;"></td>
                        <td colspan="5" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">CN-'. $str_no .'</td>
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
                        <td colspan="2" style="padding:4px;">'. date("d/m/Y",strtotime($order->collection_day)) .'</td>
                        <td colspan="2" style="padding:4px;">'. $invoice->payment_method .'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Description</td>
                        <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Quantity</td>
                        <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Unit Price</td>
                        <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Taxes</td>
                        <td style="padding:4px; font-weight:600; color:#fff; background-color:#000;">Amount</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:4px; background-color:#e7e7e7;">Order ' . $order->order_number . ' – Shipping service. ' . $order->pickup_country .  ' - ' . $order->desti_country . '</td>
                        <td style="padding:4px; background-color:#e7e7e7;">1.00</td>
                        <td style="padding:4px; background-color:#e7e7e7;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                        <td style="padding:4px; background-color:#e7e7e7; text-align:center;">' . $vat . '</td>
                        <td style="padding:4px; background-color:#e7e7e7; text-align:right;">' . $invoice->invoice_amount . ' &euro;</td>
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
                        <td style="padding:4px; text-align:right;">' . ($invoice->invoice_amount - $vat_amount) . ' &euro;</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:4px;">&nbsp;</td>
                        <td colspan="3" style="padding:4px;">VAT ' . $vat . ' &euro;</td>
                        <td style="padding:4px; text-align:right;">' . $vat_amount . ' &euro;</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding:4px; color:#fff;">&nbsp;</td>
                        <td colspan="3" style="background-color:#000; padding:4px; color:#fff;">Total</td>
                        <td style="padding:4px; background-color:#000; color:#fff;text-align:right;">' .$invoice->invoice_amount .' &euro;</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding:60px 4px; text-align:center;">Payment reference: CN-'.$str_no.' / IBAN: RO80 INGB 0000 9999 1362 3897 (SWIFT/BIC: INGBROBU)</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="padding:4px; text-align:center; background-color:#000; color:#6f7071;">www.easymoveeurope.com || +40 317 801 214 || info@easymoveeurope.com</td>
                    </tr>
                </table>
            
            </div>
        </div>
    </div>';

        
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($html);
                $file_name = 'credit_note_' . $str_no . '.pdf';

                $path = storage_path('invoices/') . $file_name;
        
                if (File::exists($path)) {
                    File::delete($path);
                }
               
                $pdf->save($path);

       // $invoice_data = $pdf->stream('invoice_' . $str_invoice_no . '.pdf');
       /* $fileContents = base64_encode(File::get($path));
        $html = "<p>see attached</p>";
        $order_email ="kapilapgg1976@gmail.com";
        Mail::html($html, function($message) use($order_email, $fileContents, $file_name){
            $message->from(config('mail.mailers.smtp.username'), 'Easymoveeurope');
            $message->to($order_email);
            $message->subject('New Invoice');
            $message->attachData(base64_decode($fileContents), $file_name);
        });*/

       // return $file_name;

        return response()->json(['data' => $file_name]);
      //  return response()->file(storage_path('invoices/' . $file_name),['content-type'=>'application/pdf']);    
         //   return response()->json(['data'=>$html]);
       //  return  view('invoice_view',['str_invoice_no'=>$str_invoice_no, 'invoice'=>'$invoice', 'order'=>$order, 'vat_no'=>$vat_no, 'vat'=>$vat, 'vat_amount'=>$vat_amount, 'invoice_amount'=>$invoice_amount ]);

    }


    public function display_pdf($file_name){
       /* return Response::make(file_get_contents('images/image1.pdf'), 200, [
            'content-type'=>'application/pdf',
        ]);*/
//or
        return response()->file(storage_path('invoices/' . $file_name),['content-type'=>'application/pdf']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Price $repair
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Price::find($id)->delete();

        return response()->json(['success' => 'Deleted successfully.']);
    }
}
