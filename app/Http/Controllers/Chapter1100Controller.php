<?php

namespace App\Http\Controllers;

use App\Models\DavidPricing\Chapter1100;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\EstimatedItem;
use App\Models\JobHistory;

class Chapter1100Controller extends CalculationController
{
    public $chapter;
    public function __construct()
    {
       $this->chapter = 1100;
    }

    public function getPrice(Request $request)
    {

            $labor_formula = null;
            $part_retail = 0;
            $labor_retail = 0;
            $total_with_labor_part = 0;
            $express_total = 0;
            $total_with_picklist_charges = 0;
            $actual_item = Chapter1100::query(); 
            $sum_of_labors = 0;
            $setting_charges = 0;
            $sales_tax = salesTax();
            $service_id = bin2hex(random_bytes(8));
            $first_service_handled = false;
            $price_chart = [];
            $quantity_for_envelope = 1;
            // iterating
            
            foreach ($request->values[$this->chapter]['procedure_details_1']['options'] as $key => $value) 
            {
                if($key !== 'no_of_price_criteria_item' && $key !== 'complication_surcharge_selected')
                {
                    $actual_item->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", [str_replace(' ', '', $value)]);
                }
            }
            // dd($request->all());

            $actual_item = $actual_item->first();
            // dd($actual_item);
            if($actual_item->retail_price && $actual_item->retail_price != '')
            {
                // dd($labor_info);
                if(str_contains(strtolower($actual_item->retail_price),'estimate'))
                {
                    $labor_info = ((double)(ltrim($actual_item->retail_price, '$')));
                    $service_id = bin2hex(random_bytes(8));

                    $item_data                         = [
                    'id'                       => $actual_item->id,
                    'geller_sku'               => $actual_item->geller_sku,
                    'major_item'               => $actual_item->major_item,
                    'total'                    => null,
                    'is_actual'                => true,
                    'is_rhodium'               => null,
                    'vendor_cost'              => null,
                    'is_rush'                  => $request->is_rush,
                    'is_estimated'             => (integer)$actual_item->is_estimated
                    ];

                    array_push($price_chart,$item_data);
                    $service_detail = array(
                    'service_id'                    => $service_id, // this is in simple terms 'order id'
                    'jeweler_id'                    => $request->jeweler_id,
                    'sale_person_id'                => $request->sale_person_id,
                    'grand_total'                   => null,
                    'sales_tax'                     => null,
                    'total_with_sales_tax'          => null,
                    'is_rhodium'                    => null,
                    'is_rush'                       => null,
                    'price_chart'                   => $price_chart,
                    'sales_tax'                     => $sales_tax

                    );
                    return $this->APIResponse(config('response_codes.Accepted'), 'Item is estimate only.',$service_detail);
                }
                else if(str_contains(strtolower($actual_item->retail_price),'to'))
                {
                        $range = explode('to',strtolower($actual_item->retail_price));
                        $newstring = '';
                        foreach($range as $index => $val)
                        {
                            $val = trim($val);
                            $trimmed_val = ((double)(ltrim($val, '$')));
                            $added_val = ((double)$trimmed_val) + $sales_tax;
                        
                            if($index !== 1)
                            {
                                $newstring = $added_val.' to ';
                            }
                            else if($index == 1)
                            {
                                $newstring .= '$'.$added_val;
                            }
                        }
                        $item_data = [
                        'id'                       => $actual_item->id,
                        'geller_sku'               => $actual_item->geller_sku,
                        'major_item'               => $actual_item->major_item,
                        'total'                    => $newstring,
                        'is_actual'                => true,
                        'is_rhodium'               => null,
                        'is_rush'                  => $request->is_rush,
                        'is_estimated'             => (integer)$actual_item->is_estimated
                        ];
                        array_push($price_chart,$item_data);
                        $service_detail = array(
                        'service_id'                    => $service_id, // this is in simple terms 'order id'
                        'other_retail'                  => 0,
                        'other_cost'                    => 0,
                        'jeweler_id'                    => $request->jeweler_id,
                        'sale_person_id'                => $request->sale_person_id,
                        'grand_total'                   => $newstring,
                        'total_with_sales_tax'          => $newstring,
                        'is_rhodium'                    => null,
                        'is_rush'                       => null,
                        'other_notes'                   => null,
                        'price_chart'                   => $price_chart,
                        'sales_tax'                     => $sales_tax
                        );
                    // it should be nit OK some status else
                    return $this->APIResponse(config('response_codes.OK'), 'successfully returned the price of chapter 1100 product.',$service_detail);
                }
                else
                {
                    $labor_retail += ((int)(ltrim($actual_item->retail_price, '$')));
                    $first_service_handled = true;
                }
            }
            
            if($actual_item->chapter1100SKUs && $actual_item->chapter1100SKUs != '')
            {
                if($actual_item->more_percentage_to_SKU && $actual_item->more_percentage_to_SKU != '')
                {
                  $labor_retail += $this->getDataOfChapterItemItself($actual_item->chapter1100SKUs,$actual_item->more_percentage_to_SKU,null);
                }
            }
            // dd($labor_retail);
            // additional charges
            if($request->complication_surcharge)
            {
                foreach ($request->complication_surcharge as $key => $value) 
                {
                    $temp_value = Chapter1100::query(); 
                    if($value)
                    {

                        $additional_item = $temp_value->where('description',$key)->first();
                        if($additional_item)
                        {
                            // echo "---";
                            // print_r(ltrim($additional_item->retail_price, '$'));
                            $labor_retail += ((double)(ltrim($additional_item->retail_price, '$')));
                        }
                    }
                }
            }

            // each additional
            if($actual_item->each_additional && $actual_item->each_additional !== '')
            {
                if(array_key_exists('no_of_price_criteria_item',$request->values[$this->chapter]['procedure_details_1']['options']))
                {
                    if($first_service_handled)
                    {
                        $quantity = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'] - 1;
                    }
                    else
                    {
                        $quantity = $request->values[$this->chapter]['procedure_details_1']['options']['no_of_price_criteria_item'];
                    }
                }
                else
                {
                        $quantity = 1;
                }
                $labor_retail += $this->getDataOfEachAdditional($actual_item->each_additional,$quantity);
            }
            // dd($labor_retail);
            // vendor cost
            $vendor_cost  = $labor_retail / 2;
            $express_total = $request->is_rush ? ($labor_retail/2) : 0;
            $rhodium_charges = array_key_exists($this->chapter,$request->is_rhodium)?
                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                        \Config::get('gellerbook.rhodium_charges') : 0):0;
                        // dd($part_retail,$labor_retail,$express_total,$rhodium_charges);
            $grand_total = sprintf('%0.2f', round($part_retail+$labor_retail+$express_total+$rhodium_charges)) ;   
            // dd($grand_total);
            // dd($part_retail,$labor_retail,$express_total,$rhodium_charges);
            $service_id = bin2hex(random_bytes(8));

