<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculationRequest;
use App\Http\Requests\Chapter700Request;
use App\Models\JobHistory;
use App\Http\Controllers\StullerAPIController;
use App\Models\DavidPricing\Chapter100;
use Exception;


class CalculationController extends Controller
{
    public $stuller_controller;
    public $chap700;
    public $request700;

    public function __construct()
    {
        // $this->stuller_controller = new StullerAPIController();
        $this->stuller_controller = \App::make('App\Http\Controllers\StullerAPIController');

    }
    // solder work  
    public function getLaborDetails($chapter,$sku,$labor_formula = null ,$required_stone_work = null ,$required_solder_work = null)
    {

        $model_class = getModelByChapter($chapter);
        $item = $model_class::where('geller_sku',$sku)->first();
        $setting_details = null;
        $soldering_details = null;
        if(!$labor_formula)
        {
            if(isset(request()->welding_technology[$chapter]) && request()->welding_technology[$chapter] == 'laser')
            {
                $labor_formula = $item->JLRC_labor_laser;
            }
            else
            {
                $labor_formula = $item->JLRC_labor_torch;
            }
        }
        $labor_details = $this->getLaborRetailAndCostByFormula($labor_formula);
        // dd($required_stone_work);
        if($required_stone_work)
        {
            $this->chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
            $this->request700 = \App::make('App\Http\Requests\Chapter700Request');
            $setting_details  = $this->chap700->getPrice($this->request700,$chapter);
        }
        return array('labor_retail' => $labor_details['labor_retail'],'labor_cost' => $labor_details['labor_cost'],'setting_charges' => $setting_details);
    }

    public function getLaborRetailAndCostByFormula($labor_formula)
    {
        $labor_parts = explode("x", $labor_formula);
        # retail(labor);
        // print_r($labor_parts);
        $labor_retail = $this->getLaborRetail($labor_parts);
        # cost(labor);
        $labor_cost = $this->getLaborCost($labor_retail);
        return array('labor_cost' => $labor_cost,'labor_retail' => $labor_retail);
    }

    public function getPartDetails($chapter,$sku,$no_of_price_criteria_items = null)
    {
        # note: sometimes part cost is per stone and 
        # code...
        # cost(part);
        $model_class = getModelByChapter($chapter);
        $item = $model_class::where('geller_sku',$sku)->first();
        $part_cost = $this->getPartCost($chapter, $sku);
        // dd($part_cost);
        // dd($item);
        $quantity = (($item->stuller_sku  && $item->stuller_sku !== '') ? 
        (($no_of_price_criteria_items && $no_of_price_criteria_items !== '') ? $no_of_price_criteria_items : 1)
        : 1);
        // dd($quantity);
        $total_part_cost = $part_cost * $quantity;
        # retail(part);
        $part_retail = $this->getPartRetail($total_part_cost); 
        return array('part_retail' => $part_retail,'part_cost' => $part_cost,'total_part_cost' => $total_part_cost);
    }
     
    public function getPicklistCharges($quantity, $stuller, $picklist_item)
    {
        $stuller_product     = $this->getPriceFromStuller($stuller,!$picklist_item || $picklist_item == '' ? true : false);
        $pick_list_part_cost = $stuller_product['amount'];
        $picklist_item       = $stuller_product['description'];
        // dd($pick_list_part_cost , $quantity);
        $pick_list_amount = round($pick_list_part_cost * $quantity); 
        return array(
            'name' => strtoupper($picklist_item),
            'quantity' => $quantity,
            'total' => $pick_list_amount,
            'stuller_sku' => $stuller
        );
    }
 
