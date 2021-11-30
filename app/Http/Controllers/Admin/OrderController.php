<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderConfirmation;
use App\Models\OrderDetail;
use App\Models\Service;
// use Barryvdh\DomPDF\PDF; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'orderDetails', 'orderDetails.service'])->latest();
        // dd($orders);
        if ($request->ajax()) {
            return DataTables::eloquent($orders)
                ->addIndexColumn()
                ->addColumn('service_name', function (Order $order) {
                    $orderdetail = '<p>';
                    foreach ($order->orderDetails as $value) {
                        $orderdetail .=
                            '<a class="" href="' .
                            route('services_edit', $value->service->id) .
                            '">' .
                            $value->service->name .
                            ' </a><br>
                    ';
                    }
                    $orderdetail .= '</p>';
                    return $orderdetail;
                })
                ->addColumn('total_price', function (Order $order) {
                    $total_price = $order->orderDetails->sum('total_price');
                    return $total_price;
                })
                ->addColumn('action', function (Order $order) {
                    $action =
                        '<div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('transactions_detail', $order->id) .
                        '" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                        <a href=""  type="button" class="btn btn-secondary" data-order_id="' .
                        $order->id .
                        '"><i class="fa fa-trash"></i></a>
                      </div>
               ';
                    return $action;
                })
                // ->filterColumn('price', function ($query, $keyword) {
                //     $sql = 'order_details.total_price';
                //     $query->sum($sql);
                // })
                ->rawColumns(['action', 'service_name', 'total_price'])
                // ->make(true);
                ->toJson();
        }

        return view('pages.consumen.transactions.index');
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
    public function getInvoice($id)
    {
        $pdf = new PDF();
        $order = Order::with(['user', 'orderdetails', 'payments'])->find($id);
        $data = [];
        $pdf = PDF::loadview('exports.invoice', ['order'=>$order]);
        $options = [
            'dpi' => 96,
            'defaultFont' => 'Nunito',
            'isRemoteEnabled' => true
        ];
        
        $pdf->setOptions($options);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('invoice-pdf');
    	// return $pdf->download('invoice-pdf');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails', 'payments'])->find($id);
        $countorderdetail = OrderDetail::where('order_id', $order->id)
            ->where('status_order_detail', 'pending')
            ->get()
            ->count();
        return view(
            'pages.consumen.transactions.detail',
            compact('order', 'countorderdetail')
        );
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createConfirmation($id)
    {
        $orderdetail = OrderDetail::with(['service'])->find($id);
        $service = Service::with(['serviceCategory'])->find(
            $orderdetail->service->id
        );
        $employees = Employee::where(
            'service_category_id',
            @$service->serviceCategory->id
        )->get();
        return view(
            'pages.consumen.transactions.confirmation',
            compact('orderdetail', 'service', 'employees')
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeConfirmation(Request $request, $id)
    {
        // dd($id);
        $validator = Validator::make(
            $request->all(),
            [
                'employee_id' => 'required',
                'work_duration' => 'required',
                'type_work_duration' => 'required',
                'salary_employee' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'digits' => 'your :attribute is to long',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            session()->flash('danger', $error);
            return back()->withInput();
        }
        DB::beginTransaction();
        $orderdetail = OrderDetail::with(['service'])->find($id);
        // dd($orderdetail);
        OrderConfirmation::create([
            'employee_id' => $request->employee_id,
            'order_detail_id' => @$orderdetail->id,
            'service_id' => @$orderdetail->service->id,
            'work_duration' => $request->work_duration,
            'type_work_duration' => $request->type_work_duration,
            'description' => $request->description,
            'salary_employee' => $request->salary_employee,
        ]);
        $orderdetail->status_order_detail = 'process';
        $orderdetail->verified_at = now();
        $orderdetail->save();

        $countorderdetail = OrderDetail::where(
            'order_id',
            $orderdetail->order_id
        )
            ->where('status_order_detail', 'pending')
            ->get()
            ->count();
        if (!$countorderdetail) {
            $order = Order::find($orderdetail->order_id);
            $order->status_order = 'process';
            $order->verified_at = now();
            $order->save();
        }
        DB::commit();
        session()->flash('success', 'Order Confirmation has been added');
        return redirect()->route('transactions_detail', $orderdetail->order_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelDetailOrder($id)
    {
        DB::beginTransaction();
        $orderdetail = OrderDetail::find($id);
        $orderdetail->status_order_detail = 'cancel';
        $orderdetail->verified_at = now();
        $orderdetail->save();
        $countorderdetail = OrderDetail::where(
            'order_id',
            $orderdetail->order_id
        )
            ->where('status_order_detail', 'pending')
            ->get()
            ->count();
        if (!$countorderdetail) {
            $order = Order::find($orderdetail->order_id);
            $order->status_order = 'process';
            $order->verified_at = now();
            $order->save();
        }
        DB::commit();
        session()->flash('danger', 'Order Confirmation has been canceled');
        return redirect()->route('transactions_detail', $orderdetail->order_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder($id)
    {
        $order = Order::find($id);
        $order->status_order = 'cancel';
        $order->verified_at = now();
        $order->save();

        $orderdetails = OrderDetail::where('order_id', $id)->get();
        foreach ($orderdetails as $orderdetail) {
            $orderdetail->status_order_detail = 'cancel';
            $orderdetail->verified_at = now();
            $orderdetail->save();
        }

        session()->flash('danger', 'Order has been canceled');
        return redirect()->route('transactions_detail', $order->id);
    }
    public function confirmOrder($id)
    {
        DB::beginTransaction();
        $order = Order::find($id);
        $order->status_order = 'done';
        $order->verified_at = now();
        $order->save();
        $orderdetails = OrderDetail::where('order_id', $id)->get();
        foreach ($orderdetails as $orderdetail) {
            if ($orderdetail->status_order_detail == 'process') {
                $orderdetail->status_order_detail = 'done';
                $orderdetail->verified_at = now();
                $orderdetail->save();
            }
        }
        DB::commit();
        session()->flash('success', 'Order has been approved');
        return back();
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        Order::destroy($request->order_id);
        OrderDetail::where('order_id', $request->order_id)->delete();
        DB::commit();
        session()->flash('danger', 'Order has been deleted');
        return back();
    }
}
