<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter400Request;
use App\Http\Requests\Chapter700Request;
use App\Http\Requests\Chapter900Request;
use App\Models\DavidPricing\Chapter400;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Chapter400Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 400;
    }
  # note no JLRC -> add setting and soldering skus
    public function getPrice(Chapter400Request $request, $requestee_chapter = null)
    {
        // try{
            $part_cost = 0;
            $part_retail = 0;
            $labor_cost = 0;
            $labor_retail = 0;
            $total_with_labor_and_part = 0;
            $express_total = 0;
            $picklist_charges = 0;
            $sales_tax = Setting::where('setting','sales_tax')->first()->value;
            $soldering_charges = 0;
            $setting_charges = 0;
            $item = Chapter400::query();
            $price_chart = [];
            $quantity_for_envelope = 1;

            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology')
                {
                    $item->where($key,'like', '%' . $value . '%');
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
                // $setting_charges  = json_decode(json_encode($setting_details,true))->original->data->grand_total_after_discount;
            }
            if($item->soldering_sku_per_post_or_back && $item->soldering_sku_per_post_or_back != '')
            {   // soldering sku is per post or back so it can be multiplied further as per number of post or backs
                // dd($item->soldering_sku_per_post_or_back);
                $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                $request900 = \App::make('App\Http\Requests\Chapter900Request');
                $soldering_charges  = $chap900->getPrice($request900,$this->chapter,$item->soldering_sku_per_post_or_back);
                // dd($soldering_charges);
                // $soldering_details  = json_decode(json_encode($soldering_details['soldering_charges'],true))->original->data;
            }           
            # cost(part)
            $qty_to_order = $item->qty_to_order_of_stuller_sku;
            $part_cost = $this->getPartCost($this->chapter,$item->geller_sku) * ($qty_to_order && $qty_to_order != '' ? $qty_to_order : 1);
            # retail(part)
            $part_retail = $this->getPartRetail($part_cost);
            if($requestee_chapter && $request->part_only)
            {
                return $part_cost;
            }
            // dd($part_retail);
            # order dependencies that are out of stock but not bound to apply retail but
            // dd($item);
            # in total amount as JLRC already includes this.
            // dd($item->picklist_quantity_if_needed, $item->picklist_stuller_if_needed, $item->picklist_item_if_needed);
            // if($item->picklist_stuller_if_needed != "" && $request->picklist)

            if($request->picklist && $item->picklist_stuller_if_needed != "")
            $pick_list_charges = $this->getPicklistCharges($item->picklist_quantity_if_needed, is_array($item->picklist_stuller_if_needed) ? $item->picklist_stuller_if_needed[0] : $item->picklist_stuller_if_needed, $item->picklist_item_if_needed);  
            // dd($pick_list_charges);
            // dd($item->picklist_quantity_if_needed, $item->picklist_stuller_if_needed, $item->picklist_item_if_needed);
            # total(labor_retail + metarial_retail);
            $labor_retail = $setting_charges + $soldering_charges;
            if($request->check_and_tighten_enabled)
            {
                $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
                $labor_retail += $charges;
            }
            $express_retail = $request->is_rush ? ($labor_retail/2) : 0;
            $picklist_total = (array_key_exists('total',$pick_list_charges) ? $pick_list_charges['total'] :0);
            $rhodium_charges  = array_key_exists($this->chapter,$request->is_rhodium)?
                                ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                \Config::get('gellerbook.rhodium_charges') : 0):0;
            $grand_total = sprintf('%0.2f', round($part_retail+$labor_retail+$express_retail+$rhodium_charges+$picklist_total)) ;   
            # add job history and bind jeweler to it.
            $service_id = bin2hex(random_bytes(8));
            $item_data                     = [
                'id'                       => $item->id,
                'geller_sku'               => $item->geller_sku,
                'major_item'               => $item->major_item,
                'total'                    => $grand_total,
                'is_actual'                => true,
                'is_rhodium'               => array_key_exists($this->chapter,$request->is_rhodium)?
                                            ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                            true : false):false,
                'is_rush'                  => $request->is_rush,
                'pick_list_charges'        => $picklist_total,
                'pick_list'                => $pick_list_charges,
                'soldering_charges'        => $soldering_charges,
                'setting_charges'          => $setting_charges,
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
    
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 400 product.', $service_detail);    
            // }catch(Exception $e){
    
            //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
    
            // }
        
    }
}
