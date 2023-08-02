<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SuperAdminSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            SettingsSeeder::class,
        ]);

        $this->call(Chapter300pricingTableSeeder::class);
        $this->call(Chapter200pricingTableSeeder::class);
        $this->call(Chapter700pricingTableSeeder::class);
        $this->call(Chapter900pricingTableSeeder::class);
        $this->call(Chapter400pricingTableSeeder::class);
        $this->call(Chapter500pricingTableSeeder::class);
        $this->call(Chapter1200pricingTableSeeder::class);
        $this->call(Chapter1100pricingTableSeeder::class);
        $this->call(Chapter100pricingTableSeeder::class);
        // $this->call(ShopShankDetailsSeeder::class);

        $this->call(Chapter1000pricingTableSeeder::class);
        $this->call(Chapter1300pricingTableSeeder::class);
        $this->call(Chapter800pricingTableSeeder::class);
        $this->call(Chapter600pricingTableSeeder::class);

        $this->call(SuperAdminSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(JewelerSeeder::class);


    }
}
