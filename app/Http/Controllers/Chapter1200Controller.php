<?php

namespace App\Http\Controllers;

use App\Models\DavidPricing\Chapter1200;
use App\Models\Setting;
use Illuminate\Http\Request;

class Chapter1200Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 1200;
    }

    public function getPrice(Request $request, $requestee_chapter = null, $sku = null)
    {

        $part_cost = 0;
        $part_retail = 0;
        $labor_cost = 0;
        $labor_retail = 0;
        $express_total = 0;
        $sales_tax = Setting::where('setting','sales_tax')->first()->value;
        $soldering_charges = 0;
        $actual_item = Chapter1200::query();
        $part_cost_of_additional_part_1 = 0;
        $part_cost_of_additional_part_2 = 0;
        $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
        $request900 = \App::make('App\Http\Requests\Chapter900Request');
        $retail_added = false;
        $soldering_added = false;
        $minimum_added = false;
        $pick_list_charges = [];
        $welding_technology_to_use = 'torch';
        $price_chart = [];
        $chapter_itself_added = false;
        $quantity = 1;
        $quantity_for_envelope = 
        $no_of_price_criterian_item = 1;

        // try{
        if($sku)
        {
            $actual_item = Chapter1200::where('geller_sku',$sku)->first();
        } 
        else
        {
            if(array_key_exists('no_of_price_criteria_item',$request->values[$this->chapter]['procedure_details_1']['options']))
            {
                $remaining_factor = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];
                $no_of_price_criterian_item = (double)$request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];
                // dd($remaining_factor,$no_of_price_criterian_item);
            
            }
            else{
                $remaining_factor = 1;
                $no_of_price_criterian_item = 1;
            }
            
            // it'll be used each case to calculate quantity. 
            $quantity = (double)(array_key_exists($this->chapter,$request->quantity) ? $request->quantity[$this->chapter] : 1);
            
            // dd($request->values[$this->chapter]);
            // iterating column to find object
            
            foreach ($request->values[$this->chapter]["procedure_details_1"]['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item')
                {
                    if($key !== 'major_item' && ($key == 'extra_work_per_appraisal' && 
                    $request->values[$this->chapter]["procedure_details_1"]['options']['type'] == 'New Appraisals'))
                    {
                        break;
                    }
                    else
                    {
                        $actual_item->where($key,$value);
                    }
                }
            }
            // dd('h',$actual_item->get());

            // additional charges on appraisals
            if(array_key_exists('type',$request->values[$this->chapter]["procedure_details_1"]['options']) && 
              $request->values[$this->chapter]["procedure_details_1"]['options']['type'] == 'New Appraisals')
            {
                $actual_item = $actual_item->first();
                // dd($additional_query);
                $additional_charges = 0;
                // dd($request->interlink_quantities);
                foreach($request->interlink_quantities as $appraisal_key =>$appraisal_value)
                {
                    // // print_r($appraisal_key);
                    // // echo "-------";
                    // // print_r($appraisal_value);

                   foreach($appraisal_value as $service_key => $additional_service)
                   {
                    //    // echo "\n";
                    //    // echo '-------------------------------------------';
                    //    // print_r($service_key);
                    //    // echo "\n";
                    //    // print_r($additional_service);
                        $additional_query = Chapter1200::query();
                       if($additional_service)
                       {
                            $additonal_item = $additional_query->where('extra_work_per_appraisal',$service_key)->first();
                            if($additonal_item)
                            {
                                $additional_service = is_numeric($additional_service) ? $additional_service : 1;
                                $additional_charges += ltrim($additonal_item->retail_price,'$') * $additional_service;
                            }
                       }
                   }
                }
                $labor_retail += $additional_charges;
            }
            // dd($request->welding_technology);
            if(isset($request->welding_technology) && !empty($request->welding_technology)){
            $actual_item = $actual_item->where('welding_technology',$request->welding_technology[$this->chapter]);}
            // retail price of items having range 
            // two ranges are there.
            // 1. 1-4,>=5
            // 2. 36-50, >50
            // specific for the ranges
            if(!($actual_item instanceof \App\Models\DavidPricing\Chapter1200))
            {
                // dd($actual_item->get());
                $price_criterian_items = $actual_item->get(['geller_sku','no_of_price_criteria_item'])->toArray();
                if(strtolower($request->values[$this->chapter]["procedure_details_1"]['options']['major_item']) == 'refinish')
                {
                    $temp_item = null;
                    foreach($price_criterian_items as $sku_with_range)
                    {
                        // possible values are 1-20,20-35,36-50,>50
                        // loop value is 20-35
                        // we have 52
                        $value = $sku_with_range['no_of_price_criteria_item'];
                        if($value !== '' && str_contains($value, '-')) // range
                        {
                            $range = explode("-",$value);
                            $min = (double)$range[0];
                            $max = (double)$range[1];
                            if($no_of_price_criterian_item >= $min && 
                               $no_of_price_criterian_item <= $max)
                            {
                                $actual_item = clone $actual_item->where('no_of_price_criteria_item',$value)->first();
                                // echo "---1";

                                // if soldering_sku exists then calculate labor either lies in range or not
                                $item_found = true;
                                break;
                            }
                            else
                            {
                                if(str_contains($value,'36-50'))
                                {
                                    // echo "\n";
                                    // echo "---2";
                                    $temp_item = clone $actual_item;
                                    $temp_item = $temp_item->where('no_of_price_criteria_item',$value)->first();
                                    // dd($temp_item);
                                    if($temp_item->setting_sku)
                                    {
                                        $this->chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                                        $this->request700 = \App::make('App\Http\Requests\Chapter700Request');
                                        $setting_details  = $this->chap700->getPrice($this->request700,$this->chapter,$temp_item->setting_sku);
                                        $labor_retail += $setting_details;
                                        // echo "\n";
                                        // echo "setting_details";
                                        // // print_r($setting_details);
                                    }
                                    
                                    if($temp_item->chapter1200SKUs && $temp_item->chapter1200SKUs != '')
                                    {
                                        $detail = $this->getDataOfChapterItemItself($temp_item->chapter1200SKUs);
                                        // dd($detail);
                                        $labor_retail += $detail['labor_retail'];
                                        $part_retail += $detail['part_retail'];
                                        // echo "\n";
                                        // echo "chapter1200SKUs";
                                        // // print_r($detail['labor_retail']);
                                        // echo "--sku--";
                                        // // print_r($temp_item->chapter1200SKUs);
                                        $chapter_itself_added = true;
                                    }
                                    // $retail_detail = $this->handleMinimumNoOfItemsToChargeAndAdditionalItems($temp_item,$quantity,$no_of_price_criterian_item,$labor_retail,$retail_added);
                                    // $labor_retail = $retail_detail['labor_retail'];
                                    // $retail_added = $retail_detail['retail_added'];
                                    // $minimum_additional_handled = true;

                                }
                            }
                        }
                        else if($value !== '' && str_contains($value, '>')) // stones are greater than 50.
                        {
                            // dd('>50');
                            // >50
                            $range = explode(">",$value);
                            // if($no_of_price_criterian_item > $range[1])
                            // {
                                // 53 > 50
                                $additional_labor = 0; 
                                $each_additional_to_be_multiplied = $no_of_price_criterian_item - $range[1]; // 3
                                $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                                // if($actual_item->soldering_sku)
                                // {
                                //     $per_solder  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
                                //     $soldering_charges = ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));                                
                                //     // $labor_retail += ($actual_item->flat_fee == '1') ? $soldering_charges : $soldering_charges * $remaining_factor;
                                //     $additional_labor += $soldering_charges;
                                //     // $soldering_added = true;
                                //     // soldering of previous item will get added.
                                // }

                                // setting_sku
                                // dd($actual_item);
                                if($actual_item->setting_sku)
                                {
                                    $this->chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                                    $this->request700 = \App::make('App\Http\Requests\Chapter700Request');
                                    $setting_details  = $this->chap700->getPrice($this->request700,$this->chapter,$actual_item->setting_sku);
                                    // echo "\n";
                                    // echo "setting sku";
                                    // print_r($setting_details);
                                    $labor_retail += $setting_details;
                                }

                                // retail itself
                                $labor_retail_to_add = ltrim($actual_item->retail_price,'$'); // $1
                                // dd($labor_retail_to_add);// 53-50
                                // $additional_labor += $labor_retail_to_add; 
                                $labor_retail += ($labor_retail_to_add * $each_additional_to_be_multiplied);
                                // echo "\n";
                                // echo "additional stone costs";
                                // // print_r($labor_retail_to_add * $each_additional_to_be_multiplied);
                                $actual_item = $temp_item;
                                $item_found = true;
                                break;
                            // }
                            // // $item->whereBetween('no_of_price_criteria_item',[intval($min), intval($max)]);
                            // else
                            // {
                            //     return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 1200 product2.');
                            // }
                        }            
                    }
                }
                else if(strtolower($request->values[$this->chapter]["procedure_details_1"]['options']['major_item']) == 'watch pin')
                {
                    // dd('watch pin');
                    foreach($price_criterian_items as $sku_with_range)
                    {
                        // loop value is 1-4
                        // we have 12
                        $value = $sku_with_range['no_of_price_criteria_item'];
                        if($value !== '' && str_contains($value, '-')) // range
                        {
                            $range = explode("-",$value);
                            $min = (double)$range[0];
                            $max = (double)$range[1];
                            // 55-1 = 4, 11-1 = 10, 10-1 = 9
                            if($no_of_price_criterian_item >= $min && 
                            $no_of_price_criterian_item <= $max)
                            {
                                $actual_item = clone $actual_item->where('no_of_price_criteria_item',$value)->first();
                                // dd('in watch pin',$actual_item);
                                // if soldering_sku exists then calculate labor either lies in range or not.
                                // dd($remaining_factor); // 37 - 35
                                if($actual_item->soldering_sku)
                                {
                                    $per_solder  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
                                    $soldering_charges = ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));                                
                                    $labor_retail += ($actual_item->flat_fee) ? $soldering_charges : $soldering_charges * $remaining_factor;
                                    // dd($labor_retail);
                                    $soldering_added = true;
                                }
                                // dd($labor_retail);
                                $item_found = true;
                                break;
                            }
                            else
                            {
                                $temp_item = clone $actual_item;
                                $temp_item = $temp_item->where('no_of_price_criteria_item',$value)->first();
                                //if soldering_sku exists then calculate labor either lies in range or not.
                                if($temp_item->soldering_sku)
                                {
                                    $per_solder  = $chap900->getPrice($request900,$this->chapter,$temp_item->soldering_sku);
                                    $soldering_charges = ($per_solder * ($temp_item->qty_to_solder && $temp_item->qty_to_solder !== '' ? $temp_item->qty_to_solder : 1));
                                    // dd($remaining_factor);
                                    $labor_retail += ($temp_item->flat_fee) ? $soldering_charges : $soldering_charges * $max; // x * 4 ( in 1-4)
                                    // dd($labor_retail);
                                    $soldering_added = true;
                                }

                               
                                $remaining_factor = $max;
                                $temp_item = clone $actual_item;
                            }
                        }
                        else if($value !== '' && str_contains($value, '>=')) 
                        {
                            // >=5
                            $range = explode(">=",$value);
                            if($no_of_price_criterian_item >= $range[1])
                            {
                                // find the item and calculate respective or calculate in parallel.
                                $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first(); // >=5
                                if($actual_item->soldering_sku)
                                {
                                    $per_solder  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
                                    $soldering_charges = ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));
                                    $remaining_factor = $no_of_price_criterian_item - $remaining_factor;
                                    $labor_retail += ($soldering_charges * $remaining_factor);
                                    $soldering_added = true;
                                }
                                // // echo "\n";
                                // // echo "3=";
                                // // echo "$labor_retail";
                                // dd($request->values['200']['no_of_price_criteria_item']);
                                $item_found = true;
                                break;
                            }
                            // $item->whereBetween('no_of_price_criteria_item',[intval($min), intval($max)]);
                            else
                            {
                                return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 1200 product1.');
                            }
                        }          
                    }
                }
            }

            // dd($actual_item->get());
            if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) == 1)
            {
                $actual_item = $actual_item->first();
            }
            else if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) >= 2)
            {
                return $this->APIResponse(config('response_codes.Bad Request'), 'error in returning the price of chapter 1200 product.');
            }
        }
        // dd($labor_retail);
            #
            // }
            // dd($labor_retail,$actual_item->get());
            // retail price of items having no range
            if($actual_item->first_service)
            {
                $first_service_item = Chapter1200::where('geller_sku',$actual_item->first_service)->first();
                if($first_service_item->soldering_sku && $first_service_item->soldering_sku !=='')
                {
                    $per_solder  = $chap900->getPrice($request900,$this->chapter,$first_service_item->soldering_sku);
                    $soldering_charges = ($per_solder * ($first_service_item->qty_to_solder && $first_service_item->qty_to_solder !== '' ? $first_service_item->qty_to_solder : 1));
                    $labor_retail += $soldering_charges;
                }
                if($first_service_item->retail_price && $first_service_item->retail_price !== "")
                {
                    $labor_retail += ltrim($first_service_item->retail_price,'$');
                }
            }
            // dd('act',$actual_item);
            
            
            $retail_detail = $this->handleMinimumNoOfItemsToChargeAndAdditionalItems($actual_item,$quantity,$no_of_price_criterian_item,$labor_retail,$retail_added);
            $labor_retail = $retail_detail['labor_retail'];
            $retail_added = $retail_detail['retail_added'];
            // dd($labor_retail,$retail_added);
            // dd('$soldering_added',$actual_item->soldering_sku);
            if($actual_item->soldering_sku && $actual_item->soldering_sku !== '' && !$soldering_added)
            {
                if(str_contains($actual_item->soldering_sku,'+')) // if having 2 soldering skus
                {
                    $soldering_skus = explode("+", $actual_item->soldering_sku);
                    foreach($soldering_skus as $soldering_sku)
                    {
                        $per_solder  = $chap900->getPrice($request900,$this->chapter,$soldering_sku);
                        $soldering_charges += ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));
                    }
                }
                else
                {
                    $per_solder  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
                    $soldering_charges = ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));
                }
                // for stringing for each additional inch, calculate soldering accordingly.
                if($actual_item->minimum_no_of_items_to_charge && $actual_item->minimum_no_of_items_to_charge != '')
                {
                    $multiplication_factor = $actual_item->minimum_no_of_items_to_charge < 1 ? 1 : 
                    ($no_of_price_criterian_item - $actual_item->minimum_no_of_items_to_charge); // 8-5
                    $soldering_charges = ($multiplication_factor * $soldering_charges);
                }
                else
                {
                    $soldering_charges = $no_of_price_criterian_item * $soldering_charges;
                }
                $labor_retail += $soldering_charges;
            }
            // dd($labor_retail);
            if(!$retail_added)
            {
                if($actual_item->retail_price && $actual_item->retail_price !== "") 
                {
                    $retail_price = ltrim($actual_item->retail_price,'$');
                    if(
                       $actual_item->price_criteria_item && 
                       $actual_item->price_criteria_item !== '' && 
                       $minimum_added == false
                       )
                       // pricing is per item
                    {
                        // add only if retail of minimum no. of items not added yet so that we cant add again
                        // dd($retail_price);
                        // $labor_retail += $labor_retail_charges * $multiplication_factor;
                        // dd($no_of_price_criterian_item,$retail_price,!$actual_item->flat_fe);
                        // dd($actual_item->flat_fee);
                        if($no_of_price_criterian_item && !$actual_item->flat_fee)
                        {
                            $retail_price         = ($no_of_price_criterian_item * $retail_price);
                        }
                        $labor_retail += $retail_price;
                        // dd($labor_retail);
                    }
                    else
                    {
                        // dd($retail_price);
                        $labor_retail += $retail_price;
                    }
                }
            }
            // dd($labor_retail);

            // setting_sku
            if($actual_item->setting_sku)
            {
                $this->chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                $this->request700 = \App::make('App\Http\Requests\Chapter700Request');
                $setting_details  = $this->chap700->getPrice($this->request700,$this->chapter,$actual_item->setting_sku);
                // dd($setting_details);
                $labor_retail += $setting_details;
            }
            // vendor cost
            if($actual_item->vendor_cost && $actual_item->vendor_cost !== '')
            {
                $labor_retail += ltrim($actual_item->vendor_cost, '$');
            }

            $part_cost = $this->getPartCost($this->chapter,$actual_item->geller_sku,0,0,[],$actual_item->id);
            // dd($part_cost);
            if($actual_item->sizing_stock_amount && $actual_item->sizing_stock_amount != '')
            {
                $part_cost = $part_cost * $actual_item->sizing_stock_amount;
            }
            // dd($part_cost);
            // being used in 1200
            if($actual_item->stuller_additional_part_1 && $actual_item->stuller_additional_part_1 !== '')
            {
                $part_cost_of_additional_part_1 += $this->getPriceFromStuller($actual_item->stuller_additional_part_1)['amount'];     
                $part_cost += $part_cost_of_additional_part_1 * (($actual_item->qty_of_additional_part_1 && $actual_item->qty_of_additional_part_1 !== '') ? $actual_item->qty_of_additional_part_1 : 1);
            }
            if($actual_item->stuller_additional_part_2 && $actual_item->stuller_additional_part_2 !== '')
            {
                $part_cost_of_additional_part_2 += $this->getPriceFromStuller($actual_item->stuller_additional_part_2)['amount'];
                $part_cost += $part_cost_of_additional_part_2 * (($actual_item->qty_of_additional_part_2 && $actual_item->qty_of_additional_part_2 !== '') ? $actual_item->qty_of_additional_part_2 : 1);
                // dd($part_cost_of_additional_part_2 * (($actual_item->qty_of_additional_part_2 && $actual_item->qty_of_additional_part_2 !== '') ? $actual_item->qty_of_additional_part_2 : 1));
            }
            # retail(part)
            $part_retail = $this->getPartRetail($part_cost);
            # order dependencies that are out of stock but not bound to apply retail but
            # in total amount as JLRC already includes this.
            if($request->picklist && is_array($actual_item->picklist_stuller_if_needed) && $actual_item->picklist_stuller_if_needed[0] != "")
            {
                //  && $request->picklist
                $pick_list_charges = $this->getPicklistCharges($actual_item->picklist_quantity_if_needed, 
                $actual_item->picklist_stuller_if_needed[0],
                $actual_item->picklist_item_if_needed);
            }

            if($actual_item->chapter1200SKUs && $actual_item->chapter1200SKUs != '' && !$chapter_itself_added)
            {
                $detail = $this->getDataOfChapterItemItself($actual_item->chapter1200SKUs);
                // dd($detail);
                $labor_retail += $detail['labor_retail'];
                $part_retail += $detail['part_retail'];
                // dd($actual_item->chapter1200SKUs,$labor_retail);

            }
            // dd('final calculations',$labor_retail);

            // dd($item->picklist_quantity_if_needed, $item->picklist_stuller_if_needed, $item->picklist_item_if_needed);
            # total(labor_retail + metarial_retail);
            // dd($labor_retail);
            // dd($request->welding_technology); 
            if(isset($request->welding_technology)) // it will only be set when category requires welding technology
            {
                if(array_key_exists($this->chapter,$request->welding_technology))
                {   // because its possible to have many indices in welding technology array
                    $welding_technology_to_use = $request->welding_technology[$this->chapter];
                }
                else
                {
                    if(!(empty(array_values($request->welding_technology))))
                    {
                        $welding_technology_to_use = array_values($request->welding_technology)[0];
                    }
                }
            }
            
            // dd($labor_retail,array_key_exists($this->chapter,$request->welding_technology) , !(empty(array_values($request->welding_technology))));
            $labor_retail = ($welding_technology_to_use == 'laser') ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
            $labor_retail = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
            // dd($labor_retail);$request->welding_technology
            $total_with_labor_part = $labor_retail + $part_retail;
            // dd($labor_retail , $part_retail);
            // dd($part_retail);
            // dd($total_with_labor_part);
            $express_total = $request->is_rush ? ($labor_retail/2) : 0;
            $labor_cost = $this->getLaborCost($labor_retail);
            $rhodium_charges = array_key_exists($this->chapter,$request->is_rhodium)?
            ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
            \Config::get('gellerbook.rhodium_charges') : 0):0;
            $grand_total = sprintf('%0.2f', round($total_with_labor_part+$express_total+$rhodium_charges)) ;
            $service_id = bin2hex(random_bytes(8));
            if($sku)
            {
                return $grand_total;
            }
            $item_data                     = [
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

                    return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 1200 product.', $service_detail);
    }
    public function getDataOfChapterItemItself($geller_sku)
    {
        $part_cost = 0;
        $part_retail = 0;
        $labor_retail = 0;
        $soldering_charges = 0;
        $actual_item = Chapter1200::query();
        $part_cost_of_additional_part_1 = 0;
        $part_cost_of_additional_part_2 = 0;
        $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
        $request900 = \App::make('App\Http\Requests\Chapter900Request');
        $retail_added = false;
        $pick_list_charges = [];
        $actual_item = Chapter1200::where('geller_sku',$geller_sku)->first();
        if($actual_item->first_service)
        {
            $first_service_item = Chapter1200::where('geller_sku',$actual_item->first_service)->first();
            if($first_service_item->soldering_sku && $first_service_item->soldering_sku !=='')
            {
                $per_solder  = $chap900->getPrice($request900,$this->chapter,$first_service_item->soldering_sku);
                $soldering_charges = ($per_solder * ($first_service_item->qty_to_solder && $first_service_item->qty_to_solder !== '' ? $first_service_item->qty_to_solder : 1));
                $labor_retail += $soldering_charges;
            }
            if($first_service_item->retail_price && $first_service_item->retail_price !== "")
            {
                $labor_retail += ltrim($first_service_item->retail_price,'$');
            }
        }
        if($actual_item->soldering_sku)
        {
            $per_solder  = $chap900->getPrice($request900,$this->chapter,$actual_item->soldering_sku);
            $soldering_charges = ($per_solder * ($actual_item->qty_to_solder && $actual_item->qty_to_solder !== '' ? $actual_item->qty_to_solder : 1));
            // dd($per_solder,$soldering_charges);
            // for stringing for each additional inch, calculate soldering accordingly.
            if($actual_item->minimum_no_of_items_to_charge && $actual_item->minimum_no_of_items_to_charge != '')
            {
                $multiplication_factor = $actual_item->minimum_no_of_items_to_charge;
                $soldering_charges = ($multiplication_factor * $soldering_charges);
            }
            $labor_retail += $soldering_charges;
        }
        // dd($labor_retail);
        if(!$retail_added)
        {
            if($actual_item->retail_price && $actual_item->retail_price !== "") 
            {
                $labor_retail += ltrim($actual_item->retail_price,'$');
            }
        }
        if(request()->picklist && is_array($actual_item->picklist_stuller_if_needed) && $actual_item->picklist_stuller_if_needed[0] != "")
        {
            //  && $request->picklist
            $pick_list_charges = $this->getPicklistCharges($actual_item->picklist_quantity_if_needed, 
            $actual_item->picklist_stuller_if_needed[0],
            $actual_item->picklist_item_if_needed);
            $labor_retail += $pick_list_charges;
        }
        $labor_retail = (isset(request()->welding_technology[$this->chapter]) && 
        request()->welding_technology[$this->chapter] == 'laser') ? 
        ($labor_retail + ($labor_retail/2)) : $labor_retail;
        $labor_retail = request()->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
        $labor_cost = $this->getLaborCost($labor_retail);

        // part cost
        $part_cost = $this->getPartCost($this->chapter,$geller_sku,0,0,[],$actual_item->id);
        if($actual_item->sizing_stock_amount && $actual_item->sizing_stock_amount != '')
        {
            $part_cost = $part_cost * $actual_item->sizing_stock_amount;
        }
        if($actual_item->stuller_additional_part_1 && $actual_item->stuller_additional_part_1 !== '')
        {
            $part_cost_of_additional_part_1 += $this->getPriceFromStuller($actual_item->stuller_additional_part_1)['amount'];     
            $part_cost += $part_cost_of_additional_part_1 * (($actual_item->qty_of_additional_part_1 && $actual_item->qty_of_additional_part_1 !== '') ? $actual_item->qty_of_additional_part_1 : 1);
        }
        if($actual_item->stuller_additional_part_2 && $actual_item->stuller_additional_part_2 !== '')
        {
            $part_cost_of_additional_part_2 += $this->getPriceFromStuller($actual_item->stuller_additional_part_2)['amount'];
            $part_cost += $part_cost_of_additional_part_2 * (($actual_item->qty_of_additional_part_2 && $actual_item->qty_of_additional_part_2 !== '') ? $actual_item->qty_of_additional_part_2 : 1);
            // dd($part_cost_of_additional_part_2 * (($actual_item->qty_of_additional_part_2 && $actual_item->qty_of_additional_part_2 !== '') ? $actual_item->qty_of_additional_part_2 : 1));
        }
        # retail(part)
        $part_retail = $this->getPartRetail($part_cost);
        return array(
            'part_retail'                  => $part_retail,
            'labor_retail'                 => $labor_retail
        );
    }

    function handleMinimumNoOfItemsToChargeAndAdditionalItems($item,$quantity,$no_of_price_criterian_item,$labor_retail,$retail_added)
    {
        // dd('item',$item);
        if($item->minimum_quantity && $item->minimum_quantity != '')
        {
            // dd($item);
            // we are done price criteria item and no need tp find actua;l item 
            if($item->each_additional && $item->each_additional !== '')
            {
                //dd($quantity,$item->minimum_quantity);
                if($quantity > (double)$item->minimum_quantity)
                {
                // dd($item);
                // being handled for the sake of each additional i.e., 1 or more
                $minimum_quantity      = $item->minimum_quantity;  // 1
                $multiplication_factor = $minimum_quantity < 1 ? 1 : ($quantity - (double)$item->minimum_quantity); // 1 // 5-5
                $labor_retail         += ($multiplication_factor * ltrim($item->each_additional,'$'));
                } // if equals or less than
                else 
                {
                $minimum_quantity = $item->minimum_quantity;  // 1
                $multiplication_factor = $minimum_quantity < 1 ? 1 : ($quantity - (double)$item->minimum_quantity); // 1 // 5-5
                // dd($multiplication_factor);    
                $labor_retail         += ($multiplication_factor * ltrim($item->each_additional,'$'));
                }
                // dd($labor_retail);
                $minimum_added = true;
            }
        }
        else // that meanse its having price criteria item and quantity as well.
            {
            // dd('here should land',$item->each_additional);
            $minimum_no_of_items_to_charge = ($item->minimum_no_of_items_to_charge && // 5
            $item->minimum_no_of_items_to_charge != '') ? (double)$item->minimum_no_of_items_to_charge : 1;

            // dd($no_of_price_criterian_item,$quantity);

            if($item->each_additional && $item->each_additional !== '' && 
            $no_of_price_criterian_item > 1)// condition -> $no_of_price_criterian_item > 1 is obvious that swhy each additional works.
            {
                $retail_price = ltrim($item->retail_price,'$');
            
                if($item->quantity && $item->quantity !== '' && $item->quantity == 1) // means it will be hanlded per item
                {
                    if(!($quantity > 1))
                    {
                        if($no_of_price_criterian_item > (double)$item->minimum_no_of_items_to_charge)
                        {
                            // being handled for the sake of each additional i.e., 1 or more
                            $multiplication_factor = $minimum_no_of_items_to_charge < 1 ? 1 : ($no_of_price_criterian_item - (double)$item->minimum_no_of_items_to_charge); // 1
                            $labor_retail         += ($multiplication_factor * ltrim($item->each_additional,'$'));
                        }
                        $minimum_added = true;
                    }
                    else if(($quantity > 1))
                    {
                    // dd($quantity , $minimum_no_of_items_to_charge);
                        if($quantity > $minimum_no_of_items_to_charge)
                        {
    
                        // dd($minimum_no_of_items_to_charge,$quantity);
                        // being handled for the sake of each additional i.e., 1 or more
                        $multiplication_factor = $quantity - $minimum_no_of_items_to_charge; // 7-5 = 2 are additionaal 
                        $labor_retail          += ($retail_price * $minimum_no_of_items_to_charge);
                        $labor_retail          += ($multiplication_factor * ltrim($item->each_additional,'$')); // 2*$7
                        $retail_added           = true;
    
                        }
                        else
                        {
                        // being handled for the sake of each additional i.e., 1 or more
                        $labor_retail          += ($retail_price * $quantity);
                        $retail_added = true;
                        // dd($labor_retail);
    
                        }   
                    }
                }
                else if($item->quantity == null)// will be handled as a bundle
                {
                    $multiplication_factor = $no_of_price_criterian_item - $minimum_no_of_items_to_charge; // 22 - 18 inches
                    if($multiplication_factor < 0)
                    {
                        $multiplication_factor = 0;
                    }
                    $labor_retail          += ($multiplication_factor * ltrim($item->each_additional,'$')); // 2*$7
                    $labor_retail          += $retail_price;
                    $retail_added           = true;
                }
               
            }
            // dd($labor_retail);
            }
            // dd($labor_retail);

            return array(
                'labor_retail' => $labor_retail,
                'retail_added' => $retail_added
            );
    } 
}