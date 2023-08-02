<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter600Request;
use App\Models\DavidPricing\Chapter600;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class Chapter600Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
        parent::__construct();
        $this->chapter = 600;
    }
    # note no JLRC -> add setting and soldering skus
    public function getPrice(Chapter600Request $request, Chapter700Controller $chap700, Chapter900Controller $chap900)
    {
        // try{
            $part_cost = 0;
            $part_retail = 0;
            $labor_cost = 0;
            $labor_retail = 0;
            $total_with_labor_and_part = 0;
            $sales_tax = Setting::where('setting','sales_tax')->first()->value;
            $soldering_charges = 0;
            $setting_charges = 0;
            $item = Chapter600::query();
            $service_id                  = bin2hex(random_bytes(8));
            $price_chart = [];
            // dd($request->all());
            $quantity_for_envelope       = 1;
        
            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item')
                {
                    $item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", [str_replace(' ', '', $value)]);
                    // $actual_item->where($key,'like', '%' . $value . '%');
                }
            }
            $item = $item->first();
            $pick_list_charges = [];
            //if soldering_sku_per_post_or_back or setting_sku exists then calculate labor
            if($item->setting_sku && $item->setting_sku != '')
            {
                $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                $request700 = \App::make('App\Http\Requests\Chapter700Request');
                $setting_charges  = $chap700->getPrice($request700,$this->chapter,$item->setting_sku);
            }
            if($item->soldering_sku && $item->soldering_sku != '')
            {   // soldering sku is per post or back so it can be multiplied further as per number of post or backs

                $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                $request900 = \App::make('App\Http\Requests\Chapter900Request');
                $soldering_charges  = $chap900->getPrice($request900,$this->chapter,$item->soldering_sku);
                // $soldering_details  = json_decode(json_encode($soldering_details['soldering_charges'],true))->original->data;
            
            }
            # cost(part)
            
            $part_cost = $this->getPartCost($this->chapter,$item->geller_sku);
            # retail(part)
            $part_retail = $this->getPartRetail($part_cost);
            $labor_retail = $setting_charges + $soldering_charges;
            // dd($part_cost,$part_retail);
            // dd($part_cost,$part_retail,$labor_retail);
            $labor_cost                        = $this->getLaborCost($labor_retail);
            $express_retail                    = $request->is_rush ? ($labor_retail/2) : 0;
            $rhodium_charges                   = array_key_exists($this->chapter,$request->is_rhodium)?
                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                        \Config::get('gellerbook.rhodium_charges') : 0):0;
                        //  dd($part_retail,$labor_retail,$express_retail,$rhodium_charges);
            $grand_total                       = sprintf('%0.2f', round($part_retail+$labor_retail+$express_retail+$rhodium_charges)) ;        
            $item_data                         = [
            'id'                               => $item->id,
            'geller_sku'                       => $item->geller_sku,
            'major_item'                       => $item->major_item,
            'total'                            => $grand_total,
            'is_actual'                        => true,
            'is_rhodium'                       => array_key_exists($this->chapter,$request->is_rhodium)?
                                                ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                                true : false):false,
            'is_rush'                  => $request->is_rush,
            'pick_list_charges'        => [],
            'quantity'                 => $quantity_for_envelope

             ];
            array_push($price_chart,$item_data);
            $service_detail = array(

                'service_id'                    => $service_id, // this is in simple terms 'order id'
                'other_retail'                  => 0,
                'other_cost'                    => 0,
                'jeweler_id'                    => $request->jeweler_id,
                'sale_person_id'                => $request->sale_person_id,
                'grand_total'                   => $grand_total,
                'sales_tax'                     => $sales_tax,
                'total_with_sales_tax'          => $grand_total + $sales_tax,
                'is_rhodium'                    => null,
                'is_rush'                       => null,
                'other_notes'                   => null,
                'price_chart'                   => $price_chart,

            );
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 200 product.', $service_detail);

            // }catch(Exception $e){
    
            //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
    
            // }
        
    }
}