    public function getPriceFromStuller($stuller, $picklist_name_needed = false)
    {
        # code ...
        if($stuller != "" || (is_array($stuller) && $stuller[0] !== ''))
        {
        
            // echo "\n";
            // echo "$stuller";
            // echo "\n";
            // dd($stuller);
            // if($stuller && )
            if($this->stuller_controller == null)
            {
                $this->stuller_controller = \App::make('App\Http\Controllers\StullerAPIController');
            }
            $product = $this->stuller_controller->getStullerProductsBySKU($stuller);
            // dd($product);
            if(array_key_exists('Products',json_decode(json_encode($product),true)['original']['data']))
            {
                $product = json_decode(json_encode($product),true)['original']['data']['Products'][0];

                if(array_key_exists('Price',$product))
                {
                    $amount_from_stuller = $product['Price']['Value'];
                    $description_from_stuller = $product['Description'];
                    return array('amount' => $amount_from_stuller,'description' => $description_from_stuller);
                }
                else
                {
                    return array('amount' => 0,'description' => 'inactive product');
                }
            }
            else // item went inactive
            {
                return array('amount' => 0,'description' => 'inactive product');
            }
            
        }
    }
    
    ###
    # ideal: get amount from stuller and add dependent stuller in to. 
    # if item stuller doesnot exists:
    #    check for dependent parts stuller and quantity and multiply it to get own and dependents
    #    check for dependent part sku 
    #    add altogether
    ###
    
    public function getPartCost($chapter,$sku,$part_cost = 0,$node = 0,$comparative_percentage_to_sku = [],$id_passed = false,$default_name = 'stuller_sku')
    {      
        // echo 'chapter--------';
        // echo "\n";
        // print_r($chapter);
        // echo "\n";   
        # appraoch 2 : when dependent items have just picklist items;
        $chapter_model = getModelByChapter($chapter);
        // $geller_item = $chapter_model::where('geller_sku',$sku)->first();
        // dd($sku);
        // dd($id_passed);
        // dd($chapter_model::where('geller_sku',$sku)->get());
        $geller_item = $id_passed ? $chapter_model::where('id',$id_passed)->first() : $chapter_model::where('geller_sku',$sku)->first();
        // dd($geller_item);
        // dd(is_array($geller_item->$default_name));
        if($node == 0 && $geller_item->comparative_percentage_to_sku)
        {
            $comparative_percentage_to_sku = $geller_item->comparative_percentage_to_sku;
        }
        if($geller_item->$default_name && is_array($geller_item->$default_name))
        {
            foreach($geller_item->$default_name as $sku)
            {
                // dd($sku);
                if($sku != "")
                {
                    // dd($sku);
                    $part_cost += $this->getPriceFromStuller($sku)['amount'];   
                    // dd($part_cost);
                    // echo 'part_cost--------';
                    // echo "\n";
                    // print_r($part_cost);
                    // echo "\n";
                    if($geller_item->part_cost_note && $geller_item->part_cost_note != "" )
                    {
                        $part_cost = $this->getPartCostNote($geller_item->part_cost_note,$part_cost,$chapter);
                    }    
                }
            }
        }
        if($node == 0 && $geller_item->dependent_part_stuller_if_needed && 
           $geller_item->dependent_part_stuller_if_needed !== '')
        {
            $dependent_cost = $this->getDependentPartStullerAmount($geller_item->dependent_part_stuller_if_needed)*
           (($geller_item->dependent_part_quantity_if_needed && 
           $geller_item->dependent_part_quantity_if_needed > 0) ? 
           $geller_item->dependent_part_quantity_if_needed : 1);
           if($geller_item->dependent_part_cost_note && $geller_item->dependent_part_cost_note != "" )
            {        
                // echo "1===1";
                $part_cost += $this->getPartCostNote($geller_item->dependent_part_cost_note,$dependent_cost,$chapter);
            }
        }
        # being commented due to testing purposes for 200

        // else{
        //     // echo "\n";
        //     // echo "========================by2============================";
        //     // print_r($geller_item->$default_name);
        //     if($geller_item->$default_name[0] != ""){
        //         $part_cost += $this->getPriceFromStuller($geller_item->$default_name)['amount'];
        //     }
        // }

        # this is 0 for parent and "something" for chillds  # for for figure 8 and barrel clasps
        # 1. part cost is zero
        if(is_array(json_decode($geller_item->dependent_part_skus)) && count(json_decode($geller_item->dependent_part_skus)) > 0){
            foreach (json_decode($geller_item->dependent_part_skus) as $dependent_sku) {
                $node = 1;
                // echo "1===";
                // echo "\n";
                // echo "dependent_part_skus > ";
                // print_r(json_decode($geller_item->dependent_part_skus));
                // echo "\n";
                // echo "dependent_part_skus part cost";
                // print_r($this->getPartCost($chapter,$dependent_sku,$part_cost = 0,$node,$comparative_percentage_to_sku));
                $part_cost += $this->getPartCost($chapter,$dependent_sku,$part_cost = 0,$node,$comparative_percentage_to_sku);
                $node = 2;
                # find clasp
                # check if dependent_part_stuller_if_needed exists
                # check if dependent_part_skus exists , if so call it again recusrsively
            }
            # 2. part cost has some value which will be zero in recusrive flow
        }
        if($node == 1){
            if($comparative_percentage_to_sku && !empty($comparative_percentage_to_sku))
            $part_cost = $this->addComparativePercentageAmountToSKU($part_cost, $comparative_percentage_to_sku);
        }
        return $part_cost;
    }

