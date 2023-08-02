<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class JewelerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([

            'username'         =>  'shaista',
            'fullname'         =>  'Test Jeweler',
            'email'            =>  'jeweler@technerdslab.com',
            'password'         =>  'abc123@Sh',
            'type'             =>  'jeweler',
            'shop_id'             =>  1

        ]);
    }
}
