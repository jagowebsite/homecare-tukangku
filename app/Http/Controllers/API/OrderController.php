<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

            foreach ($order->orderDetails as $orderDetail) {
                $order_detail[] = [];
            }
        }
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