    public function getPartCostNote($part_cost_note,$part_cost,$chapter)
    {
        
        # code...
        switch ($chapter) {
            case 300:
                $part_cost_note_formula = preg_split("/[()*\/]+/", $part_cost_note);
                $part_cost = ($part_cost/(int)$part_cost_note_formula[2])*(int)$part_cost_note_formula[3];
                break;
            case 200:
                $part_cost_note_formula = preg_split("/[()%\/]+/", $part_cost_note);
                if($part_cost_note_formula[0] && $part_cost_note_formula[0] !== '')
                $part_cost = ($part_cost_note_formula[0]/100)*$part_cost;
                break;
            case 100:
                if($part_cost_note == '10%x')
                {
                    $part_cost = (10/100)*$part_cost;
                }else if($part_cost_note == '12%x')
                {
                    $part_cost = (12/100)*$part_cost;
                }else if($part_cost_note == '75%x')
                {
                    $part_cost = (75/100)*$part_cost;
                }else if($part_cost_note == '20%x')
                {
                    $part_cost = (20/100)*$part_cost;
                }else if($part_cost_note == '33%x')
                {
                    $part_cost = (33/100)*$part_cost;
                }else if($part_cost_note == '60%x')
                {
                    $part_cost = (60/100)*$part_cost;
                }else if($part_cost_note == '90%x')
                {
                    $part_cost = (90/100)*$part_cost;
                }else if($part_cost_note == '57%x')
                {
                    $part_cost = (57/100)*$part_cost;
                }else if($part_cost_note == '100%x')
                {
                    $part_cost = (100/100)*$part_cost;
                }else if($part_cost_note == '40%x')
                {
                    $part_cost = (40/100)*$part_cost;
                }else if($part_cost_note == '180%x')
                {
                    $part_cost = (180/100)*$part_cost;
                }else if($part_cost_note == '125%x')
                {
                    $part_cost = (125/100)*$part_cost;
                }else if($part_cost_note == '160%x')
                {
                    $part_cost = (160/100)*$part_cost;
                }else if($part_cost_note == '15%x')
                {
                    $part_cost = (15/100)*$part_cost;
                }else if($part_cost_note == '79%x')
                {
                    $part_cost = (79/100)*$part_cost;
                }else if($part_cost_note == '235%x')
                {
                    $part_cost = (235/100)*$part_cost;
                }else if($part_cost_note == '65%x')
                {
                    $part_cost = (65/100)*$part_cost;
                }else if($part_cost_note == '200%x')
                {
                    $part_cost = (200/100)*$part_cost;
                }else if($part_cost_note == '135%x')
                {
                    $part_cost = (135/100)*$part_cost;
                }
                break;
            case 1200:
                if($part_cost_note == '3%x')
                {
                    $part_cost = (3/100)*$part_cost;
                }
                else if($part_cost_note == '6%x')
                {
                    $part_cost = (6/100)*$part_cost;
                }
                else if($part_cost_note == '12%x')
                {
                    $part_cost = (12/100)*$part_cost;
                }
                else if($part_cost_note == '50%x')
                {
                    $part_cost = (50/100)*$part_cost;
                }
                else if($part_cost_note == 'x/150')
                {
                    $part_cost = ($part_cost/150);
                }
                else if($part_cost_note == 'x/151')
                {
                    $part_cost = ($part_cost/151);
                }
                else if($part_cost_note == 'x/152')
                {
                    $part_cost = ($part_cost/152);
                }
                else if($part_cost_note == 'x/153')
                {
                    $part_cost = ($part_cost/153);
                }
                else if($part_cost_note == '2%x')
                {
                    $part_cost = (2/100)*$part_cost;
                }
                else if($part_cost_note == '2%x')
                {
                    $part_cost = (2/100)*$part_cost;
                }
                else if($part_cost_note == '30%x')
                {
                    $part_cost = (30/100)*$part_cost;
                }else if($part_cost_note == '50%x')
                {
                    $part_cost = (50/100)*$part_cost;
                }else if($part_cost_note == '150%x')
                {
                    $part_cost = (150/100)*$part_cost;
                }
        }
        return $part_cost;
    }

