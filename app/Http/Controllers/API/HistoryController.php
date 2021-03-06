<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderConfirmation;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $users = User::get()->pluck('id');
        $orderdetails = OrderDetail::with([
            'order',
            'service',
            
        ])->whereHas('order', function ($query) use ($users){
            $query->whereIn('user_id', $users); })->latest()->paginate($limit);
        $data = [];
        foreach($orderdetails as $item){
            $user = [
                'id' => (int) @$item->order->user->id,
                'email' => @$item->order->user->email,
                'name' => @$item->order->user->name,
                'date_of_birth' => @$item->order->user->date_of_birth,
                'address' => @$item->order->user->address,
                'number' => @$item->order->user->number,
                'images' => @$item->order->user->images
                    ? asset('storage/' . @$item->order->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => @$item->order->user->ktp_image
                    ? asset('storage/' . @$item->order->user->ktp_image)
                    : '',
            ];
            $order = [
                'id' => (int) @$item->order->id,
                'invoice_id' => @$item->order->invoice_code,
                'user' => @$user,
                'status_order' => @$item->order->status_order,
            ];
            $images_service = [];
            if (@$item->service->status_service == '1') {
                $status_service = 'active';
            } else {
                $status_service = 'nonactive';
            }
            if (
                @count(@json_decode(@$item->service->images, true))
            ) {
                foreach (
                    @json_decode(@$item->service->images, true)
                    as $image
                ) {
                    $images_service[] = asset('storage/' . $image);
                }
            } else {
                $images_service[] = 'https://picsum.photos/64';
            }
            $service = [
                'id' => (int) @$item->service_id,
                        'name' => @$item->service->name,
                        'category' => [
                            'id' => (int) @$item->service->service_category_id,
                            'name' => @$item->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$item->service
                            ->type_quantity,
                        'price' => (int) @$item->service->price,
                        'images' => @$images_service,
                        'description' => @$item->service->description,
                        'status' => @$status_service,
                    ];
                    $data[]=[
                        'id'=> (int) $item->id,
                        'order'=>@$order,
                        'service'=>@$service,
                        'quantity'=> (int) @$item->quantity,
                        'price'=> (int) @$item->price,
                        'total_price'=> (int) @$item->total_price,
                        'description'=>@$item->description,
                        'status_order_detail'=>@$item->status_order_detail,
                        'verified_at' => date_format(
                            date_create(@$item->verified_at),
                            'Y-m-d H:i:s'
                        ),
                        'created_at' => date_format(
                            date_create($item->created_at),
                            'Y-m-d H:i:s'
                        ),
                    ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data history consumen success.',
                'data' => @$data,
            ],
            200
        );
    }

    public function indexEmployee(Request $request)
    {
        $limit = $request->limit ?? 6;
        $orderconfirmations = OrderConfirmation::with([
            'employee',
            'orderdetail',
            'service',
        ])->latest()->paginate($limit);
        $data = [];
        foreach ($orderconfirmations as $item) {
            $image_employee = @$item->employee->images
                ? asset('storage/' . @$item->employee->images)
                : 'https://picsum.photos/64';
            if (@$item->employee->is_ready == 1) {
                $is_ready = true;
            } else {
                $is_ready = false;
            }
            $employee = [
                'id' => (int) @$item->employee->id,
                'category_service' => [
                    'id' => (int) @$item->employee->service_category_id,
                    'name' => @$item->employee->servicecategory->name,
                ],
                'name' => @$item->employee->name,
                'address' => @$item->employee->address,
                'number' => @$item->employee->number,
                'is_ready' => $is_ready,
                'status' => @$item->employee->status_employee,
                'images' => $image_employee,
            ];
            $images_service = [];
            if (@$item->service->status_service == '1') {
                $status_service = 'active';
            } else {
                $status_service = 'nonactive';
            }
            if (
                @count(@json_decode(@$item->service->images, true))
            ) {
                foreach (
                    @json_decode(@$item->service->images, true)
                    as $image
                ) {
                    $images_service[] = asset('storage/' . $image);
                }
            } else {
                $images_service[] = 'https://picsum.photos/64';
            }
            $service = [
                'id' => (int) @$item->service_id,
                        'name' => @$item->service->name,
                        'category' => [
                            'id' => (int) @$item->service->service_category_id,
                            'name' => @$item->service->servicecategory
                                ->name,
                        ],
                        'type_quantity' => @$item->service
                            ->type_quantity,
                        'price' => (int) @$item->service->price,
                        'images' => @$images_service,
                        'description' => @$item->service->description,
                        'status' => @$status_service,
                    ];
                    $user = [
                        'id' => (int) @$item->orderdetail->order->user->id,
                        'email' => @$item->orderdetail->order->user->email,
                        'name' => @$item->orderdetail->order->user->name,
                        'date_of_birth' => @$item->orderdetail->order->user->date_of_birth,
                        'address' => @$item->orderdetail->order->user->address,
                        'number' => @$item->orderdetail->order->user->number,
                        'images' => @$item->orderdetail->order->user->images
                            ? asset('storage/' . @$item->orderdetail->order->user->images)
                            : url('/') . '/assets/icon/user_default.png',
                        'ktp_image' => @$item->orderdetail->order->user->ktp_image
                            ? asset('storage/' . @$item->orderdetail->order->user->ktp_image)
                            : '',
                    ];
                    $order = [
                        'id' => (int) @$item->orderdetail->order->id,
                        'invoice_id' => @$item->orderdetail->order->invoice_code,
                        'user' => @$user,
                        'status_order' => @$item->orderdetail->order->status_order,
                    ];
                    $order_detail=[
                        'id'=> (int) $item->order_detail_id,
                        'order'=>@$order,
                        'service'=>@$service,
                        'quantity'=> (int) @$item->orderdetail->quantity,
                        'price'=> (int) @$item->orderdetail->price,
                        'total_price'=>(int) @$item->orderdetail->total_price,
                        'description'=>@$item->orderdetail->description,
                        'status_order_detail'=>@$item->orderdetail->status_order_detail,
                        'verified_at' => date_format(
                            date_create(@$item->orderdetail->verified_at),
                            'Y-m-d H:i:s'
                        ),
                        'created_at' => date_format(
                            date_create(@$item->orderdetail->created_at),
                            'Y-m-d H:i:s'
                        ),
                    ];
                    $data[]=[
                        'id'=> (int) $item->id,
                        'employee'=>$employee,
                        'order_detail'=>$order_detail,
                        'work_duration'=> (int) $item->work_duration,
                        'type_work_duration'=> $item->type_work_duration,
                        'description'=>$item->description,
                        'salary_employee'=> (int) $item->salary_employee,
                        'created_at' => date_format(
                            date_create(@$item->create_at),
                            'Y-m-d H:i:s'
                        ),
                    ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data history employee success.',
                'data' => @$data,
            ],
            200
        );
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
