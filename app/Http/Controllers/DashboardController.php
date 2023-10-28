<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Models\Purchase;

class DashboardController extends Controller
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
    public function index(Request $request)
    {

        $user_email = auth()->user()->email;
        $requests = DB::table('requests')->where(function ($query) use ($user_email) {
            $query->where('user_id', auth()->id())
                ->orWhere('user_email', $user_email);
        })
            ->select(DB::raw('COUNT(CASE WHEN collection_day <= "'.date('Y-m-d').'" THEN 1 END) AS past_count,
                     COUNT(CASE WHEN collection_day > "'.date('Y-m-d').'" THEN 1 END) AS upcoming_count'))
            ->first();



        return view('dashboard',[
            'pastCount'=> $requests->past_count,
            'upcomingCount'=> $requests->upcoming_count            
        ]);
    }

}
