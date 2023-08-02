<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemsInOurCareRequest;
use App\Models\Customer;
use App\Models\ItemInOurCare;
use App\Models\Shop;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Str;

class ItemsInOurCareController extends Controller
{
    /**
     * get all items in shop care
     */
    public function index()
    {
        try{
            $shop_with_items_in_its_care = Shop::with(['customers', 'customers.itemsInOurCare'])->get()->flatten();
            return $this->APIResponse(config('response_codes.OK'), 'Item in shop custody.',$shop_with_items_in_its_care);
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage() ,$shop_with_items_in_its_care);
        }
    }

    /**
     * store 1 item in shop per on ecustomer regarding envelope
     */
    public function store(ItemsInOurCareRequest $request)
    {
        // if(ItemInOurCare::where('envelope_id',$request->envelope_id)->first())
        // {
        //     return $this->APIResponse(config('response_codes.OK'), 'Item is taken under shop .');
        // }
        // else
        // {
            
            $url = '';
            // dd($request->all());
            DB::beginTransaction();
            $photo_urls = [];
            $shop = shop()->where('id',$request->shop_id)->first();
            // dd(Customer::find($request->customer_id)->customer_id);
            // dd($request->all(),Customer::where('primary_email',$request->customer_email)->first());
            // dd($request->all(),Customer::all());
            // dd(Customer::where('email',$request->customer_email)->first());
            $customer_id = Customer::where('email',$request->customer_email)->first()->id;
            // dd($customer_id);
            // dd(shop()->shop_name.'/'.$customer_id.'/items_in_our_care');
            /** handling images */
            if(isset($request->photos) && is_array($request->photos) && (!empty($request->photos)))
            {
                
                // dd(json_encode($request->photo,true));/
                // dd(json_encode($request->photo));
                // dd(gettype($request->photo));
                // dd(json_encode($request->photo,true));
    
                for($i = 0;$i<count($request->photos);$i++)
                {
                    // dd('in loop');
                    // dd($request->photos[$i]['path']);
                    // if(array_key_exists('path',$request->photos[$i]))
                    // {
                        $image     = $request->photos[$i];  // your base64 encoded
                        $image     = str_replace('data:image/png;base64,', '', $image);
                        $image     = str_replace(' ', '+', $image);
                        $imageName = shop()->shop_name.'/'.$customer_id.'/items_in_our_care//'.time().'.'.'png';
                        // $url = Storage::disk('local')->put($imageName,$image);
                        $url = Storage::disk('public')->put($imageName, base64_decode($image));
                        array_push($photo_urls,$url);
                    // }
                }
            }
            // if ($request->hasFile('photo',0))
            // {
            //     dd($request->file('photo')->isValid());
            //     //  Let's do image handling here
            //     if ($request->file('photo')->isValid()) {
            //         $extension = $request->photo->extension();
            //         $url = Storage::disk('public')->putFileAs(
            //           shop()->shop_name.'/'.$customer_id.'/items_in_our_care', $request->photo, time().'-'.$request->photo->getClientOriginalName()
            //         );
            //     }
            // }
           

            $item_in_our_care = ItemInOurCare::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'repair_id'   => $request->repair_id,
            ],[
                'customer_id'                   => $customer_id,
                'item_description'              => $request->item_description, 
                'customer_stated_value'         => $request->customer_stated_value ?? null,
                'photos'                        => json_encode($photo_urls,true) ?? null,
                'stones_quality_description'    => $request->stones_quality_description ?? null,
                'is_guarranteed'                => $request->is_guarranteed ?? null,
                'is_qualiteed'                  => $request->is_qualiteed ?? null,
                'envelope_id'                   => $request->envelope_id,
                'promise_date'                  => $request->promise_date ? \Carbon\Carbon::parse($request->promise_date)->toDateTimeString() 
                : Carbon::now()->addDays(10)->toDateString(),
                'stones_guarrantee_description' => $request->stones_guarrantee_description ?? null,
            ]);
            // all good
            DB::commit();
            return $this->APIResponse(config('response_codes.Created'), 'Item is taken under shop .',$item_in_our_care);
        // }
        
    }

    /**
     * get customer's item in shop's care
     */
    public function getCustomerItemsInShopCare(ItemsInOurCareRequest $request)
    {
        try{
            $customer = Customer::find($request->customer_id);
            $customer_items_in_shop_care = $customer->itemsInOurCare;
            return $this->APIResponse(config('response_codes.OK'), 'Item is taken in shop .',$customer_items_in_shop_care);
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'), 'Item is taken in shop.');
        }
    }

    /**
     * delete item in our care from customer list.
     */
    public function deleteItemInOurCarePerCustomer(ItemsInOurCareRequest $request)
    {
        try{
            $customer = Customer::find($request->customer_id);
            $customer_items_in_shop_care = $customer->itemsInOurCare;
            return $this->APIResponse(config('response_codes.OK'), 'Item is taken in shop .',$customer_items_in_shop_care);    
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'), $e->getMessage());    
        }
    }

    /**
     * delete item in our care from customer list.
     */
    public function deleteItemInOurCarePerShop(ItemsInOurCareRequest $request)
    {
        try{
            $status = ItemInOurCare::destroy($request->item_id);
            if($status){
                return $this->APIResponse(config('response_codes.OK'), 'Item deleted successfully.');
            }
            return $this->APIResponse(config('response_codes.Internal Server Error'),'Error in deleting item in shop care.');    
        }catch(Exception $e){
            return $this->APIResponse(config('response_codes.Internal Server Error'),$e->getMessage());    
        }
    }

}
