<?php
namespace App\Http\Controllers;

use App\Models\DavidPricing\Chapter100;
use App\Models\DavidPricing\Chapter1000;
use App\Models\DavidPricing\Chapter200;
use App\Models\DavidPricing\Chapter300;
use App\Models\DavidPricing\Chapter700;
use App\Models\DavidPricing\Chapter900;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


class MasterPriceController extends CalculationController
{
    public $skus_with_precedence;
    public $main_dependency_level;

    function __construct()
    {
        $this->skus_with_precedence = [];
        $this->main_dependency_level = 0;
    }

    public function ChangeMasterPrice(Request $request)
    {
        # code
        // request would be geller sku with price
        // chapter 100
    }

    public function getChapterData()
    {
        // try{
            // dd(request()->all());
            $query_params = request()->filter;
            $chapter = request()->chapter;//100
            $relation_value =  "chapter$chapter";//chapter100
            $model_class = getModelByChapter($chapter);
            $table_name = $model_class::getTableName();
            
            if($query_params && $query_params !== '')
            {
                $details = $model_class::where('is_david',1)
                ->WhereRaw("REPLACE(geller_sku, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                ->orWhereRaw("REPLACE(major_item, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $query_params).'%'])
                ->paginate(10);
            }
            else
            {
                $details =   $model_class::where('is_david',1)->paginate(10);
            }
            $stuller_column = 'stuller_sku';
            if($chapter == '100')
            {
                $stuller_column = 'stuller_sku_for_metal_pricing_for_each_size_larger';
            }
          
