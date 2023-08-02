<?php

namespace App\Http\Controllers;

use App\Models\DavidPricing\Chapter1000;
use App\Models\Setting;
use Illuminate\Http\Request;

class Chapter1000Controller extends CalculationController
{

    public $chapter;
    public function __construct()
    {
       // dd(request()->all());
        parent::__construct();
        $this->chapter = 1000;
    }
    // metal+ labor = selling price 

    public function getPrice(Request $request)
    {

        $part_cost  = 0;
        $part_retail= 0;
        $labor_retail = 0;
        $express_total = 0;
        $sales_tax = Setting::where('setting','sales_tax')->first()->value;
        $actual_item = Chapter1000::query();
        $setting_charges = 0;
        $pick_list_charges = 0;
        $price_chart = [];
        $part_added = false;
        $quantity_for_envelope = 1;

        foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value)
        {
            if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology' && $key !== 'popup' && $key !== 'require_weight_popup')
            {
                $actual_item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", [str_replace(' ', '', $value)]);
            }
        }
        // dd($actual_item->get());
        if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) == 1)
        {
            $actual_item = $actual_item->first();
        }
        else
        {
            return $this->APIResponse(config('response_codes.Bad Request'));
        }
        // being commented by direct connecting chapter 700 to chapter 1000
        if($actual_item->retail_labor)
        {
            $labor_retail += $actual_item->retail_labor;
        }
        // dd($actual_item->chapter700,gettype($actual_item->chapter700),empty($actual_item->chapter700));
        if($actual_item->chapter700 && is_array($actual_item->chapter700) && !empty($actual_item->chapter700))
        {
            $this->chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
            $this->request700 = \App::make('App\Http\Requests\Chapter700Request');
            // dd($actual_item->chapter700);
            foreach($actual_item->chapter700 as $sku700)
            {
                $setting_charges  = $this->chap700->getPrice($this->request700,$this->chapter,$sku700);
                // echo "charges";
                // print_r($setting_charges);
                // dd($setting_charges);
                $labor_retail += $setting_charges;
            }
        }
        // dd($labor_retail);

        if($request->check_and_tighten_enabled)
        {
            $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
            $labor_retail += $charges;
        }
        // dd($actual_item);
        if($actual_item->dependent_chapter !== '' && 
        array_key_exists($actual_item->dependent_chapter,$request->values) && 
        $request->values[$actual_item->dependent_chapter]['procedure_details_1']['options'])
        {
            // dd('in depenedent chapter');
            $part_specific_chapter    = \App::make("App\Http\Controllers\Chapter".$actual_item->dependent_chapter."Controller");
            $related_request          = \App::make("App\Http\Requests\Chapter".$actual_item->dependent_chapter."Request");
            $part_cost                += $part_specific_chapter->getPrice($related_request,$this->chapter);
            // dd($part_specific_chapter->getPrice($related_request,$this->chapter));
            $part_added               = true;
            // dd($part_cost);
        }
        
        if($actual_item->picklist_stuller_if_needed != "" && $request->picklist)
        {
            $pick_list_charges = $this->getPicklistCharges( 
            $actual_item->picklist_quantity_if_needed, is_array($actual_item->picklist_stuller_if_needed) ? 
            $actual_item->picklist_stuller_if_needed[0] : $actual_item->picklist_stuller_if_needed
            ,'');  
        }
    
        if(array_key_exists('popup',$request->values[$this->chapter]['procedure_details_1']['options']) && 
           $request->values[$this->chapter]['procedure_details_1']['options']['popup'])
        {
            // dd('popup exists');
            $no_of_grams = $request->values[$this->chapter]['procedure_details_1']['options']['require_weight_popup'];
            $specific_pennyweight = Chapter1000::where('major_item','Metals')->where('price_criteria_item', 'like', '%' . 'pennyweight' . '%')
            ->where('karats',$request->selected_metal)->first();
            // dd($specific_pennyweight);
            if($specific_pennyweight)
            {
                // dd('specific_pennyweight exists');
                $part_details       = $this->getPartDetails($this->chapter,$specific_pennyweight->geller_sku);
                // dd($part_details);
                $metal_cost         = $part_details['part_cost']; // pennyweight
                $gramprice_for_1    = $metal_cost * .675;  // getting gram price
                $total_metal_cost   = $gramprice_for_1 * $no_of_grams;
                $part_added         = true;
                $part_cost          += $total_metal_cost;
                // dd($part_details,$metal_cost,$gramprice_for_1,$no_of_grams,$part_added,$total_metal_cost);
            }
        }
        // dd($part_retail);
        // determining weight
        if(!$part_added)
        {
            if(is_array($actual_item->stuller_sku) && (count($actual_item->stuller_sku) == 1 && array_unique($actual_item->stuller_sku)[0] !== ''))
            {
                $part_cost_of_all_items = $this->getPartCost($this->chapter,$actual_item->geller_sku);
                // dd($part_cost_of_all_items);
                $part_added           = true; 
                // dd($part_cost_of_all_items,$actual_item->stuller_quantity);
                $part_cost += ($part_cost_of_all_items * ($actual_item->stuller_quantity == '' ? 1 : $actual_item->stuller_quantity));
                // dd($part_cost);
            }
            else
            {
                // dd('part not added',$actual_item->stuller_sku);
                if($actual_item->stuller_sku !== '')
                {
                    // dd($actual_item->stuller_quantity);
                    $part_details      = $this->getPartDetails($this->chapter,$actual_item->geller_sku,$actual_item->stuller_quantity);
                    // dd($part_details);
                    $part_added        = true; 
                    $part_cost         += $part_details['total_part_cost'];
                }
            }
            if($actual_item->metal_weight && $actual_item->metal_weight !== '')
            {
                // check if metal exists then this part cost is penny weight and 
                // first we have to transform this penny weight into gram weight
                $no_of_grams       = $actual_item->metal_weight;
                $gramprice_for_1   = $part_cost * .675;  // getting gram price
                $part_cost         = $gramprice_for_1 * $no_of_grams;
                // dd($part_cost);
            }
        }
        // some products have weight and metal associated to get multiplier of item
        // dd($part_cost);
        $part_retail    = $this->getPartRetail($part_cost);
        // dd($part_retail);
        $express_total = $request->is_rush ? ($labor_retail/2) : 0;
        $rhodium_charges = array_key_exists($this->chapter,$request->is_rhodium)?
                    ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                    \Config::get('gellerbook.rhodium_charges') : 0):0;
        // dd($part_retail,$labor_retail,$express_total,$rhodium_charges);
        $grand_total = sprintf('%0.2f', round($part_retail+$labor_retail+$express_total+$rhodium_charges)) ;   
        // dd($grand_total);     
        // dd($part_retail,$labor_retail,$express_total,$rhodium_charges);
        $service_id = bin2hex(random_bytes(8));

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
        'pick_list_charges'        => $pick_list_charges,
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
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 1000 product.', $service_detail);
    }

    public function Get1000Metals()
    {
        # code...
        $metals = Chapter1000::where('major_item','Metals')->distinct()->pluck('karats');
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 800 product.', $metals);
    }
}
