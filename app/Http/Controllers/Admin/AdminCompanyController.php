<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\User;
use DataTables;

class AdminCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->where(['type' => '2'],)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           //$btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" style="margin-right:2px;"><i class="fa fa-edit"></i></a>';
                           $btn = '<a href="/admin/company_profile/' . $row->id. '"  class="btn btn-primary btn-sm" style="margin-right:2px;"><i class="fa fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                ->editColumn('created_at', function($row){

                    return $row->created_at->format("d-m-Y");
                })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.adminCompany');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hashed = Hash::make($request->password);



        if($request->password != null){
        User::updateOrCreate(['id' => $request->user_id],
                $request->validate([
                    'name' => 'required|min:3|max:50',
                    'email' => 'email',
                    'company_name' => 'required',
                    'country' =>  'required',
                    'phone' =>  'required',
                    'vat_name' =>  'required',
                    'ship_area' =>  'required',
                    'location' =>  'required',
                    'zipcode' =>  'required',
                    'city' =>  'required',

                ]));
        }
        else{
            User::updateOrCreate(['id' => $request->user_id],
                $request->validate([
                    'name' => 'required|min:3|max:50',
                    'email' => 'email',
                    'company_name' => 'required',
                    'country' =>  'required',
                    'phone' =>  'required',
                    'vat_name' =>  'required',
                    'ship_area' =>  'required',
                    'location' =>  'required',
                    'zipcode' =>  'required',
                    'city' =>  'required',
                ])
               );

        }
        return response()->json(['success'=>'User saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $strpos = strlen($user->vat_name);
        $country_code  = substr($user->vat_name,0,2);
        $vat_number =  substr($user->vat_name,2,$strpos);
        
        $valid_vat = checkValidVat($vat_number, $country_code);
        $user['valid_vat_or_not'] = !$user->valid_vat ? $valid_vat : $user->valid_vat;

        return response()->json($user);
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['success'=>'User deleted successfully.']);
    }

    public function verifyVat(Request $request)
    {
        $strpos = strlen($request->vat);
        $country_code  = substr($request->vat,0,2);
        $vat_number =  substr($request->vat,2,$strpos);
        $valid_vat = checkValidVat($vat_number, $country_code);

        return $valid_vat ? response(true) : response(false);

    }


    /** Update Company Profile
     * 
     */

     public function company_profile($id, Request $request)
    {

        if ($request->ajax()) {
            $data = Price::latest()->where(['user_id' => $id])->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $url = route('adminRequest.index') .'/' . $row->id .'/edit';
                           $btn = '<a href="'.$url.'" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                            
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

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


        $user = User::find($id);
        $strpos = strlen($user->vat_name);
        $country_code  = substr($user->vat_name,0,2);
        $vat_number =  substr($user->vat_name,2,$strpos);
       
        $valid_vat = checkValidVat($vat_number, $country_code);
        $user['valid_vat_or_not'] = !$user->valid_vat ? $valid_vat : $user->valid_vat;

        $tot_orders_count = Price::latest()->where(['user_id' => $id])->count();

        $tot_orders_paid_amount = Price::latest()->where(['user_id' => $id, ])->where('status', '=', 'PAID')->orWhere('status', '=', 'CONFIRMED')->orWhere('status', '=', 'DEFERRED')->sum('total_price');
        $tot_carrier_amount = Price::latest()->where(['user_id' => $id, ])->where('status', '=', 'PAID')->orWhere('status', '=', 'CONFIRMED')->orWhere('status', '=', 'DEFERRED')->sum('carrier_price');
        $tot_margin = ($tot_orders_paid_amount - $tot_carrier_amount);

        return view('admin.adminCompanyProfile', ['user'=>$user, 'tot_orders_count'=>$tot_orders_count, 'paid_amount'=>$tot_orders_paid_amount, 'margin'=>$tot_margin]);
    }


    public function company_profile_update(Request $request)
    {
       
        $result = User::where('id', $request->uid)->first();

        $res =   $result->update([
            'name' => $request->contact_name,
            'phone' => $request->uphone,
            'company_country' => $request->ucountry,
            'vat_name' => $request->uvat,
            'email' => $request->email,
            'additional_email' => $request->additional_email,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'valid_vat'=> $request->vvat,
            'invoice_type'=> $request->invoice_type,
            'internal_note'=> $request->internal_note,
            'credit_balance'=> $request->credit_balance,
        ]);

        if(!$res) {
            return response()->json(array('status' => 1,'error' => "Database Error"));
        }

       
        return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
    }

    public function delete_order($id){
        Price::find($id)->delete();

        return response()->json(['success'=>'Order deleted successfully.']);
    }
    
}
