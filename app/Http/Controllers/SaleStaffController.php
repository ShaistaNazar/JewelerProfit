<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStaffRequest;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Shop;
use App\Models\User;
use App\Filters\CustomerFilters;
use App\Models\SaleStaff;
use Illuminate\Support\Facades\Auth;


class SaleStaffController extends Controller
{

    public function __construct(){            
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $query_params = request()->filter;
            // dd($query_params);
           if($query_params && $query_params !== ''){

            $saleStaff = shop()->saleStaff()
            ->orWhere('username', 'like', '%' . $query_params . '%')
            ->orWhere('fullname', 'like', '%' . $query_params . '%')
            ->orWhere('email', 'like', '%' . $query_params . '%')
            ->orWhere('contact_no', 'like', '%' . $query_params . '%')
            ->paginate(4);

           }else{
            $saleStaff = shop()->saleStaff()->paginate(4);
           }
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned all saleStaff of shop.', $saleStaff );
            
        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStaffRequest $request)
    {
        try{
            
            $input = array_merge(array('shop_id' =>  shop()->id,
            ),$request->all());
            $sale_person = SaleStaff::create($input);
            return $this->APIResponse(config('response_codes.Created'), 'created_successfully', $sale_person);

        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SaleStaffRequest $request)
    {
        try{
            
        $sale_perspn = SaleStaff::find($request->id);
        if($sale_perspn){
            return $this->APIResponse(config('response_codes.OK'), 'successfully Returned SaleStaff',$sale_perspn);
        }else{
            return $this->APIResponse(config('response_codes.Not Found'),'SaleStaff does not exist.');
        }

        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleStaffRequest $request)
    {
        try{

            $sale_person = SaleStaff::where('id',$request->sale_person['id'])->first();
            if($sale_person)
            {
                $sale_person->update($request->sale_person);
            }
            
            return $this->APIResponse(config('response_codes.OK'), 'updated_successfully', $sale_person);

        }catch(\Exception $e){
         
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleStaffRequest $request)
    {
        try{

            $destroyed_or_not = SaleStaff::where('email',$request->email)->first()->delete();
            if($destroyed_or_not){
                return $this->APIResponse(config('response_codes.OK'), 'deleted_successfully');
            }else{
            return $this->APIResponse(config('response_codes.Bad Request'), 'Some thing went wrong, try again');
            }
 
        }catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

         }
        
    }
}
