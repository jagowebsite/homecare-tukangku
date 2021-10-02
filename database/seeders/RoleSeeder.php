<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web',
        ]);

        $role2 = Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        $permissions = [
            'admin_dashboard',
            'master_data',
            'report_service_view',
            'report_service_show',
            'user_management_access',
            'report_registration_user',
            'user_order_view',
            'user_payment_view',
            'user_payment_show',
            'user_payment_store',
            'user_payment_update',
            'user_payment_delete',
            'log_order_location',
            'chating_view',
            'service_record',
            'order_record',
            'superadmin',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $role1->givePermissionTo('superadmin');
    }
}
