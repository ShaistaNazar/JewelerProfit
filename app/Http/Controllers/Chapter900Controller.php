<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter700Request;
use App\Http\Requests\Chapter900Request;
use App\Models\DavidPricing\Chapter900;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Chapter900Controller extends CalculationController
{

    public $chapter;
    public function __construct()
    {
        parent::__construct();
        $this->chapter = 900;
    }
    
     /**
     * calculation of prices of 200 
     */

    public function getPrice(Chapter900Request $request, $requestee_chapter = null,$sku = null)
    {
        // try{
        // dd($request->all());
        $labor_cost = 0;
        $JLRC = 0;
        $total_with_labor_and_part = 0;
        $express_total = 0;
        $sales_tax = salesTax();
        $price_chart = [];
        $quantity_for_envelope = 1;

        if($sku)
        {
            $actual_item = Chapter900::where('geller_sku',$sku)->first();
            // soldering charges per item in tobemultipliedform
            $soldering_charges = $this->getLaborRetailAndCostByFormula($actual_item->soldering_labor_without_discount);
            $soldering_charges = round($soldering_charges['labor_retail'],2);
            return $soldering_charges;
        }
        else
        {
            $quantity_for_envelope = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];
            if(array_key_exists('complexity',$request->values[$this->chapter]['procedure_details_1']['options']) && 
               $request->values[$this->chapter]['procedure_details_1']['options']['complexity'] === 'Charms (5 or more)' && $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] <=4)
            {
                // dd('hi');
                return $this->APIResponse(config('response_codes.Bad Request'), 'Request has wrong parameters.');
            }
            else
            {
                $actual_item = Chapter900::query();
                // dd($request->values[$this->chapter]['procedure_details_1']['options']);
                foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key  => $value) 
                {   // its covering welding technology as well
                    if($key !== 'no_of_price_criteria_item')
                    $actual_item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $value).'%']);
                }
                // dd($actual_item->get());
                if(count($actual_item->get()) == 1)
                {
                    $actual_item = $actual_item->first();
                    // soldering charges per item in tobemultipliedform
                    // dd($actual_item);
                    // dd($request->all());
                    // request()->values;
                    if($request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] > 1)
                    {
                        $discount_available = true;
                        // dd($actual_item->soldering_labor_without_discount,$actual_item->soldering_labor_with_discount);
                        $soldering_charges_without_discount = $this->getLaborRetailAndCostByFormula($actual_item->soldering_labor_without_discount)['labor_retail'];
                        if($actual_item->soldering_labor_with_discount && $actual_item->soldering_labor_with_discount !== '')
                        {
                            $soldering_charges_with_discount = $this->getLaborRetailAndCostByFormula($actual_item->soldering_labor_with_discount)['labor_retail'];
                            $discount_available = true;
                        }
                        else
                        {
                            $discount_available = false;
                            $soldering_charges_with_discount = 0;
                        }
                        
                        if($request->values[$this->chapter]['procedure_details_1']['options']['complexity'] === 'Charms (5 or more)')
                        {
                            // 5 or more: Each
                            $remaining_charms = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - 4; // 5 - 4 = 1 || 10 - 4 = 6 
                            $soldering_charges = $soldering_charges_without_discount * $remaining_charms;
                        }   
                        else
                        {
                            // discount be applied on each additional
                            $remaining_items_with_discount = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - 1;
                            if($discount_available)
                            {
                                $soldering_charges = $soldering_charges_without_discount * 1 + $remaining_items_with_discount * $soldering_charges_with_discount;
                            }else{
                                $soldering_charges = $soldering_charges_without_discount * $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];
                            }
                        }   
                        if($actual_item->JLRC_with_discount)
                        {
                            $JLRC_with_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_with_discount,'$'))['labor_retail'];
                            $JLRC_without_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'];
                            $JLRC = $JLRC_without_discount * 1 + $remaining_items_with_discount * $JLRC_with_discount;                
                        }
                        else
                        {
                            $JLRC = $soldering_charges;
                        }                         
                    }
                    else
                    {
                        $soldering_charges = $this->getLaborRetailAndCostByFormula($actual_item->soldering_labor_without_discount)['labor_retail'];
                        if($actual_item->JLRC_without_discount)
                        {
                            $JLRC = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'];
                        }
                        else
                        {
                            $JLRC = $soldering_charges;
                        }
                    }
                    // adding manufacturing solder to current calculation
                    // $labor_retail = $soldering_charges + $actual_item->manufacturing_solder;
                    $labor_retail = $soldering_charges + $actual_item->manufacturing_solder;
                    if($request->check_and_tighten_enabled)
                    {
                        $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
                        $labor_retail += $charges;
                    }
                    // if($request->finishing_work)
                    // {
                    //     $chap1200    = \App::make('App\Http\Controllers\Chapter1200Controller');
                    //     $request1200 = \App::make('App\Http\Requests\Chapter1200Request');
                    //     $setting_details  = $chap1200->getPrice($request1200, $this->chapter, $actual_item->setting_sku);
                    //     $setting_charges = json_decode(json_encode($setting_details,true))->original->data->grand_total_after_discount;
                    // }
                    # cost(labor);
                    $labor_cost                        = $this->getLaborCost($labor_retail);
                    $express_retail                    = $request->is_rush ? ($labor_retail/2) : 0;
                    $rhodium_charges                   = array_key_exists($this->chapter,$request->is_rhodium)?
                                                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                                        \Config::get('gellerbook.rhodium_charges') : 0):0;
                                                        //  dd($part_retail,$labor_retail,$express_retail,$rhodium_charges);
                    $grand_total                       = sprintf('%0.2f', round($labor_retail+$express_retail+$rhodium_charges)) ;        
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
                    $service_id = bin2hex(random_bytes(8));

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
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 100 product.', $service_detail);

                }else{
                return $this->APIResponse(config('response_codes.Bad Request'), 'Request has wrong parameters');
                }
            }
      }
        // }catch(Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
        // }              
    }
}
