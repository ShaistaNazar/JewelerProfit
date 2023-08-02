<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        if (Role::where('name', '=', 'super_admin')->where('guard_name', '=', 'super_admin_api')->first() === null) {
            Role::create(['guard_name' => 'super_admin_api','name' => 'super_admin']);
        }
        if (Role::where('name', '=', 'shop_owner')->where('guard_name', '=', 'shop_owner_api')->first() === null) {
            Role::create(['guard_name' => 'shop_owner_api','name' => 'shop_owner']);
        } 

    }
}
