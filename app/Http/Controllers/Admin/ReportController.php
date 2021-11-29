<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AllReport;
use App\Exports\ServiceReport;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderdetails = OrderDetail::with(['order', 'service', 'order.user'])
            ->where('status_order_detail', 'done')
            ->whereHas('service', function ($query) {
                $query->whereNotIn('service_category_id', [2, 7]);
            });

        // dd($orderdetails);
        if ($request->ajax()) {
            return DataTables::eloquent($orderdetails)
                // ->addIndexColumn()
                // ->rawColumns(['service_name', 'total_price'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.report.report_service');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAllOrder(Request $request)
    {
        $orderdetails = OrderDetail::with([
            'order',
            'service',
            'order.user',
        ])->where('status_order_detail', 'done')->latest();
        // ->whereHas('service', function ($query) {
        //     $query->whereNotIn('service_category_id', [2, 7]);
        // });

        // dd($orderdetails);
        if ($request->ajax()) {
            return DataTables::eloquent($orderdetails)
                // ->addIndexColumn()
                // ->rawColumns(['service_name', 'total_price'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.report.report_consumen');
    }

    public function exportServiceReport(Request $request)
    {
        return Excel::download(new ServiceReport($request), 'service_report.xlsx');
    }
    public function exportAllReport(Request $request)
    {
        return Excel::download(new AllReport($request), 'all_report.xlsx');
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
