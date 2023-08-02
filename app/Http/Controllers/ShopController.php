<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shops = Shop::with('shopOwner','saleStaff','jewelers','customers')->paginate(10);
        return $this->APIResponse(config('response_codes.OK'),null,$shops);

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
    public function update(Request $request)
    {
        $shop = Shop::updateOrCreate(
            [   'id'                             => $request->id  ],
            [
                'shop_name'                      => $request->shop_name,
                'zip_code'                       => $request->zip_code,
                'city'                           => $request->city,
                'apartment'                      => $request->apartment,
                'contact_no'                     => $request->contact_no,
                'trademark_url'                  => $request->trademark_url,
            ]
        );
        if($shop)
        {
            return $this->APIResponse(config('response_codes.OK'), 'successfully shop is updated.');
        }
        else
        {
            return $this->APIResponse(config('response_codes.Not Found'), 'Error in updating the shop.');
        }
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

    public function getShop(Request $request)
    {
 
        // try{
            // $shop = shops()->where('id',$request->shop_id)->first();
            //  dd(shop());
            if(shop())
            {
                return $this->APIResponse(config('response_codes.OK'), 'successfully returned shop of owner',shop());
            }
            else
            {
                return $this->APIResponse(config('response_codes.Not Found'), 'No shop is registered yet for owner.');
            }
        // }catch(\Exception $e){
        //     return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());
        // }

    }
}    