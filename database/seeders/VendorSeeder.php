<?php

namespace Database\Seeders;

use App\Models\GlobalVendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlobalVendor::create([

            'name'             =>  'Stuller',
            'link'             =>  'stuller.com',
            'shop_id'             =>  1

        ]);
    }
}
