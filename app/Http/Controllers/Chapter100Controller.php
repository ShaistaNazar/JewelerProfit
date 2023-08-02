<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Chapter100Request;
use App\Models\DavidPricing\Chapter100;
use App\Models\Setting;
use App\Models\ShopShankDetails;
use Carbon\Carbon;

class Chapter100Controller extends CalculationController
{
    //    This is the cost the inch of 10kt is $37.14. So 10% of that, 
    //    our cost for metal is 10% of $37.14 or  $3.74.. Muiltiply x 3, 
    //    metal retails for $11.22. Add to that the retail labor for one 
    //    size larger (cell “O23”) of $60.00, one size larger retail is $71.00
    //    Then 2 sizes larger is the $60.00 labor plus another $15.00 for the next size
    //    (column :P” (P23). The metal cost is 2 pieces of the $3.74 gold. 
    //    Labor: $60 + $15 = $75.00|| Gold is $11.22 x 2 sizes - $$22.44
    //    $22.44 + 75.00. Retail is now $97.00.

    public $chapter;
    public function __construct()
    {
       $this->chapter = 100;
       parent::__construct();
    }

    public function getPrice(Chapter100Request $request)
    {
        // C2,C3,C4
        // C3 = C2 * value
        // sizing chapter 100
        // price,JLRC,welding technology,1st size larger,each additional,
        // smaller/larger,with/without stones,
        // Stuller Sku for Metal pricing for each size larger
        // Chapter 700-Setting for Solitares
        // % of Stuller Sku for Costing
        // Outside Vendor Cost
        // Superfilt Cost of Jlrc-Installation
        // Vendor Markup For Part-Geller Book Retail
        // Markup for Superfit labor To Install

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
        $quantity_for_envelope       = 1;
        # item itself
        $actual_item                 =  $this->getProceduralItem($this->chapter,1,['no_of_price_criteria_item','size_now','size_to','welding_technology'],
                                        );
        if(array_key_exists('size_now',request()->values[$this->chapter]["procedure_details_1"]['options']) &&
           array_key_exists('size_to',request()->values[$this->chapter]["procedure_details_1"]['options']))
        {
            $size_now = request()->values[$this->chapter]["procedure_details_1"]['options']['size_now'];
            $size_to = request()->values[$this->chapter]["procedure_details_1"]['options']['size_to'];
            $size_difference = $size_now - $size_to;
            if($size_difference < 0)
            //larger
            {
                // dd($item->get());
                $size_difference = floor($size_now) - ceil($size_to);
                $size_difference = abs($size_difference);
                $actual_item = $actual_item->where('smaller_or_larger','larger');
                // dd($actual_item->get());
                if(count($actual_item->get()) == 1)
                {
                    $actual_item = $actual_item->first();
                }
                else
                {
                    // dd('failure case');
                    return $this->APIResponse(config('response_codes.Bad Request'));
                }
                if($actual_item->first_size_larger && $actual_item->first_size_larger != '')
                {
                    //labor
                    $labor_retail += (double)ltrim($actual_item->first_size_larger, '$');
                    $size_difference_for_each_additional_size_JLRC = $size_difference - 1;
                    $labor_retail += $size_difference_for_each_additional_size_JLRC * (double)ltrim($actual_item->each_additional_size_JLRC, '$');
                    // dd($labor_retail);
                    //part
                    for($i = 0; $i < $size_difference ; $i++)
                    {
                        $part_cost += $this->getPartCost($this->chapter,$actual_item->geller_sku,0,0,[],false,'stuller_sku_for_metal_pricing_for_each_size_larger');
                    }
                }                
            }
            else if($size_difference > 0)
            // smaller
            {      
                $actual_item = $actual_item->where('smaller_or_larger','like', '%' . 'smaller' . '%');
                // dd($actual_item->get());
                if(count($actual_item->get()) == 1)
                {
                    $actual_item = $actual_item->first();
                }
                else
                {
                    // dd('5');
                    return $this->APIResponse(config('response_codes.Bad Request'));
                }

            }
        }
        else 
        {
            # handling bad request parameters
            if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) == 1)
            {
                // dd($actual_item->get());
                $actual_item = $actual_item->first();
                // if($actual_item->JLRC && $actual_item->JLRC != '')
                // {
                //     $labor_retail += (double)ltrim($actual_item->JLRC, '$');
                // }
                $part_cost += $this->getPartCost($this->chapter,$actual_item->geller_sku,0,0,[],false,'stuller_sku_for_metal_pricing_for_each_size_larger');
                // dd('landed the case');
            }
            else if($actual_item instanceof \Illuminate\Database\Eloquent\Builder && count($actual_item->get()) > 1)
            {
                // dd('7');
                return $this->APIResponse(config('response_codes.Bad Request'));
            }
        }
        // dd($actual_item);
        if($actual_item->outside_vendor_cost && $actual_item->outside_vendor_cost !== '')
        {
            // dd($actual_item->outside_vendor_cost,$actual_item->vendor_markup_for_part_geller_book_retail);
            $labor_retail += (double)ltrim($actual_item->outside_vendor_cost, '$') * (double)$actual_item->vendor_markup_for_part_geller_book_retail;
        }
        // dd('yes',$labor_retail);
        // dd($actual_item);
        if($actual_item->superfit_cost_of_jlrc_installation && $actual_item->superfit_cost_of_jlrc_installation !== '')
        {
            $labor_retail += (double)ltrim($actual_item->superfit_cost_of_jlrc_installation, '$') * (double)$actual_item->markup_for_superfit_labor_to_install;
        }
        // dd($labor_retail);
        if($actual_item->chapter1200SKUs && $actual_item->chapter1200SKUs !== '')
        {
            // chapter 1200 skus for two tone masking
            $chap1200    = \App::make('App\Http\Controllers\Chapter1200Controller');
            $request     = \App::make('Illuminate\Http\Request');
            // dd($actual_item->chapter1200SKUs);
            $masking_charges   = $chap1200->getPrice($request,$this->chapter,$actual_item->chapter1200SKUs);
            // dd('masking',$masking_charges);
            $labor_retail      += $masking_charges;      
        }
        
        if($actual_item->chapter700 && $actual_item->chapter700 !== '')
        {
            $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
            $request700 = \App::make('App\Http\Requests\Chapter700Request');
            // dd($actual_item->chapter700);
            $setting_charges  += $chap700->getPrice($request700,$this->chapter,$actual_item->chapter700);
            // dd('setting',$masking_charges);
            $labor_retail += $setting_charges;
        }
        // dd($request->check_and_tighten_enabled);
        // dd($this->chapter,null,$request->check_and_tighten_enabled);
        // dd($labor_retail);
        if($request->check_and_tighten_enabled)
        {
            $charges = $this->addCheckAndTightenChrages($this->chapter,null,$request->check_and_tighten_enabled);
            $labor_retail += $charges;
        }
        
        // dd($actual_item->JLRC);
        // overall JLRC
        if($actual_item->JLRC && $actual_item->JLRC != '')
        {
            $labor_retail += (double)ltrim($actual_item->JLRC, '$');
        }
        // dd($part_cost);
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
                'masking_charges'          => $masking_charges,
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
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 100 product.', $service_detail);
    }

    #helper function
    public function evaluateActualItem($actual_item,$chapter,$procedure_number,$labor_retail,$part_cost)
    {
        # code...
        if(request()->values[$chapter]["procedure_details_"+$procedure_number]['options']['size_now'] && 
           request()->values[$chapter]["procedure_details_"+$procedure_number]['options']['size_to'])
        {
            $size_now = request()->values[$chapter]["procedure_details_"+$procedure_number]['options']['size_now'];
            $size_to = request()->values[$chapter]["procedure_details_"+$procedure_number]['options']['size_to'];
            $size_difference = $size_now - $size_to;
            if($size_difference < 0)
            //larger
            {
                // dd($item->get());
                $size_difference = floor($size_now) - ceil($size_to);
                $size_difference = abs($size_difference);
                $actual_item = $actual_item->where('smaller_or_larger','larger');
                // dd(count($actual_item->get()));
                if(count($actual_item->get()) == 1)
                {
                    $actual_item = $actual_item->first();
                }
                else
                {
                    // dd('1');
                    return $this->APIResponse(config('response_codes.Bad Request'));
                }
                $labor_retail += (double)ltrim($actual_item->first_size_larger, '$');
                for($i = 0; $i < $size_difference ; $i++)
                {
                    $part_cost += $this->getPartCost($chapter,$actual_item->geller_sku,0,0,[],false,'stuller_sku_for_metal_pricing_for_each_size_larger');
                }
                // dd($size_difference);
                // dd($actual_item);
                $size_difference_for_each_additional_size_JLRC = $size_difference - 1;
                $labor_retail += $size_difference_for_each_additional_size_JLRC * (double)ltrim($actual_item->each_additional_size_JLRC, '$');
            }
            else if($size_difference > 0)
            // smaller
            {
                $actual_item = $actual_item->where('smaller_or_larger','like', '%' . 'smaller' . '%');
                if(count($actual_item->get()) == 1)
                {
                    $actual_item = $actual_item->first();
                }
                else
                {
                    // dd('2');

                    return $this->APIResponse(config('response_codes.Bad Request'));
                }
            }
        }
    }

    # update cliq shanks
    public function updateCliqShanksCost(Chapter100Request $request)
    {
        $cliq_shanks = $request->cliq_shanks;
        try {

            \DB::beginTransaction();
            foreach($cliq_shanks as $shank)
            {
                Chapter100::where('geller_sku',$shank['geller_sku'])->update($shank);
            }
            // shop()->shop_shank_details()->save($shop_shank_details);
            // dd(shop()->shop_shank_details);
            \DB::commit();
            return $this->APIResponse(config('response_codes.OK'), 'successfully updated cliq shanks.');

        } catch (\Exception $e) {
            //handle your error (log ...)
            \DB::rollBack();
            return $this->APIResponse(config('response_codes.Bad Request'), 'error in updating cliq shanks.');
        }
    }
 
    # update shop shank details
    public function updateShopShankDetails(Chapter100Request $request)
    {

        $shop_shank_details_request = $request->shop_shank_details;
        // dd($shop_shank_details_request);
        try {
        \DB::beginTransaction();
        # code...
        // dd($shop_shank_details_request);
        $require_update_records = false;
        if(!shop()->shop_shank_details)
        {
            $shop_shank_details_default = ShopShankDetails::where('is_default',1)->first();
            $shop_shank_details = ShopShankDetails::create
            (
                [
                    'latest_pricing_date'                        =>  Carbon::now()->toDateString(),
                    'vendor_cost_markup'                         =>  $shop_shank_details_request['vendor_cost_markup'],
                    'vendor_phone_number'                        =>  $shop_shank_details_request['vendor_phone_number'],
                    'is_default' => false,
                    'shop_id' => shop()->id
                ]
            );
            if($shop_shank_details->vendor_cost_markup !== $shop_shank_details_default->vendor_cost_markup)
            {
                $require_update_records = true;
            }
        }
        else
        {
            $shop_shank_details = shop()->shop_shank_details;
            $shop_shank_details->latest_pricing_date = Carbon::now()->toDateString();
            $shop_shank_details->vendor_cost_markup = $shop_shank_details_request['vendor_cost_markup'];
            $shop_shank_details->vendor_phone_number = $shop_shank_details_request['vendor_phone_number'];
            // dd($shop_shank_details->isDirty('vendor_markup_for_part_geller_book_retail'));
            if($shop_shank_details->isDirty('vendor_cost_markup'))
            {
                $require_update_records = true;
            }
            $shop_shank_details->save();
            // dd($shop_shank_details);
        }
        if($require_update_records)
        {
            $cliq_shanks = Chapter100::whereRaw('LOWER(`type`) LIKE ? ',[trim(strtolower('cliq-adjustable')).'%'])
                           ->update(['vendor_markup_for_part_geller_book_retail' => $shop_shank_details['vendor_cost_markup']]);
            // dd(Chapter100::whereRaw('LOWER(`type`) LIKE ? ',[trim(strtolower('cliq-adjustable')).'%'])->get());
        }
        \DB::commit();

        return $this->APIResponse(config('response_codes.OK'), 'successfully updated shop cliq shanks.');
    } catch (\Exception $e) {
        //handle your error (log ...)
        \DB::rollBack();
        return $this->APIResponse(config('response_codes.Bad Request'), 'error in updating cliq shanks.');
    }
    }


    #get Cliq shanks
    public function getCliqShanks()
    {            
        // $cliq_shanks = Chapter100::where(\DB::raw('lower(major_item)'), "ILIKE", '%' . 'cliq-adjustable' . '%')->get();
        // dd($cliq_shanks);
        // $key = 'type';
        // $value = 'Cliq-Adjustable';
        // $cliq_shanks = Chapter100::whereRaw( 'LOWER(`major_item`) ilike ?', array( 'cliq-adjustable' ));
        $cliq_shanks = Chapter100::whereRaw('LOWER(`type`) LIKE ? ',[trim(strtolower('cliq-adjustable')).'%'])->get(['id','geller_sku','major_item','type','size','width','weight',
        'karats','vendor_markup_for_part_geller_book_retail','outside_vendor_cost']);
        // dd($cliq_shanks);
        if(shop()->shop_shank_details)
        {
            $shop_shank_details =  shop()->shop_shank_details;
        }else{
            $shop_shank_details = ShopShankDetails::where('is_default',1)->first();
        }
        if(count($cliq_shanks) > 0)
        {
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the cliq shanks from superfit.', 
            array('cliq_shanks' => $cliq_shanks,'shop_shank_details' => $shop_shank_details));
        }
        else
        {
            return $this->APIResponse(config('response_codes.Not Found'), 'error in getting cliq shanks from superfit.', 
            array('cliq_shanks' => $cliq_shanks,'shop_shank_details' => $shop_shank_details));
        }
    }
}