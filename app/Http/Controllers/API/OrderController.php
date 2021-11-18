<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderConfirmation;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $orders = Order::with(['user', 'orderDetails'])->paginate($limit);
        $data = [];
        foreach ($orders as $order) {
            $user = [
                'id' => $order->user->id,
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
                    'id' => @$orderdetail->id,
                    'service' => [
                        'id' => @$orderdetail->service_id,
                        'name' => @$orderdetail->service->name,
                        'category' => [
                            'id' => @$orderdetail->service->service_category_id,
                            'name' => @$orderdetail->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$orderdetail->service
                            ->type_quantity,
                        'price' => @$orderdetail->service->price,
                        'images' => @$images_service,
                        'description' => @$orderdetail->service->description,
                        'status' => @$status_service,
                    ],
                    'quantity' => @$orderdetail->quantity,
                    'price' => @$orderdetail->price,
                    'total_price' => @$orderdetail->total_price,
                    'description' => @$orderdetail->description,
                    'status_order_detail' => @$orderdetail->status_order_detail,
                ];

                $total_all_price = $total_all_price + @$orderdetail->total_price;
            }
            $data[] = [
                'id' => $order->id,
                'user' => @$user,
                'invoice_id' => $order->invoice_code,
                'status_order' => $order->status_order,
                'transaction_detail' => $order_detail,
                'total_all_price' => $total_all_price,
                'created_at' => date_format(date_create($order->created_at), 'Y-m-d H:i:s')
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
            if ($orderdetail->status_order_detail = 'process') {
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
}
