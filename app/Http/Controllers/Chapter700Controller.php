<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Chapter700Request;
use App\Models\DavidPricing\Chapter700;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Config;

class Chapter700Controller extends CalculationController
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

    public function getPrice(Chapter700Request $request,$requestee_chapter,$sku=null,$check_and_tighten_enabled = null)
    {
        // try{
            // dd($requestee_chapter);
            // dd($sku);
            // dd($requestee_chapter,$sku,$check_and_tighten_enabled);
        $labor_cost = 0;
        $labor_retail = 0;
        $JLRC = 0;
        $total_with_labor_metarial = 0;
        $sales_tax = salesTax();
        $express_total = 0;
        $found = false;
        $quantity_for_envelope = 1;
        if($sku)
        {
            $actual_item = Chapter700::where('geller_sku',$sku)->first();
            $setting_charges = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount);
            $setting_charges = round($setting_charges['labor_retail'],2);
            // echo "\n";
            // print_r($setting_charges);
            return $setting_charges;
        }
        else
        {
        $part_cost                   = 0;
        $part_retail                 = 0;
        $labor_cost                  = 0;
        $labor_retail                = 0;
        $total_with_labor_metarial   = 0;
        $express_total               = 0;
        $total_with_picklist_charges = 0;
        $setting_charges             = 0;
        $masking_charges             = 0;
        # new settings
        $sales_tax                   = Setting::where('setting','sales_tax')->first()->value;
        $price_chart                 = [];
        $service_id                  = bin2hex(random_bytes(8));
        $quantity_for_envelope       = $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'];
        
        # item itself
        // foreach(request()->values[$this->chapter] as 'procedure_details_1' => $procedure)
        // {
            // dd(''procedure_details_1'','procedure_details_1');
            if($check_and_tighten_enabled)
            {
                $item = Chapter700::query();
                $actual_item = $item->whereRaw("REPLACE(`major_item`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', 'Check & Tighten Stones').'%']);
            }
            else
            {
                $actual_item              =  $this->getProceduralItem($this->chapter,1,['no_of_price_criteria_item','welding_technology']);
            }

            // dd($actual_item->get());
            if(count($actual_item->get()) > 1)
            { 
                $price_criterian_items = $actual_item->get(['geller_sku','no_of_price_criteria_item'])->toArray();
                // dd($price_criterian_items);
                foreach($price_criterian_items as $sku_with_range)
                {
                    $value = $sku_with_range['no_of_price_criteria_item'];
                    if($value !== '' && str_contains($value, 'to')) // range
                    {
                        $range = explode(" to ",$value);
                        // dd($range);
                        $min = $range[0];
                        $max = $range[1];
                        if($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] >= $min && 
                        $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] <= $max)
                        {
                            $found = true;
                            $actual_item->where('no_of_price_criteria_item','like', '%' . $value . '%');
                        }
                    }
                    else if($value !== '' && str_contains($value, '>')) // greater than values
                    {
                        $range = explode(">",$value);
                        if($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] > $range[1])
                        {
                            $found = true;
                            $actual_item->where('no_of_price_criteria_item','like', '%' . $value . '%');
                        }
                    }
                    // else
                    // {
                    //     if($value == $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'])
                    //     {
                    //         $actual_item->where('no_of_price_criteria_item',$value);
                    //     }
                    // }                 
                }
                // if('procedure_details_1' == 'procedure_details_2')
                // dd($actual_item->get());
                
            }else{
                // in combination with other chapter or does n't have range
                $found = true;
            }
            if($found)
            {
            // dd($actual_item);
            // dd('700',$actual_item);
                if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) == 1)
                {
                    $actual_item =  $actual_item->first();
                    $found = true;
                }
                else
                {
                    return $this->APIResponse(config('response_codes.Bad Request'), 'Request has wrong parameters.');
                }
                if($actual_item->is_flat_fee)
                {
                    // dd('flat');
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

                            // if($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] > 50){
                            // total retail
                            $subtracted_stones = $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] - 50;
                            $labor_retail = $labor_details_of_item_to_add_amount_from['labor_retail'] + $labor_detail_for_actual_item['labor_retail'] * $subtracted_stones; 
                            // } else {
                            //     $labor_retail = $labor_details_of_item_to_add_amount_from['labor_retail'];
                            // }
                        }
                        else
                        {
                            $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'];
                        }
                        
                    }
                    else
                    {
                        // dd('hello');
                        // if($request->values['700']['settings'] == 'Check & Tighten Stones' && 
                        // isset($request->stone_details) && $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] <= 4 )
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
                    // dd($labor_retail,$JLRC);
                    if($actual_item->discount_applying && $actual_item->discount_applying != '')
                    {
                        // handling failure cases
                        $subtracted_stones = $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'] - 6;
                        // dd($subtracted_stones);
                        // dd($this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount),$this->getLaborRetailAndCostByFormula($actual_item->setting_labor_with_discount)['labor_retail']);
                        // $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_with_discount);
                        // dd('hi',$labor_retail);
                        $JLRC_with_discount = ltrim($actual_item->JLRC_with_discount,'$');
                        $JLRC_without_discount = ltrim($actual_item->JLRC_without_discount,'$');
                        $JLRC_with_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_with_discount,'$'))['labor_retail'];
                        $JLRC_without_discount = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'];
                        // dd($labor_retail,$JLRC_with_discount,$JLRC_without_discount);
                        if($subtracted_stones < 0)
                        {
                            $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'] * 
                            $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'];
                            $JLRC = $JLRC_without_discount * $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'];
                        }
                        else
                        {
                            $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'] * 6
                            + $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_with_discount)['labor_retail'] * $subtracted_stones;
                            $JLRC = $JLRC_without_discount * 6 + $JLRC_with_discount * $subtracted_stones;
                        }
                        // dd($JLRC);
                    }
                    else
                    {
                        $labor_retail = $this->getLaborRetailAndCostByFormula($actual_item->setting_labor_without_discount)['labor_retail'] * $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'];
                        $JLRC_without_discount = ltrim($actual_item->JLRC_without_discount,'$');
                        $JLRC = $this->getLaborRetailAndCostByFormula(ltrim($actual_item->JLRC_without_discount,'$'))['labor_retail'] * $request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['no_of_items'];
                    }
                }
                # cost(labor);
                $labor_retail = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
                // dd($labor_retail);
                $express_total = $request->is_rush ? ($labor_retail/2) : 0;
                $labor_cost = $this->getLaborCost($labor_retail);
                // dd($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['lower_value_colored_stone']);
                $after_discount_if_lower_value_colored_stone = round($labor_retail) - ($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['lower_value_colored_stone'] ? (round($labor_retail) * 0.15) : 0);
                $labor_retail = $after_discount_if_lower_value_colored_stone;
                // dd($labor_retail);

                $JLRC = $JLRC - ($request->extra_work_details[$this->chapter]['flow_details']['procedure_details_1']['lower_value_colored_stone'] ? $JLRC * 0.15 : 0);
                $geller_sku = $actual_item->geller_sku;
                 // dd($part_cost); 
                $part_retail                       = $this->getPartRetail($part_cost,($actual_item->part_markup && $actual_item->part_markup !== '')
                                                   ? (double)$actual_item->part_markup:config('gellerbook.part_markup'));
                        // dd($part_cost,$part_retail,$labor_retail);
                $labor_cost                        = $this->getLaborCost($labor_retail);
                $express_retail                    = $request->is_rush ? ($labor_retail/2) : 0;
                $rhodium_charges                   = array_key_exists($this->chapter,$request->is_rhodium)?
                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                        \Config::get('gellerbook.rhodium_charges') : 0):0;
                        //  dd($part_retail,$labor_retail,$express_retail,$rhodium_charges);
                $grand_total                       = sprintf('%0.2f', round($part_retail+$labor_retail+$express_retail+$rhodium_charges)) ;        
                // dd($grand_total);
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
                        'masking_charges'          => $masking_charges,
                        'setting_charges'          => $setting_charges,
                        'quantity'                 => $quantity_for_envelope

                        ];
                array_push($price_chart,$item_data);
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

                $item_data                     = [
                    'id'                       => null,
                    'geller_sku'               => null,
                    'major_item'               => null,
                    'total'                    => $grand_total,
                    'is_actual'                => true,
                    'is_rhodium'               => array_key_exists($this->chapter,$request->is_rhodium)?
                                                ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                                true : false):false,
                    'is_rush'                  => $request->is_rush,
                    'pick_list_charges'        => [],
                    'masking_charges'          => $masking_charges,
                    'setting_charges'          => $setting_charges
                    ];
            array_push($price_chart,$item_data);
            // }
        }
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
        }
    }
}
