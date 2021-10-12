<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'user_id' => '2',
            'order_id' => '1',
            'payment_code' => 'TF26384529',
            'type' => 'lunas',
            'type_transfer' => 'transfer',
            'images_payment' => '',
            'images_user' => '',
            'bank_number' => '263989362',
            'bank_name' => 'BCA',
            'account_name' => 'Haikal',
            'latitude' => '-7.2849482571831015',
            'longitude' => '112.69343853960775',
            'total_payment' => '125000',
            'status_payment' => 'pending',
            'description' => 'Pembayaran order bersih bersih dan service ac',
            'address' => 'Jalan HR muhammad No. 373',
        ]);
    }
}
