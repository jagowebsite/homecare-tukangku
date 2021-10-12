<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderDetail::create([
            'order_id' => 1,
            'service_id' => 1,
            'quantity' => 1,
            'price' => 50000,
            'total_price' => 50000,
            'description' => 'ac tidak bisa menyala',
            'status_order_detail' => 'pending',
        ]);
        OrderDetail::create([
            'order_id' => 1,
            'service_id' => 3,
            'quantity' => 3,
            'price' => 25000,
            'total_price' => 75000,
            'description' => 'mengepel seluruh bagian rumah',
            'status_order_detail' => 'pending',
        ]);
    }
}
