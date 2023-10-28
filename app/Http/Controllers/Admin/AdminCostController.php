<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cost;
use Illuminate\Support\Facades\DB;

class AdminCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cost = DB::table('costs')->value('cost');

        return view('admin.adminCost', ['cost'=>$cost]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Cost::where(['id' => $request->cost_id])->first();

        $model->update(
                $request->validate(
                    [
                            'cost' => 'required',
                    ],
                ),
                [
                    'cost' => $request->cost, 
                ]
        );

        return response()->json(array('status' => 1,'msg' => 'New garage saved successfully.'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cost = Cost::find($id);
        return response()->json($cost);
    }

}