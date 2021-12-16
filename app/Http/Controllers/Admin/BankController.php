<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountpayments = AccountPayment::query()->latest();
        // dd($AccountPayments);
        if ($request->ajax()) {
            return DataTables::eloquent($accountpayments)
                ->addIndexColumn()
                
                ->addColumn('action', function (AccountPayment $accountpayment) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('account_edit', [$accountpayment->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-accountpayment" data-asset_id="' .
                        $accountpayment->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.setting.bank_account.index');
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
    public function update(Request $request, $id)
    {
        //
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
