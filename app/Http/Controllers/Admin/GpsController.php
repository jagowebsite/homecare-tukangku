<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
       $users = User::get()->pluck('id');
        $payment = Payment::with(['user', 'order'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); });
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
                    $result = null;
                    try {
                        $response = Http::get("https://nominatim.openstreetmap.org/reverse?format=json&lat=$payment->latitude&lon=$payment->longitude&zoom=18&addressdetails=1");
                        $result = $response->json();
                    } catch (\Throwable $th) {
                    }
                    if ($result) {
                        $display_url =
                            '<div>' . $result['display_name'] . '</div>';
                    }

                    $invoice =
                        ' <div>' .
                        $payment->latitude .
                        ', ' .
                        $payment->longitude .
                        '</div>
' .
                        @$display_url .
                        '
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
    // function get_CURL($url)
    // {
    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //     $result = curl_exec($curl);
    //     curl_close($curl);

    //     return json_decode($result, true);
    // }
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
