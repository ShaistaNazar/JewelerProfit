<?php

namespace Database\Seeders;

use App\Models\JewelJob;
use Illuminate\Database\Seeder;

class JewelJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        JewelJob::insert(
            array( 
            'name' => 'Jewelry Repair',
            'name' => 'Appraisal',
            'name' => 'Watch Repair or Battery',
            'name' => 'Custom Design',
            'name' => 'Diamonds and Gemstones'
            )
        );

    }
}
