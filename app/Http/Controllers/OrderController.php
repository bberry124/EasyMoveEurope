<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        if(request()->ajax()){
            $requests = Price::latest()->get();
            return DataTables::of($requests)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $url = route('adminRequest.index') .'/' . $row->id .'/edit';
                    $btn = '<a href="'.$url.'" data-toggle="tooltip"  data-original-title="Edit" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

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

                    return number_format($row->total_price, 2, ".", ","). " " . euroSymbol();
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

        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $di)
    {
        $price = Price::find($di);

        $pickup_country = \DB::table('countries')->where('abbreviation', $request->pickup_country)->first();
        $destination_country = \DB::table('countries')->where('abbreviation', $request->destination_country)->first();
        if($pickup_country){
            $pickup_country = $pickup_country->country;
        }

        if($destination_country){
            $destination_country = $destination_country->country;
        }
        $price->pickup_country = $pickup_country;
        $price->desti_country = $destination_country;
        $price->status = $request->status;
        $price->collection_day = $request->collection_day;

        $price->save();
                return response()->json(array('status' => 2,'msg' => "Successfully Submitted"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $reqItems = DB::table('requests')->where('id', $id)->get();

//        dd($reqItems);
        return view('admin.invoice',[
            'reqItems'=> $reqItems
        ]);
    }
}