            // Loop through each record
            foreach ($details as $record) 
            {
                $part_retail = 0;
                if(Schema::hasColumn($table_name, $stuller_column) && $record->$stuller_column && $record->$stuller_column !== '')
                {
                    if($chapter == '1200')
                    {
                        $setting_charges = 0;
                        $soldering_charges = 0;

                        $part_cost = $this->getPartCost($chapter,$record->geller_sku,0,0,[],$record->id);
                        if($record->sizing_stock_amount && $record->sizing_stock_amount != '')
                        {
                            $part_cost = $part_cost * $record->sizing_stock_amount;
                        }
                        if($record->stuller_additional_part_1 && $record->stuller_additional_part_1 !== '')
                        {
                            $part_cost_of_additional_part_1 = $this->getPriceFromStuller($record->stuller_additional_part_1)['amount'];     
                            $part_cost += $part_cost_of_additional_part_1 * (($record->qty_of_additional_part_1 && $record->qty_of_additional_part_1 !== '') ? $record->qty_of_additional_part_1 : 1);
                        }
                        if($record->stuller_additional_part_2 && $record->stuller_additional_part_2 !== '')
                        {
                            $part_cost_of_additional_part_2 = $this->getPriceFromStuller($record->stuller_additional_part_2)['amount'];
                            $part_cost += $part_cost_of_additional_part_2 * (($record->qty_of_additional_part_2 && $record->qty_of_additional_part_2 !== '') ? $record->qty_of_additional_part_2 : 1);
                            // dd($part_cost_of_additional_part_2 * (($record->qty_of_additional_part_2 && $record->qty_of_additional_part_2 !== '') ? $record->qty_of_additional_part_2 : 1));
                        }
                        # retail(part)
                        $part_retail = $this->getPartRetail($part_cost);
                        if($record->setting_sku && $record->setting_sku != '')
                        {
                            $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                            $request700 = \App::make('App\Http\Requests\Chapter700Request');
                            $setting_charges = $chap700->getPrice($request700,$chapter,$record->setting_sku);
                            $setting_charges = sprintf('%0.2f', round($setting_charges));

                        }
                        if($record->soldering_sku && $record->soldering_sku != '')
                        {
                            $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                            $request900 = \App::make('App\Http\Requests\Chapter900Request');
                            $soldering_charges = $chap900->getPrice($request900,$chapter,$record->soldering_sku);
                            // dd($soldering_charges , $record->qty_to_solder,gettype($soldering_charges),gettype($record->qty_to_solder));
                            $soldering_charges = $soldering_charges * ($record->qty_to_solder && $record->qty_to_solder !== '' ? $record->qty_to_solder : 1);
                            $soldering_charges = sprintf('%0.2f', round($soldering_charges));
                            
                        }  
                        $record->setting_charges = '$'.$setting_charges;
                        $record->soldering_charges = '$'.$soldering_charges;
                    }
                    else if($chapter == '400')
                    {
                        $setting_charges   = 0;
                        $soldering_charges = 0;
                        $qty_to_order = $record->qty_to_order_of_stuller_sku;
                        $part_cost    = $this->getPartCost($chapter,$record->geller_sku) * ($qty_to_order && $qty_to_order != '' ? $qty_to_order : 1);
                        $part_retail  = $this->getPartRetail($part_cost);
                        if($record->setting_sku && $record->setting_sku != '')
                        {
                            $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                            $request700 = \App::make('App\Http\Requests\Chapter700Request');
                            $setting_charges  = $chap700->getPrice($request700,$chapter,$record->setting_sku);
                            $setting_charges = sprintf('%0.2f', round($setting_charges));

                        }
                        if($record->soldering_sku_per_post_or_back && $record->soldering_sku_per_post_or_back != '')
                        {   // soldering sku is per post or back so it can be multiplied further as per number of post or backs
                            // dd($record->soldering_sku_per_post_or_back);
                            $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                            $request900 = \App::make('App\Http\Requests\Chapter900Request');
                            $soldering_charges  = $chap900->getPrice($request900,$chapter,$record->soldering_sku_per_post_or_back);
                            $soldering_charges = sprintf('%0.2f', round($soldering_charges));
                            
                        }  
                        $record->setting_charges = '$'.$setting_charges;
                        $record->soldering_charges = '$'.$soldering_charges;
                    }
                    else if($chapter == '800')
                    {
                        $setting_charges   = 0;
                        $soldering_charges = 0;
                        $part_cost    = $this->getPartCost($chapter,$record->geller_sku);
                        $part_retail  = $this->getPartRetail($part_cost);
                        if($record->setting_sku && $record->setting_sku != '')
                        {
                            $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
                            $request700 = \App::make('App\Http\Requests\Chapter700Request');
                            $setting_charges  = $chap700->getPrice($request700,$chapter,$record->setting_sku);
                            $setting_charges = sprintf('%0.2f', round($setting_charges));
                        }
                        if($record->soldering_sku && $record->soldering_sku != '')
                        {   
                            // soldering sku is per post or back so it can be multiplied further as per number of post or backs
                            // dd($record->soldering_sku);
                            $chap900    = \App::make('App\Http\Controllers\Chapter900Controller');
                            $request900 = \App::make('App\Http\Requests\Chapter900Request');
                            $soldering_charges  = $chap900->getPrice($request900,$chapter,$record->soldering_sku);
                            $soldering_charges = sprintf('%0.2f', round($soldering_charges));
                            
                        }  
                        $record->setting_charges = '$'.$setting_charges;
                        $record->soldering_charges = '$'.$soldering_charges;
                    } 
                    else
                    {
                        // dd('should fall here');
                        $part_cost = $this->getPartCost($chapter,$record->geller_sku,0,0,[],false,$stuller_column);
                        $part_retail = $this->getPartRetail($part_cost);
                        // dd($part_retail);
                    }
                }
                // Add a new column with the corresponding amount
                $part_retail = sprintf('%0.2f', round($part_retail));
                $record->stuller_amount ='$'.$part_retail;
            }
            

            // geller sku
            $master_price = $this->getMasterPrices($chapter);    
            
            return $this->APIResponse(config('response_codes.OK'), null, 
            array('details' => $details,'master_prices' => $master_price)
        );
            
        // }catch(\Exception $e){

