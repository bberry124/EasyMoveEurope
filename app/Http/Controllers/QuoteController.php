<?php

namespace App\Http\Controllers;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;

class QuoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_email = auth()->user()->email;
        

        if(request()->ajax()) {
            $query = Price::where(function ($query) use ($user_email) {
                $query->where('user_id', auth()->id())
                    ->orWhere('user_email', $user_email);
            })
                ->whereDate('collection_day', '>=', date('Y-m-d'))
                ->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {

                    return Carbon::create($row->created_at)->format("d.m.Y");
                })
                ->editColumn('collection_day', function ($row) {

                    return Carbon::create($row->collection_day)->format("d.m.Y");
                })
                ->editColumn('id', function ($row) {

                    return $row->order_number;
                })
                ->editColumn('price', function ($row) {

                    return number_format($row->total_price, 2, ".", ",") . " " . euroSymbol();
                })
                ->editColumn('status', function ($row) {

                    return is_null($row->status) ? $row::$status['WAITING PAYMENT'] : $row->status;
                })
                ->addColumn('view', function($row){
                    $url = url('view_order_company/' . $row->id);
                    return <<<BUTTON
<a class='fa fa-eye' href="$url" target="_blank"></a>
BUTTON;


                })
                ->rawColumns(['view'])
                ->make(true);
        }

        return view('quote');
    }

    public function past()
    {
        $user_email = auth()->user()->email;

        if(request()->ajax()){
            $query =Price::where(function ($query) use ($user_email) {
                $query->where('user_id', auth()->id())
                    ->orWhere('user_email', $user_email);
            })
                ->whereDate('collection_day', '<=', date('Y-m-d'))
                ->get();
            return DataTables::of($query)
                ->addIndexColumn()
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
                ->addColumn('view', function($row){
                    $url = url('view_order_company/' . $row->id);
                    return <<<BUTTON
<a class='fa fa-eye' href="$url" target="_blank"></a>
BUTTON;


                })
                ->rawColumns(['view'])

                    ->make(true);

        }

        return view('pastQuote');
    }

}