    # helper function responsible to add comparative amount to current amount
    public function addComparativePercentageAmountToSKU($part_cost,$comparative_percentage_to_sku=[])
    {   
        if($comparative_percentage_to_sku[0] == "+"){
            $total_with_comparative_amount = $part_cost + ($part_cost*(((double)$comparative_percentage_to_sku[1])/100));
        }else{
            $total_with_comparative_amount = $part_cost*(((double)$comparative_percentage_to_sku[0])/100);
        }
        return $total_with_comparative_amount;
    }

    # helper function responsible to get amount of required item an ddependent ones as well and add it together
    public function getDependentPartStullerAmount($dependent_part_stuller_if_needed){
        $dependent_part_cost = 0;
        // dd($dependent_part_stuller_if_needed);
        // dd($dependent_part_stuller_if_needed);
        if(is_array($dependent_part_stuller_if_needed) && count($dependent_part_stuller_if_needed) > 0){
            foreach ($dependent_part_stuller_if_needed as $dependent_stuller) {
                
                $dependent_part_cost +=  $this->getPriceFromStuller($dependent_stuller)['amount'];
            }
        }
        return $dependent_part_cost;
    } 

    # helper function responsible to get labor cost.
    public function getLaborCost($labor_retail)
    {
        # code...
        $labor_cost = $labor_retail * (config('gellerbook.labor_cost_percentage')/100);
        return $labor_cost;
    }

    # helper function responsible to get labor retail
    public function getLaborRetail($labor_parts)
    {
        // echo "labor parts";
        // echo "\n";
        // print_r($labor_parts);
        // dd($labor_parts);
        $labor_retail = ltrim($labor_parts[0], '$') * $labor_parts[1];
        return $labor_retail;
    } 
    
    # helper function resonsible to get part retail
    public function getPartRetail($part_cost,$markup = 3)
    {
        # code...
        $part_retail = $markup * $part_cost; 
        return $part_retail;
    }