        //     return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        // } 
    }
    
    public function revive()
    {
        # code...
        
    }

    public function getMasterPrices($chapter)
    {
        # code...
        $model_class = getModelByChapter($chapter);
        $options     = $model_class::query();
    
        if($chapter  == 100)
        {
            $options     = $options->where('is_master',true)->get(['geller_sku','major_item','JLRC']);
            $options = array(
                'geller_sku'  => $options[0]->geller_sku,
                'major_item'  => $options[0]->major_item,
                'torch_value' => $options[0]->JLRC,
            );
        }
        if($chapter == 200)
        {
            $options     = $options->where('is_master',true)->get(['geller_sku','major_item','JLRC_labor_torch','JLRC_labor_laser']);
            $torch_array = explode("x",$options[0]->JLRC_labor_torch);
            $laser_array = explode("x",$options[0]->JLRC_labor_laser);
            $options = array(
                'geller_sku'  => $options[0]->geller_sku,
                'major_item'  => $options[0]->major_item,
                'torch_value' => $torch_array[0],
                'laser_value' => $laser_array[0],
            );
        }
        if($chapter == 300)
        {
            $options     = $options->where('is_master',true)->get(['geller_sku','major_item','JLRC_labor_torch','JLRC_labor_laser']);
            $torch_array = explode("x",$options[0]->JLRC_labor_torch);
            $laser_array = explode("x",$options[0]->JLRC_labor_laser);
            $options = array(
                'geller_sku'  => $options[0]->geller_sku,
                'major_item'  => $options[0]->major_item,
                'torch_value' => $torch_array[0],
                'laser_value' => $laser_array[0],
            );
        }
        if($chapter == 700)
        {
            $options     = $options->where('is_master',true)->
            get(['geller_sku','major_item','setting_labor_without_discount'])->toArray();
            $newArray = array();
            foreach ($options as $element) {
              $geller_sku = $element["geller_sku"];
              $major_item = $element["major_item"];
              $setting_labor_without_discount = $element["setting_labor_without_discount"];
              $setting_labor_without_discount = explode("x",$setting_labor_without_discount);
              $newArray[$geller_sku] = array(
                "major_item" => $major_item,
                "setting_labor_without_discount" => $setting_labor_without_discount[0]
              );
            }
            $options = $newArray;
        }
        if($chapter == 900)
        {

            $options        = $options->where('is_master',true);
            $cloned_options = clone $options;
            $torch_option   = $cloned_options->where('welding_technology','torch')->first(['geller_sku','major_item','welding_technology','soldering_labor_without_discount']);
            $laser_option   = $options->where('welding_technology','laser')->first(['geller_sku','major_item','welding_technology','soldering_labor_without_discount']);
            // dd($torch_option,$laser_option);
            $torch_array    = explode("x",$torch_option->soldering_labor_without_discount);
            $laser_array    = explode("x",$laser_option->soldering_labor_without_discount);
            // $options = array(
            //     'geller_sku'  => $options[0]->geller_sku,
            //     'major_item'  => $options[0]->major_item,
            //     'torch_value' => $torch_array[0],
            //     'laser_value' => $laser_array[0],
            // );
            $options = array($torch_option->geller_sku =>['major_item'=>'Soldering With Torch','master_price' => $torch_array[0]],
                  $laser_option->geller_sku =>['major_item'=>'Soldering With Laser','master_price' => $laser_array[0]]);
        }
        if($chapter == 1000)
        {
            $options      =  $options->where('is_master',true)->first();
            $options      = array(
                'geller_sku'  => $options->geller_sku,
                'major_item'  => $options->major_item,
                'torch_value' => '$'.$options->retail_labor,
            );
        }
        return $options;
    }

    
    public function change200MasterPrice(Request $request)
    {
        try{
            \DB::beginTransaction();
            $chapter200_products = Chapter200::all();
            foreach($chapter200_products as $product)
            {
                if($product->JLRC_labor_torch && $product->JLRC_labor_laser)
                {
                    $previous_torch_master_number = explode('x',$product->JLRC_labor_torch);
                    $previous_laser_master_number = explode('x',$product->JLRC_labor_laser);
                    $product->JLRC_labor_torch = $request->torch_value.'x'.$previous_torch_master_number[1];
                    $product->JLRC_labor_laser = $request->laser_value.'x'.$previous_laser_master_number[1];
                    // dd($product);
                    $product->save();
                }
            }
            \DB::commit();
        }
        catch(\Exception $e)
        {
            \DB::rollBack();
        }
        // JLRC_labor_laser
    }

   

    public function change300MasterPrice(Request $request)
    {
        try{
            \DB::beginTransaction();
            $chapter300_products = Chapter300::all();
            foreach($chapter300_products as $product)
            {
                if($product->JLRC_labor_torch && $product->JLRC_labor_laser)
                {
                    $previous_torch_master_number = explode('x',$product->JLRC_labor_torch);
                    $previous_laser_master_number = explode('x',$product->JLRC_labor_laser);
                    $product->JLRC_labor_torch = $request->torch_value.'x'.$previous_torch_master_number[1];
                    $product->JLRC_labor_laser = $request->laser_value.'x'.$previous_laser_master_number[1];
                    $product->save();
                }
            }
            \DB::commit();
            return $this->APIResponse(config('response_codes.OK'), 'successfully changed the master prices of chapter 300.');
        }
        catch(\Exception $e)
        {
            \DB::rollBack();
        }
    }

    public function change700MasterPrice(Request $request)
    {
        try
        {
            \DB::beginTransaction();
            foreach($request->data as $sku => $detail)
            {
                $chapter300_products = Chapter700::where('main_dependency_sku',$sku)->get();
                foreach($chapter300_products as $product)
                {
                    if($product->setting_labor_without_discount)
                    {
                        $previous_setting_labor_without_discount = explode('x',$product->setting_labor_without_discount);
                        $product->setting_labor_without_discount = $detail['setting_labor_without_discount'].'x'.$previous_setting_labor_without_discount[1];
                    }
                    if($product->JLRC_without_discount)
                    {
                        $previous_JLRC_without_discount = explode('x',$product->JLRC_without_discount);
                        $product->JLRC_without_discount = $detail['setting_labor_without_discount'].'x'.$previous_JLRC_without_discount[1];
                    }
                    if($product->setting_labor_with_discount)
                    {
                        $previous_setting_labor_with_discount = explode('x',$product->setting_labor_with_discount);
                        $product->setting_labor_with_discount = $detail['setting_labor_without_discount'].'x'.$previous_setting_labor_with_discount[1];
                    }
                    if($product->JLRC_with_discount)
                    {
                        $previous_JLRC_with_discount = explode('x',$product->JLRC_with_discount);
                        $product->JLRC_with_discount = $detail['setting_labor_without_discount'].'x'.$previous_JLRC_with_discount[1];
                    }    
                    $product->save();
                }
            }            
            \DB::commit();
            return $this->APIResponse(config('response_codes.OK'), 'successfully changed the master prices of chapter 300.');
        }
        catch(\Exception $e)
        {
            \DB::rollBack();
        }
    }


    public function change900MasterPrice(Request $request)
    {
        try
        {
            // dd($request->all());
            \DB::beginTransaction();
            foreach($request->data as $sku => $detail)
            {
                $chapter300_products = Chapter900::where('main_dependency_sku',$sku)->get();
                // dd($chapter300_products);
                foreach($chapter300_products as $product)
                {
                    // dd($product->soldering_labor_without_discount);
                    if($product->soldering_labor_without_discount && $product->soldering_labor_without_discount !== '')
                    {
                        $previous_soldering_labor_without_discount = explode('x',$product->soldering_labor_without_discount);
                        // dd($previous_soldering_labor_without_discount);
                        // dd($detail);
                        $product->soldering_labor_without_discount = $detail['master_price'].'x'.$previous_soldering_labor_without_discount[1];
                        // dd($product);
                    }
                    if($product->soldering_labor_with_discount && $product->soldering_labor_with_discount !== '')
                    {
                        $previous_soldering_labor_with_discount = explode('x',$product->soldering_labor_with_discount);
                        $product->soldering_labor_with_discount = $detail['master_price'].'x'.$previous_soldering_labor_with_discount[1];
                    }
                    if($product->JLRC_without_discount && $product->JLRC_without_discount !== '')
                    {
                        $previous_JLRC_without_discount = explode('x',$product->JLRC_without_discount);
                        $product->JLRC_without_discount = $detail['master_price'].'x'.$previous_JLRC_without_discount[1];
                    }
                    if($product->JLRC_with_discount && $product->JLRC_with_discount !== '')
                    {
                        $previous_JLRC_with_discount = explode('x',$product->JLRC_with_discount);
                        $product->JLRC_with_discount = $detail['master_price'].'x'.$previous_JLRC_with_discount[1];
                    }    
                    $product->save();
                    // dd($product);

                }
            }            
            \DB::commit();
            return $this->APIResponse(config('response_codes.OK'), 'successfully changed the master prices of chapter 900.');
        }
        catch(\Exception $e)
        {
            \DB::rollBack();
        }
    }

    public function change1000MasterPrice(Request $request)
    {
        // try
        // {
            // dd($request->all());
            $master_number = (double)ltrim($request->torch_value, '$');
            // \DB::beginTransaction();
            // try{
            // \DB::beginTransaction();
            $chapter200_products = Chapter1000::all();
            foreach($chapter200_products as $product)
            {
                // dd($product);
                if($product->master_applicable)
                {
                    if($product->multiplier_of_master_price && $product->multiplier_of_master_price !== '')
                    {
                        $amount_to_be_updated = $master_number*$product->multiplier_of_master_price;
                        $product->retail_labor = sprintf('%0.2f', round($amount_to_be_updated)) ;        

                    }
                    else
                    {
                        $product->retail_labor = $master_number * 1;
                    }
                    $product->save();                    
                }
            }
                // \DB::commit();
            // }
            // catch(\Exception $e)
            // {
            //     // \DB::rollBack();
            // }         
            // \DB::commit();
            return $this->APIResponse(config('response_codes.OK'), 'successfully changed the master prices of chapter 1000.');
        // }
        // catch(\Exception $e)
        // {
        //     // \DB::rollBack();
        // }
    }

    public function change100MasterPrice(Request $request)
    {
        try
        {
            \DB::beginTransaction();
        # code...
        $master_number     = (double)ltrim($request->torch_value, '$');
        $master_geller_sku = (double)ltrim($request->geller_sku, '$');
        $master_item       = Chapter100::where('geller_sku',$master_geller_sku)->first();
        // dd($master_number);
        $master_item->JLRC = '$'.$master_number;
        $master_item->save();

        // getting item itself
        $this->changeValueAndReturnDepenedencies($request->geller_sku);

        $level = 1;
        $this->main_dependency_level = count($this->skus_with_precedence);
            //   dd($this->main_dependency_level);
            // dd($this->skus_with_precedence);
        foreach ($this->skus_with_precedence as $key => $val) 
        {
            $further_skus = Chapter100::where('main_dependency_sku',$key)->pluck('geller_sku')->toArray();
            // dd(is_array($further_skus),)
            if (is_array($further_skus) && !(empty($further_skus)) && !($level >= $this->skus_with_precedence)) 
            {
                $level = $level + 1;
                $this->changeValueAndReturnDepenedencies($key,$level,$this->skus_with_precedence);
            }
            else
            {   
                continue;
            }
        }

        $grouped_skus = array();
        foreach ($this->skus_with_precedence as $key => $value) {
            if (!isset($grouped_skus[$value])) {
                $grouped_skus[$value] = array();
            }
            $grouped_skus[$value][] = $key;
        }

        $done_arrays = [];
        foreach($grouped_skus as $key => $value)
        {
            // key is group 
            if(!in_array($key,$done_arrays))
            {
               foreach($value as $further_value)
               {
                    $obj = Chapter100::where('geller_sku',$further_value)->first();
                    // dd($obj);
                    if($obj->main_dependency_sku && $obj->main_dependency_sku !== '')
                    {
                        $to_change                 = $obj->main_dependency_title; // to change
                        $to_pick                   = $obj->main_dependency_upon;  // to pick
                        $sku_to_get_amount_from    = $obj->main_dependency_sku;   // to pick
                        $multilplier               = $obj->main_dependency_multiplier;   // to pick
                        $obj_to_get_from           = Chapter100::where('geller_sku',$sku_to_get_amount_from)->first();                    
                        $obj->$to_change           = '$'.((double)ltrim($obj_to_get_from->$to_pick, '$') * $multilplier);
                        $obj->save();
                        if($obj->other_dependency_sku && $obj->other_dependency_sku !== '')
                        {
                            $to_change                 = $obj->other_dependency_title; // to change
                            $to_pick                   = $obj->other_dependency_upon;  // to pick
                            $sku_to_get_amount_from    = $obj->other_dependency_sku;   // to pick
                            $multilplier               = $obj->other_dependency_multiplier;   // to pick
                            $obj_to_get_from           = Chapter100::where('geller_sku',$sku_to_get_amount_from)->first();  
                            $obj->$to_change           = '$'.((double)ltrim($obj_to_get_from->$to_pick, '$') * $multilplier);
                            $obj->save();
                        } 
                    }       
                }
            }
        }
        \DB::commit();
        }
        catch(\Exception $e)
        {
            \DB::rollBack();
        }
    }

    public function changeValueAndReturnDepenedencies($sku_to_change,$level = 1)
    {
        $further_main_skus = Chapter100::where('main_dependency_sku',$sku_to_change)->pluck('geller_sku');
        // if($level == 110)
        // dd($sku_to_change,$further_skus);
        foreach($further_main_skus as $sku)
        {
            if(!array_key_exists($sku,$this->skus_with_precedence))
            {
                $this->skus_with_precedence[$sku] = $level;
            }
        }
        return;
    }
}