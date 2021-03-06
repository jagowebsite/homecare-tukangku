<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderConfirmation;
use App\Models\OrderDetail;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $users = User::get()->pluck('id');
        $limit = $request->limit ?? 6;
        $orders = Order::with(['user', 'orderDetails', 'payments'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); })->paginate(
            $limit
        );
        $data = [];
        foreach ($orders as $order) {
            $user = [
                'id' => (int) $order->user->id,
                'email' => $order->user->email,
                'name' => $order->user->name,
                'date_of_birth' => $order->user->date_of_birth,
                'address' => $order->user->address,
                'number' => $order->user->number,
                'images' => $order->user->images
                    ? asset('storage/' . $order->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $order->user->ktp_image
                    ? asset('storage/' . $order->user->ktp_image)
                    : '',
            ];
            $order_detail = [];

            $total_all_price = 0;
            foreach ($order->orderdetails as $orderdetail) {
                $images_service = [];
                if (@$orderdetail->service->status_service == '1') {
                    $status_service = 'active';
                } else {
                    $status_service = 'nonactive';
                }
                if (
                    @count(@json_decode(@$orderdetail->service->images, true))
                ) {
                    foreach (
                        @json_decode(@$orderdetail->service->images, true)
                        as $image
                    ) {
                        $images_service[] = asset('storage/' . $image);
                    }
                } else {
                    $images_service[] = 'https://picsum.photos/64';
                }
                $order_detail[] = [
                    'id' => (int) @$orderdetail->id,
                    'service' => [
                        'id' => (int) @$orderdetail->service_id,
                        'name' => @$orderdetail->service->name,
                        'category' => [
                            'id' => (int) @$orderdetail->service->service_category_id,
                            'name' => @$orderdetail->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$orderdetail->service
                            ->type_quantity,
                        'price' => (int) @$orderdetail->service->price,
                        'images' => @$images_service,
                        'description' => @$orderdetail->service->description,
                        'status' => @$status_service,
                    ],
                    'quantity' => (int) @$orderdetail->quantity,
                    'price' => (int) @$orderdetail->price,
                    'total_price' => (int) @$orderdetail->total_price,
                    'description' => @$orderdetail->description,
                    'status_order_detail' => @$orderdetail->status_order_detail,
                ];

                $total_all_price =
                    $total_all_price + @$orderdetail->total_price;
            }
            $payments = [];
            foreach ($order->payments as $payment) {
                $is_active = @$payment->accountpayment->is_active ? 'active':'nonactive';
            $account_payment = [
                'id'=> (int) @$payment->account_payment_id,
                'account_name' => @$payment->accountpayment->account_name,
                'account_number' => @$payment->accountpayment->account_number,
                'bank_name' => strtoupper(@$payment->accountpayment->bank_name),
                'is_active' => $is_active,
            ];
                $payments[] = [
                    'id' => (int) $payment->id,
                    'payment_code' => $payment->payment_code,
                    'account_payment' => @$account_payment,
                    'type' => $payment->type,
                    'type_transfer' => $payment->type_transfer,
                    'images_payment' => $payment->images_payment
                        ? asset('storage/' . $payment->images_payment)
                        : '',
                    'images_user' => $payment->images_user
                        ? asset('storage/' . $payment->images_user)
                        : '',
                    'bank_number' => $payment->bank_number,
                    'bank_name' => $payment->bank_name,
                    'account_name' => $payment->account_name,
                    'longitude' => $payment->longitude,
                    'latitude' => $payment->latitude,
                    'total_payment' => (int) $payment->total_payment,
                    'status' => $payment->status_payment,
                    'description' => $payment->description,
                    'address' => $payment->address,
                    'created_at' => date_format(
                        date_create($payment->created_at),
                        'Y-m-d H:i:s'
                    ),
                ];
            }
            $data[] = [
                'id' => (int) $order->id,
                'user' => @$user,
                'invoice_id' => $order->invoice_code,
                'status_order' => $order->status_order,
                'total_all_price' => (int) $total_all_price,
                'transaction_detail' => $order_detail,
                'payment' => $payments,
                'created_at' => date_format(
                    date_create($order->created_at),
                    'Y-m-d H:i:s'
                ),
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data all transaction success.',
                'data' => @$data,
            ],
            200
        );
    }

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
        return $pdf->stream($order->invoice_code);
    	// return $pdf->download('invoice-pdf');

    }
    public function getLetter($id)
    {
        $pdf = new PDF();
        // $orderconfirmation = OrderConfirmation::with(['employee', 'orderdetail', 'service'])->find($id);
        $orderconfirmation = OrderConfirmation::with(['employee', 'orderDetail', 'service'])
        ->where('order_detail_id', $id)
        ->first();
        $letter= time().'_surat_tugas.pdf';
        if (!$orderconfirmation) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'file not found',
                ],
                200
            );
        }
        $pdf = PDF::loadview('exports.letter', ['orderconfirmation'=>$orderconfirmation]);
        $options = [
            'dpi' => 96,
            'defaultFont' => 'Nunito',
            'isRemoteEnabled' => true
        ];
        
        $pdf->setOptions($options);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream($letter);
    	// return $pdf->download('invoice-pdf');

    }
    public function indexMyTransaction(Request $request)
    {
        $user_id = $request->user()->id;
        $limit = $request->limit ?? 6;
        $orders = Order::with(['user', 'orderDetails', 'payments'])
        ->where('user_id', $user_id)->latest()->paginate(
            $limit
        );
        $data = [];
        foreach ($orders as $order) {
            $user = [
                'id' => (int) $order->user->id,
                'email' => $order->user->email,
                'name' => $order->user->name,
                'date_of_birth' => $order->user->date_of_birth,
                'address' => $order->user->address,
                'number' => $order->user->number,
                'images' => $order->user->images
                    ? asset('storage/' . $order->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $order->user->ktp_image
                    ? asset('storage/' . $order->user->ktp_image)
                    : '',
            ];
            $order_detail = [];

            $total_all_price = 0;
            foreach ($order->orderdetails as $orderdetail) {
                $images_service = [];
                if (@$orderdetail->service->status_service == '1') {
                    $status_service = 'active';
                } else {
                    $status_service = 'nonactive';
                }
                if (
                    @count(@json_decode(@$orderdetail->service->images, true))
                ) {
                    foreach (
                        @json_decode(@$orderdetail->service->images, true)
                        as $image
                    ) {
                        $images_service[] = asset('storage/' . $image);
                    }
                } else {
                    $images_service[] = 'https://picsum.photos/64';
                }
                $order_detail[] = [
                    'id' => (int) @$orderdetail->id,
                    'service' => [
                        'id' => (int) @$orderdetail->service_id,
                        'name' => @$orderdetail->service->name,
                        'category' => [
                            'id' => (int) @$orderdetail->service->service_category_id,
                            'name' => @$orderdetail->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$orderdetail->service
                            ->type_quantity,
                        'price' => (int) @$orderdetail->service->price,
                        'images' => @$images_service,
                        'description' => @$orderdetail->service->description,
                        'status' => @$status_service,
                    ],
                    'quantity' => (int) @$orderdetail->quantity,
                    'price' => (int) @$orderdetail->price,
                    'total_price' => (int) @$orderdetail->total_price,
                    'description' => @$orderdetail->description,
                    'status_order_detail' => @$orderdetail->status_order_detail,
                ];

                $total_all_price =
                    $total_all_price + @$orderdetail->total_price;
            }
            $payments = [];
            foreach ($order->payments as $payment) {
                $is_active = @$payment->accountpayment->is_active ? 'active':'nonactive';
                $account_payment = [
                    'id'=> (int) @$payment->account_payment_id,
                    'account_name' => @$payment->accountpayment->account_name,
                    'account_number' => @$payment->accountpayment->account_number,
                    'bank_name' => strtoupper(@$payment->accountpayment->bank_name),
                    'is_active' => $is_active,
                ];
                $payments[] = [
                    'id' => (int) $payment->id,
                    'payment_code' => $payment->payment_code,
                    'account_payment' => @$account_payment,
                    'type' => $payment->type,
                    'type_transfer' => $payment->type_transfer,
                    'images_payment' => $payment->images_payment
                        ? asset('storage/' . $payment->images_payment)
                        : '',
                    'images_user' => $payment->images_user
                        ? asset('storage/' . $payment->images_user)
                        : '',
                    'bank_number' => $payment->bank_number,
                    'bank_name' => $payment->bank_name,
                    'account_name' => $payment->account_name,
                    'longitude' => $payment->longitude,
                    'latitude' => $payment->latitude,
                    'total_payment' => (int) $payment->total_payment,
                    'status' => $payment->status_payment,
                    'description' => $payment->description,
                    'address' => $payment->address,
                    'created_at' => date_format(
                        date_create($payment->created_at),
                        'Y-m-d H:i:s'
                    ),
                ];
            }
            $data[] = [
                'id' => (int) $order->id,
                'user' => @$user,
                'invoice_id' => $order->invoice_code,
                'status_order' => $order->status_order,
                'total_all_price' => (int) $total_all_price,
                'transaction_detail' => $order_detail,
                'payment' => $payments,
                'created_at' => date_format(
                    date_create($order->created_at),
                    'Y-m-d H:i:s'
                ),
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data all my transaction success.',
                'data' => @$data,
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'user_id' => 'required',
        //     ],
        //     $messages = [
        //         'required' => 'The :attribute field is required.',
        //         'email' => 'Email is not valid.',
        //         'unique' => 'Email has been registered.',
        //         'digits' => 'your :attribute is to long',
        //         'image' =>
        //             'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
        //         'max' =>
        //             'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
        //     ]
        // );
        // if ($validator->fails()) {
        //     $error = $validator->errors()->first();
        //     return response()->json(
        //         [
        //             'status' => 'failed',
        //             'message' => $error,
        //         ],
        //         201
        //     );
        // }
        DB::beginTransaction();
        $order = Order::create([
            'user_id' => @$request->user()->id,
            'invoice_code' => 'TRHMC' . strtotime('now'),
            'status_order' => 'pending',
        ]);
        foreach ($request->transaction_detail as $order_detail) {
            OrderDetail::create([
                'order_id' => $order->id,
                'service_id' => $order_detail['service_id'],
                'quantity' => $order_detail['quantity'],
                'price' => $order_detail['price'],
                'total_price' => $order_detail['total_price'],
                'description' => $order_detail['description'],
                'status_order_detail' => 'pending',
            ]);
        }
        $users = User::with(['roles'])->whereHas('roles', function ($query) {
            $query->where('name', '<>', 'user');
        })->get();
        $data = json_encode([
            'order_id'=>$order->id
        ]);
        $action = route('transactions_detail', $order->id);
        $messages = 'Hai Ada yang melakukan pesanan dengan kode pesanan: '.$order->invoice_code;
        foreach ($users as $user) {
            $user->notify(new OrderNotification($messages, $data, $action));
        }
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' =>
                    'Pesanan berhasil ditambahkan, silahkan lakukan pembayaran.',
            ],
            201
        );
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
        if ($order) {

            $data = [];
            $user = [
                'id' => (int) $order->user->id,
                'email' => $order->user->email,
                'name' => $order->user->name,
                'date_of_birth' => $order->user->date_of_birth,
                'address' => $order->user->address,
                'number' => $order->user->number,
                'images' => $order->user->images
                    ? asset('storage/' . $order->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $order->user->ktp_image
                    ? asset('storage/' . $order->user->ktp_image)
                    : '',
            ];
            $order_detail = [];

            $total_all_price = 0;
            foreach ($order->orderdetails as $orderdetail) {
                $images_service = [];
                if (@$orderdetail->service->status_service == '1') {
                    $status_service = 'active';
                } else {
                    $status_service = 'nonactive';
                }
                if (
                    @count(@json_decode(@$orderdetail->service->images, true))
                ) {
                    foreach (
                        @json_decode(@$orderdetail->service->images, true)
                        as $image
                    ) {
                        $images_service[] = asset('storage/' . $image);
                    }
                } else {
                    $images_service[] = 'https://picsum.photos/64';
                }
                $order_detail[] = [
                    'id' => (int) @$orderdetail->id,
                    'service' => [
                        'id' => (int) @$orderdetail->service_id,
                        'name' => @$orderdetail->service->name,
                        'category' => [
                            'id' => (int) @$orderdetail->service->service_category_id,
                            'name' => @$orderdetail->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$orderdetail->service
                            ->type_quantity,
                        'price' => (int) @$orderdetail->service->price,
                        'images' => @$images_service,
                        'description' => @$orderdetail->service->description,
                        'status' => @$status_service,
                    ],
                    'quantity' => (int) @$orderdetail->quantity,
                    'price' => (int) @$orderdetail->price,
                    'total_price' => (int) @$orderdetail->total_price,
                    'description' => @$orderdetail->description,
                    'status_order_detail' => @$orderdetail->status_order_detail,
                ];

                $total_all_price =
                    $total_all_price + @$orderdetail->total_price;
            }
            $payments = [];
            foreach ($order->payments as $payment) {
                $is_active = @$payment->accountpayment->is_active ? 'active':'nonactive';
                $account_payment = [
                    'id'=> (int) @$payment->account_payment_id,
                    'account_name' => @$payment->accountpayment->account_name,
                    'account_number' => @$payment->accountpayment->account_number,
                    'bank_name' => strtoupper(@$payment->accountpayment->bank_name),
                    'is_active' => $is_active,
                ];
                $payments[] = [
                    'id' => (int) $payment->id,
                    'payment_code' => $payment->payment_code,
                    'account_payment' => @$account_payment,
                    'type' => $payment->type,
                    'type_transfer' => $payment->type_transfer,
                    'images_payment' => $payment->images_payment
                        ? asset('storage/' . $payment->images_payment)
                        : '',
                    'images_user' => $payment->images_user
                        ? asset('storage/' . $payment->images_user)
                        : '',
                    'bank_number' => $payment->bank_number,
                    'bank_name' => $payment->bank_name,
                    'account_name' => $payment->account_name,
                    'longitude' => $payment->longitude,
                    'latitude' => $payment->latitude,
                    'total_payment' => (int) $payment->total_payment,
                    'status' => $payment->status_payment,
                    'description' => $payment->description,
                    'address' => $payment->address,
                    'created_at' => date_format(
                        date_create($payment->created_at),
                        'Y-m-d H:i:s'
                    ),
                ];
            }
            $data = [
                'id' => (int) $order->id,
                'user' => @$user,
                'invoice_id' => $order->invoice_code,
                'status_order' => $order->status_order,
                'total_all_price' => (int) $total_all_price,
                'transaction_detail' => $order_detail,
                'payment' => $payments,
                'created_at' => date_format(
                    date_create($order->created_at),
                    'Y-m-d H:i:s'
                ),
            ];
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Get data all transaction success.',
                    'data' => @$data,
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Get detail transaction failed.',
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showConfirmation($id)
    {
        $order = OrderConfirmation::with(['employee', 'orderDetail', 'service'])
            ->where('order_detail_id', $id)
            ->first();
        if ($order) {
            $data = [];
            $employee = [
                'id' => $order->employee_id,
                'name' => $order->user->name,
            ];
            if ($order->service->status_service == '1') {
                $status_service = 'active';
            } else {
                $status_service = 'nonactive';
            }
            if (@count(@json_decode($order->service->images, true))) {
                foreach (
                    @json_decode($order->service->images, true)
                    as $image
                ) {
                    $images[] = asset('storage/' . $image);
                }
            } else {
                $images[] = ' https://picsum.photos/64';
            }
            $service = [
                'id' => (int) @$order->service->id,
                'name' => @$order->service->name,
                'category' => [
                    'id' => (int) @$order->service->service_category_id,
                    'name' => @$order->service->servicecategory->name,
                ],
                'type_quantity' => @$order->service->type_quantity,
                'price' => @$order->service->price,
                'images' => $images,
                'description' => $order->service->description,
                'status' => $status_service,
            ];
            $data = [
                'id' => (int) $order->order_detail_id,
                'employee' => @$employee,
                'service' => @$service,
                'work_duration' => $order->work_duration,
                'type_work_duration' => $order->type_work_duration,
                'description' => $order->description,
                'salary_employee' => $order->salary_employee,
                'created_at' => date_format(
                    date_create($order->created_at),
                    'Y-m-d H:i:s'
                ),
            ];
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Get confirm transaction detail info success.',
                    'data' => @$data,
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Get confirm transaction detail infofailed.',
            ],
            200
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
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                201
            );
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
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Confirm transaction detail success.',
            ],
            201
        );
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
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Cancel detail transaction success.',
            ],
            201
        );
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
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Confirm transaction success.',
            ],
            201
        );
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

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Cancel transaction success.',
            ],
            201
        );
    }

    public function countMyTransaction(Request $request)
    {
        $user_id = $request->user()->id;
        $orders = Order::where('user_id', $user_id)->where('status_order', 'pending')->get()->count();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get count my transaction success.',
                'data' => [
                    'count'=> $orders,
                ],
            ],
            201
        );
    }
}
