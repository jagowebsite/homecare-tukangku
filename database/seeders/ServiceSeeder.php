<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'service_category_id' => 1,
            'name' => 'Service',
            'price' => 50000,
            'type_quantity' => 'layanan',
            'description' => 'perbaikan ac rusak ',
            'status_service' => '1',
            'images' => json_encode([], true),
        ]);
        Service::create([
            'service_category_id' => 1,
            'name' => 'Isi Freon',
            'price' => 80000,
            'type_quantity' => 'layanan',
            'description' => 'pengisian freon AC',
            'status_service' => '1',
            'images' => json_encode([], true),
        ]);
        Service::create([
            'service_category_id' => 3,
            'name' => 'Mengepel Rumah',
            'price' => 25000,
            'type_quantity' => 'jam',
            'description' => 'mengepel ruang tamu, keluarga dan teras rumah',
            'status_service' => '1',
            'images' => json_encode([], true),
        ]);
    }
}
