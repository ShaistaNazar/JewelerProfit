<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd(SuperAdmin::all());
        if(!(SuperAdmin::where('email','shaistanazar@technerdslab.com')->first())){

            SuperAdmin::create([

                'username'         =>  'shaista',
                'fullname'         =>  'Shaista Nazar',
                'email'            =>  'shaistanazar@technerdslab.com',
                'role_id'          =>   Role::where('name','super_admin')->first()->id,
                'password'         =>  'abc123@Sh'
    
            ]);

            
        }

    }
}
