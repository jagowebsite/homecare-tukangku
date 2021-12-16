<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ComplainController extends Controller
{
    public $log;
    public function __construct(){
        $this->log = new LogController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get()->pluck('id');
        $complains = Complain::with(['user', 'order'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); });
            if ($request->ajax()) {
                return DataTables::eloquent($complains)
                ->addIndexColumn()
                ->addColumn('invoice', function (Complain $complain) {
                    $invoice =
                        '<a class="" href="' .
                        route('transactions_detail', $complain->order_id) .
                        '">' .
                        $complain->order->invoice_code .
                        ' </a>
                    ';

                    return $invoice;
                })
                ->addColumn('date_complain', function (Complain $complain) {
                    $date =$complain->created_at;
                    return $date;
                })
                ->addColumn('action', function (Complain $complain) {
                    if ($complain->status_complain != 'pending') {
                        $action =
                            ' <div class="btn-group " role="group" aria-label="Basic example"><button class="btn btn-light tx-uppercase">
                      ' .
                            $complain->status_complain .
                            '</button>    
                      </div>
               ';
                    } else {
                        $action =
                            ' <div class="btn-group" role="group" aria-label="Basic example">
                                    <button data-toggle="modal" data-target="#editCategory"  class="btn btn-success active btn-konfirmasi" data-urlconfirm="' .
                            route('complains_update', ['id' => $complain->id]) .
                            '"><i class="fa fa-check-circle"></i> Konfirmasi</button>
                                  </div>
                           ';
                    }
                    return $action;
                })
                ->rawColumns(['action', 'date_complain', 'invoice'])
                ->make(true);
                // ->toJson();
            }
            return view('pages.complain.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id)
    {
        DB::beginTransaction();
        $user_id = Auth::user()->id??0;
        $complain = Complain::find($id);
        $complain->status_complain = 'done';
        $complain->verified_at = now();
        $complain->save();
        $datalog = [
            'user_id' => $user_id,
            'type' => 'create',
            'description' => "verify complain [$complain->id] $complain->description", 
        ];
        $this->log->store($datalog);
        DB::commit();
        Alert::success('Success', 'Complain has been confirmed');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
