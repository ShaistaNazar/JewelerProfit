<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission List
         *
         */
        $Permissionitems = config('jewelers_permissions');

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            // print_r($Permissionitem['name']);echo "------";print_r($Permissionitem['guard']);
            $newPermissionitem = config('permission.models.permission')::where('name', '=', $Permissionitem['name'])->first();
            if ($newPermissionitem === null) {
                // dd($Permissionitem);
                $newPermissionitem = config('permission.models.permission')::create([
                    'name'       => $Permissionitem['name'],
                    'guard_name' => $Permissionitem['guard'],
                ]);
            }
        }

        /*
         * Permission List
         *
         */
        $Permissionitems = config('admin_permissions');

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            // print_r($Permissionitem['name']);echo "------";print_r($Permissionitem['guard']);
            $newPermissionitem = config('permission.models.permission')::where('name', '=', $Permissionitem['name'])->first();
            if ($newPermissionitem === null) {
                // dd($Permissionitem);
                $newPermissionitem = config('permission.models.permission')::create([
                    'name'       => $Permissionitem['name'],
                    'guard_name' => $Permissionitem['guard'],
                ]);
            }
        }
    }
}
