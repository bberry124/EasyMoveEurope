<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class AdminCarriersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->where('type', '!=', '1')->get();
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

        return view('admin.adminCarriers');
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

        User::updateOrCreate(['id' => $request->user_id],
                $request->validate([
                    'name' => 'required|min:3|max:50',
                    'email' => 'email',
                    'company_country' => 'required',
                    'location' => 'required',
                    'zipcode' => 'required',
                    'city' => 'required',
                    'phone'=> 'required|string',
                    'vat_name'=>'string'
                ])
                );
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
}
