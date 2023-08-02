<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class OutsideVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd(SuperAdmin::all());

            User::create([

                'username'         =>  'shaista',
                'fullname'         =>  'Test Vendor',
                'email'            =>  'vendor@technerdslab.com',
                'password'         =>  'abc123@Sh',
                'type'             =>  'vendor',
                'shop_id'             =>  1
    
            ]);
    }
}
