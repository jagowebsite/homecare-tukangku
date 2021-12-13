<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HistoryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get()->pluck('id');
        $orderdetails = OrderDetail::with(['order', 'service', 'order.user'])->whereHas('order', function ($query) use ($users){
            $query->whereIn('user_id', $users); })->latest();
        // dd($orderdetails);
        if ($request->ajax()) {
            return DataTables::eloquent($orderdetails)
            ->addIndexColumn()
            // ->filterColumn('date_search', function ($query, $keyword) {
            //     $sql = 'order_details.created_at';
            //     $query->where($sql , 'like', "%{$keyword}%");
            // })
            ->addColumn('date_order', function (OrderDetail $orderDetail) {
                $date =$orderDetail->created_at;
                return $date;
            })
                ->rawColumns(['date_order'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.history.history_transaction');
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
