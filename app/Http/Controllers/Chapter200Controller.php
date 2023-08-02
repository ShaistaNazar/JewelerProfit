<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter200Request;
use App\Models\DavidPricing\Chapter200;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class Chapter200Controller extends CalculationController
{
    /**
     * calculation of prices of 200 
     */
    public $chapter;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 200;
    }
    

    public function getPrice(Chapter200Request $request)
    {

        // try{

            $labor_formula = null;
            $part_retail = 0;
            $labor_retail = 0;
            $total_with_labor_part = 0;
            $express_total = 0;
            $total_with_picklist_charges = 0;
            $actual_item = Chapter200::query();
            $sum_of_labors = 0;
            $setting_charges = 0;
            $sales_tax = salesTax();
            $remaining_factor = $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'];
            $service_id = bin2hex(random_bytes(8));
            $price_chart = [];
            $quantity_for_envelope = $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'];
            // dd($request->all());

            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology')
                {
                    $actual_item->where($key,'like', '%' . $value . '%');
                }
            }
            $price_criterian_items = $actual_item->get(['geller_sku','no_of_price_criteria_item'])->toArray();
            // finding item itself  if its tip/prong and its actual labor
            // dd($price_criterian_items);
            if(strtolower($request->values[$this->chapter]['procedure_details_1']['options']['major_item']) == 'tip' || 
               strtolower($request->values[$this->chapter]['procedure_details_1']['options']['major_item']) == 'prong' || 
               strtolower($request->values[$this->chapter]['procedure_details_1']['options']['major_item']) == 'full prong' ||
               strtolower($request->values[$this->chapter]['procedure_details_1']['options']['major_item']) == 'v prong'
               )
               {
                foreach($price_criterian_items as $sku_with_range)
                {   
                    // loop value is >=11
                    // we have 12
                    $value = $sku_with_range['no_of_price_criteria_item'];
                    if($value !== '' && str_contains($value, '-')) // range
                    {
                        $range = explode("-",$value);
                        $min = $range[0];
                        $max = $range[1];
                        // 55-1=4,11-1=10,10-1=9
                        if($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] >= $min && 
                           $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] <= $max)
                        {
                            // dd($actual_item->where('no_of_price_criteria_item',$value)->first());
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $actual_item->geller_sku)['labor_retail'];
                            // dd($max, $min, $remaining_factor, (($max - $min) + 1));
                            $labor_retail += ($labor_retail_to_add * $remaining_factor);
                            $item_found = true;
                            break;
                        }
                        else
                        {
                            // else means no of items are greater than 10 so apply formula as remaining items 
                            $temp_item = clone $actual_item;
                            $temp_item = $temp_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $temp_item->geller_sku)['labor_retail']; // for furthur query.
                            // echo "labor_retail_to_add";
                            // echo "$labor_retail_to_add";
                            // echo "multiplying_factor";
                            // echo "$multiplying_factor";
                            // for  next iteration purpose;
                            // dd($labor_retail_to_add,$remaining_factor);
                            // if($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] > $max){
                                $remaining_factor = ( $max - $min ) + 1; // 9 
                            // }else{
                                
                            // }
                            $labor_retail += ($labor_retail_to_add * $remaining_factor);
                            $remaining_factor = $max;
                            // echo "\n";
                            // echo "2=";
                            // echo "$labor_retail";
                            $temp_item = clone $actual_item;
                        }
                    }
                    else if($value !== '' && str_contains($value, '>=')) // greater than values
                    {
                        $range = explode(">=",$value);
                        if($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] >= $range[1])
                        {
                            // dd('hi');
                            // dd($labor_retail);
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $actual_item->geller_sku)['labor_retail'];
                            // dd($labor_retail_to_add);
                            $remaining_factor = $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] - $remaining_factor ;
                            $labor_retail += ($labor_retail_to_add * $remaining_factor);

                            // echo "\n";
                            // echo "3=";
                            // echo "$labor_retail";
                            // dd($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item']);
                            $item_found = true;
                            break;
                        }
                        // $item->whereBetween('no_of_price_criteria_item',[intval($min), intval($max)]);
                        else
                        {
                            return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 200 product.');
                        }
                    }
                    else if($value == 1)
                    {
                        // dd($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item']);
                        // dd($value,$request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item']);
                        if($value == $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'])
                        {
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail += $this->getLaborDetails($this->chapter, $actual_item->geller_sku)['labor_retail'];
                            // echo "\n";
                            // echo "4=";
                            // echo "$labor_retail";
                            $item_found = true;
                            break;
                        }
                        else
                        {
                            $temp_item = clone $actual_item;
                            $temp_item = $temp_item->where('no_of_price_criteria_item',$value)->get();
                            // dd($actual_item);
                            $labor_retail += $this->getLaborDetails($this->chapter, $temp_item->first()->geller_sku)['labor_retail'];
                            // echo "\n";
                            // echo "5=";
                            // echo "$labor_retail";
                            // for furthur query.
                            $remaining_factor = $remaining_factor - 1; // 55-1=4,11-1=10,10-1=9
                            $temp_item = clone $actual_item;
                        }
                        // $item->where('no_of_price_criteria_item','like', '%' .  . '%');
                    }    
                                
                } //Channel Repair
            }
            else if(strtolower($request->values[$this->chapter]['procedure_details_1']['options']['major_item']) == 'channel repair')
            {
                foreach($price_criterian_items as $sku_with_range)
                {   
                    // lop value is >=8
                    //we have 11    
                    $value = $sku_with_range['no_of_price_criteria_item'];
                    if($value !== '' && str_contains($value, '-')) // range
                    {
                        $range = explode("-",$value);
                        $min = $range[0];
                        $max = $range[1];
                        if($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] >= $min && 
                           $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] <= $max)
                        {
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $actual_item->geller_sku)['labor_retail'];
                            $labor_retail += ($labor_retail_to_add * $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item']);
                            // echo "\n";
                            // echo "$labor_retail";
                            $item_found = true;
                            break;
                        }else{
                            $temp_item = clone $actual_item;
                            $temp_item = $temp_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $temp_item->geller_sku)['labor_retail']; // for furthur query.
                            $labor_retail += ($labor_retail_to_add * $max);
                            // echo "\n";
                            // echo "$labor_retail";
                            $temp_item = clone $actual_item;
                        }
                    }
                    else if($value !== '' && str_contains($value, '>=')) // greater than values
                    {
                        $range = explode(">=",$value);
                        if($request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] >= $range[1])
                        {
                            // range is 8 
                            // items 8 
                            // 8 -(8-1)
                            // items are 9 range is 8 
                            // 9 - (8-1)
                            // 9 - (7 stone price is already calculated before)
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail_to_add = $this->getLaborDetails($this->chapter, $actual_item->geller_sku)['labor_retail'];
                            $multiplying_factor = $request->values['200']['procedure_details_1']['options']['no_of_price_criteria_item'] - ($range[1] - 1);// 8 - (8-1) = 8 - 7 // 10 - 7
                            $labor_retail += ($labor_retail_to_add * $multiplying_factor);
                            // echo "\n";
                            // echo "$labor_retail";
                            $item_found = true;
                            break;
                        }
                        // $item->whereBetween('no_of_price_criteria_item',[intval($min), intval($max)]);
                        else{
                            return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 200 product.');
                        }
                    }                               
                }
            }
