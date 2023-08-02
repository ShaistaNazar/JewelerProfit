<?php

namespace App\Http\Controllers;

use App\Http\Requests\JewelJobRequest;
use App\Models\Jeweler;
use App\Models\JewelJob;
use App\Models\JobHistory;
use App\Models\Shop;
use Exception;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class JewelJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

    /**
     * get jewel jobs per job
     */
    public function jewelJobsPerJeweler(JewelJobRequest $request)
    {
        try{

            $job_histories = JobHistory::having('jeweler_id',$request->jeweler_id)->get()->groupBy('jeweler_id');
			return $this->APIResponse(config('response_codes.OK'), 'successfully returned the jobs per jewelers.', $job_histories);

        }catch(Exception $e){

			return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }


    /**
     * Annual Income of jeweler
     */
    public function getAnnualIncomeOfJeweler(JewelJobRequest $request)
    {
        try{
           
            $jeweler = Jeweler::find($request->jeweler_id);
            // dd($jeweler->with('jewelerLabor')->get());
            if($jeweler){
                $price_array= [];

                $jobs_done_by_jeweler =  $jeweler->jewelerLabor->groupBy(function($d) {
                    return Carbon::parse($d->created_at)->format('Y');
                });
                // dd($jobs_done_by_jeweler);
                // foreach($jobs_done_by_jeweler as $key => $job){
                //     dd($key);
                // }
                $jeweler->jewelJobs->each(function ($item, $key)  use (&$price_array){


                    if(Arr::exists($price_array, Carbon::parse($item->created_at)->format('Y'))){
                        // array_push($price_array[Carbon::parse($item->created_at)->format('Y')],$item->JLRC->labor);
                        // dd($price_array[Carbon::parse($item->created_at)->format('Y')]);

                        // dd(gettype($price_array[Carbon::parse($item->created_at)->format('Y')][0]));
                        echo "\n";

                        // $price_array[Carbon::parse($item->created_at)->format('Y')] = Arr::prepend($price_array[Carbon::parse($item->created_at)->format('Y')],$item->JLRC->labor);
                        // dd($price_array[Carbon::parse($item->created_at)->format('Y')]);
                        $price_array[Carbon::parse($item->created_at)->format('Y')] = $price_array[Carbon::parse($item->created_at)->format('Y')] + (double)$item->JLRC->labor;
                        // dd($price_array);
                        // print_r($price_array);
                        // echo "\n";
                        // dd($price_array);
                    }else{
                        // array_push($price_array,'1');
                        // dd($item->JLRC->labor);
                        $price_array = Arr::add($price_array,Carbon::parse($item->created_at)->format('Y'),(double)($item->JLRC->labor));
                        // dd($price_array);

                    }

                });
                // dd($price_array);

                // $grouped = $collection->mapToGroups(function ($item, $key) {
                //     return [$item['department'] => $item['name']];
                // });

                // dd($jobs_done_by_jeweler);

                // $jobs_done_by_jeweler->each(function ($job, $key) use (&$price_array) {
                // // print_r($key);
                // // echo "==============================================";
                // dd($key,$job);
                // echo "\n";
                // echo "==============================================";
                // echo "\n";

                // // $job->each(function ($job, $key) use (&$price_array) {
                // //    dd($job);
                // // });
                // // $array = Arr::add($price_array, $key, $job->JLRC->labor == null ? 0 : $job->JLRC->labor);
                // // $exists = Arr::exists($key.'job', $key);
                // //      dd($array, 'exists but after creation');
                // //     array_push($price_array,$job->JLRC->labor == null ? 0 : $job->JLRC->labor);
                // });
                // dd('hit');
                // Arr::where()
                //data_get();

                $total_income = array_sum($price_array);
                
                // $dates = JobHistory::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                // ->groupby('year','month')
                // ->get();
                // $dates = JobHistory::get()->groupBy(function($d) {
                //     return Carbon::parse($d->created_at)->format('y');
                // });
                // dd($dates);
                // $res= ::where('someColumn','test')
                //     ->get()
                //     ->groupBy(function($val) {
                //     return Carbon::parse($val->created_at)->format('Y');
                // });
                return $this->APIResponse(config('response_codes.OK'), 'successfully returned the annual income per jeweler.',array('total_income' => $total_income, 'yearly_income' => $price_array));
            }else{
                return $this->APIResponse(config('response_codes.Not Found'), 'Jeweler of this id does not exist.');
            }

        }catch(Exception $e){

			return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }
    
    /**
     * Get Annual Income Of Jewelers of Single Shop
     */
    public function getAnnualIncomeOfShopJewelers(JewelJobRequest $request)
    {
        try{

            $shop = Shop::find($request->shop_id);
            $shop_with_jewelers = $shop->with('jewelers')->first();
            $income_as_per_jeweler = [];
            $shop_with_jewelers->jewelers->each(function ($jeweler, $jeweler_key)  use (&$income_as_per_jeweler){

                $price_array= [];
                $total_income = 0;
            
                $jeweler->jewelJobs->each(function ($item, $key)  use (&$price_array){
    
                    if(Arr::exists($price_array, Carbon::parse($item->created_at)->format('Y'))){
    
                        $price_array[Carbon::parse($item->created_at)->format('Y')] = $price_array[Carbon::parse($item->created_at)->format('Y')] + (double)$item->JLRC->labor;
                        
                    }else{
                        
                        $price_array = Arr::add($price_array,Carbon::parse($item->created_at)->format('Y'),(double)($item->JLRC->labor));
    
                    }
    
                });
                $total_income = array_sum($price_array);
                $income_as_per_jeweler = Arr::add($income_as_per_jeweler, $jeweler->id, array('jeweler_fullname' => $jeweler->fullname, 'total_income'=> $total_income));                
            });
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the annual income of shop jewelers.',$income_as_per_jeweler);
    
        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }

    }

    /**
     * Get Annual Income Of All Shops
     */
    public function getAnnualIncomeOfAllShopJewelers()
    {
        try{

            $income_as_per_shop = [];
            Shop::all()->each(function ($shop, $key) use (&$income_as_per_shop){
                $income_as_per_jeweler = 0;
                $shop->jewelers->each(function ($jeweler, $jeweler_key)  use (&$income_as_per_jeweler, &$shop, &$income_as_per_shop){
                    $price_array= [];
                    $total_income = 0;
                    $jeweler->jewelJobs->each(function ($item, $key)  use (&$price_array , &$shop, &$income_as_per_shop){
        
                        if(Arr::exists($price_array, Carbon::parse($item->created_at)->format('Y'))){
        
                            $price_array[Carbon::parse($item->created_at)->format('Y')] = $price_array[Carbon::parse($item->created_at)->format('Y')] + (double)$item->JLRC->labor;
                            
                        }else{
                            
                            $price_array = Arr::add($price_array,Carbon::parse($item->created_at)->format('Y'),(double)($item->JLRC->labor));
        
                        }
        
                    });

                    $total_income = array_sum($price_array);
                    $income_as_per_jeweler = $income_as_per_jeweler + $total_income;
                });
                $income_as_per_shop = Arr::add($income_as_per_shop, $shop->id, array('shop_name' => $shop->shop_name, 'total_income'=> $income_as_per_jeweler, 'no_of_customers' => count($shop->customers), 'shop_owner' => $shop->shopOwner));                
            });

            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the annual income of shop jewelers.', $income_as_per_shop);
           
        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }

    /**
     * Get Jobs By their Status
     */

    public function getShopJobsByStatus(JewelJobRequest $request)
    {
        try{

            $job_histories = JobHistory::whereHas('jeweler.shop' , function($query) use ($request)
            {
                $query->where('id', $request->shop_id);
            })->get()->groupBy('status');

            return $this->APIResponse(config('response_codes.OK'), 'successfully returned the Jobs done shop', $job_histories);

        }catch(Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }        
    } 
}
