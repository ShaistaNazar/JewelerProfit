<?php

namespace Database\Seeders;

use App\Models\ShopOwner;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        /**
         * Get Available Permissions.
         */
        $permissions = config('permission.models.permission')::all();
        // dd($permissions);

        /**
         * Attaching Permissions to Roles.
         *
         * SuperAdmin
         */
        $super_admin = config('permission.models.role')::where('name', '=', 'super_admin')->first();
        $super_admin->syncPermissions(Permission::where('guard_name','super_admin_api')->get());

        /**
         * ShopOwner
         */
        $shop_owner = config('permission.models.role')::where('name', '=', 'shop_owner')->first();
        $shop_owner->syncPermissions(Permission::where('guard_name','shop_owner_api')->get());

        // foreach ($permissions as $permission) {
        //     if (!in_array($permission->name, $this->forbiddenShopOwnerPermissions())) {
        //         $shop_owner->givePermissionTo($permission);
        //     }
        // }

        // $shop_owners = ShopOwner::all();
        // foreach ($shop_owners as $shop_owner) {
        //     foreach ($permissions as $permission) {
        //         if (!in_array($permission->name, $this->forbiddenShopOwnerPermissions())) {
        //             $shop_owner->givePermissionTo($permission);
        //         }
        //     }
        // }

        
         // dd($shop_owner->permissions);
    }

    protected function forbiddenShopOwnerPermissions()
    {
        return [

            'create_stores',
            'view_stores',
            'update_stores',
            'delete_stores',
            'update_master_price'

        ];
    }
}
