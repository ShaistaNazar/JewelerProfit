<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Chapter::insert(
            array( 
            ['name' => '100','job_id' => 1],
            ['name' => '200','job_id' => 1],
            ['name' => '300','job_id' => 1],
            )
        );

    }
}
