<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        $categories = [
            'Service AC',
            'Penjualan Pasir dan Semen',
            'Bersih Bersih',
            'Pertukangan',
            'Renovasi',
            'Reparasi Listrik',
            'Desain Arsitektur',
    ];
    foreach ($categories as $category) {
        ServiceCategory::create([
            'name' => $category,
        ]);
    }
        
    }
}