// dd($actual_item);
            # Setting labor.
            # setting charges are being calculated in nest of getLaborDetails.
            # note : setting labor is being calculated in calculationcontroller.
            // $labor_details_array = $this->getLaborDetails($this->chapter, $actual_item->geller_sku, null, isset(request()->stone_work) && request()->stone_work == 'require_stone_work');
            // $labor_details_array = $this->getLaborDetails($this->chapter, $actual_item->geller_sku);

            // // dd('require_stone_work');
            // $stone_labor = json_decode(json_encode($labor_details_array['setting_charges'],true));
            // if($stone_labor)
            // {
            //     $setting_charges += $stone_labor->original->data->total_with_sales_tax;
            //     // dd($labor_details_array,$sum_of_labors);
            // }
            // else
            // {
            //     $setting_charges += $stone_labor;
            // }
            if($request->check_and_tighten_enabled)
            {
                $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
                $labor_retail += $charges;
            }
            $part_cost = $this->getPartCost($this->chapter,$actual_item->geller_sku);
            $part_retail                       = $this->getPartRetail($part_cost,($actual_item->part_markup && $actual_item->part_markup !== '')
            ? (double)$actual_item->part_markup:config('gellerbook.part_markup'));
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
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 200 product.', $service_detail);

        // }catch(Exception $e){

        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

        // }        
    }
    
}

