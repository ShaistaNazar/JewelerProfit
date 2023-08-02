<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter200Request;
use App\Http\Requests\Chapter500Request;
use App\Models\DavidPricing\Chapter500;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class Chapter500Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
       $this->chapter = 500;
    }

    public function getPrice(Chapter500Request $request)
    {
        // try{
// dd($request->all());
            $labor_formula = null;
            $part_retail = 0;
            $labor_retail = 0;
            $total_with_labor_part = 0;
            $express_total = 0;
            $total_with_picklist_charges = 0;
            $actual_item = Chapter500::query();
            $sum_of_labors = 0;
            $setting_charges = 0;
            $sales_tax = salesTax();
            $price_chart = [];
            $quantity_for_envelope = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];

            // iterating
            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key  => $value) 
            {
                // its covering welding technology as well
                if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology')
                $actual_item->where($key,'like', '%' . $value . '%');
            }

          
            // dd($actual_item->get());
            $questionable_item = clone $actual_item;
            $price_criterian_item_exists = clone $actual_item;
            $price_criterian_item_exists = $price_criterian_item_exists->where('is_additional','!=',1)
            ->orWhereNull('is_additional')
            ->pluck('price_criteria_item')->toArray();
            // without additional price criterian items
            $price_criterian_items = $actual_item->where('is_additional','!=',1)->orWhereNull('is_additional')
            ->get(['geller_sku','no_of_price_criteria_item','price_criteria_item'])->toArray();
            // dd($price_criterian_items);
            // dd($actual_item->get(),$price_criterian_item_exists,$price_criterian_items);

            // additional item exits
            $questionable_item = $questionable_item->whereNotNull('question')->where('question','!=','')->first();

            // dd($questionable_item,$request->all());
            // if price criterian is set
            if(count(array_unique($price_criterian_item_exists)) == 1 &&
            $price_criterian_item_exists[0] !== '' && count($price_criterian_items) > 1)
            {
                // criterian item is set 
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
                        if($request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] >= $min && 
                           $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] <= $max)
                        {
                            // dd($actual_item->where('no_of_price_criteria_item',$value)->first());
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail += ltrim($actual_item->retail_price, '$');
                            $item_found = true;
                            break;
                        }
                    }
                    else if($value !== '' && str_contains($value, 'flat'))
                    {
                        // this case is being handles in question part
                    }
                    else
                    {
                        // dd($request->values['200']['no_of_price_criteria_item']);
                        // dd($value,$request->values['200']['no_of_price_criteria_item']);
                        if($value == $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'])
                        {
                            $actual_item = $actual_item->where('no_of_price_criteria_item',$value)->first();
                            $labor_retail += ltrim($actual_item->retail_price, '$');
                            $item_found = true;
                            break;
                        }
                    }            
                }
            }
            else
            {
                $actual_item = $actual_item->first();
                // dd($actual_item);
            } 
            // vendor cost  
            // dd($actual_item->get());
            $vendor_cost  = ltrim($actual_item->vendor_cost_retail_price, '$');
            $JLRC  = ltrim($actual_item->JLRC_on_retail, '$');
            // dd($vendor_cost,$JLRC);
            // handling additionalletters
            if($actual_item->price_criteria_item == 'Letter')
            {
                // dd($actual_item);
                $additional_letter_charges_array = array('additional_letters_over_03',
                'additional_letters_over_08','additional_letters_over_15');
                foreach($additional_letter_charges_array as $additional_charges_column)
                {
                    // echo "\n";
                    // print_r($actual_item->$additional_charges_column);
                    if($actual_item->$additional_charges_column && $actual_item->$additional_charges_column != '')
                    {
                        // dd($request->values[$this->chapter]);
                        $character_threshold = substr($additional_charges_column, -2);

                        $additional_letters  = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - $character_threshold;
                        if($additional_letters < 0)
                        {
                            $additional_letters  = 0;
                        }
                        // dd($character_threshold,$additional_letters);
                        // dd($additional_letters);
                        // dd($additional_letters,$actual_item->$additional_charges_column);
                        $additional_charges  = ltrim($actual_item->$additional_charges_column, '$');
                        $additional_JLRC  = ltrim($actual_item->JLRC_additional, '$');
                        $labor_retail += $additional_charges * $additional_letters; // so that 0 cant be multiplied to mutiplication factor
                        // dd($multiplying_factor , ltrim($actual_item->JLRC_additional, '$'));
                        $JLRC += ($additional_JLRC * $additional_letters);
                    }                  
                }
                // dd($labor_retail);
                $vendor_cost_charges_array = array('vendor_cost_additional_letters_over_03','vendor_cost_additional_letters_over_08','vendor_cost_additional_letters_over_15');
                foreach($vendor_cost_charges_array as $vendor_cost_value)
                {  
                    // echo "\n";
                    // print_r($actual_item->$additional_charges_column);
                    if($actual_item->$vendor_cost_value && $actual_item->$vendor_cost_value != '')
                    {
                        $character_threshold_vendor = substr($vendor_cost_value, -2);// 03, 05
                        $additional_letters_vendor  = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - $character_threshold_vendor;
                        $multiplying_factor_vendor = ltrim($actual_item->$vendor_cost_value, '$');// $3 -> 3
                        $vendor_cost += $multiplying_factor_vendor * ($additional_letters_vendor == 0 ? 1 : $additional_letters_vendor); // so that 0 cant be multiplied to mutiplication factor
                    }                  
                }
            }
            else if($actual_item->price_criteria_item == 'Line')
            {
                // additional_lines_engraving_retail
                $line_threshold = $actual_item->no_of_price_criteria_item;
                $additional_lines = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - $line_threshold;
                if($actual_item->additional_lines_engraving_retail && $actual_item->additional_lines_engraving_retail != '')
                {
                    // minimum price is set per 1 line each additional line will be priced additionally and its set in 
                    // document 
                    
                    $multiplying_factor = ltrim($actual_item->additional_lines_engraving_retail, '$');
                    $labor_retail += $multiplying_factor * ($additional_lines == 0 ? 1 : $additional_lines); // so that 0 cant be multiplied to mutiplication factor
                    $JLRC += $multiplying_factor * ltrim($actual_item->JLRC_additional, '$');

                }
                if($actual_item->vendor_cost_additional_lines_engraving_retail && $actual_item->vendor_cost_additional_lines_engraving_retail != '')
                {
                    // minimum price is set per 1 line each additional line will be priced additionally and its set in 
                    // document 
                    $multiplying_factor = ltrim($actual_item->vendor_cost_additional_lines_engraving_retail, '$');
                    $vendor_cost += $multiplying_factor * ($additional_lines == 0 ? 1 : $additional_lines); // so that 0 cant be multiplied to mutiplication factor
                }
                // vendor_cost_additional_lines_engraving_retail
            }
            // dd($labor_retail);
            // dd($additional_item);

            // handling additional price means if odd shaped or having crown stones
            // dd($questionable_item ,$request->question);
            // dd($labor_retail);
            if($questionable_item && $request->question == 1)
            {
                $labor_retail += ltrim($questionable_item->retail_price, '$');
                // vendor cost
                
                $vendor_cost += ltrim($questionable_item->vendor_cost_retail_price, '$');

            }

            // retail of item itself
            $labor_retail += ltrim($actual_item->retail_price, '$');

            // handling rush charges
            $labor_retail = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
            $express_retail   = $request->is_rush ? ($labor_retail/2) : 0;
            $rhodium_charges  = array_key_exists($this->chapter,$request->is_rhodium)?
            ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
            \Config::get('gellerbook.rhodium_charges') : 0):0;
            $labor_cost = $this->getLaborCost($labor_retail);
            $grand_total = sprintf('%0.2f', round($part_retail+$labor_retail+$express_retail+$rhodium_charges)) ;  
            $service_id = bin2hex(random_bytes(8));

            # add job history and bind jeweler to it.
            $service_id = bin2hex(random_bytes(8));
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
                'vendor_cost'              => $vendor_cost,
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
    
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 500 product.', $service_detail);
        // }catch(Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
        // }        

    }

    public function updateRetailPricePerShop(Chapter500Request $request){

        $engraving_item = Chapter500::where([
            'geller_sku' =>  $request->geller_Sku
        ])->first();

        if($engraving_item){
            $updated_engraving_item = $engraving_item->update($request->all());
        }

        return $updated_engraving_item;
    }
}