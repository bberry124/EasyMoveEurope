<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Price;
use DataTables;

class AdminGuestRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Price::latest()->where(['who_type' => null])->get();
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
        
        return view('admin.adminGuestRequest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Price::updateOrCreate(['id' => $request->repair_id],
                [
                    'reg_number' => $request->reg_number,
                    'email' => $request->email
                ]);

        return response()->json(['success'=>'Saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repair = Price::find($id);
        return response()->json($repair);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $repair
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Price::find($id)->delete();

        return response()->json(['success'=>'Deleted successfully.']);
    }
}
