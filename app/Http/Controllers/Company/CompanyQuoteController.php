<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyQuoteController extends Controller
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
        if(request()->ajax()){
            $query = Price::where(function ($query) use ($user_email) {
                $query->where('user_id', auth()->id())
                    ->orWhere('user_email', $user_email);
            })
                ->whereDate('collection_day', '>=', date('Y-m-d'))
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
                    $url = url('company/view_order_company/' . $row->id);
                    return <<<BUTTON
<a class='fa fa-eye' href="$url" target="_blank"></a>
BUTTON;


                })
                ->rawColumns(['view'])

                ->make(true);

        }

        return view('company.companyQuote');
    }

    public function past()
    {
        $user_email = auth()->user()->email;

        if(request()->ajax()){
            $query = Price::where(function ($query) use ($user_email) {
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
                    $url = url('company/view_order_company/' . $row->id);
                    return <<<BUTTON
<a class='fa fa-eye' href="$url" target="_blank"></a>
BUTTON;


                })
                ->rawColumns(['view'])

                ->make(true);

        }

        return view('company.companyPastQuote');
    }

    public function create()
    {
        if(url()->previous() != url('company/invoice_company')){
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


        return view('company.created_order', ['dont_show_container' => true, 'deferred' =>$deferred]);
    }

    public function getReceiverDetails($sender, $receiver)
    {

        $pickup_country = $sender;
        $destination_country =$receiver;



        $pickup_prices = DB::table('countries')->where('country', $pickup_country)->first();
        $destination_prices = DB::table('countries')->where('country', $destination_country)->first();


        if ($pickup_prices == null && $destination_prices == null) {
            $pickup_prices = DB::table('countries')->where('abbreviation', $pickup_country)->first();

            $destination_prices = DB::table('countries')->where('abbreviation', $destination_country)->first();

        } else {

            $destination_country = $pickup_prices->abbreviation;
            $pickup_country = $destination_prices->abbreviation;
        }


        $data = ['pickup_prices' => $pickup_prices,'destination_prices' =>  $destination_prices, 'destination_country' => $destination_country,'pickup_country' =>  $pickup_country];

        return response()->json($data);
    }


    public function invoice(Request $request)
    {
        if(auth()->check())
        $reqItems = DB::table('requests')->where('user_id', auth()->id())->latest()->take(1)->get();
        else
            $reqItems = DB::table('requests')->latest()->take(1)->get();


//        dd($reqItems);
        return view('company.created_order_invoice',[
            'reqItems'=> $reqItems
            , 'request' => $request->all()
        ]);
    }

    public function verifyVat(Request $request)
    {
        $strpos = strlen($request->vat);
        $country_code  = substr($request->vat,0,2);
        $vat_number =  substr($request->vat,2,$strpos);
        $valid_vat = checkValidVat($vat_number, $country_code);



        return $valid_vat ? response(true) : response(false);
    }
}

