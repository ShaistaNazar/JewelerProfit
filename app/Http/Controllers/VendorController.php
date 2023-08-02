<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Models\Vendor;


class VendorController extends Controller
{

    public function __construct()
    {
                    
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

            $vendors = shop()->vendors()
            ->orWhere('username', 'like', '%' . $query_params . '%')
            ->orWhere('fullname', 'like', '%' . $query_params . '%')
            ->orWhere('email', 'like', '%' . $query_params . '%')
            ->orWhere('contact_no', 'like', '%' . $query_params . '%')
            ->paginate(4);

           }else{
            $vendors = shop()->vendors()->paginate(4);
           }
            return $this->APIResponse(config('response_codes.OK'), 'successfully returned all vendors of shop.', $vendors );
            
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
    public function store(VendorRequest $request)
    {
        // try{
            // dd('hi',$request->all());
            $input = array_merge(array('shop_id' =>  shop()->id,'type' => 'vendor'
            ),$request->all());
            $vendor = Vendor::create($input);
            return $this->APIResponse(config('response_codes.Created'), 'created_successfully', $vendor);

        // }catch(\Exception $e){

        //     return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());

        // }    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VendorRequest $request)
    {
        try{
        $vendor = Vendor::find($request->id);
        if($vendor){
            return $this->APIResponse(config('response_codes.OK'), 'successfully Returned Vendor',$vendor);
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
    public function update(VendorRequest $request)
    {
        try{
            // dd($request->vendor);
            $vendor = Vendor::where('id',$request->vendor['id'])->first()->update($request->vendor);
            return $this->APIResponse(config('response_codes.OK'), 'updated_successfully', $vendor);
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
    public function destroy(VendorRequest $request)
    {
        try{

            $destroyed_or_not = Vendor::where('email',$request->email)->first()->delete();
            dd($destroyed_or_not);
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
