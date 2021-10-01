<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@tukangku.co.id',
            'password' => bcrypt('admin')
        ]);
        
        $superadmin = User::create([
            'name' => 'haikal',
            'email' => 'user@tukangku.co.id',
            'password' => bcrypt('user')
        ]);

        $admin->assignRole('superadmin');
        $superadmin->assignRole('user');
    }
}
