<?php

namespace App\Http\Controllers\API;

use App\Exports\AllReport;
use App\Exports\ServiceReport;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
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
        $users = User::get()->pluck('id');
        $limit = $request->limit ?? 6;
        $orderdetails = OrderDetail::with([
            'order',
            'service',
            'order.user',
        ])->where('status_order_detail', 'done')->whereHas('order', function ($query) use ($users){
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
                            date_create($item->verified_at),
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
                'message' => 'Get data all report success.',
                'data' => @$data,
            ],
            200
        );
    }

    public function indexService(Request $request)
    {
        $users = User::get()->pluck('id');
        $limit = $request->limit ?? 6;
        $orderdetails = OrderDetail::with([
            'order',
            'service',
            'order.user',
        ])->where('status_order_detail', 'done')->whereHas('service', function ($query) {
            $query->whereNotIn('service_category_id', [2, 7]);
        })->whereHas('order', function ($query) use ($users){
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
                        'created_at' => date_format(
                            date_create($item->verified_at),
                            'Y-m-d H:i:s'
                        ),

                    ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data all report success.',
                'data' => @$data,
            ],
            200
        );
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
