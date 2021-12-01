<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment = Payment::with(['user', 'order']);
        // dd($payment);
        if ($request->ajax()) {
            return DataTables::eloquent($payment)
                ->addIndexColumn()
                ->addColumn('invoice', function (Payment $payment) {
                    $invoice =
                        '<p>
                            <a class="" href="' .
                        route('transactions_detail', $payment->order->id) .
                        '">' .
                        $payment->order->invoice_code .
                        ' </a>
                    ';

                    return $invoice;
                })
                ->addColumn('gps_maps', function (Payment $payment) {
                    $invoice =
                        ' <div>' .
                        $payment->latitude .
                        ', ' .
                        $payment->longitude .
                        '</div>
                    <a href="http://maps.google.com/maps?q=' .
                        $payment->latitude .
                        ',' .
                        $payment->longitude .
                        '" target="_blank">Lihat lokasi <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';

                    return $invoice;
                })

                ->rawColumns(['invoice', 'gps_maps'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.consumen.gps_logs.index');
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