    # API to add other amount to current calculted item price 
    public function addOtherAmount(CalculationRequest $request)
    {
        # code...
        try{
            // as jewelers have done many jobs on same sku, this will track specific service jeweler have done,
            $job_history = JobHistory::where('geller_sku',$request->sku)
                                     ->where('jeweler_id',$request->jeweler_id)
                                     ->where('service_id',$request->service_id)
                                     ->first();
            $job_history->other_cost = $request->other_cost;
            $job_history->other_retail = $request->other_retail;
            $job_history->other_note = $request->note;
            $job_history->total_with_others = $job_history->grand_total + ((double)($request->other_cost) + (double)($request->other_retail));
            $job_history->grand_total = $job_history->grand_total + ((double)($request->other_cost) + (double)($request->other_retail));
            $job_history->save();
            // total_with_others
            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned menu details.', $job_history);
           
        }catch(Exception $exception){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $exception->getMessage());
        }
    }

    # getProceduralItem
    public function getProceduralItem1($chapter,$index,$prohibited_keys)
    {
        // dd(request()->all());
        # code...
        $model_class = getModelByChapter($chapter);
        $item = $model_class::query();
        foreach (request()->values[$chapter]["procedure_details_$index"]['options'] as $key => $value)
        {
            if(!(in_array($key,$prohibited_keys)))
            {
                $item = $item->where('major_item','Rings')

                ->where('type','Generic')->where('karats','14kt')->where('size','3mm')
                ->where('welding_technology','toRch                                                     ');
                // "major_item" => "Rings"
                // "type" => "Generic"
                // "description" => "Shrink"
                // "karats" => "14kt"
                // "size" => "3mm"
                // "color" => "Yellow"
                // "welding_technology" => "torch"
                // "silver_stone_specification" => "Without Stones"
                // $item->where('color')
            }
            if($key == 'color')
            {
                $item->where('color','both')->orWhere('color',$value);
            }
        }
        return $item;
    }

    # getProceduralItem 
    public function getProceduralItem($chapter,$index,$prohibited_keys,$conditional_values = [])
    {
        # code...
        $model_class = getModelByChapter($chapter);
        $item = $model_class::query();
        
        // $item->whereRaw("REPLACE(`major_item`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', 'Check & Tighten Stones').'%']);
        // $item = $item->where('major_item','Check & Tighten Stones');
        // return $item;
        // $result=Chapter100::OrderBY('id','desc');
        // dd(request()->all());
        foreach (request()->values[$chapter]["procedure_details_$index"]['options'] as $key => $value)
        {
            // if(!empty($conditional_values))
            // {
                // dd($prohibited_keys);
                if(!in_array($key,$prohibited_keys))
                {
                    // echo $key;
                    if($key == 'color')
                    {
                        $item->where(
                            function ($query) use ($value) {
                              return $query
                              ->where('color','both');
                        });
                    }
                    else
                    {
                        $item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", [str_replace(' ', '', $value)]);
                    }
                }
            // }
            // else
            // {
                // if($key !== 'major_item' && ($key == 'extra_work_per_appraisal' && $request->values[$this->chapter]['type'] == 'New Appraisals'))
                // {
                //     break;
                // }
                // else
                // {
                //     $item->where($key,$value);
                // }
            // }
        }
        // dd($result->get());
        return $item;
    }
    public function addCheckAndTightenChrages($chapter,$sku,$check_and_tighten_enabled)
    {
        // dd($chapter,$sku,$check_and_tighten_enabled);
        $check_and_tighten_charges = 0;
        # code...
        $chap700    = \App::make('App\Http\Controllers\Chapter700Controller');
        $request700 = \App::make('App\Http\Requests\Chapter700Request');
        // dd($actual_item->chapter700);
        $response  = $chap700->getPrice($request700,$chapter,$sku,$check_and_tighten_enabled);
        $response_data = json_decode($response->getContent(), true);
        // $response_data              = json_decode($check_and_tighten_charges->data,true);
        // dd($check_and_tighten_charges,$response_data['data']['grand_total']);
        $check_and_tighten_charges                 += $response_data['data']['grand_total'];

        // dd($check_and_tighten_charges);
        return $check_and_tighten_charges;
    }
}