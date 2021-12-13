<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get()->pluck('id');
        $payments = Payment::with(['user', 'order'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); });
        // dd($payment);
        if ($request->ajax()) {
            return DataTables::eloquent($payments)
                ->addIndexColumn()
                ->addColumn('invoice', function (Payment $payment) {
                    $invoice =
                        '<p>
                            <a class="" href="' .
                        route('transactions_detail', $payment->order_id) .
                        '">' .
                        $payment->order->invoice_code .
                        ' </a>
                    ';

                    return $invoice;
                })
                ->addColumn('payment_type', function (Payment $payment) {
                    if ($payment->type == 'lunas') {
                        $type =
                            '<p class="text-capitalize"><i class="fa fa-check-circle text-success" aria-hidden="true"></i> ' .
                            $payment->type .
                            '</p>
                    ';
                    } else {
                        $type =
                            '<p class="text-capitalize"><i class="fa fa-hourglass text-warning" aria-hidden="true"></i> ' .
                            $payment->type .
                            '</p>
                        ';
                    }
                    return $type;
                })
                ->addColumn('action', function (Payment $payment) {
                    if ($payment->status_payment != 'pending') {
                        $action =
                            ' <div class="btn-group " role="group" aria-label="Basic example"><button class="btn btn-light tx-uppercase">
                      ' .
                            $payment->status_payment .
                            '</button>
                        <a href="' .
                            route('payments_detail', $payment->id) .
                            '" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                        
                      </div>
               ';
                    } else {
                        $action =
                            ' <div class="btn-group" role="group" aria-label="Basic example">
                                    <button data-toggle="modal" data-target="#editCategory"  class="btn btn-success active btn-konfirmasi" data-urlconfirm="' .
                            route('confirm_payment', ['id' => $payment->id]) .
                            '" data-urlcancel="' .
                            route('cancel_payment', ['id' => $payment->id]) .
                            '"</button><i class="fa fa-check-circle"></i> Konfirmasi</button>
                                    <a href="' .
                            route('payments_detail', $payment->id) .
                            '" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                                    <a href="' .
                            route('cancel_payment', ['id' => $payment->id]) .
                            '"  type="button" class="btn btn-secondary" title="Reject Payment"><i class="fa fa-times-circle"></i></a>
                                  </div>
                           ';
                    }

                    return $action;
                })
                ->addColumn('images', function (Payment $payment) {
                    $img_url = $payment->images_payment
                        ? asset('storage/' . $payment->images_payment)
                        : 'https://picsum.photos/64';
                    $image =
                        '<img src="' . $img_url . '" class="wd-40" alt="">';
                    return $image;
                })
                // ->filterColumn('price', function ($query, $keyword) {
                //     $sql = 'order_details.total_price';
                //     $query->sum($sql);
                // })
                ->rawColumns(['action', 'invoice', 'payment_type', 'images'])
                // ->make(true);
                ->toJson();
        }

        return view('pages.consumen.payments.index');
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
        $payment = Payment::with(['order', 'user'])->find($id);
        return view('pages.consumen.payments.detail', compact('payment'));
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

    public function confirmPayment($id)
    {
        $payment = Payment::find($id);
        $payment->status_payment = 'success';
        $payment->verified_at = now();
        $payment->save();

        // session()->flash('success', 'Payment has been confirmed');
        Alert::success('Success', 'Paymetn has been confirmed');
        return back();
    }
    public function cancelPayment($id)
    {
        $payment = Payment::find($id);
        $payment->status_payment = 'reject';
        $payment->verified_at = now();
        $payment->save();

        // session()->flash('danger', 'Payment has been reject');
        Alert::warning('Warning','Payment has been rejected');
        return back();
    }
}
