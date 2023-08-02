<?php

namespace Database\Seeders;

use App\Models\DavidPricing\Chapter100;
use App\Models\ShopShankDetails;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShopShankDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cliq_shank_exists = Chapter100::whereRaw('LOWER(`type`) LIKE ? ',[trim(strtolower('cliq-adjustable')).'%'])->first();
        // dd($cliq_shank_exists);
        $latest = null;
        $vendor_markup = null;
        if($cliq_shank_exists)
        {
            $vendor_markup = $cliq_shank_exists->vendor_markup_for_part_geller_book_retail;
            $latest = $cliq_shank_exists->updated_at;
        }
        if(!(ShopShankDetails::whereNotNull('vendor_cost_markup')->first()))
        {
            ShopShankDetails::create([

                'latest_pricing_date'         =>  $latest,
                'vendor_cost_markup'          =>  $vendor_markup,
                'is_default'                  =>  1,
                'latest_pricing_date'         =>  Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
