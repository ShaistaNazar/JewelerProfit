<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\User;
use App\Filters\CustomerFilters;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
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

            $customers = shop()->customers()
            ->Where('customer_id', 'like', '%' . $query_params . '%')
            // ->orWhere('firstname', 'like', '%' . $query_params . '%')
            // ->orWhere('lastname', 'like', '%' . $query_params . '%')
            ->orWhere('email', 'like', '%' . $query_params . '%')
            // ->orWhere('cell_phone', 'like', '%' . $query_params . '%')
            ->paginate(3);

           }else{
            $customers = shop()->customers()->paginate(3);
           }
            return $this->APIResponse(config('response_codes.OK'), null, $customers );
            
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
    public function store(CustomerRequest $request)
    {
        try{ 
 
            $input = array_merge(array('shop_id' =>  shop()->id,
            ),$request->all());
            
            $customer = Customer::create($input);
            return $this->APIResponse(config('response_codes.Created'), 'created_successfully', $customer);

        }
        catch(\Exception $e){

            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerRequest $request)
    {
        try{
        $customer = Customer::find($request->id);
        if($customer){
            return $this->APIResponse(config('response_codes.OK'), 'successfully Returned Customer',$customer);
        }else{
            return $this->APIResponse(config('response_codes.Not Found'),'Customer does not exist.');
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
    public function update(CustomerRequest $request)
    {
        try{
            
            // dd($request->all());
            $customer = Customer::where('id',$request->customer['id'])->first()->update($request->customer);

            // dd(Customer::where('id',$request->customer['id'])->first());
            return $this->APIResponse(config('response_codes.OK'), 'updated_successfully', $customer);

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
    public function destroy(CustomerRequest $request)
    {
        try{

            $destroyed_or_not = Customer::where('primary_email',$request->email)->first()->delete();
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
