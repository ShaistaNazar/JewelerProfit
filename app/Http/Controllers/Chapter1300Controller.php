<?php

namespace App\Http\Controllers;
 
use App\Http\Requests\Chapter1300Request;
use App\Models\DavidPricing\Chapter1300;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class Chapter1300Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 1300;
    }

    public function getPrice(Chapter1300Request $request)
    {
        // try{
        // dd($request->all());
        $part_cost            = 0;
        $part_retail          = 0;
        $sales_tax            = Setting::where('setting','sales_tax')->first()->value;
        $price_chart          = [];
        $service_id           = bin2hex(random_bytes(8));
        $item                 = $this->getProceduralItem($this->chapter,1,['no_of_price_criteria_item']);
        // dd($item->get());
        $actual_item          = $item->first();
        $part_cost            = $this->getPartCost($this->chapter,$actual_item->geller_sku);
        $part_retail          = round($this->getPartRetail($part_cost)); 
        $grand_total          = round($part_retail,2);
        
        $item_data    = [
            'id'         => $actual_item->id,
            'geller_sku' => $actual_item->geller_sku,
            'major_item' => $actual_item->major_item,
            'total'      => $grand_total,
            'is_actual'  => true,
            'is_rhodium' => false,
            'is_rush'    => false,
            'quantity'                 => 1

        ];
        array_push($price_chart,$item_data);
        
        # iterating dependencies and finallizing total 
        // foreach($request->values as $chapter_key => $chapter_data)
        // {
        //     if($chapter_key !== $this->chapter)
        //     {
        //         $item         = $this->getProceduralItem($this->chapter,1,[]);   
        //         $actual_item  = $item->first();
        //         $part_cost    = $this->getPartCost($this->chapter,$actual_item->geller_sku);
        //         $part_retail  = round($this->getPartRetail($part_cost)); 
        //         $grand_total  = round($part_retail,2);
        //         $item_data    = [
        //                             'id'         => $actual_item->id,
        //                             'geller_sku' => $actual_item->geller_sku,
        //                             'major_item' => $actual_item->major_item,
        //                             'total'      => $grand_total,
        //                             'is_actual'  => false,
        //                             'is_rhodium' => false,
        //                             'is_rush'    => false,
        //                         ];
        //         array_push($price_chart,$item_data);
        //     }
        // }

        $service_detail = array(
            'service_id'                    => $service_id, // this is in simple terms 'order id'
            'other_retail'                  => 0,
            'other_cost'                    => 0,
            'jeweler_id'                    => $request->jeweler_id,
            'grand_total'                   => $grand_total,
            'sales_tax'                     => $sales_tax,
            'total_with_sales_tax'          => $grand_total + $sales_tax,
            'is_rhodium'                    => null,
            'is_rush'                       => null,
            'other_notes'                   => null,
            'price_chart'                   => $price_chart,
        );
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 1300 product.', $service_detail);
        // }catch(Exception $e){

        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

        // }
    }

}
