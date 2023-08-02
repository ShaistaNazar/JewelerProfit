<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chapter300Request;
use App\Models\DavidPricing\Chapter300;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Chapter300Controller extends CalculationController
{
    public $chapter;
    public $request1200;
    public $chap1200;
    public function __construct()
    {
        // dd(request()->all());
        parent::__construct();
        $this->chapter = 300;
    }
    /**
     * get Clasp menu api
     */
    public function getAllClasps()
    {
        # get all clasps from config
        $clasps = Config::get('gellerbook.clasps');
        return $clasps;
    }

    # clasps 
    # 1. get stuller amount

    public function getPrice(Chapter300Request $request,$requestee_chapter = null)
    {
        // try{

        // dd($request->all());
        $labor_formula = null;
        $part_cost = 0;
        $part_retail = 0;
        $labor_cost = 0;
        $labor_retail = 0;
        $total_with_labor_metarial = 0;
        $express_total = 0;
        $picklist_charges = 0;
        $sales_tax = Setting::where('setting','sales_tax')->first()->value;
        $clasp = Chapter300::query();
        $stringing_details = 0;
        $price_chart = [];
        $quantity_for_envelope = 1;

        // dd($request->all());
        foreach ($request->values[$this->chapter]["procedure_details_1"]['options'] as $key => $value) 
        {
            if($key !== 'no_of_price_criteria_item' && $key !== 'welding_technology')
            {
                $clasp->whereRaw("REPLACE(`$key`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $value).'%']);
            }
        }
        $clasp = $clasp->first();
        // $clasp = Chapter300::where('geller_sku',30201)->first();

        $pick_list_charges = [];
        # choose labor depends upon welding technology
        if(isset($request->welding_technology) && $request->welding_technology == 'laser')
        {
            $labor_formula = $clasp->JLRC_labor_laser;
        }
        else
        {
            $labor_formula = $clasp->JLRC_labor_torch;
        }
        $labor_parts = explode("x", $labor_formula);
        # cost(part)
        if($labor_formula)
        {
            # retail(labor)
            $labor_retail = round($this->getLaborRetail($labor_parts));
            # cost(labor)
            $labor_cost =   round($this->getLaborCost($labor_retail));
        }
        // dd($part_cost,$labor_parts,$labor_retail,$part_retail);

        # order dependencies that are out of stock but not bound to apply retail but
        // dd($clasp);
        # in total amount as JLRC already includes this.
        // dd($clasp->picklist_quantity_if_needed, $clasp->picklist_stuller_if_needed, $clasp->picklist_item_if_needed);
        if($clasp->picklist_stuller_if_needed != "" && $request->picklist)
        $pick_list_charges = $this->getPicklistCharges($clasp->picklist_quantity_if_needed, is_array($clasp->picklist_stuller_if_needed) ? $clasp->picklist_stuller_if_needed[0] : $clasp->picklist_stuller_if_needed, $clasp->picklist_item_if_needed);  
        if(isset($request->stringing_work) && $request->stringing_work == 'require_stringing_work' && array_key_exists(1200,$request->values))
        {

            $this->chap1200    = \App::make('App\Http\Controllers\Chapter1200Controller');
            $this->request1200 = \App::make('App\Http\Requests\Chapter1200Request');
            $stringing_details  = $this->chap1200->getPrice($this->request1200,$this->chapter);
            if($stringing_details instanceof \Illuminate\Http\JsonResponse)
            {
                $stringing_details     = json_decode(json_encode($stringing_details,true))->original->data->price_chart[0]->total;
            }
            $labor_retail += $stringing_details;
        }

        // $total_with_others = $total_with_labor_metarial + $request->other_cost + $request->other_price;
        # add job history and bind jeweler to it.
        $service_id  = bin2hex(random_bytes(8));
        $part_cost   = $this->getPartCost($this->chapter,$clasp->geller_sku);
        // dd($clasp,$part_cost);
        $part_retail = round($this->getPartRetail($part_cost));
        // dd($part_retail);
        if($requestee_chapter && $request->part_only)
        {
            return $part_cost;
        }
        // sum of labor is setting charges and retail labor of item itself
        // dd($part_retail);
        $labor_retail    = $request->is_rush ? ($labor_retail + ($labor_retail/2)) : $labor_retail;
        // dd($labor_retail);
        $express_retail  = $request->is_rush ? ($labor_retail/2) : 0;
        $labor_cost      = $this->getLaborCost($labor_retail);
        $pick_list_total = array_key_exists('total',$pick_list_charges) ? $pick_list_charges['total'] :0;
        // dd($pick_list_total,gettype($pick_list_total));
        $rhodium_charges = array_key_exists($this->chapter,$request->is_rhodium)?
                ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                \Config::get('gellerbook.rhodium_charges') : 0):0;
        $grand_total     = sprintf('%0.2f', round($part_retail+$labor_retail+$express_retail+$rhodium_charges+$pick_list_total)) ;        
        $service_id = bin2hex(random_bytes(8));

        $item_data                         = [
        'id'                       => $clasp->id,
        'geller_sku'               => $clasp->geller_sku,
        'major_item'               => $clasp->major_item,
        'total'                    => $grand_total,
        'is_actual'                => true,
        'is_rhodium'               => array_key_exists($this->chapter,$request->is_rhodium)?
                                      ($request->is_rhodium[$this->chapter]['procedure_details_1'] ? 
                                      true : false):false,
        'is_rush'                  => $request->is_rush,
        'pick_list_charges'        => $pick_list_total,
        'stringing_chrges'         => $stringing_details,
        'pick_list'                => $pick_list_charges,
        'quantity'                 => $quantity_for_envelope,

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
        // }catch(Exception $e){

        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());

        // }
        
    }

    /**
     * get clasps's detail
     */
    public function getClaspMenuDetails(Request $request)
    {

        # code...
        // approach 1
        // by title and get sizes thats ambigous
        // approach 2
        // give all chapter items to frontend  (with alot of static pages) but sizes are specific that should have to be picked from 
        // chapter as per title either from front or backend so approach 1 is better but still requires betterment

        try
        {
            $menu_details = Chapter300::where(
                'title' , $request->title
            )->get();
            return $this->APIResponse(config('response_codes.OK'), 'Successfully returned menu details', $menu_details);
        }
        catch(Exception $e)
        {
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());
        }

    }

}