            $item_data                         = [
            'id'                       => $actual_item->id,
            'geller_sku'               => $actual_item->geller_sku,
            'major_item'               => $actual_item->major_item,
            'total'                    => (integer)$actual_item->is_estimated ? $grand_total.' or higher' : $grand_total,

            'is_actual'                => true,
            'is_rhodium'               => array_key_exists($this->chapter,$request->is_rhodium)?
                                        ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                        true : false):false,
            'vendor_cost'              => $vendor_cost,
            'is_rush'                  => $request->is_rush,
            'is_estimated'             => (integer)$actual_item->is_estimated,
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
            'total_with_sales_tax'          => (integer)$actual_item->is_estimated ? $grand_total + $sales_tax.' or higher' : $grand_total + $sales_tax,
            'is_rhodium'                    => null,
            'is_rush'                       => null,
            'other_notes'                   => null,
            'price_chart'                   => $price_chart,

            );
            // dd($labor_details_array,$service_detail);
            return $this->APIResponse((integer)$actual_item->is_estimated ? 
            config('response_codes.Accepted') : config('response_codes.OK'), 'successfully returned the price of chapter 1100 product.', $service_detail);

            // }catch(Exception $e){
            //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
            // }        

    }

     #helper function
    public function getDataOfChapterItemItself($chapter1100SKUs,$more_percentage_to_SKU,$each_additional)
    {
        $retail_price = 0;
        $additional_charges = 0 ;
        $dependent_item = Chapter1100::where('geller_sku',$chapter1100SKUs)->first();//more_percentage_to_SKU
        $retail_price = ((double)(ltrim($dependent_item->retail_price, '$')));
        if($dependent_item->price_criteria_item)
        {
            if($dependent_item->each_additional)
            {
                $additional_charges += $this->getDataOfChapterItemItself(null,null,$dependent_item->each_additional);
            }
        }
        $retail_price += $additional_charges;
        $retail_price = $retail_price + $retail_price*($more_percentage_to_SKU/100);
        return $retail_price;
    }

     #helper function
     public function getDataOfEachAdditional($sku,$quantity)
     {
         $dependent_item = Chapter1100::where('geller_sku',$sku)->first();
         $retail_price = ((double)(ltrim($dependent_item->retail_price, '$'))); 
        //  dd($retail_price , $quantity);
         $retail_price = $retail_price * $quantity;        
         return $retail_price;
     }

    # estimateTheProduct
    public function estimateTheProduct(Request $request)
    {
        $estimated_item = EstimatedItem::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'id'                            => $request->id,
        ],[
            'shop_id'                       => shop()->id,
            'vendor_id'                     => $request->vendor_id, 
            'service_id'                    => $request->service_id,
            'envelope_id'                   => $request->envelope_id,
            'date_sent'                     => $request->date_sent,
            'date_received_back_into_store' => $request->date_received_back_into_store,
            'estimated_cost_from'           => $request->estimated_cost_from,
            'estimated_cost_finalized'      => $request->estimated_cost_from,
            'estimated_cost_to'             => $request->estimated_cost_to,
            'retail_price'                  => $request->retail_price,
            'work_to_be_performed'          => $request->work_to_be_performed,
            'customer_approved_or_declined' => $request->customer_approved_or_declined,
            'customer_number'               => $request->customer_number,
            'geller_sku'                    => $request->geller_sku
        ]);   
        return $this->APIResponse(config('response_codes.OK'), 'Successfully returned the frequently used prices.',$estimated_item);  
        
    }

    # getEstimatedItems 
    public function getEstimatedItems (Request $request)
    {
        // dd($request->all());
        # code...
        try{
            $query_params = request()->filter;
            // dd($query_params);
            // dd($query_params);
           if($query_params && $query_params !== '')
           {
            $customers = shop()->estimated_items()
            ->Where('service_id', 'like', '%' . $query_params . '%')
            ->with('vendor')
            ->paginate(4);
           }
           else
           {
            $customers = shop()->estimated_items()->with('vendor')->paginate(4);
           }
            return $this->APIResponse(config('response_codes.OK'), null, $customers);
        }
        catch(\Exception $e)
        {

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }

    #updateEstimate
    public function updateEstimate(Request $request)
    {
        # code...
        try{
            // dd($request->estimated_item['is_rush']);
            // \DB::beginTransaction();
            $estimated_item =                                EstimatedItem::find($request->estimated_item['id']);
            $estimated_item->date_sent                     = $request->estimated_item['date_sent'];
            $estimated_item->date_received_back_into_store = $request->estimated_item['date_received_back_into_store'];
            $estimated_item->retail_price                  = $request->estimated_item['retail_price'];
            $estimated_item->is_rush                       = $request->estimated_item['is_rush'] ? true : false;
            $estimated_item->estimated_cost_finalized      = $request->estimated_item['estimated_cost_finalized'];
            $estimated_item->estimated_cost_from           = $request->estimated_item['estimated_cost_finalized'];
            $estimated_item->work_to_be_performed          = $request->estimated_item['work_to_be_performed'];
            $estimated_item->customer_approved_or_declined = $request->estimated_item['customer_approved_or_declined'];
            $estimated_item = $estimated_item->save();

            if($estimated_item)
            {
                $history = JobHistory::where('service_id',$estimated_item->service_id)->where('geller_sku',$estimated_item);
                $history->total_with_sales_tax =  $estimated_item->retail_price + salesTax();
                $history->save();
                if($request->estimated_item['customer_approved_or_declined'])
                {
                    EstimatedItem::where('service_id',$request->estimated_item['service_id'])->delete();
                    \DB::table('estimated_items')->where('service_id',1)->delete();
                }
                return $this->APIResponse(config('response_codes.OK'),'Estimate updated successfully.');
            }
            else
            {
                return $this->APIResponse(config('response_codes.Bad Request'));
            }
            // \DB::commit();
        }catch(\Exception $e){
            // \DB::rollBack();
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());
        }
    }
}