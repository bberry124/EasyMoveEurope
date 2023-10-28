<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrier;
use Illuminate\Support\Facades\DB;

use DataTables;

class AdminCarrierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
           // $data = DB::table('carriers')->get();
            $data = Carrier::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                           $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                ->editColumn('created_at', function($row){

                    return $row->created_at->format("d-m-Y");
                })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.adminCarrier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

try{

                $request->validate([
                    'carrier_name' => 'required|min:3|max:50',
                    'carrier_email' => 'email',
                    'phone'=> 'required|string',
                    'company_country' => 'required',
                    'location' => 'required',
                    'zipcode' => 'required',
                    'city' => 'required',
                    'vat_name'=>'string',
                ]);
         /*   Carrier::updateOrCreate(['id' => $request->id],
                $request->validate([
                    'carrier_name' => 'required|min:3|max:50',
                    'carrier_email' => 'email',
                    'phone'=> 'required|string',
                    'company_country' => 'required',
                    'location' => 'required',
                    'zipcode' => 'required',
                    'city' => 'required',
                    'vat_name'=>'string',
                ])
                );
                
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 0,
                        'error' => $validator->errors()->all()
                    ]);
                }*/
                
                if($request->id > 0){
                    $data = Carrier::find($request->id);
                    $data->carrier_name = $request->carrier_name; 
                    $data->carrier_email = $request->carrier_email;
                    $data->phone = $request->phone;
                    $data->company_country =$request->company_country;
                    $data->location = $request->location;
                    $data->zipcode = $request->zipcode;
                    $data->city = $request->city;
                    $data->vat_name = $request->vat_name;
                    $data->save();
                }
                else{
                    $data = new Carrier;
                    $data->carrier_name = $request->carrier_name; 
                    $data->carrier_email = $request->carrier_email;
                    $data->phone = $request->phone;
                    $data->company_country =$request->company_country;
                    $data->location = $request->location;
                    $data->zipcode = $request->zipcode;
                    $data->city = $request->city;
                    $data->vat_name = $request->vat_name;
                    $data->save();
                }
}
                 catch(\Exception $e){
                    return response()->json(['errors'=>$e->getMessage()]);
                 }


        return response()->json(['success'=>'User saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $carrier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrier = Carrier::find($id);
        return response()->json($carrier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carrier  $carrier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Carrier::find($id)->delete();

        return response()->json(['success'=>'User deleted successfully.']);
    }
}
