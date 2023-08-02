<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!(Setting::where('setting','basic_prices')->first())){

            Setting::create([

                'setting'          => 'basic_prices',
                'value'            => array('h6' => 20, 'h10' => 30),
    
            ]);
            
        }
        if(!(Setting::where('setting','sales_tax')->first())){

            Setting::create([

                'setting'          => 'sales_tax',
                'value'            => 6.65,
    
            ]);
            
        }
    }
}
