<?php

namespace App\Http\Controllers;

use App\Models\DavidPricing\Chapter800;
use App\Models\Setting;
use Illuminate\Http\Request;

class Chapter800Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
        parent::__construct();
        $this->chapter = 800;
    }

    public function getPrice(Request $request, $requestee_chapter = null, $sku = null)
    {
        // try{
            // if($sku){
            //     $actual_item = Chapter800::where('geller_sku',$sku)->first();
            // }else{
                
            $part_cost = 0;
            $part_retail = 0;
            $labor_cost = 0;
            $labor_retail = 0;
            $express_total = 0;
            $sales_tax = Setting::where('setting','sales_tax')->first()->value;
            $soldering_charges = 0;
            $setting_charges = 0;
            $stone_details = 0;
            $actual_item = Chapter800::query();
            $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
            $request900 = \App::make('App\Http\Requests\Chapter900Request');
            $price_chart = [];
            $quantity_for_envelope = 1;

            // dd($request->values[$this->chapter]);
            // iterating column to find object
            
            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology')
                {
                    $actual_item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", [str_replace(' ', '', $value)]);
                    // $actual_item->where($key,'like', '%' . $value . '%');
                }
            }
            $pick_list_charges = [];
            // dd($actual_item->get());
            if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) == 1)
            {
                $actual_item = $actual_item->first();
            }
            else if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) >= 2)
            {
                return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 200 product.');
            }
            // dd($actual_item);
            if($actual_item->setting_sku && $actual_item->setting_sku != '')
            {
                // dd($actual_item->setting_sku);
                $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                $request700 = \App::make('App\Http\Requests\Chapter700Request');
                $setting_charges  = $chap700->getPrice($request700,$this->chapter,$actual_item->setting_sku);
            }
            
            if($actual_item->soldering_sku && $actual_item->soldering_sku != '')
            {
                // dd($item);
                $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                $request900 = \App::make('App\Http\Requests\Chapter900Request');
                $soldering_charges  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
                // $soldering_details  = json_decode(json_encode($soldering_details['soldering_charges'],true))->original->data;
            }
            $part_cost = $this->getPartCost($this->chapter,$actual_item->geller_sku);   
            // dd($this->chapter,$actual_item->geller_sku);         
            $part_retail = $this->getPartRetail($part_cost);
            if($requestee_chapter && $request->part_only)
            {
                return $part_cost;
            }
            // dd($soldering_charges ,'---', $setting_charges ,'---', $stone_details);
            $labor_retail = $soldering_charges + $setting_charges + $stone_details;
            if($request->check_and_tighten_enabled)
            {
                $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
                $labor_retail += $charges;
            }
            $labor_retail = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
            $express_total = $request->is_rush ? ($labor_retail/2) : 0;
            $labor_cost = $this->getLaborCost($labor_retail);
            $rhodium_charges = array_key_exists($this->chapter,$request->is_rhodium)?
                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                        \Config::get('gellerbook.rhodium_charges') : 0):0;
            $grand_total = sprintf('%0.2f', round($part_retail+$labor_retail+$express_total+$rhodium_charges)) ;        
            $service_id = bin2hex(random_bytes(8));

            $grand_total                       = sprintf('%0.2f', round($part_retail+$labor_retail+$express_total+$rhodium_charges)) ;        
            $item_data                         = [
            'id'                       => $actual_item->id,
            'geller_sku'               => $actual_item->geller_sku,
            'major_item'               => $actual_item->major_item,
            'total'                    => $grand_total,
            'is_actual'                => true,
            'is_rhodium'               => array_key_exists($this->chapter,$request->is_rhodium)?
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
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 800 product.', $service_detail);
            // }catch(Exception $e){
            //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
            // }
    }
}