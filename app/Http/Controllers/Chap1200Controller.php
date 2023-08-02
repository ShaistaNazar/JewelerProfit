<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Chapter700Request;
use App\Models\Chapter700;
use Exception;
use Illuminate\Support\Facades\Config;

class Chap1200Controller extends CalculationController
{
    /**
     * calculation of prices of 200 
     */

     // TODO NOte 1 : check & tightening stones
     # Prices are rings
     # with no diamonds/
     # stones in them. If there
     # are stones you must
     # charge extra (below) for
     # 5 or more stones in the
     # ring.

     // TODO NOte 2: guarantee
     // Channel 
     # Channel setting where either the channel is very thin, torn, not
     # straight across the stones OR there is no support underneath
     # the channels to hold them together. Example: No cross wires or
     # support to keep the channel from pulling away leaving the
     # stone to loosen up or fall out.
     // Prong/Tip
     # Retipped prongs on stones- We can not guarantee the
     # loss of a stone when we do not retip or reprong all of
     # the prongs when we deem it necessary to repair all of
    public $chapter;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 700;
    }

    public function getPrice(Chapter700Request $request,$requestee_chapter,$sku=null)
    {
        // try{
            // dd($requestee_chapter);
        $labor_cost = 0;
        $labor_retail = 0;
        $JLRC = 0;
        $total_with_labor_metarial = 0;
        $sales_tax = salesTax();
        $express_total = 0;
        $found = false;
        if($sku){
            $actual_item = Chapter700::where('geller_sku',$sku)->first();
        }else{
            // dd($request->all());
            $actual_item = Chapter700::query();
            foreach ($request->values['700'] as $key => $value) 
            {
                $actual_item->where($key,'like', '%' . $value . '%');
            }
            // dd($actual_item->get());
            // item to iterate further is object to get dependent amount to add on.
            // $item_to_interate_further = $actual_item;
            // finding item itself on the basis of stone range
            if(count($actual_item->get()) > 1)
            {
                $price_criterian_items = $actual_item->get(['geller_sku','no_of_price_criteria_item'])->toArray();
                foreach($price_criterian_items as $sku_with_range)
                {
                    // finding no_of_price_criterian_item
                    $value = $sku_with_range['no_of_price_criteria_item'];
                    if($value !== '' && str_contains($value, '-')) // range
                    {
                        $range = explode("-",$value);
                        $min = $range[0];
                        $max = $range[1];
                        if($request->values[$this->chapter]['no_of_price_criteria_item'] >= $min && 
                           $request->values[$this->chapter]['no_of_price_criteria_item'] <= $max)
                        {   // 1-4 
                            $found = true;
                            $actual_item->where('no_of_price_criteria_item','like', '%' . $value . '%');
                        }
                    }
                    else if($value !== '' && str_contains($value, '>')) // greater than values
                    {    // >50 $1 -> each
                        $range = explode(">",$value);
                        if($request->stone_details['no_of_stones'] > $range[1])
                        {
                            $found = true;
                            $actual_item->where('no_of_price_criteria_item','like', '%' . $value . '%');
                        }
                    }
                    else if($value !== '' && str_contains($value, '>=')) // greater than values
                    {    // >=5
                        $range = explode(">",$value);
                        if($request->stone_details['no_of_stones'] > $range[1])
                        {
                            $found = true;
                            $actual_item->where('no_of_price_criteria_item','like', '%' . $value . '%');
                        }
                    }
                    // else
                    // {
                    //     if($value == $request->stone_details['no_of_stones'])
                    //     {
                    //         $actual_item->where('no_of_price_criteria_item',$value);
                    //     }
                    // }                 
                }
            }else{
                // in combination with other chapter or does n't have range
                $found = true;
            }
        }
        // dd($found);
        if($found)
        {
            $actual_item = $actual_item->first();
            if($actual_item->is_flat_fee)
            {
                if($actual_item->no_of_price_criteria_item && $actual_item->no_of_price_criteria_item != '')
                {
                    // needs previous item to be added in first
                    if(strpos(strtolower($actual_item->no_of_price_criteria_item),'>') !== false)
                    {
                        // dd($actual_item);
                        // basic price being handled as price of next sku will be added per stone in this amount 
                        $item_to_add_amount_from = Chapter700::where('geller_sku',$actual_item->previous_dependency)->first();
                        $labor_details_of_item_to_add_amount_from = $this->getLaborRetailAndCostByFormula($item_to_add_amount_from->setting_labor_without_discount);
                        $labor_detail_for_actual_item = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount); // $1
                        // if($request->stone_details['no_of_stones'] > 50){
                        // total retail
                        $subtracted_stones = $request->stone_details['no_of_stones'] - 50;
                        $labor_retail = $labor_details_of_item_to_add_amount_from['labor_retail'] + $labor_detail_for_actual_item['labor_retail'] * $subtracted_stones; 
                        // } else {
                        //     $labor_retail = $labor_details_of_item_to_add_amount_from['labor_retail'];
                        // }
                    }
                    else
                    {
                        $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'];
                    }
                    
                }else
                {
                    // dd('hello');
                    // if($request->values['700']['settings'] == 'Check & Tighten Stones' && 
                    // isset($request->stone_details) && $request->stone_details['no_of_stones'] <= 4 )
                    // {
                    //     return $this->APIResponse(config('response_codes.Bad Request'), 'No pricing for this service.');
                    // }
                    // else
                    // {
                        $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'];
                    // }
                }
                $JLRC = $labor_retail;
            }
            else
            {
                if($actual_item->discount_applying && $actual_item->discount_applying != '')
                {
                    // handling failure cases
                    $subtracted_stones = $request->stone_details['no_of_stones'] - 6;
                    // $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_with_discount);
                    $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'] * 6 + $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_with_discount)['labor_retail'] * $subtracted_stones; 
                    $JLRC_with_discount = ltrim($actual_item->JLRC_with_discount,'$');
                    $JLRC_without_discount = ltrim($actual_item->JLRC_without_discount,'$');
                    $JLRC_with_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_with_discount,'$'))['labor_retail'];
                    $JLRC_without_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'];
                    $JLRC = $JLRC_without_discount * 6 + $JLRC_with_discount * $subtracted_stones;
                }
                else
                {
                    // tested
                    $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'] * $request->stone_details['no_of_stones'];
                    $JLRC_without_discount = ltrim($actual_item->JLRC_without_discount,'$');
                    $JLRC = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'] * $request->stone_details['no_of_stones'];
                }
            }
             # cost(labor);
             $labor_retail = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
             $express_total = $request->is_rush ? ($labor_retail/2) : 0;
             $labor_cost = $this->getLaborCost($labor_retail);
             $after_discount_if_lower_value_colored_stone = round($labor_retail) - ($request->stone_details['lower_value_colored_stone'] ? round($labor_retail) * 0.15 : 0);
             $grand_total = $after_discount_if_lower_value_colored_stone;
             $JLRC = $JLRC - ($request->stone_details['lower_value_colored_stone'] ? $JLRC * 0.15 : 0);
             $geller_sku = $actual_item->geller_sku;
            }
            else
            {
                // return $this->APIResponse(config('response_codes.Bad Request'), 'No pricing for this service.');
                # cost(labor);
                $labor_retail = 0;
                $labor_cost = 0;
                $after_discount_if_lower_value_colored_stone = 0;
                $grand_total = 0;
                $JLRC = 0;
                $geller_sku = null;
                $sales_tax = 0;
            }
        $service_detail = array(
            'geller_sku'                    => $geller_sku,
            'labor_cost'                    => $labor_cost,
            'labor_retail'                  => $labor_retail,
            'rush_service'                  => $express_total, 
            'service_id'                    => $requestee_chapter ? null : bin2hex(random_bytes(8)), // this is in simple terms 'order id'
            'jeweler_id'                    => $request->jeweler_id,
            'is_rush'                       => $request->is_rush, 
            'grand_total'                   => round($grand_total, 2),
            'total_cost'                    => $labor_cost,// as part cost is not included.
            'total_retail'                  => $labor_retail,
            'JLRC'                          => $JLRC, 
            'grand_total_after_discount'    => $after_discount_if_lower_value_colored_stone,
            'stone_type'                    => $request->stone_details['stone_type'],
            'sales_tax'                     => $requestee_chapter ? 0 : $sales_tax,
            'total_with_sales_tax'          => $requestee_chapter ? $after_discount_if_lower_value_colored_stone : $after_discount_if_lower_value_colored_stone + $sales_tax,
        );
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the labor of chapter 700 product.', $service_detail);
        // }catch(Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
        // }        
    }
}
