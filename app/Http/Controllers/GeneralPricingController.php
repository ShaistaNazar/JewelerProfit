<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralPricingRequest;
use App\Models\Chapter300;
use App\Models\favoriteSKU;
use App\Models\JobHistory;
use App\Models\SKU;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class GeneralPricingController extends Controller
{

    # api to preserve SKU
    public function preserveSKU(GeneralPricingRequest $request)
    {
        try{

            $sku = SKU::create([
                'sku' => $request->sku,
                'shop_id' => $request->shop_id
            ]);
            if($sku){
                return $this->APIResponse(config('response_codes.OK'), 'Successfully returned menu details', $sku);
            }else{
                return $this->APIResponse(config('response_codes.Internal Server Error'), 'Error in preserving SKU.');
            }

        }catch(Exception $exception){
            return $this->APIResponse(config('response_codes.Internal Server Error'), $exception->getMessage());
        }
    }

    # API to add sku to favourites
    public function favoriteTheSKU(GeneralPricingRequest $request)
    {
        try
        {
            $favorite_sku = favoriteSKU::create([
                'sku' => $request->sku,
                'shop_id' => $request->shop_id
            ]);
            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned menu details', $favorite_sku);
        }
        catch(Exception $exception)
        {
            return $this->APIResponse(config('response_codes.Internal Server Error'), $exception->getMessage());
        }
    }

    # API to get Next Options dynamically.
    public function getNextOptions(GeneralPricingRequest $request)
    {
        //  dd($request->all());
        # code...
        // try{
            $model_class = getModelByChapter($request->chapter);
            // dd($model_class,$request->all());
            $table_name = $model_class::getTableName();
            $set_checkbox = false;
            $next_options = [];
            
            if(isset($request->next_selection))
            {
                $options = $model_class::query();
                // $options = $options->where('major_item','Rings')->where('type',' Engagement Ring ');
                // dd($options->pluck('shape'));
                // dd($options->where('geller_sku','1058')->get());
                ;
                if(isset($request->previous_selections) && is_array($request->previous_selections))
                {
                    // welding technology
                    // just 4 items have welding tech associated in one sheet and should show.
                    TODO://reviewable as thsi can controlled from frontend by checking current flow if welding
                    if($request->next_selection == 'welding_technology')
                    {
                        // chapter 900 would be handled accordingly.
                        return $this->APIResponse(config('response_codes.OK'), 'welding technology passed and chapter is having welding technology associated', -1);
                    }
                    foreach($request->previous_selections as $key => $value) 
                    {
                        if($request->chapter == '900')
                        {
                            if($key !== 'no_of_price_criteria_item' && $key !== 'popup' && $key !== 'require_weight_popup' && $key !=="complication_surcharge_selected")
                            // if price criteria item comes at the end then its not needed but if it comes earlier its needed.
                            {
                                if($key == 'color')
                                {
                                    $options->where(
                                        function ($query) use ($value) {
                                        return $query
                                        ->where('color','both')->orWhere('color',$value);
                                    });
                                }else{
    
                                    $options->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $value).'%']);
                                }
                            }
                        }
                        else
                        {
                            if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology' && $key !== 'popup' && $key !== 'require_weight_popup'
                            && $key !=="complication_surcharge_selected")
                            // if price criteria item comes at the end then its not needed but if it comes earlier its needed.
                            {
                                if($key == 'color')
                                {
                                    $options->where(
                                        function ($query) use ($value) {
                                        return $query
                                        ->where('color','both')->orWhere('color',$value);
                                    });
                                }else{
    
                                    $options->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $value).'%']);
                                }
                            }
                        }
                       
                    }
                    // now checking if having welding technology
                    // dd($options->get());
                }
                
                // rule
                if($request->next_selection != 'picklist_item_if_needed')
                {
                    // chapter 500 dont have quantity column but 200 have 
                    // options having quantity column should have quantity field just.
                    if($request->next_selection == 'price_criteria_item')
                    {
                        $quantity = false;
                        $price_criteria_item = [];
                        $response_back = array($request->next_selection => '','quantity' => false);
                        // 500 and 700 has price criterian item
                        if(Schema::hasColumn($table_name, 'price_criteria_item'))
                        {
                            $price_criteria_item = $options->distinct()->pluck($request->next_selection);
                            $response_back[$request->next_selection] = $price_criteria_item;
                        }
                        // chapter 1200 have
                        if(Schema::hasColumn($table_name, 'quantity')) // 500 doesnt have ,so not show quantity field but 200 have
                        // if we have not quantity column
                        {
                            $have_quantity_or_not = $options->distinct()->pluck('quantity');
                            // dd($have_quantity_or_not);
                            if(count($have_quantity_or_not) > 0 && $have_quantity_or_not[0] == 1) // quantity column has correspoding quantity set
                            $quantity = true;
                            else
                            $quantity = false;
                            $response_back['quantity'] = $have_quantity_or_not;
                        }
                        if($table_name == 'chapter1200pricing' && count($options->distinct()->pluck('welding_technology')) == 2) 
                        {
                            $welding_technology_exist_or_not = $options->distinct()->pluck('welding_technology');
                            $response_back['welding_technology'] = $welding_technology_exist_or_not;
                        }
                        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned next option to ask.', $response_back);
                    }
                    else
                    {
                        // interlink handling for 1200
                        $interlink_quantity = false; $interlink_added = false;
                        if(Schema::hasColumn($table_name, 'optionable'))
                        {
                            // dd(Schema::hasColumn($table_name, 'optionable'));
                            // if($request->chapter == '1200')
                            // {
                                // if($request->next_selection !== 'major_item')
                                // {
                                    $options = $options->where('optionable',1)->distinct();
                                    // dd($options->get());
                                // }
                            // }else{
                                // $options = $options->where('optionable',1)->distinct();
                            // }
                        }
                        else
                        {
                            // if(isset($request->discarded_item))
                            // {
                            //     dd('discarded otem',$options->where('major_item','<>',$request->discarded_item)->distinct()->get()->toArray());
                            //     $options = $options->where('major_item','<>',$request->discarded_item)->distinct();
                            // }
                            // else{
                            //     dd('not hitting discarded');
                                $options = $options->distinct();
                            // }
                        }
                        // dd($options->get()->toArray());
                        // below is for chapter 1200 having few items in category interlinked quantity
                        // if(Schema::hasColumn($table_name, 'interlinked_options'))
                        // {
                        //     $temp_options = clone $options;
                        //     $interlink_quantity_exists = $temp_options->whereNotNull('interlinked_options')
                        //                                     ->pluck('interlinked_options')->toArray();
                        //     if($interlink_quantity_exists && count(array_unique($interlink_quantity_exists)) === 1 
                        //     && $interlink_quantity_exists[0] == $request->next_selection) 
                        //     {
                        //         $interlink_quantity = $interlink_quantity_exists[0];
                        //         $interlink_added = true;
                        //         if(Schema::hasColumn($table_name, 'required_interlink_quantity'))
                        //         {
                        //             $required_interlink_quantity_exists = $temp_options->whereNotNull('required_interlink_quantity')
                        //             ->where('required_interlink_quantity',1)->pluck($interlink_quantity )->toArray();
                        //             if($required_interlink_quantity_exists) 
                        //             {
                        //                 $interlink_quantity_for_individual_items = $required_interlink_quantity_exists;
                        //             }
                        //         }
                        //     }
                        // }
                        // identical items having difference of welding technology 
                        TODO2:// commenting due to test purpose
                        // if(count($options->get()) == 2 && 
                        // $request->next_selection == 'welding_technology' && 
                        // Schema::hasColumn($table_name, 'welding_technology'))
                        // {                                         
                        //     $value_array = $options->get()->toArray();
                        //     $first_record = $value_array[0];
                        //     $second_record = $value_array[1];
                        //     $array_difference = array_diff_assoc($first_record,$second_record);
                        //     if(count($array_difference) == 1)
                        //     {
                        //         if(array_key_exists('welding_technology',$array_difference))
                        //         {
                        //             $options = $options->where('welding_technology',trim($value));
                        //         }
                        //     }
                        // }
                        // dd($options->get());
                        // dd('hi',$request->previous_selections['type'],str_contains(strtolower($request->previous_selections['type']),strtolower('two tone')));
                        if($request->next_selection == 'ring_size' && $request->chapter == '100')
                        {
                            // dd($options->get());

                            // dd(str_contains(strtolower($request->previous_selections['major_item']),strtolower('rings')));
                            if($request->previous_selections && array_key_exists('major_item',$request->previous_selections) &&
                            str_contains(strtolower($request->previous_selections['major_item']),strtolower('rings')))
                            {
                                $should_sizing_options_to_show = $options->pluck('first_size_larger')->toArray();
                                // dd(current(array_filter($should_sizing_options_to_show)));

                                if(!empty($should_sizing_options_to_show) && current(array_filter($should_sizing_options_to_show))  && 
                                current(array_filter($should_sizing_options_to_show)) !== '')
                                {
                                    $next_options = Config::get('gellerbook.ring_sizes');
                                }
                                else
                                {
                                    $next_options = [];
                                }
                                // dd($options->get()->toArray());
                                // if(count($options->whereNotNull('first_size_larger')->where('first_size_larger','!=','')->get()) > 0)
                            }
                        }
                        else if($request->previous_selections && array_key_exists('type',$request->previous_selections) && $request->next_selection == 'karats' &&
                        str_contains(strtolower($request->previous_selections['type']),strtolower('two tone')) && $request->chapter == '100')
                        {
                            $next_options = Config::get('gellerbook.available_karats');
                            $set_checkbox = true;
                            // specify interlinked quantity
                            // return $this->APIResponse(config('response_codes.OK'), 'Successfully returned next option to ask.', array($request->next_selection => $surcharges));
                        }
                        else if($request->chapter == '1100' && $request->next_selection == 'complication_surcharge' && 
                        (str_contains(strtolower($request->previous_selections['major_item']),'battery')))
                        {
                            $temp_options = $model_class::query();
                            $next_options = $temp_options->where('complication_surcharge',1)->pluck('description');
                            $set_checkbox = true;
                        }
                        else
                        {
                            // dd($options->get()->toArray());
                            $next_options = $options->whereNotNull($request->next_selection)
                            ->where($request->next_selection,'<>','');
                            // dd($options->get());
                            if(isset($request->discarded_item)) // handling discarded item
                            {
                                $next_options = $next_options->where($request->next_selection,'<>',$request->discarded_item);
                            }
                            $next_options = $next_options->pluck($request->next_selection);
                            // dd($next_options->);
                            // dd(json_decode($next_options[0],false));
                            // if(count($next_options) == 1)
                            // {}
                            // array of array
                        }
                        // dd($next_options);
                        // $next_options = $model_class::trimOptions($next_options->toArray());
                        if($set_checkbox)
                        {
                            // dd('entered');
                            $checkbox_array = [];
                            for($checkbox_element = 0; $checkbox_element< count($next_options); $checkbox_element++)
                            {
                                $checkbox_array[$next_options[$checkbox_element]] = false;
                            }
                            // dd('h',$checkbox_array);
                            $next_options = $checkbox_array;
                        }

                        // chapter 1200 have
                        //  if(Schema::hasColumn($table_name, 'main_quantity') && $request->next_selection == 'main_quantity') // 500 doesnt have ,so not show quantity field but 200 have
                        //  if we have not quantity column
                        // {
                        //     if($options[0] && $options[0] == 1) // quantity column has correspoding quantity set
                        //     $quantity = true;
                        //     else
                        //     $quantity = false;
                        //     $response_back['quantity'] = $options;
                        // }
                        // dd($request->all());

                        if($request->chapter == '1200' && $request->next_selection == 'extra_work_per_appraisal' && 
                        (str_contains(strtolower($request->previous_selections['major_item']),'appraisals') &&
                        !(str_contains(strtolower($request->previous_selections['type']),'update'))))
                        {
                            $interlink_quantity_for_individual_items = $options->where('required_interlink_quantity', 1)->pluck($request->next_selection);
                            // dd($required_interlink_quantity);
                            $add_ons = [];
                            for($appraisal_no = 1; $appraisal_no<= $request->no_of_appraisals; $appraisal_no++)
                            {
                                $appraisals = [];
                                $appraisals["appraisal_$appraisal_no"] = [];
                                foreach ($next_options as $add_on) 
                                {
                                    $appraisals["appraisal_$appraisal_no"][$add_on] = false;
                                }
                                $add_ons["appraisal_$appraisal_no"] = $appraisals["appraisal_$appraisal_no"];
                            }
                            // specify interlinked quantity
                            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned next option to ask.', array($request->next_selection => $add_ons,
                            'interlink_quantity_for_individual_items' => $interlink_quantity_for_individual_items));
                            // dd($add_ons);
                        }
                        // else if()
                        // {
                        //     $surcharges = [];
                        //     for($surcharge = 0; $surcharge< count($next_options); $surcharge++)
                        //     {
                        //         $surcharges[$next_options[$surcharge]] = false;
                        //     }
                        //     // specify interlinked quantity
                        //     return $this->APIResponse(config('response_codes.OK'), 'Successfully returned next option to ask.', array($request->next_selection => $surcharges));
                        //     // dd($add_ons);
                        // }
                        else
                        {
                            // dd($next_options);
                            $options = $next_options;
                            // dd($options);
                            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned next option to ask.', array($request->next_selection => $options));
                        }
                    }
                }
                else
                {
                    // dd($options->get());
                    $options = $options->pluck('picklist_stuller_if_needed');
                    // dd($options[0][0]);
                    if(is_array($options[0]))
                    {
                        if($options[0][0] && $options[0][0] !== '')
                        {
                            return $this->APIResponse(config('response_codes.Accepted'), 'picklist exists', array());    
                        }
                        else return $this->APIResponse(203, 'picklist does not exist');                                
                    }
                    else
                    {
                        if(count($options) > 0 && $options[0] != null && $options[0] !== '')
                        {
                            return $this->APIResponse(config('response_codes.Accepted'), 'picklist exists', array());    
                        }
                        else return $this->APIResponse(203, 'picklist does not exist');                                
                    }
                }
            }
            else
            {
                if(isset($request->geller_sku))
                {
                    $chapter_item = $model_class::where('geller_sku',$request->details['geller_sku'])->first();
                    if($chapter_item->picklist_item_if_needed)
                    {
                        return $this->APIResponse(config('response_codes.Accepted'), 'picklist exists', array());    
                    }
                    else
                    {
                        return $this->APIResponse(203, 'picklist does not exist');                                
                    }
                }
                else
                {
                    return $this->APIResponse(203, 'next selection does not exists.',array());
                }
                return $this->APIResponse(203, 'next selection does not exists.',array());
            }
            // }
            return $this->APIResponse(config('response_codes.Internal Server Error'), 'something went wrong');
        // }catch(Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage(), null);
        // }
    }

     /**
     * confirmTheJob API , will called after price generation
     */
    
    public function confirmTheJob(GeneralPricingRequest $request)
    {
        //  try
        //  dd(($request->details['geller_sku'].'')[0]);
        //  getting dynamic chspter as 'Chapter'.$request->details['geller_sku'][0].'00' means chapter300
        // $model_class = getModelByChapter($request->chapter);
        // dd($request->details);
        // $chapter_item = $model_class::where('geller_sku',$request->details['geller_sku'])->first();
        // dd($request->details);
        $history_data = array_merge($request->details,
        ['envelope_id' => $request->envelope_id],['customer_number' => $request->customer_number]);
        $service_detail = populateModel(new JobHistory,$history_data);
        $service_detail_array = $service_detail->toArray();
        // if($chapter_item->ask_furthur)
        // {
        //     $service_detail_array['ask_furthur'] = $chapter_item->ask_furthur;
        // }
        // else
        // {
        //     $service_detail_array['ask_furthur'] = false;
        // }
        return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 300 product.', $service_detail_array);    
        // }catch(Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());    
        // }
    }

    /**
     * search for sku screen
     */

    public function searchForSKU(GeneralPricingRequest $request)
    {
        try{
           $item_per_sku = Chapter300::where('geller_sku',$request->sku)->first();
           return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 300 product.', $item_per_sku);    
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());    
        }

    }

    /**
     * Get Frequenly used prices
     */

    public function getFrequentlyUsedPrices()
    {        
        try{

            $frenquentused_prices = JobHistory::select('geller_sku', \DB::raw('COUNT(*) as count'))
            ->having('count', '<' , 2)
            ->get();

            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the frequently used prices.', $frenquentused_prices);  
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());    
        }
    }

    # API responsible to get envelope number
    public function getEnvelopeNumbers(GeneralPricingRequest $request)
    {
        // dd($request->all());
        $envelopes_numbers = [];
        for($i = 0;$i<$request->no_of_envelopes;$i++){
            $number = '1-'.rand(10000,99999);
            array_push($envelopes_numbers,$number);
        }
        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the envelope numbers.', $envelopes_numbers);  
    }
     # chapters requiring stone work
    public function GetLinkedChapters()
    {
        # code...

        $stone_chapters = Config::get('gellerbook.chapters_requiring_setting_stone');
        $solder_chapters = Config::get('gellerbook.chapters_requiring_soldering');  
        $finishing_chapters = Config::get('gellerbook.chapters_requiring_fininshing'); 
        $stringing_chapters = Config::get('gellerbook.chapters_requiring_stringing');     
        $heads_and_bezels_chapters = Config::get('gellerbook.chapters_requiring_heads_and_bezels');
        $dependencies_itself = Config::get('gellerbook.dependencies_itself');
        
        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the chapters requiring extra labor', 
        array('stone_chapters' => $stone_chapters,'solder_chapters' => $solder_chapters,
        'finishing_chapters' => $finishing_chapters,'stringing_chapters' => $stringing_chapters,
        'heads_and_bezels_chapters' => $heads_and_bezels_chapters,'dependencies_itself' => $dependencies_itself));

    }
    
    # options of chapters requiring images
    public function GetImageRequiringChapters()
    {
        # code...
        $image_requiring_chapters = Config::get('gellerbook.chapters_requiring_image');     
        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the chapters requiring images', 
        array('image_requiring_chapters' => $image_requiring_chapters));
    }

     # chapters requiring stone work
    public function GetJobChapters()
    {
        # code...
        $job_chapter = config::get('gellerbook.chapters');
        $image_menu_chapters = config::get('gellerbook.image_menu_chapters');
        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the Job chapters.', array('chapters' => $job_chapter,'image_menu_chapters' => $image_menu_chapters));
    }

    
    public function getSalesTax()
    {
        return $this->APIResponse(config('response_codes.OK'), 'successfully Returned SaleTax',salesTax());
    }

}

