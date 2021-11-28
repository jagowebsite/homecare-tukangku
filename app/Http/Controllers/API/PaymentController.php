<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $payments = Payment::with(['user', 'order'])->paginate($limit);
        $data = [];
        foreach ($payments as $payment) {
            $user = [
                'id' => $payment->user->id,
                'email' => $payment->user->email,
                'name' => $payment->user->name,
                'date_of_birth' => $payment->user->date_of_birth,
                'address' => $payment->user->address,
                'number' => $payment->user->number,
                'images' => $payment->user->images
                    ? asset('storage/' . $payment->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $payment->user->ktp_image
                    ? asset('storage/' . $payment->user->ktp_image)
                    : '',
            ];

            if (@$payment->order->orderdetails) {
                $order_detail = [];
                foreach (@$payment->order->orderdetails as $orderdetail) {
                    $images_service = [];
                    if (@$orderdetail->service->status_service == '1') {
                        $status_service = 'active';
                    } else {
                        $status_service = 'nonactive';
                    }
                    if (
                        @count(
                            @json_decode(@$orderdetail->service->images, true)
                        )
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
                        'id' => @$orderdetail->id,
                        'service' => [
                            'id' => @$orderdetail->service_id,
                            'name' => @$orderdetail->service->name,
                            'category' => [
                                'id' => @$orderdetail->service
                                    ->service_category_id,
                                'name' => @$orderdetail->service
                                    ->servicecategory->name,
                            ],
                            'type_quantity' => @$orderdetail->service
                                ->type_quantity,
                            'price' => @$orderdetail->service->price,
                            'images' => @$images_service,
                            'description' => @$orderdetail->service
                                ->description,
                            'status' => @$status_service,
                        ],
                        'quantity' => @$orderdetail->quantity,
                        'price' => @$orderdetail->price,
                        'total_price' => @$orderdetail->total_price,
                        'description' => @$orderdetail->description,
                        'status_order_detail' => @$orderdetail->status_order_detail,
                    ];
                }
            }
            $order = [
                'id' => $payment->order->id,
                // 'user' => $user,
                'invoice_id' => $payment->order->invoice_code,
                'status_order' => $payment->order->status_order,
                'transaction_detail' => $order_detail,
            ];
            $data[] = [
                'id' => $payment->id,
                'user' => @$user,
                'transaction' => @$order,
                'payment_code' => $payment->payment_code,
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
                'total_payment' => $payment->total_payment,
                'status' => $payment->status_payment,
                'description' => $payment->description,
                'address' => $payment->address,
                'created_at' => date_format(date_create($payment->created_at), 'Y-m-d H:i:s')
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data all payments success.',
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
        $validator = Validator::make(
            $request->all(),
            [
               
                'transaction_id' => 'required',
                'type' => 'required',
                'type_transfer' => 'required',
                'images_payment' => 'required|image|file|max:8192',
                'images_user' => 'required|image|file|max:8192',
                'bank_number' => 'required',
                'bank_name' => 'required',
                'account_name' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'total_payment' => 'required',
                'address' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
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
        if ($request->file('images_payment')) {
            $images_payment = @$request
                ->file('images_payment')
                ->store('payments');
        }
        if ($request->file('images_user')) {
            $images_user = @$request->file('images_user')->store('payments');
        }
        $user_id = $request->user()->id;
        Payment::create([
            'user_id' => $user_id,
            'order_id' => $request->transaction_id,
            'payment_code' => 'INVHMC-' . strtotime('now'),
            'type' => $request->type,
            'type_transfer' => $request->type_transfer,
            'images_payment' => @$images_payment,
            'images_user' => @$images_user,
            'bank_number' => $request->bank_number,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'total_payment' => $request->total_payment,
            'status_payment' => 'pending',
            'description' => $request->description,
            'address' => $request->address,
        ]);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Create payment success.',
            ],
            201
        );
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
        $payment = Payment::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                
                'transaction_id' => 'required',
                'type' => 'required',
                'type_transfer' => 'required',
                'images_payment' => 'image|file|max:8192',
                'images_user' => 'image|file|max:8192',
                'bank_number' => 'required',
                'bank_name' => 'required',
                'account_name' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'total_payment' => 'required',
                'address' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
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
        if ($request->file('images_payment')) {
            Storage::delete(@$payment->images_payment);
            $images_payment = @$request
                ->file('images_payment')
                ->store('payments');
            $payment->images_payment = $images_payment;
        }
        if ($request->file('images_user')) {
            Storage::delete(@$payment->images_user);
            $images_user = @$request->file('images_user')->store('payments');
            $payment->images_user = $images_user;
        }
        $user_id = $request->user()->id;
        $payment->user_id = $user_id;
        $payment->order_id = $request->transaction_id;
        $payment->type = $request->type;
        $payment->type_transfer = $request->type_transfer;
        $payment->bank_number = $request->bank_number;
        $payment->bank_name = $request->bank_name;
        $payment->account_name = $request->account_name;
        $payment->longitude = $request->longitude;
        $payment->latitude = $request->latitude;
        $payment->total_payment = $request->total_payment;
        $payment->description = $request->description;
        $payment->address = $request->address;
        $payment->save();
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Payment data successfully updated.',
            ],
            201
        );
    }

    public function confirmPayment($id)
    {
        $payment = Payment::find($id);
        $payment->status_payment = 'success';
        $payment->verified_at = now();
        $payment->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Payment has been confirmed.',
            ],
            201
        );
    }
    public function cancelPayment($id)
    {
        $payment = Payment::find($id);
        $payment->status_payment = 'reject';
        $payment->verified_at = now();
        $payment->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Payment has been rejected',
            ],
            201
        );
    }
}
